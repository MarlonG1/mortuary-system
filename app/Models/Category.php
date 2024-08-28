<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Scout\Searchable;

class Category extends Model
{
    use HasFactory, Searchable;


    protected $table = 'categories';
    protected $fillable = [
        'name',
        'details',
        'type',
        'stock',
    ];

    protected $casts = [
        'stock' => 'boolean',
    ];

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
        ];
    }

    public function service() : hasOne
    {
        return $this->hasOne(Service::class);
    }

    public function products() : belongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_category');
    }

}
