<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayWeek extends Model
{
    use HasFactory;

    protected $table = 'days_week';

    protected $fillable = ['nome'];
}
