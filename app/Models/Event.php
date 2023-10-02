<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = ['nome', 'descricao'];

    public function rules() {
        return [
            'nome' => 'required|unique:events,nome,'.$this->id.'|min:3',
            'descricao' => 'required|nullable|integer|not_in:0|exists:categories,id',
        ];
    }

    public function feedback() {
        return [
            'required' => 'O Campo :attribute é Obrigatório',
            'nome.unique' => 'O nome do evento já existe',
            'nome.min' => 'O nome deve ter no mínimo 3 caracteres',
        ];
    }

    public function fairs_events()
    {
        return $this->belongsToMany('App\Models\FairEvent');
    }
}
