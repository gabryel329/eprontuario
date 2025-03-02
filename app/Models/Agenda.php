<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agenda extends Model
{
    use HasFactory, SoftDeletes;

    protected $table='agendas';
    protected $fillable = [
        'hora',
        'data',
        'name',
        'celular',
        'sobrenome',
        'paciente_id',
        'profissional_id',
        'especialidade_id',
        'convenio_id',
        'matricula',
        'codigo',
        'procedimento_id',
        'status',
        'valor_proc'
    ];
    protected $dates=['deleted_at'];

    public function profissional()
    {
        return $this->belongsTo(Profissional::class, 'profissional_id');
    }

    public function especialidade()
    {
        return $this->belongsTo(Especialidade::class, 'profissional_id');
    }

    public function convenio()
    {
        return $this->belongsTo(Convenio::class, 'convenio_id');
    }

    public function paciente()
    {
        return $this->belongsTo(Pacientes::class, 'paciente_id');
    }

    public function atendimento()
    {
        return $this->belongsTo(Atendimentos::class, 'agenda_id');
    }

    public function anamnese()
    {
        return $this->belongsTo(Anamnese::class, 'agenda_id');
    }
    public function remedio()
    {
        return $this->belongsTo(Remedio::class, 'agenda_id');
    }
    public function procedimento()
    {
        return $this->belongsTo(Procedimentos::class, 'procedimento_id');
    }
    public function painel()
    {
        return $this->belongsTo(Painel::class, 'agenda_id');
    }
    public function guia()
    {
        return $this->hasMany(GuiaConsulta::class, 'agenda_id');
    }

    public function medagenda()
    {
        return $this->hasMany(MedAgenda::class, 'agenda_id');
    }

    public function procagenda()
    {
        return $this->hasMany(ProcAgenda::class, 'agenda_id');
    }

    public function guiaSps()
    {
        return $this->hasOne(GuiaSp::class);
    }

}
