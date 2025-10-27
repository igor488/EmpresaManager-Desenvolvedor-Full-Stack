<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{

     use HasFactory;
    protected $table = 'auditorias';

      protected $fillable = [
        'user_id',
        'entidade',
        'entidade_id',
        'acao',
        'dados'
    ];

    protected $casts = [
        'dados_antigos' => 'array',
        'dados_novos' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
