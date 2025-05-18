<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nome',
        'email',
        'password',
        'telefone',
        'endereco',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // -- Casts: password deve ser hashed automaticamente
    protected $casts = [
        'password' => 'hashed',
    ];


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Laravel espera o atributo "password" para autenticação.
     * Como renomeamos para "password", precisamos sobrescrever:
     */
    public function getAuthPassword(): string
    {
        return $this->password;
    }

    /**
     * Relação: um Usuário (cliente) faz muitos Agendamentos
     */
    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class, 'cliente_id');
    }
}
