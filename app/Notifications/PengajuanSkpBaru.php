<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PengajuanSkpBaru extends Notification
{
      use Queueable;

    public $pengajuan;

    public function __construct($pengajuan)
    {
        $this->pengajuan = $pengajuan;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Pengajuan Surat Pengantar Pernikahan Baru',
            'message' => 'Ada pengajuan Surat Pengantar Pernikahan dari ' . $this->pengajuan->nama,
            'id_pengajuan' => $this->pengajuan->id,
        ];
    }
}
