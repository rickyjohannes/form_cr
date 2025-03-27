<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApprovalDIVH extends Notification
{
    use Queueable;

    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // Ambil data 'Jenis Permintaan' dari $this->data
        $jenisPermintaan = $this->data['proposal']['status_barang'] ?? 'Unknown';

        return (new MailMessage)
            ->subject("Full Approve - Permintaan {$jenisPermintaan}") // Subject diperbaiki
            ->markdown('mail.approval_divh', [
                'proposal' => $this->data['proposal'],
            ]);
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
