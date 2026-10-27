<?php

namespace App\Notifications;

use App\Models\Peminjaman;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class StatusPeminjamanUpdated extends Notification
{
    use Queueable;

    protected $peminjaman;
    protected $pesan;

    public function __construct(Peminjaman $peminjaman, string $pesan)
    {
        $this->peminjaman = $peminjaman;
        $this->pesan = $pesan;
    }

    public function via(object $notifiable): array
    {
        return ['database']; // Menyimpan notifikasi ke dalam database
    }

    public function toArray(object $notifiable): array
    {
        return [
            'id_peminjaman' => $this->peminjaman->id_peminjaman,
            'nama_aset'     => $this->peminjaman->aset->nama_aset,
            'status'        => $this->peminjaman->status_pengajuan,
            'pesan'         => $this->pesan,
            'url'           => route('peminjam.pengajuan.show', $this->peminjaman->id_peminjaman),
        ];
    }
}