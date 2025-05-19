<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barbearia extends Model
{
    /** @use HasFactory<\Database\Factories\BarbeariaFactory> */
    use HasFactory;

    // ---------- Configurações básicas ----------

    // Nome da tabela (opcional, pois segue convenção)
    protected $table = 'barbearias';

    // Colunas que podem ser atribuídas em massa
    protected $fillable = [
        'nome',
        'endereco',
        'latitude',
        'longitude',
        'telefone',
        'email',
    ];

    // ---------- Relacionamentos ----------

    /**
     * Uma barbearia oferece vários serviços.
     */
    public function servicos()
    {
        return $this->hasMany(Servico::class, 'barbearia_id');
    }

    /**
     * Uma barbearia emprega vários profissionais.
     */
    public function profissionais()
    {
        return $this->hasMany(Profissional::class, 'barbearia_id');
    }

    /**
     * Os agendamentos ocorrem nesta barbearia.
     */
    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class, 'barbearia_id');
    }
}
