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
    ];
    protected $dates=['deleted_at'];

    public function remedio()
    {
        return $this->belongsTo(Remedio::class, 'medicamento_id');
    }
}
