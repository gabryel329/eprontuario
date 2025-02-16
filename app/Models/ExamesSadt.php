<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamesSadt extends Model
{
    use HasFactory;

     // Nome da tabela
     protected $table = 'exames_sadt';

     // Campos que podem ser preenchidos em massa
     protected $fillable = [
         'guia_sps_id',
         'tabela',
         'codigo_procedimento_solicitado',
         'descricao_procedimento',
         'qtd_sol',
         'qtd_aut',
         'agenda_id',
     ];
 
     // Relacionamento com GuiaSps
     public function guiaSps()
     {
         return $this->belongsTo(GuiaSp::class, 'guia_sps_id');
     }
}
