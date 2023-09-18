<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;


    protected $fillable = ['nome', 'descricao'];

    public function rules() {
        return [
            'nome' => 'required|unique:category,nome,'.$this->id.'|min:3',
        ];
    }

    public function category() {
        return $this->hasMany('App\Models\Product');
    }
}
