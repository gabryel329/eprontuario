<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tabela extends Model
{
    use HasFactory, SoftDeletes;
    protected $table='tabelas';
    protected $fillable=['nome', 'valor'];
    protected $dates=['deleted_at'];
}
