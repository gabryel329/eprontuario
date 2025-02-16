<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cid extends Model
{
    use HasFactory, SoftDeletes;

    protected $table='cid';
    protected $fillable=['cid10', 'descr'];
    protected $dates=['deleted_at'];
}
