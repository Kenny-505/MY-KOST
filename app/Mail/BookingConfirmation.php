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

class BookingConfirmation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $booking;
    public $payment;

    /**
     * Create a new message instance.
     */
    public function __construct(Booking $booking, Pembayaran $payment)
    {
        $this->booking = $booking;
        $this->payment = $payment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Konfirmasi Booking MYKOST - Kamar ' . $this->booking->kamar->no_kamar,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-confirmation',
            with: [
                'booking' => $this->booking,
                'payment' => $this->payment,
                'penghuni' => $this->booking->penghuni,
                'teman' => $this->booking->teman,
                'kamar' => $this->booking->kamar,
                'paket' => $this->booking->paketKamar,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        $attachments = [];

        // Attach invoice PDF if available
        try {
            $pdfService = app(\App\Services\PDFExportService::class);
            $pdf = $pdfService->generateInvoicePDF($this->payment);
            $filename = 'Invoice-' . $this->booking->kamar->no_kamar . '-' . date('Y-m-d') . '.pdf';
            
            $attachments[] = Attachment::fromData(
                fn () => $pdf->output(),
                $filename
            )->withMime('application/pdf');
        } catch (\Exception $e) {
            // Log error but don't fail email sending
            \Log::warning('Failed to attach invoice PDF to booking confirmation email: ' . $e->getMessage());
        }

        return $attachments;
    }
}
