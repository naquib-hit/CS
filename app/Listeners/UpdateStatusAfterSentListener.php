<?php

namespace App\Listeners;

use App\Events\InvoiceEmailSentEvent;
use App\Models\Transaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
    }
}
