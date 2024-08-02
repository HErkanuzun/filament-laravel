<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use hasFactory;
    protected $fillable = [
        "state_id",
        'name',
    ];
    public function state(): Belongsto
    {
        return $this->belongsTo(State::class);
    }
}
