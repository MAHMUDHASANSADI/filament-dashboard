<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Product extends Model
{
    use LogsActivity;
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'sale_price',
        'stock',
        'is_active',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'slug',
                'description',
                'price',
                'stock',
                'is_active',
                'category_id',
            ]);
    }
}
