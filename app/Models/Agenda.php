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
        'sobrenome',
        'paciente_id',
        'profissional_id',
        'procedimento_id',
        'status',
    ];
    protected $dates=['deleted_at'];

    public function profissional()
    {
        return $this->belongsTo(Profissional::class, 'profissional_id');
    }

    public function paciente()
    {
        return $this->belongsTo(Pacientes::class, 'paciente_id');
    }

    public function atendimento()
    {
        return $this->belongsTo(Atendimentos::class, 'agenda_id');
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
}
