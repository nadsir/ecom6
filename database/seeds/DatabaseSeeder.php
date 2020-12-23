<?php

use Illuminate\Database\Seeder;
use App\Admin;
use App\Section;
use App\User;
use App\Category;
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
        $categoryRecords=[
            ['id'=>1,'parent_id'=>0,'section_id'=>1,'category_name'=>'T-Shirts','category_image'=>'','category_discount'=>0,'description'=>'','url'=>'t-shirt',
                'meta_title'=>'','meta_description'=>'','meta_keywords'=>'','status'=>1],
            ['id'=>2,'parent_id'=>1,'section_id'=>1,'category_name'=>'Casual T-Shirts','category_image'=>'','category_discount'=>0,'description'=>'','url'=>'Casual t-shirt',
                'meta_title'=>'','meta_description'=>'','meta_keywords'=>'','status'=>1],
        ];
        Category::insert($categoryRecords);
    }
}
