<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products';
    protected $fillable = array('name','unitsInStock','unitPrice','categoryId','description');

    public function categories(){
        return $this->belongsTo('App\Category','categoryId', 'id');
    }
    public function productImage()
    {
        return $this->hasOne('App\ProductImage','product_id','id');
    }
}
