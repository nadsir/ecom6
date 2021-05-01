<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProductsAttribute;

class Product extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }

    public function section()
    {
        return $this->belongsTo('App\Section', 'section_id');
    }

    public function attributes()
    {
        return $this->hasMany(ProductsAttribute::class);
    }

    public function images()
    {
        return $this->hasMany(ProductsImage::class);
    }

    public function brand()
    {
        return $this->belongsTo('App\Brand', 'brand_id');
    }

    //we use static because we want to use this function every where
    public static function productsFilter()
    {

        $productsFilter['fabricArray'] = array('Cotton', 'Polyester', 'wool');
        $productsFilter['sleeveArray'] = array('Full Sleeve', 'Half Sleeve', 'Short Sleeve', 'sleeveless');
        $productsFilter['patternArray'] = array('Checked', 'Plain', 'Printed', 'Self', 'Solid');
        $productsFilter['fitArray'] = array('Regular', 'slim', 'wool');
        $productsFilter['occasionArray'] = array('Casual', 'Formal');
        return $productsFilter;
    }

    public static function getDiscounterPrice($product_id)
    {
        $proDetails = Product::select('product_price', 'product_discount', 'category_id')->where('id', $product_id)
            ->first()->toArray();
        $catDetails = Category::select('category_discount')->where('id', $proDetails['category_id'])->first()->toArray();
        if ($proDetails['product_discount'] > 0) {
            $discounted_price = $proDetails['product_price'] - ($proDetails['product_price'] * $proDetails['product_discount'] / 100);
            //Sale Price=Cost Price-Discount Price
            //
        } else if ($catDetails['category_discount'] > 0) {
            $discounted_price = $proDetails['product_price'] - ($proDetails['product_price'] * $catDetails['category_discount'] / 100);


        } else {
            $discounted_price = 0;
        }
        return $discounted_price;
    }
}
