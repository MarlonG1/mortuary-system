<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Scout\Searchable;

class Employee extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'office_id',
        'name',
        'lastname',
        'phone',
        'birth_date',
        'dui',
    ];

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'lastname' => $this->lastname,
            'birth_date' => $this->birth_date,
        ];
    }

    public function office() : BelongsTo
    {
        return $this->belongsTo(Office::class);
    }

    public function user() : hasOne
    {
        return $this->hasOne(User::class);
    }
}
