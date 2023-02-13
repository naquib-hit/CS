<?php

namespace App\Observers;

use App\Models\{ User, Report, Invoice, Transaction };
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvoiceObserver
{

    /**
     * Executing the observer after commit transaction
     *
     * @var boolean
     */
    public $afterCommit = TRUE;

    /**
     * Handle the Invoice "saved" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function saved(Invoice $invoice)
    {
        //
        try
        {
            $valid = $invoice->getInvoiceByID($invoice->id);
            DB::transaction(function () use($valid) {
                Transaction::create([
                    'invoice_id'        => $valid['id'],
                    'trans_date'        => (new \DateTime())->format('Y-m-d'),
                    'create_date'       => (new \DateTime($valid['create_date']))->format('Y-m-d'),
                    'delivery_status'   => intval($valid['invoice_status']),
                    'due_date'          => !empty($valid['due_date']) ? (new \DateTime($valid['due_date']))->format('Y-m-d') : NULL,
                    'customer_id'       => $valid['projects']['customers']['id'],
                    'customer_name'     => $valid['projects']['customers']['customer_name'],
                    'details'           => json_encode($valid),
                    'create_by'         => auth()->id()
                ]);

                Report::updateOrCreate(
                    [
                        'invoice_id' => $valid['id']
                    ], 
                    [
                        'sent_status'   => $valid['invoice_status'],
                        'deskripsi'     => json_encode($valid)
                    ]
                );
            });
        }
        catch(\Throwable $e)
        {
            Log::error($e->__toString());
        }
       
    }

    /**
     * Handle the Invoice "deleted" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function deleted(Invoice $invoice)
    {
        //
    }

    /**
     * Handle the Invoice "restored" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function restored(Invoice $invoice)
    {
        //
    }

    /**
     * Handle the Invoice "force deleted" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function forceDeleted(Invoice $invoice)
    {
        //
    }
}
