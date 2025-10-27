<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GrupoEconomico extends Model
{
      use HasFactory;

    protected $fillable = ['nome'];

    public function bandeiras()
    {
        return $this->hasMany(Bandeira::class, 'grupo_economico_id');
    }
    
}
