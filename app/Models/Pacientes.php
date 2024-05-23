<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Pacientes extends Model
{
    use HasFactory, SoftDeletes, HasApiTokens, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table='pacientes';
    protected $fillable = [
        'name',
        'sobrenome',
        'email',
        'nasc',
        'cpf',
        'cep',
        'rua',
        'bairro',
        'cidade',
        'uf',
        'numero',
        'complemento',
        'genero',
        'telefone',
        'celular',
        'nome_social',
        'acompanhante',
        'nome_pai',
        'nome_mae',
        'sus',
        'convenio',
        'matricula',
        'certidao',
        'rg',
        'cor',
    ];
    protected $dates=['deleted_at'];

    public function anamneses()
    {
        return $this->hasMany(Anamnese::class, 'paciente_id');
    }
}
