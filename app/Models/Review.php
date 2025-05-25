<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    protected $fillable = [
        'user_id',
        'barbearia_id',
        'agendamento_id',
        'nota',
        'comentario'
    ];

    protected $casts = [
        'nota' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function barbearia()
    {
        return $this->belongsTo(Barbearia::class);
    }

    public function agendamento()
    {
        return $this->belongsTo(Agendamento::class);
    }
}
