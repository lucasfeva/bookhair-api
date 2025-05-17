<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profissional extends Model
{
    /** @use HasFactory<\Database\Factories\ProfissionalFactory> */
    use HasFactory;


    protected $table = 'profissionals';

    // Atributos atribuíveis em massa
    protected $fillable = [
        'nome',
        'barbearia_id',
    ];

    /**
     * Relacionamentos
     */

    // Este profissional pertence a uma barbearia
    public function barbearia()
    {
        return $this->belongsTo(Barbearia::class, 'barbearia_id');
    }

    // Agendamentos atendidos por este profissional
    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class, 'profissional_id');
    }

    // Serviços que este profissional pode executar (tabela pivot)
    public function servicos()
    {
        return $this->belongsToMany(
            Servico::class,
            'profissional_servico',
            'profissional_id',
            'servico_id'
        );
    }
}
