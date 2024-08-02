<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConvenioProcedimento extends Model
{
    use HasFactory;

    protected $table = 'convenio_procedimento';

    protected $fillable = ['convenio_id', 'procedimento_id', 'valor', 'codigo'];

    public function procedimento()
{
    return $this->belongsTo(Procedimentos::class);
}

}
