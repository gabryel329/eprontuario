<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medicamento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table='medicamentos';
    protected $fillable = [
        'nome',
        'marca',
        'tipo',
        'grupo',
        'produto',
        'sub_grupo',
        'preco_venda',
        'natureza',
        'ativo',
        'controlado',
        'padrao',
        'ccih',
        'generico',
        'consignado',
        'disp_emergencia',
        'disp_paciente',
        'fracionado',
        'imobilizado',
        'antibiotico',
        'substancias',
    ];
    protected $dates=['deleted_at'];

    public function remedio()
    {
        return $this->belongsTo(Remedio::class, 'medicamento_id');
    }
    public function medagenda()
    {
        return $this->hasMany(MedAgenda::class, 'medicamento_id');
    }
}
