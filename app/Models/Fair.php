<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fair extends Model
{
    use HasFactory;

    protected $casts = [
        'dias_abertura' => 'array',
    ];

    protected $fillable = [
        'nome',
        'endereco',
        'horarioInicio',
        'horarioFim',
        'longitude',
        'latitude',
        'dias_abertura',
    ];

    public function rules(){
        return [
            'nome' => 'required|min:3',
            'endereco' => 'required|min:10',
            'horarioInicio' => 'required|date_format:H:i:s',
            'horarioFim' => 'required|date_format:H:i:s',
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
    public function events()
    {
        return $this->belongsToMany('App\Models\Event', 'fairs_events');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'fairs_categories');
    }
}
