<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aset extends Model
{
    protected $table = 'aset';
    protected $primaryKey = 'id_aset';
    public $timestamps = false;

    protected $fillable = [
        'kode_aset',
        'nama_aset',
        'kategori',
        'kondisi_saat_ini',
        'status_aktif',
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_aset', 'id_aset');
    }
}