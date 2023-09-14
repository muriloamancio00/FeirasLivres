<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['regra', 'permissao', 'type_id'];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
