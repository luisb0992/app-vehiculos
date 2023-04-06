<?php

namespace App\Mail;

use App\Models\RepairOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifyRecorderAndSupervisorNewQuotationEmail extends Mailable
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
        $data = [
            'vehicle' => $this->repairOrder->vehicle->load('brand', 'model', 'color'),
            'order_number' => '000' .  $this->repairOrder->id,
            'workshop' => $this->repairOrder->workshop,
        ];

        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject('Orden de reparación cotizada')
            ->view('emails.order-repair-quoted')
            ->with(['data' => $data]);
    }
}
