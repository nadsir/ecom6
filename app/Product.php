<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProductsAttribute;
class Product extends Model
{
    public function category(){
        return $this->belongsTo('App\Category','category_id');
    }
    public function section(){
        return $this->belongsTo('App\Section','section_id');
    }
    public function attributes(){
        return $this->hasMany(ProductsAttribute::class);
    }
    public function images(){
        return $this->hasMany(ProductsImage::class);
    }
    public function brand(){
        return $this->belongsTo('App\Brand','brand_id');
    }
}
