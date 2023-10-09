<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FairsCategories extends Model
{
    use HasFactory;

    protected $table = 'fairs_categories';

    protected $fillable = ['fair_id', 'category_id'];

    public function rules() {
        return [
            'fair_id' => 'required|exists:fairs,id',
            'category_id' => 'required|exists:categories,id',
        ];
    }
    public function feedback() {
        return [
            'required' => 'O campo :attribute é obrigatório',
        ];
    }

    public function fairs() {
        return $this->belongsTo(\App\Models\Fair::class);
    }

    public function categories() {
        return $this->belongsTo(\App\Models\Category::class);
    }

}
