<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','url','vat_value','vat_value_type',
        'shipping_cost_value','shipping_cost_value_type'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
