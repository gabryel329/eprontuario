<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxaAgenda extends Model
{
    use HasFactory;
    protected $table = 'taxa_agendas';

    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'agenda_id',
        'paciente_id',
        'guia_sps_id',
        'taxa_id',
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
    public function produto()
    {
        return $this->belongsTo(Produtos::class, 'taxa_id');
    }
}
