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
        'cor',
        'rg',
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
        'telefone',
        'celular',
        'tipoprof_id',
        'conselho'
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

    public function tipoprof()
    {
        return $this->belongsTo(TipoProf::class, 'tipoprof_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'profissional_id');
    }

    public function agenda()
    {
        return $this->hasMany(Agenda::class, 'profissional_id');
    }
    public function atendimento()
    {
        return $this->hasMany(Atendimentos::class, 'profissional_id');
    }
    public function remedio()
    {
        return $this->hasMany(Remedio::class, 'profissional_id');
    }
    public function anamnese()
    {
        return $this->hasMany(Anamnese::class, 'profissional_id');
    }
    public function procedimento()
    {
        return $this->hasMany(Procedimentos::class, 'agenda_id');
    }
    public function especialidades()
    {
        return $this->belongsToMany(Especialidade::class, 'especialidade_profissional');
    }
}
