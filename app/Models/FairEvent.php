<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FairEvent extends Model
{
    use HasFactory;

    protected $table = 'fairs_events';
    protected $fillable = ['fair_id', 'event_id', 'data', 'status', 'horarioInicio', 'horarioFim'];

    public function fair()
    {
        return $this->belongsTo(Fair::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
