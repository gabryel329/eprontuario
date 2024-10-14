<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produtos extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'produtos';

    protected $fillable = [
        'nome',
        'marca',
        'tipo',
        'grupo',
        'sub_grupo',
        'preco_venda',
        'natureza',
        'ativo',
        'controlado',
        'padrao',
        'ccih',
        'generico',
        'consignado',
        'disp_emergencia',
        'disp_paciente',
        'fracionado',
        'imobilizado',
    ];
}
