<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PendaftaranNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $nama,
        public string $email,
        public string $posisi
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Lamaran Baru: {$this->nama} - {$this->posisi}",
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: $this->buildHtml(),
        );
    }

    private function buildHtml(): string
    {
        $dashboardUrl = config('app.url', 'https://indoconsulting.id') . '/admin/pendaftaran';
        return <<<HTML
        <div style="font-family: 'Outfit', Arial, sans-serif; max-width: 600px; margin: 0 auto; background: #f8fafc; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0;">
            <div style="background: #020220; padding: 24px 32px; text-align: center;">
                <h1 style="color: white; font-size: 20px; font-weight: 700; margin: 0;">Indo Consulting</h1>
                <p style="color: rgba(255,255,255,0.5); font-size: 12px; margin: 4px 0 0;">Admin Notification</p>
            </div>
            <div style="padding: 32px;">
                <div style="background: #dcfce7; border: 1px solid #bbf7d0; border-radius: 8px; padding: 16px; margin-bottom: 24px; text-align: center;">
                    <p style="color: #166534; font-size: 14px; margin: 0;">📧 Lamaran baru telah masuk</p>
                </div>
                <table style="width: 100%; border-collapse: collapse; margin-bottom: 24px;">
                    <tr>
                        <td style="padding: 8px 0; font-size: 13px; color: #64748b; width: 120px;">Nama</td>
                        <td style="padding: 8px 0; font-size: 14px; color: #020220; font-weight: 600;">{$this->nama}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-size: 13px; color: #64748b;">Email</td>
                        <td style="padding: 8px 0; font-size: 14px; color: #020220;">{$this->email}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-size: 13px; color: #64748b;">Posisi</td>
                        <td style="padding: 8px 0; font-size: 14px; color: #020220;">{$this->posisi}</td>
                    </tr>
                </table>
                <a href="{$dashboardUrl}" style="display: block; text-align: center; background: #bb0027; color: white; text-decoration: none; padding: 14px 24px; border-radius: 980px; font-size: 14px; font-weight: 600;">Lihat di Dashboard</a>
            </div>
            <div style="padding: 16px 32px; text-align: center; border-top: 1px solid #e2e8f0;">
                <p style="font-size: 11px; color: #94a3b8; margin: 0;">© {$this->currentYear} Indo Consulting. Hak cipta dilindungi.</p>
            </div>
        </div>
        HTML;
    }

    private function getCurrentYear(): int
    {
        return (int) date('Y');
    }
}
