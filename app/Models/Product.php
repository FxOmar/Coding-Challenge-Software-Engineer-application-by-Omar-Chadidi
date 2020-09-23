<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'description ',
        'price',
        'image'
    ];
    /**
     * The categories that belong to the Product.
     */
    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'category_product', 'product_id', 'category_id');
    }
}
