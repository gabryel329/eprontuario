<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Convenio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'convenios';
    protected $fillable = ['nome', 'cnpj', 'ans', 'cep', 'rua', 'bairro', 'cidade', 'uf', 'numero', 'complemento',
    'telefone', 'celular', 'operadora', 'multa', 'jutos', 'dias_desc', 'desconto', 'agfaturamento', 'pagamento',
    'impmedico', 'inss', 'iss', 'ir','pis','cofins','csl','tab_cota_id', 'tab_taxa_id',
    'tab_mat_id', 'tab_med_id', 'tab_proc_id', 'tab_cota_porte', 'tab_cota_ch'];
    protected $dates = ['deleted_at'];

    public function procedimentos()
    {
        return $this->belongsToMany(Procedimentos::class, 'convenio_procedimento')
            ->withPivot('valor')
            ->withTimestamps();
    }

    public function convenioProcedimentos()
    {
        return $this->hasMany(ConvenioProcedimento::class);
    }

    public function guiatiss()
    {
        return $this->hasMany(GuiaTiss::class, 'convenio_id');
    }
    public function guiahonorario()
    {
        return $this->hasMany(GuiaHonorario::class, 'convenio_id');
    }
    public function guiasp()
    {
        return $this->hasMany(GuiaSp::class, 'convenio_id');
    }
    public function guia()
    {
        return $this->hasMany(GuiaConsulta::class, 'convenio_id');
    }
    public function pacientes()
    {
        return $this->hasMany(Pacientes::class, 'convenio_id');
    }

    public function profissionais()
    {
        return $this->belongsToMany(Profissional::class, 'convenio_profissional')
                    ->withPivot('codigo_operadora'); // Inclui o campo `codigo_operadora`
    }
    public function agenda()
    {
        return $this->hasMany(Agenda::class, 'convenio_id');
    }

    public function disponibilidade()
    {
        return $this->hasMany(Disponibilidade::class, 'convenio_id');
    }
}
