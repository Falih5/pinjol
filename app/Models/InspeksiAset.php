<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiAset extends Model
{
    protected $table = 'inspeksi_aset';
    protected $primaryKey = 'id_inspeksi';
    public $timestamps = false;

    protected $fillable = [
        'id_peminjaman',
        'waktu_serah',
        'id_petugas_serah',
        'kondisi_baseline',
        'foto_baseline_url',
        'waktu_kembali',
        'id_petugas_kembali',
        'kondisi_akhir',
        'foto_akhir_url',
    ];

    protected $casts = [
        'waktu_serah' => 'datetime',
        'waktu_kembali' => 'datetime',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }
}