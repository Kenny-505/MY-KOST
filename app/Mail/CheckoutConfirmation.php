<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class CheckoutConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $checkoutType;
    public $checkoutDate;

    /**
     * Create a new message instance.
     */
    public function __construct(Booking $booking, string $checkoutType = 'regular')
    {
        $this->booking = $booking;
        $this->checkoutType = $checkoutType;
        $this->checkoutDate = Carbon::now()->format('d F Y H:i');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✅ Konfirmasi Checkout - Kamar ' . $this->booking->kamar->no_kamar . ' - MYKOST',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.checkout-confirmation',
            with: [
                'booking' => $this->booking,
                'checkoutType' => $this->checkoutType,
                'checkoutDate' => $this->checkoutDate,
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
        return [];
    }
} 