<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permisoes extends Model
{
    use HasFactory, SoftDeletes;
    protected $table='permisoes';
    protected $fillable=['cargo'];
    protected $dates=['deleted_at'];

    public function users()
    {
        return $this->hasMany(User::class, 'permisoes_id');
    }

    public function profissional()
    {
        return $this->hasMany(Profissional::class, 'permisoes_id');
    }
}
