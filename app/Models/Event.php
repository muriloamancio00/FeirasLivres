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
        ];
    }

    public function feedback() {
        return [
            'required' => 'O Campo :attribute é Obrigatório',
            'nome.unique' => 'O nome do evento já existe',
            'nome.min' => 'O nome deve ter no mínimo 3 caracteres',
        ];
    }
    public function fair()
    {
        return $this->hasMany(FairsEvents::class, 'event_id', 'id');
    }
}
