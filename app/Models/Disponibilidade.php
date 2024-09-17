<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disponibilidade extends Model
{
    protected $fillable = [
        'profissional_id',
        'especialidade_id',
        'porcentagem',
        'valor',
        'material',
        'medicamento',
        'turno',
        'hora',
        // Campos de dias e hor�rios para manh�
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
    ];

    public function profissional()
    {
        return $this->belongsTo(Profissional::class, 'profissional_id');
    }

    public function especialidade()
    {
        return $this->belongsTo(Especialidade::class, 'especialidade_id');
    }
}
