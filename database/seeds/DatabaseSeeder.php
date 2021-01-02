<?php

use Illuminate\Database\Seeder;
use App\Admin;
use App\Section;
use App\User;
use App\Category;
use App\Product;
use App\ProductsAttribute;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
/*        Admin::truncate();
        Section::truncate();
        User::truncate();
        factory(App\Admin::class,10)->create();*/
        /*factory(App\Section::class,10)->create();*/
/*        factory(App\User::class,10)->create();*/

/*        $sectionRecord=[
            ['id'=>1,'name'=>'Men','status'=>1],
            ['id'=>2,'name'=>'Women','status'=>1],
            ['id'=>3,'name'=>'Kids','status'=>1],
        ];
        Section::insert($sectionRecord);*/
/*        $categoryRecords=[
            ['id'=>1,'parent_id'=>0,'section_id'=>1,'category_name'=>'T-Shirts','category_image'=>'','category_discount'=>0,'description'=>'','url'=>'t-shirt',
                'meta_title'=>'','meta_description'=>'','meta_keywords'=>'','status'=>1],
            ['id'=>2,'parent_id'=>1,'section_id'=>1,'category_name'=>'Casual T-Shirts','category_image'=>'','category_discount'=>0,'description'=>'','url'=>'Casual t-shirt',
                'meta_title'=>'','meta_description'=>'','meta_keywords'=>'','status'=>1],
        ];
        Category::insert($categoryRecords);*/
/*        $productRecords=[
            ['id'=>1,'category_id'=>4,'section_id'=>1,'product_name'=>'Blue Casual T-Shirt','product_code'=>'BT001','product_color'=>'Blue','product_price'=>'1500',
                'product_discount'=>10,'product_weight'=>200,'product_video'=>'','main_image'=>'','description'=>'Test Product','wash_care'=>'','fabric'=>'',
                'pattern'=>'','sleeve'=>'','fit'=>'','occassion'=>'','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','is_featured'=>'No','status'=>1,

                ],
            ['id'=>2,'category_id'=>4,'section_id'=>1,'product_name'=>'Red Casual T-Shirt','product_code'=>'RT001','product_color'=>'Red','product_price'=>'2000',
                'product_discount'=>10,'product_weight'=>200,'product_video'=>'','main_image'=>'','description'=>'Test Product','wash_care'=>'','fabric'=>'',
                'pattern'=>'','sleeve'=>'','fit'=>'','occassion'=>'','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','is_featured'=>'Yes','status'=>1,

            ],
        ];
        Product::insert($productRecords);*/
        $productAttributeRecords=[
            ['id'=>1,'product_id'=>10,'size'=>'small','price'=>1200,'stock'=>10,'sku'=>'GCT001-S','status'=>1],
            ['id'=>2,'product_id'=>10,'size'=>'small','price'=>1300,'stock'=>20,'sku'=>'GCT001-M','status'=>1],
            ['id'=>3,'product_id'=>10,'size'=>'small','price'=>1400,'stock'=>10,'sku'=>'GCT001-L','status'=>1],
        ];
        ProductsAttribute::insert($productAttributeRecords);
    }
}
