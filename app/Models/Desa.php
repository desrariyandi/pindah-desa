<?php

namespace App\Models;

use App\Models\Data;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Desa extends Model
{
    public function hasManyData(): HasMany
    {
        return $this->hasMany(Data::class);
    }

    public function kecamatan_asal(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_asal_id', 'id');
    }

    public function kecamatan_tujuan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_tujuan_id', 'id');
    }
}
