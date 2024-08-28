<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Customer extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'name',
        'lastname',
        'email',
        'phone',
        'location',
        'dui',
    ];

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'phone' => $this->phone,
            'location' => $this->location,
            'dui' => $this->dui,
        ];
    }

    public function sales() : hasMany
    {
        return $this->hasMany(Sale::class);
    }
}
