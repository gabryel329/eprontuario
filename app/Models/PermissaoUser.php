<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissaoUser extends Model
{
    use HasFactory;
    protected $table='permissao_user';
    protected $fillable=['user_id', 'permisao_id'];
}
