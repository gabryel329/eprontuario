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
    ];


    /**
     * Define the relationship with the Paciente model.
     */

    public function fornecedores()
    {
        return $this->belongsTo(Fornecedores::class, 'fornecedor_id');
    }
}
