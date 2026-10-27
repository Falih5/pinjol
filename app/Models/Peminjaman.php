<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'id_aset',
        'waktu_pengajuan',
        'waktu_mulai',
        'waktu_selesai',
        'tujuan_penggunaan',
        'status_pengajuan',
        'batas_sla_admin',
        'id_admin_approval',
    ];

    protected $casts = [
        'waktu_pengajuan' => 'datetime',
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
        'batas_sla_admin' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function aset()
    {
        return $this->belongsTo(Aset::class, 'id_aset', 'id_aset');
    }

    public function inspeksi()
    {
        return $this->hasOne(InspeksiAset::class, 'id_peminjaman', 'id_peminjaman');
    }
}