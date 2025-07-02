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

class ExtensionReminder extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $booking;
    public $daysRemaining;

    /**
     * Create a new message instance.
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
        $this->daysRemaining = Carbon::now()->diffInDays(Carbon::parse($booking->tanggal_selesai));
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '⏰ Reminder: Booking Anda akan berakhir dalam ' . $this->daysRemaining . ' hari - MYKOST',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.extension-reminder',
            with: [
                'booking' => $this->booking,
                'daysRemaining' => $this->daysRemaining,
                'penghuni' => $this->booking->penghuni,
                'teman' => $this->booking->teman,
                'kamar' => $this->booking->kamar,
                'paket' => $this->booking->paketKamar,
                'expiryDate' => Carbon::parse($this->booking->tanggal_selesai)->format('d F Y'),
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
