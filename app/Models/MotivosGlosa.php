<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotivosGlosa extends Model
{
    use HasFactory;

    // Define a tabela associada
    protected $table = 'motivos_glosas';

    // Campos permitidos para atribuição em massa
    protected $fillable = [
        'codigo',
        'descricao',
        'ativo',
    ];

    /**
     * Relacionamentos (se aplicável).
     * Exemplo: Um motivo pode estar relacionado a várias guias glosadas.
     */
}
