<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedAgenda extends Model
{
    use HasFactory;

    protected $table = 'med_agendas';

    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'agenda_id',
        'paciente_id',
        'medicamento_id',
        'dose',
        'hora',
        'valor',
        'unidade_medida',
        'qtd_solicitada',
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
    public function medicamento()
    {
        return $this->belongsTo(Medicamento::class, 'medicamento_id');
    }
}
