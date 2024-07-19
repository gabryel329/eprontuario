<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoProf extends Model
{
    use HasFactory, SoftDeletes;
    protected $table='tipo_profs';
    protected $fillable=['nome', 'conselho'];
    protected $dates=['deleted_at'];

    public function profissional()
    {
        return $this->hasMany(Profissional::class, 'tipoprof_id');
    }
}
