<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FairEvent extends Model
{
    use HasFactory;

    protected $table = 'fairs_events';
    protected $fillable = ['fair_id', 'event_id', 'data', 'status', 'horarioInicio', 'horarioFim'];

    public function rules() {
        return [
            'fair_id' => 'required|integer|not_in:0|unique:fairs',
            'event_id' => 'required|integer|not_in:0|unique:events',
            'data' => 'required|date_format:Y-m-d',
            'status' => 'required|integer|in:1,2,3,4',
            'horarioInicio' => 'required|regex:/^[0-9]{2}:[0-9]{2}$/|before_or_equal:horarioFim', // Adicionando filtro e regra para horarioInicio.
            'horarioFim' => 'required|regex:/^[0-9]{2}:[0-9]{2}$/|after_or_equal:horarioInicio', // Adicionando filtro e regra para horarioFim.
        ];
    }
    public function feedback() {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'unique' => 'O :attribute já está em uso',
            'integer' => 'O :attribute deve ser um número inteiro',
            'date_format' => 'O :attribute deve estar no formato YYYY-MM-DD',
            'in' => 'O :attribute deve ter um dos valores: :values', // Feedback para tipos de status.
            'regex' => 'O :attribute deve estar no formato HH:mm', // Feedback para horarioInicio e horarioFim.
            'before_or_equal' => 'O :attribute deve ser anterior ou igual a :other', // Feedback para horarioInicio.
            'after_or_equal' => 'O :attribute deve ser posterior ou igual a :other', // Feedback para horarioFim.
            'min' => 'O :attribute deve ter pelo menos :min caracteres',
        ];
    }

    public function fair()
    {
        return $this->belongsTo(Fair::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
