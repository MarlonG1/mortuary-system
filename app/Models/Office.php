<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Office extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'location',
    ];

    public function employees() : HasMany
    {
        return $this->hasMany(Employee::class);
    }

    public function sales() : HasMany
    {
        return $this->hasMany(Sale::class);
    }

}
