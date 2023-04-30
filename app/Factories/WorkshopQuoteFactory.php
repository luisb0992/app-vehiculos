<?php

namespace App\Factories;

use App\Enum\StatusRepairOrderEnum;
use Illuminate\Support\Facades\DB;
use App\Enum\StatusVehicleEnum;
use App\Mail\NotifyRecorderAndSupervisorNewQuotationEmail;
use App\Mail\NotifyRecorderQuotationHasBeenUpdatedEmail;
use App\Mail\NotifySupplierQuotationApprovedEmail;
use App\Models\RepairOrder;
use App\Models\Quotation;
use App\Models\Vehicle;
use App\Models\User;
use App\Utils\AppStorage;
use Illuminate\Support\Facades\Mail;

class WorkshopQuoteFactory
{

  use AppStorage;

  /**
   * Crea una nueva cotización
   *
   * @param array $data
   * @return Quotation
   */
  public function storeQuota(array $data): mixed
  {
    $trans = DB::transaction(function () use ($data) {
      // verificar si ya la orden tiene una cotización
      $user = auth()->user();
      $order = RepairOrder::with('quotation')->find($data['repair_order_id']);
      $subs = $order->subcategories()->get();
      $subtotal = array_sum(array_column($data['subs'], 'cost'));
      $total = $data['tax'] ? $subtotal + ($subtotal * $data['tax']) / 100 : $subtotal;
      $total = number_format($total, 2, '.', '');

      if ($order->quotation) {
        return false;
      }

      // agregar los costos de las sub categorias
      foreach ($data['subs'] as $subcategory) {
        $sub = $subs->where('id', $subcategory['id'])->first();
        $sub->pivot->cost = $subcategory['cost'];
        $sub->pivot->save();
      }

      // crear cotización
      $quotation = Quotation::create([
        'repair_order_id' => $data['repair_order_id'],
        'user_id' => $user->id,
        'subtotal' => $subtotal,
        'iva' => $data['tax'],
        'total' => $total,
      ]);

      // cambiar status de la orden a cotizada
      $order->update(['status' => StatusRepairOrderEnum::QUOTED]);

      // notificar al registrador y supervisor
      $this->notifyUsersNewQuotationHasBeenCreated($order);

      return $quotation;
    });

    return $trans;
  }

  /**
   * Actualizar una nueva cotización
   *
   * @param Quotation $quotation
   * @param array $data
   * @return bool
   */
  public function updateQuota($quotation, array $data): bool
  {
    $trans = DB::transaction(function () use ($quotation, $data) {
      // verificar si ya la orden tiene una cotización
      $order = $quotation->repairOrder;
      $subs = $order->subcategories()->get();
      $subtotal = array_sum(array_column($data['subs'], 'cost'));
      $total = $data['tax'] ? $subtotal + ($subtotal * $data['tax']) / 100 : $subtotal;
      $total = number_format($total, 2, '.', '');

      // actualizar los costos de las sub categorias
      foreach ($data['subs'] as $subcategory) {
        $sub = $subs->where('id', $subcategory['id'])->first();
        $sub->pivot->cost = $subcategory['cost'];
        $sub->pivot->save();
      }

      // actualizar cotización
      $updated = $quotation->update([
        'subtotal' => $subtotal,
        'iva' => $data['tax'],
        'total' => $total,
      ]);

      // notificar al registrador y supervisor
      $this->notifyUsersQuotationHasBeenUpdated($order);

      return $updated;
    });

    return $trans;
  }

  /**
   * Aprueba una cotización
   *
   * @param array $data
   * @return bool|null
   */
  public function approveQuotation(array $data): ?bool
  {
    $trans = DB::transaction(function () use ($data) {

      $user = auth()->check() ? auth()->user() : User::find($data['user_id']);

      // actualizar la orden
      $order = RepairOrder::with('quotation')->find($data['order_id']);
      $order->update(['status' => StatusRepairOrderEnum::APPROVED]);

      // guardar la orden de compra
      $order->purchaseOrder()->create([
        'user_id' => $user->id,
        'quotation_id' => $data['quotation_id'],
        'number' => $data['number'],
      ]);

      // notificar a los usuarios de ese taller
      $this->notifyUsersNewPurchaseOrderHasBeenCreated($order);

      return true;
    });

    return $trans;
  }

