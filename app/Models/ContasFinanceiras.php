<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContasFinanceiras extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contas_financeiras';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'tipo_conta',
        'fornecedor_id',
        'convenio_id',
        'user_id',
        'data_emissao',
        'competencia',
        'data_vencimento',
        'referencia',
        'tipo_documento',
        'documento',
        'nao_contabil',
        'parcelas',
        'centro_custos',
        'natureza_operacao',
        'historico',
        'valor',
        'desconto',
        'juros',
        'icms',
        'pis',
        'cofins',
        'csl',
        'iss',
        'irrf',
        'inss',
        'total',
        'tipo_guia',
    ];

    public function guia()
    {
        if ($this->tipo_guia === 'Consulta') {
            return $this->belongsTo(GuiaConsulta::class, 'guia_id');
        } elseif ($this->tipo_guia === 'SADT') {
            return $this->belongsTo(GuiaSp::class, 'guia_id');
        }

        return null; // Caso não seja nenhuma das opções
    }
    /**
     * Define the relationship with the Paciente model.
     */

    public function fornecedores()
    {
        return $this->belongsTo(Fornecedores::class, 'fornecedor_id');
    }

    public function convenios()
    {
        return $this->belongsTo(Convenio::class, 'convenio_id');
    }

    public function contaGuias()
    {
        return $this->hasMany(ContaGuia::class, 'conta_financeira_id');
    }
}
