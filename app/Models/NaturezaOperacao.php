<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NaturezaOperacao extends Model
{
    use HasFactory;

    protected $table = 'naturezas_operacao'; // Nome da tabela no banco de dados

    protected $fillable = [
        'codigo_cfop',
        'descricao',
    ];
}
