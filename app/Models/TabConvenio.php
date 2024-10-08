<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TabConvenio extends Model
{
    use HasFactory, SoftDeletes;
    protected $table='tab_convenios';
    protected $fillable=['convenio_id', 'tabela_id'];
    protected $dates=['deleted_at'];

    public function convenio()
    {
        return $this->belongsTo(Convenio::class, 'convenio_id');
    }

    // Relacionamento com Tabela
    public function tabela()
    {
        return $this->belongsTo(Tabela::class, 'tabela_id');
    }
}
