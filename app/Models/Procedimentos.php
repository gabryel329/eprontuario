<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Procedimentos extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table='procedimentos';
    protected $fillable = [
        'codigo',
        'procedimento',
        'idade',
        'limite',
    ];
    protected $dates=['deleted_at'];

    public function exame()
    {
        return $this->belongsTo(Exames::class, 'procedimento_id');
    }
}
