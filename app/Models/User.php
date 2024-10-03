<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table='users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'profissional_id',
        'sobrenome',
        'imagem',
        'permisao_id'
    ];
    protected $dates=['deleted_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profissional()
    {
        return $this->belongsTo(Profissional::class, 'profissional_id');
    }

    public function painel()
    {
        return $this->belongsTo(Painel::class, 'user_id');
    }
    public function permissoes()
    {
        return $this->belongsToMany(Permisoes::class, 'permissao_user', 'user_id', 'permisao_id');
    }
    public function guiatiss()
    {
        return $this->belongsTo(GuiaTiss::class, 'user_id');
    }
    public function guiasp()
    {
        return $this->belongsTo(GuiaSp::class, 'user_id');
    }
    public function guiahonorario()
    {
        return $this->belongsTo(GuiaHonorario::class, 'user_id');
    }
    public function guiaconsulta()
    {
        return $this->belongsTo(GuiaConsulta::class, 'user_id');
    }
}
