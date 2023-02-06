<?php

namespace App\Listeners;

use App\Models\{ Report, Transaction };
use Illuminate\Support\Facades\DB;
use App\Events\InvoiceEmailSentEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateStatusAfterSentListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\InvoiceEmailSentEvent  $event
     * @return void
     */
    public function handle(InvoiceEmailSentEvent $event)
    {
        //
        DB::transaction(function () use($event) {
            Transaction::create([
                'invoice_no'        => $event->invoice->invoice_no,
                'trans_date'        => (new \DateTime())->format('Y-m-d'),
                'create_date'       => (new \DateTime($event->invoice->create_date))->format('Y-m-d'),
                'delivery_status'   => intval($event->invoice['invoice_status']),
                'due_date'          => !empty($event->invoice['due_date']) ? (new \DateTime($event->invoice['due_date']))->format('Y-m-d') : NULL,
                'customer_id'       => $event->invoice['customers']['id'],
                'customer_name'     => $event->invoice['customers']['customer_name'],
                'details'           => json_encode($event->invoice->getInvoiceByID($event->invoice->id)),
                'create_by'         => auth()->id()
            ]);
            Report::where('invoice_id', '=', $event->invoice['id'])
                    ->update([
                        'sent_status' => $event->invoice['invoice_status'],
                        'deskripsi'   => json_encode($event->invoice->getInvoiceByID($event->invoice->id))
                    ]);
        });
        
        exit(0);
    }
}
