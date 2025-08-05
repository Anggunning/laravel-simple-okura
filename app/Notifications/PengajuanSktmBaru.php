<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PengajuanSktmBaru extends Notification
{
    use Queueable;

    public function __construct(public string $pesan) {}

    public function via($notifiable)
    {
        return ['database']; // atau ['mail', 'database'] jika juga ingin lewat email
    }

    public function toDatabase($notifiable)
    {
        return [
            'pesan' => $this->pesan,
            'url' => route('sktm.index'), // arahkan ke halaman yang sesuai
        ];
    }
}