  /**
   * Iniciar una orden de reparación
   *
   * @param array $data
   * @return bool|null
   */
  public function startRepair(array $data): ?bool
  {
    $trans = DB::transaction(function () use ($data) {
      $order = RepairOrder::find($data['order_id']);
      $order->update(['status' => StatusRepairOrderEnum::IN_REPAIR]);

      return true;
    });

    return $trans;
  }

  /**
   * Finalizar una orden de reparación
   *
   * @param array $data
   * @return bool|null
   */
  public function finishRepair(array $data): ?bool
  {
    $trans = DB::transaction(function () use ($data) {
      $order = RepairOrder::find($data['order_id']);
      $order->update(['status' => StatusRepairOrderEnum::REPAIRED]);

      return true;
    });

    return $trans;
  }

  /**
   * Finalizar el caso completamente de orden de reparación
   *
   * @param array $data
   * @return bool|null
   */
  public function finalizedCase(array $data): ?bool
  {
    $trans = DB::transaction(function () use ($data) {

      $orders = $data['orders'];
      $vehicle_id = $orders[0]['vehicle_id'];
      $isAllRepaired = true;

      // verificar si todas las ordenes tienen el status
      // de reparadas
      foreach ($orders as $order) {
        $order = RepairOrder::find($order['id']);
        if ($order->status !== StatusRepairOrderEnum::REPAIRED) {
          $isAllRepaired = false;
        }
      }

      // si todavía hay ordenes sin reparar
      if (!$isAllRepaired) {
        return false;
      }

      // actualizar todos los estados
      foreach ($orders as $order) {
        $order = RepairOrder::find($order['id']);
        $order->update(['status' => StatusRepairOrderEnum::FINALIZED]);
      }

      // actualizar el estado del vehiculo
      $vehicle = Vehicle::find($vehicle_id);
      $vehicle->update(['status' => StatusVehicleEnum::FINALIZED]);

      return true;
    });

    return $trans;
  }

  /**
   * Guardar factura relacionada con la cotización
   *
   * @param array $data
   * @return bool|null
   */
  public function storeInvoice(array $data): ?bool
  {
    $trans = DB::transaction(function () use ($data) {
      $quotation = Quotation::find($data['quotation_id']);
      $file = $data['invoice'];

      if (!$file->isValid() || !$quotation) {
        return false;
      }

      // guardar factura
      $path = config('storage.invoices.storage_path');
      $name = $this->generateName('invoice_');
      $data['invoice_path'] = $this->saveFile($file, $name, $path);

      $quotation->update([
        'invoice_number' => $data['invoice_number'],
        'invoice_path' => $data['invoice_path'],
      ]);

      return true;
    });

    return $trans;
  }

  /**
   * Notificar al registrador y supervisor
   * que una orden de reparación fue cotizada
   *
   * @param RepairOrder $order
   * @return void
   */
  public function notifyUsersNewQuotationHasBeenCreated($order): void
  {
    // usuarios a notificar
    $supervisors = User::supervisor()->get(['id']);
    $allIDS = array_merge([$order->user_id], $supervisors->pluck('id')->toArray());
    $users = User::users($allIDS)->get();

    // notificar a los usuarios
    $users->each(function ($user) use ($order) {
      $email = new NotifyRecorderAndSupervisorNewQuotationEmail($order);
      Mail::to($user->email)->send($email);
    });
  }

  /**
   * Notificar a los usuarios del taller
   * que la cotización fue aprobada
   *
   * @param RepairOrder $order
   * @return void
   */
  public function notifyUsersNewPurchaseOrderHasBeenCreated($order): void
  {
    // usuarios a notificar
    $workshopUsers = User::byWorkshop($order->workshop_id)->get();

    // iterar, tomar el email y notificar via email
    $workshopUsers->each(function ($userF) use ($order) {
      $email = new NotifySupplierQuotationApprovedEmail($order);
      Mail::to($userF->email)->send($email);
    });
  }

  /**
   * Notificar que una cotización fue actualizada
   * Notificar al supervisor y al registrador
   *
   * @param RepairOrder $order
   * @return void
   */
  public function notifyUsersQuotationHasBeenUpdated($order): void
  {
    // usuarios a notificar
    $supervisors = User::supervisor()->get(['id']);
    $allIDS = array_merge([$order->user_id], $supervisors->pluck('id')->toArray());
    $users = User::users($allIDS)->get();

    // iterar, tomar el email y notificar via email
    $users->each(function ($user) use ($order) {
      $email = new NotifyRecorderQuotationHasBeenUpdatedEmail($order);
      Mail::to($user->email)->send($email);
    });
  }
}
