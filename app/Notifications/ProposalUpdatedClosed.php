<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Proposal;

class ProposalUpdatedClosed extends Notification
{
    use Queueable;

    protected Proposal $proposal;

    public function __construct(Proposal $proposal)
    {
        $this->proposal = $proposal;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // Ambil data 'Jenis Permintaan' dari $this->data
        $jenisPermintaan = $this->proposal->status_barang ?? 'Unknown';

        return (new MailMessage)
            ->subject("Permintaan {$jenisPermintaan} Telah Close!") // Subject diperbaiki
            ->markdown('mail.proposal_updated_closed', ['proposal' => $this->proposal]);
    }    

}