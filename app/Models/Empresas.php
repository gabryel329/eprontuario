<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Empresas extends Model
{
    use HasFactory, SoftDeletes, HasApiTokens, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table='empresas';
    protected $fillable = [
        'name',
        'email',
        'cnpj',
        'cep',
        'rua',
        'bairro',
        'cidade',
        'uf',
        'numero',
        'complemento',
        'celular',
        'telefone',
        'medico',
        'crm',
        'fantasia',
        'imagem',
        'licenca',
        'contrato',
    ];
    protected $dates=['deleted_at'];
}