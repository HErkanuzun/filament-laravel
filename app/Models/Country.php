<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use hasFactory;
    protected $fillable=[
        "country_id",
        "name",
    ];
    public function states()
    {
        return $this->hasMany(State::class);
    }
}
