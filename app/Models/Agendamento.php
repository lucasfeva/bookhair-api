<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    /** @use HasFactory<\Database\Factories\AgendamentoFactory> */
    use HasFactory;

     protected $table = 'agendamentos';

    // Campos atribuíveis em massa
    protected $fillable = [
        'cliente_id',
        'profissional_id',
        'servico_id',
        'barbearia_id',
        'data_hora',
        'status',
    ];

    /**
     * Relações
     */

    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    public function profissional()
    {
        return $this->belongsTo(Profissional::class, 'profissional_id');
    }

    public function servico()
    {
        return $this->belongsTo(Servico::class, 'servico_id');
    }

    public function barbearia()
    {
        return $this->belongsTo(Barbearia::class, 'barbearia_id');
    }
    
}
