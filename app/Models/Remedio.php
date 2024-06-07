<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Remedio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table='remedios';
    protected $fillable = [
        'horas',
        'remedio',
        'paciente_id',
        'agenda_id',
        'profissional_id',
        'medicamento_id',
        'dose',
    ];
    protected $dates=['deleted_at'];

    public function agenda()
    {
        return $this->belongsTo(Agenda::class, 'agenda_id');
    }

    public function paciente()
    {
        return $this->belongsTo(Pacientes::class, 'paciente_id');
    }
    
    public function profissional()
    {
        return $this->belongsTo(Profissional::class, 'profissional_id');
    }

    public function medicamento()
    {
        return $this->hasMany(Medicamento::class, 'medicamento_id');
    }
}
