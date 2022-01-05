<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = array('categoryName');

    public function Product(){
        return $this->hasMany('App\Product','categoryId');
    }
}
