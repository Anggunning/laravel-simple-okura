<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PengajuanSktmBaru extends Notification
{
    use Queueable;

    protected $pengajuan;

    public function __construct($pengajuan)
    {
        // Jika hanya ID dikirim, ambil ulang datanya
        if (is_numeric($pengajuan)) {
            $this->pengajuan = \App\Models\SktmModel::find($pengajuan);
        } elseif (is_array($pengajuan)) {
            $this->pengajuan = (object) $pengajuan;
        } else {
            $this->pengajuan = $pengajuan;
        }
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Pengajuan SKTM Baru',
            'message' => 'Ada pengajuan Surat Keterangan Tidak Mampu dari ' . ($this->pengajuan->nama ?? '(tidak diketahui)'),
            'id_pengajuan' => $this->pengajuan->id ?? null,
        ];
    }
}
