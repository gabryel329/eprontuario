<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NfeParticula extends Model
{
    use HasFactory;

    protected $table = 'nfeparticula'; // Define o nome correto da tabela

    protected $fillable = [
        'nNF',
        'dhEmi',
        'xNome',
        'CPF',
        'tPag',
        'vPag',
        'tBand',
        'cAut',
        'nRec',
        'nProt',
        'xml_gerado',
    ];

    protected $casts = [
        'dhEmi' => 'datetime', // Converte automaticamente para um objeto Carbon
    ];
}
