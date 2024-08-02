<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Honorario extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'honorarios';
    protected $fillable = [
        'profissional_id',
        'convenio_id',
        'procedimento_id',
        'porcentagem',
        'codigo',
    ];
    protected $dates = ['deleted_at'];

    public function profissional()
    {
        return $this->belongsTo(Profissional::class, 'profissional_id');
    }

    public function procedimento()
    {
        return $this->belongsTo(Procedimentos::class, 'procedimento_id');
    }

    public function convenio()
    {
        return $this->belongsTo(Convenio::class, 'convenio_id');
    }
}
