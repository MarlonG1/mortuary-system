<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'initial_stock',
        'current_stock',
        'image'
    ];

    public $timestamps = false;

    public function products() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
