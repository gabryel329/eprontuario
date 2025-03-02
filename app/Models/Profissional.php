<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profissional extends Model
{
    use HasFactory, SoftDeletes;

    protected $table='profissionals';
    protected $fillable = [
        'name',
        'email',
        'password',
        'permisoes_id',
        'especialidade_id',
        'nasc',
        'cpf',
        'cor',
        'cbo',
        'rg',
        'cep',
        'rua',
        'bairro',
        'cidade',
        'uf',
        'numero',
        'complemento',
        'genero',
        'imagem',
        'sobrenome',
        'corem',
        'telefone',
        'celular',
        'tipoprof_id',
        'porcentagem',
        'valor',
        'material',
        'medicamento',
        'conselho_1',
        'uf_conselho_1',
        'conselho_2',
        'uf_conselho_2',

        // Campos de dias e horários para manhã
        'manha_dom',
        'manha_seg',
        'manha_ter',
        'manha_qua',
        'manha_qui',
        'manha_sex',
        'manha_sab',
        'inihonorariomanha',
        'interhonorariomanha',
        'fimhonorariomanha',

        // Campos de dias e horários para tarde
        'tarde_dom',
        'tarde_seg',
        'tarde_ter',
        'tarde_qua',
        'tarde_qui',
        'tarde_sex',
        'tarde_sab',
        'inihonorariotarde',
        'interhonorariotarde',
        'fimhonorariotarde',

        // Campos de dias e horários para noite
        'noite_dom',
        'noite_seg',
        'noite_ter',
        'noite_qua',
        'noite_qui',
        'noite_sex',
        'noite_sab',
        'inihonorarionoite',
        'interhonorarionoite',
        'fimhonorarionoite'
    ];

    protected $dates=['deleted_at'];
    public function permisao()
    {
        return $this->belongsTo(Permisoes::class, 'permisoes_id');
    }

    public function especialidade()
    {
        return $this->belongsTo(Especialidade::class, 'especialidade_id');
    }

    public function tipoprof()
    {
        return $this->belongsTo(TipoProf::class, 'tipoprof_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'profissional_id');
    }

    public function agenda()
    {
        return $this->hasMany(Agenda::class, 'profissional_id');
    }

    public function convenios()
    {
        return $this->belongsToMany(Convenio::class, 'convenio_profissional')
                    ->withPivot('codigo_operadora');
    }
    public function atendimento()
    {
        return $this->hasMany(Atendimentos::class, 'profissional_id');
    }
    public function remedio()
    {
        return $this->hasMany(Remedio::class, 'profissional_id');
    }
    public function anamnese()
    {
        return $this->hasMany(Anamnese::class, 'profissional_id');
    }
    public function procedimento()
    {
        return $this->hasMany(Procedimentos::class, 'agenda_id');
    }
    public function especialidades()
    {
        return $this->belongsToMany(Especialidade::class, 'especialidade_profissional');
    }

    public function honorarios()
    {
        return $this->hasMany(Honorario::class);
    }

    public function disponibilidade()
    {
        return $this->hasOne(Disponibilidade::class, 'profissional_id');
    }
    public function guia()
    {
        return $this->hasMany(GuiaConsulta::class, 'profissional_id');
    }
    public function guiasadt()
    {
        return $this->hasMany(GuiaSp::class, 'profissional_id');
    }
}
