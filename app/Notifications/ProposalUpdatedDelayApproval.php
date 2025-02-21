<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProposalUpdatedDelayApproval extends Notification
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
            ->subject("DELAY Approval! Permintaan {$jenisPermintaan}")
            ->markdown('mail.proposal_updated_delay_approval', [
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
