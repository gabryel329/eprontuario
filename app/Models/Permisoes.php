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
        return $this->belongsToMany(User::class, 'permissao_user', 'permisao_id', 'user_id');
    }

    
}
