<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;



class CategoryImage extends Model
{
    protected $table = 'category_images';
    protected $fillable = ['category_id', 'image'];

    
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
