<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = ['nome', 'descricao', 'category_id', ];

    public function rules() {
        return [
            'nome' => 'required|unique:products,nome,'.$this->id.'|min:3',
            'category_id' => 'required|nullable|integer|not_in:0|exists:categories,id',
            //'descricao' => 'min:5',
        ];
    }

    public function feedback() {
        return [
            'required' => 'O Campo :attribute é Obrigatório',
            'nome.unique' => 'O nome da categoria já existe',
            'nome.min' => 'O nome deve ter no mínimo 3 caracteres',
            'category_id.integer' => 'O ID da categoria deve ser um número inteiro',
            'category_id.not_in' => 'O ID da categoria não pode ser 0',
            'category_id.exists' => 'O ID da categoria não foi encontrado na base de dados',
            //'descricao.min' => 'A descricao deve ter no mínimo 5 caracteres',
        ];
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}
