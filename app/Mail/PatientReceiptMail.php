<?php

namespace App\Mail;

use App\Models\Billing;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class PatientReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public $billing;

    public function __construct(Billing $billing, $pdf)
    {
        $this->billing = $billing;
    }

    public function build()
    {
        $billing = $this->billing;

        $pdf = PDF::loadView('backend.billings.receipt_pdf', compact('billing'))
            ->setPaper([0, 0, 226.77, 841.89], 'portrait')
            ->setOption('enable-local-file-access', true);

        return $this->subject('Payment Receipt - ' . ($this->billing->patient->fname ?? ''))
                    ->markdown('emails.receipts.patient')
                    ->attachData(
                        $pdf->output(),
                        'receipt_' . $this->billing->id . '.pdf',
                        ['mime' => 'application/pdf']
                    );
    }
}
