<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transaksi;

    // Terima data transaksi saat mail dibuat
    public function __construct($transaksi)
    {
        $this->transaksi = $transaksi;
    }

    public function build()
    {
        return $this->subject('Invoice Pesanan #' . $this->transaksi->external_id)
                    ->view('emails.invoice'); // Kita akan buat view ini di tahap 2
    }
}