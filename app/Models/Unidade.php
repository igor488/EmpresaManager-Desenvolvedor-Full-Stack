<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Unidade extends Model
{
      use HasFactory;

    protected $fillable = ['nome_fantasia', 'razao_social', 'cnpj', 'bandeira_id'];

    public function bandeira()
    {
        return $this->belongsTo(Bandeira::class, 'bandeira_id');
    }

    public function colaboradores()
    {
        return $this->hasMany(Colaborador::class, 'unidade_id');
    }
}
