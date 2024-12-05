<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kecamatan extends Model
{
    public function hasManyData(): HasMany
    {
        return $this->hasMany(Data::class);
    }
    public function hasManyDesa(): HasMany
    {
        return $this->hasMany(Desa::class);
    }
}
