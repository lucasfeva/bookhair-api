<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfissionalServico extends Model
{
    /** @use HasFactory<\Database\Factories\ProfissionalServicoFactory> */
    use HasFactory;


    // Nome da tabela pivot
    protected $table = 'profissional_servico';

    // Sem chave auto-increment
    public $incrementing = false;

    // Sem timestamps nesta pivot
    public $timestamps = false;

    // Colunas preenchíveis
    protected $fillable = [
        'profissional_id',
        'servico_id',
    ];
}
