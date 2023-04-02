<?php

namespace App\Mail;

use App\Models\RepairOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifySupplierUserEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(public RepairOrder $repairOrder)
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $imgUrl = "https://i.ibb.co/Z2XrMyf/banner.webp";

        $data = [
            'title' => 'Nueva orden de reparación',
            'body' => 'Se ha solicitado una nueva orden de reparación para el vehículo ' . $this->repairOrder->vehicle?->chassis_number,
            'vehicle' => $this->repairOrder->vehicle->load('brand', 'model', 'color'),
        ];

        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject('Nueva orden de reparación')
            ->view('emails.repair-order')
            ->with(['data' => $data, 'img' => $imgUrl]);
    }
}
