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
            'nome' => 'required|unique:categories,nome,'.$this->id.'|min:3',
            'category_id' => 'exists:categories,id',
            //'descricao' => 'min:5',
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

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}
