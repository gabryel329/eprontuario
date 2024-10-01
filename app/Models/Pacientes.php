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
        'estado_civil',
        'pcd',
        'sus',
        'convenio_id',
        'matricula',
        'plano',
        'titular',
        'validade',
        'produto',
        'certidao',
        'rg',
        'cor',
        'imagem',
    ];
    protected $dates=['deleted_at'];

    public function anamneses()
    {
        return $this->hasMany(Anamnese::class, 'paciente_id');
    }

    public function agenda()
    {
        return $this->hasMany(Agenda::class, 'paciente_id');
    }
    public function atendimento()
    {
        return $this->hasMany(Atendimentos::class, 'paciente_id');
    }
    public function remedio()
    {
        return $this->hasMany(Remedio::class, 'paciente_id');
    }
    public function procedimento()
    {
        return $this->hasMany(Procedimentos::class, 'agenda_id');
    }
    public function painel()
    {
        return $this->belongsTo(Painel::class, 'paciente_id');
    }
    public function convenio()
    {
        return $this->belongsTo(Convenio::class, 'convenio_id');
    }

}
