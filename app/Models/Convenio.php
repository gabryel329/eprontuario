<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Convenio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table='convenios';
    protected $fillable=['cnpj', 'ans', 'nome', 'cep', 'rua', 'bairro', 'cidade', 'uf', 'numero', 'complemento', 'celular', 'telefone'];
    protected $dates=['deleted_at'];

    public function procedimentos()
    {
        return $this->belongsToMany(Procedimentos::class, 'convenio_procedimento')->withPivot('valor')->withTimestamps();
    }

    public function convenioProcedimentos()
    {
        return $this->hasMany(ConvenioProcedimento::class);
    }

    public function guiatiss()
    {
        return $this->hasMany(GuiaTiss::class, 'convenio_id');
    }
    public function pacientes()
    {
        return $this->hasMany(Pacientes::class, 'convenio_id');
    }

}
