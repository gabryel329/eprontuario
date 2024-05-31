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
        'consulta_id',
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
}
