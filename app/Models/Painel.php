<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Painel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table='painels';
    protected $fillable = [
        'paciente_id',
        'agenda_id',
        'user_id',
        'sala_id',
        'sequencia',
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
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
