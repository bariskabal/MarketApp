<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class ProductImage extends Model
{
    protected $table = 'product_images';
    protected $fillable = ['product_id', 'image'];

    
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
