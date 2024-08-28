<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'description',
        'price',
        'initial_stock',
        'current_stock',
    ];

    protected $casts = [
        'price' => 'float',
        'initial_stock' => 'integer',
        'current_stock' => 'integer',
    ];

    protected $table = 'service_details';

    public $timestamps = false;

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
