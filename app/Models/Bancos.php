<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bancos extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bancos';

    protected $fillable = [
        'nome',
        'codigo_banco',
        'agencia',
        'numero_conta',
        'tipo_conta',
        'titular',
        'cpf_cnpj',
        'telefone',
        'email',
        'observacoes',
    ];
}

