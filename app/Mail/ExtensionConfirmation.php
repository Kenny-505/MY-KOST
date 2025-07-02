<?php

namespace App\Mail;

use App\Models\Booking;
use App\Models\Pembayaran;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class ExtensionConfirmation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $originalBooking;
    public $extensionBooking;
    public $payment;

    /**
     * Create a new message instance.
     */
    public function __construct(Booking $originalBooking, Booking $extensionBooking, Pembayaran $payment)
    {
        $this->originalBooking = $originalBooking;
        $this->extensionBooking = $extensionBooking;
        $this->payment = $payment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✅ Konfirmasi Perpanjangan Booking - Kamar ' . $this->extensionBooking->kamar->no_kamar . ' - MYKOST',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.extension-confirmation',
            with: [
                'originalBooking' => $this->originalBooking,
                'extensionBooking' => $this->extensionBooking,
                'payment' => $this->payment,
                'penghuni' => $this->extensionBooking->penghuni,
                'teman' => $this->extensionBooking->teman,
                'kamar' => $this->extensionBooking->kamar,
                'paket' => $this->extensionBooking->paketKamar,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        $attachments = [];

        // Attach extension invoice PDF if available
        try {
            $pdfService = app(\App\Services\PDFExportService::class);
            $pdf = $pdfService->generateInvoicePDF($this->payment);
            $filename = 'Extension-Invoice-' . $this->extensionBooking->kamar->no_kamar . '-' . date('Y-m-d') . '.pdf';
            
            $attachments[] = Attachment::fromData(
                fn () => $pdf->output(),
                $filename
            )->withMime('application/pdf');
        } catch (\Exception $e) {
            // Log error but don't fail email sending
            \Log::warning('Failed to attach extension invoice PDF to email: ' . $e->getMessage());
        }

        return $attachments;
    }
}
