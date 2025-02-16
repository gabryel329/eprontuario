<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcAgenda extends Model
{
    use HasFactory;

    protected $table = 'proc_agendas';

    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'agenda_id',
        'paciente_id',
        'procedimento_id',
        'codigo',
        'valor',
        'dataproc'
    ];

    // Relacionamento com o model Agenda
    public function agenda()
    {
        return $this->belongsTo(Agenda::class, 'agenda_id');
    }

    // Relacionamento com o model Paciente
    public function paciente()
    {
        return $this->belongsTo(Pacientes::class, 'paciente_id');
    }

    // Relacionamento com o model Medicamento
    public function procedimento()
    {
        return $this->belongsTo(Procedimentos::class, 'procedimento_id');
    }
}
