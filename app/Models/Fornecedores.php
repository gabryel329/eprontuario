<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fornecedores extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'fornecedores';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // Dados Gerais
        'cnpj', 'cpf', 'name', 'fantasia', 'insc_est', 'insc_municipal',

        // Endereço
        'cep', 'rua', 'numero', 'bairro', 'cidade', 'uf',

        // Outras Informações
        'tipo', 'tipo_cf_a', 'grupo', 'site', 'contato_principal', 'senha',
        'prazo', 'email', 'telefone',

        // Informações Sobre o Contrato
        'valor_mensal', 'ultimo_reajuste', 'dia_vencimento', 'valido_ate',
        'juros_dia', 'multa', 'multa_dia',
    ];

    public function contasfinanceiras()
    {
        return $this->hasMany(ContasFinanceiras::class, 'fornecedor_id');
    }
}
