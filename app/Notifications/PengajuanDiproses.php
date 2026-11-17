<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class PengajuanDiproses extends Notification
{
    public function __construct(
        public string $judul,
        public string $pesan,
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'judul' => $this->judul,
            'pesan' => $this->pesan,
        ];
    }
}