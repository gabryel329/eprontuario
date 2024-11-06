<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAtendimento extends Model
{
    use HasFactory;

    protected $table = 'tipo_atendimentos';

    protected $fillable = [
        'atendimento',
        'codigo',
    ];
}
