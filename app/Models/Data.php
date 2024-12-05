<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Data extends Model
{
    protected $fillable =
    [
        'no_kk',
        'nik',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'kabupaten_asal',
        'kecamatan_asal_id',
        'desa_asal_id',
        'alamat_asal',
        'kabupaten_tujuan',
        'kecamatan_tujuan_id',
        'desa_tujuan_id',
        'alamat_tujuan',
    ];

    public function kecamatan_asal(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_asal_id', 'id');
    }
    public function desa_asal(): BelongsTo
    {
        return $this->belongsTo(Desa::class, 'desa_asal_id', 'id');
    }
    public function kecamatan_tujuan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_tujuan_id', 'id');
    }
    public function desa_tujuan(): BelongsTo
    {
        return $this->belongsTo(Desa::class, 'desa_tujuan_id', 'id');
    }
}
