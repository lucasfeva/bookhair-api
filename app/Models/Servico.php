<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    /** @use HasFactory<\Database\Factories\ServicoFactory> */
     use HasFactory;

    // ---------- Configurações básicas ----------

    protected $table = 'servicos';

    // Colunas permitidas para inserção em massa
    protected $fillable = [
        'barbearia_id',
        'nome',
        'descricao',
        'duracao_minutos',
        'preco',
    ];

    // ---------- Relacionamentos ----------

    /**
     * Um serviço pertence a uma barbearia.
     */
    public function barbearia()
    {
        return $this->belongsTo(Barbearia::class, 'barbearia_id');
    }

    /**
     * Um serviço pode aparecer em muitos agendamentos.
     */
    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class, 'servico_id');
    }

    /**
     * Profissionais que realizam este serviço (pivot).
     */
    public function profissionais()
    {
        return $this->belongsToMany(
            Profissional::class,
            'profissional_servico',
            'servico_id',
            'profissional_id'
        );
    }
}
