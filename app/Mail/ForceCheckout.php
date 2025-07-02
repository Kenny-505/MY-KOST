<?php

namespace App\Mail;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class ForceCheckout extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $recipient;
    public $checkoutDate;

    /**
     * Create a new message instance.
     */
    public function __construct(Booking $booking, User $recipient)
    {
        $this->booking = $booking;
        $this->recipient = $recipient;
        $this->checkoutDate = Carbon::parse($booking->tanggal_selesai)->format('d F Y');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🚨 Checkout Otomatis - Booking Berakhir - Kamar ' . $this->booking->kamar->no_kamar . ' - MYKOST',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.force-checkout',
            with: [
                'booking' => $this->booking,
                'recipient' => $this->recipient,
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
