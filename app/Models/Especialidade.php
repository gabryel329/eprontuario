<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Especialidade extends Model
{
    use HasFactory, SoftDeletes;
    protected $table='especialidades';
    protected $fillable=['especialidade'];
    protected $dates=['deleted_at'];

    public function users()
    {
        return $this->hasMany(User::class, 'especialidade_id');
    }

    public function profissional()
    {
        return $this->hasMany(Profissional::class, 'especialidade_id');
    }
}
