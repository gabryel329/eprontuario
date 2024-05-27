<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profissional extends Model
{
    use HasFactory, SoftDeletes;

    protected $table='profissionals';
    protected $fillable = [
        'name',
        'email',
        'password',
        'permisoes_id',
        'especialidade_id',
        'nasc',
        'cpf',
        'crm',
        'cep',
        'rua',
        'bairro',
        'cidade',
        'uf',
        'numero',
        'complemento',
        'genero',
        'imagem',
        'sobrenome',
        'corem',
    ];
    protected $dates=['deleted_at'];
    public function permisao()
    {
        return $this->belongsTo(Permisoes::class, 'permisoes_id');
    }

    public function especialidade()
    {
        return $this->belongsTo(Especialidade::class, 'especialidade_id');
    }
}
