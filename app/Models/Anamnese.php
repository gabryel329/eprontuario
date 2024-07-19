<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Anamnese extends Model
{
    use HasFactory, SoftDeletes;

    protected $table='anamneses';
    protected $fillable = [
        'paciente_id',
        'pa',
        'temp',
        'peso',
        'altura',
        'imc',
        'classificacao',
        'gestante',
        'dextro',
        'spo2',
        'fc',
        'fr',
        'acolhimento',
        'acolhimento1',
        'acolhimento2',
        'acolhimento3',
        'acolhimento4',
        'alergia1',
        'alergia2',
        'alergia3',
        'anamnese',
        'profissional_id',
        'agenda_id'
    ];

    protected $dates=['deleted_at'];

    public function paciente()
    {
        return $this->belongsTo(Pacientes::class, 'paciente_id');
    }
    public function profissional()
    {
        return $this->belongsTo(Profissional::class, 'profissional_id');
    }
    public function agenda()
    {
        return $this->belongsTo(Agenda::class, 'agenda_id');
    }
}
