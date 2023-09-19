<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fair extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'endereco',
        'horarioInicio',
        'horarioFim',
        'longitude',
        'latitude'
    ];

    public function rules(){
        return [
            'nome' => 'required|min:3',
            'endereco' => 'required|min:10',
            'horarioInicio' => 'required|date_format:H:i',
            'horarioFim' => 'required|date_format:H:i',
        ];
    }

    public function feedback() {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'nome.unique' => 'O nome da categoria já existe',
            'nome.min' => 'O nome deve ter no mínimo 3 caracteres',
            //'descricao.min' => 'A descricao deve ter no mínimo 5 caracteres',
        ];
    }

    public function fair_events() {
        return $this->hasMany('App\Models\FairEvent');
    }
}
