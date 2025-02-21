<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProposalUpdated extends Notification
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
            ->subject("Estimasi Tanggal Permintaan {$jenisPermintaan} Updated!") // Subject diperbaiki
            ->markdown('mail.proposal_updated', ['proposal' => $this->proposal]);
    }    

    public function toArray($notifiable)
    {
        return [];
    }
}
