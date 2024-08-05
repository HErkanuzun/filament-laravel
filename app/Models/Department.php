<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use hasFactory;
    protected $fillable = [
        'name',
        'city_id'
    ];
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
