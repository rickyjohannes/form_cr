<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Approval extends Notification
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
        // Ambil data 'Jenis Permintaan' dari $this->data
        $jenisPermintaan = $this->data['proposal']['status_barang'] ?? 'Unknown';

        return (new MailMessage)
            ->subject("Action Approval - Permintaan {$jenisPermintaan}") // Subject diperbaiki
            ->markdown('mail.approval', [
                'proposal' => $this->data['proposal'],
                'approvalLink' => $this->data['approvalLink'],
                'rejectedLink' => $this->data['rejectedLink'],
            ]);
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
