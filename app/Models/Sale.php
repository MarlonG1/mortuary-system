<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Scout\Searchable;

class Sale extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
      'customer_id',
      'office_id',
      'total',
      'sale_date',
      'execution_date'
    ];

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'total' => $this->total,
            'sale_date' => $this->sale_date,
            'execution_date' => $this->execution_date,
        ];
    }

    public function services() : belongsToMany
    {
        return $this->belongsToMany(Service::class, 'sale_service');
    }

    public function customer() : belongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function office() : BelongsTo
    {
        return $this->belongsTo(Office::class);
    }
}
