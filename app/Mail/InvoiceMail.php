<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    private $invoice;
    private $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $invoice)
    {
        //
        $this->invoice = $invoice;
        $this->user = User::find(auth()->id());
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->user->email, $this->user->fullname)
                    ->markdown('invoices.email')
                    ->with('invoice', $this->invoice)
                    ->attach(public_path('files/invoices/'.str_replace('-', trim(''), $this->invoice['id']).'.pdf'), [
                        'mime'  => 'application/pdf' 
                    ]);
    }
}
