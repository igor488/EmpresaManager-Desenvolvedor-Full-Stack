<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bandeira extends Model
{

    use HasFactory;

    protected $fillable = [
        'nome',
        'grupo_economico_id',
    ];

    public function grupoEconomico(): BelongsTo
    {
        return $this->belongsTo(GrupoEconomico::class, 'grupo_economico_id');
    }

    public function unidades(): HasMany
    {
        return $this->hasMany(Unidade::class);
    }
}
