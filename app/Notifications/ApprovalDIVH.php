<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApprovalDIVH extends Notification
{
    use Queueable;
    protected $data; // Ubah ini menjadi array

    public function __construct(array $data) // Ubah di sini
    {
        $this->data = $data; // Simpan data yang diterima
    }

    public function via($notifiable)
    {
        return ['mail']; // Atau saluran notifikasi lainnya
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('CR Approval DivisiHead Notification')
            ->markdown('mail.approval_divh', [
                'proposal' => $this->data['proposal'],
            ]);
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
