<?php

namespace App\Http\Controllers\Admin;
use Image;
use App\Category;
use App\Http\Controllers\Controller;
use App\Section;
use Illuminate\Http\Request;
use Session;
class CategoryController extends Controller
{
    public function categories()
    {
        Session::put('page','categories');
        $categories=Category::with(['parentcategory','section'])->get();
        $categories=json_decode(json_encode($categories));
        return view('admin.categories.categories')->with(compact('categories'));

    }

    public function updateCategoryStatus(Request $request)
    {
        if ($request->ajax()){
            if ($request->catStatus=="Active"){
                $catStatus=0;
            }else{
                $catStatus=1;
            }
            Category::where('id',$request->catId)->update(['status'=>$catStatus]);
            return response()->json(['catStatus'=>$catStatus,'category_id'=>$request->catId]);
            /*   return $request->all();*/
        }

    }

    public function addEditCategory(Request $request,$id=null)
    {
        if ($id==""){
            $title="Add Category";
            $category=new Category;
            $categorydata=array();
            $getCategories=array();
            $message="Category added successfully!";
        }else{
            $title="Edit Category";
            $categorydata=Category::where('id',$id)->first();
            $categorydata=json_decode(json_encode($categorydata),true);
            $getCategories=Category::with('subcategories')->where(['parent_id'=>0,'section_id'=>$categorydata['section_id']])->get();
            $getCategories=json_decode(json_encode($getCategories),true);

            $category=Category::find($id);

            $message="Category updated successfully!";


        }
        if ($request->isMethod('post')){
            /*dd($request->all());*/
            $role = [
                'category_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'section_id'=>'required',
                'url'=>'required',
                'category_image'=>'image'

            ];
            $customMessage = [
                'category_name.required' => 'Name is require',
                'category_name.regex' => 'Valid name is require',
                'section_id.required'=>'Section is required',
                'url.required'=>'url is required',
                'category_image.image'=>'Valid Image is required'
            ];
            $this->validate($request, $role, $customMessage);
            $data=$request->all();
            if ($request->hasFile('category_image')){
                $image_tmp=$request->file('category_image');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'images/admin_images/category_images/' . $imageName;
                    Image::make($image_tmp)->resize(300, 400)->save($imagePath);
                    $category->category_image=$imageName;
                }
            }
            if (empty($data['category_discount'])){
                $data['category_discount']="";
            }
            if (empty($data['meta_title'])){
                $data['meta_title']="";
            }
            if (empty($data['meta_description'])){
                $data['meta_description']="";
            }
            if (empty($data['meta_keywords'])){
                $data['meta_keywords']="";
            }
            if (empty($data['description'])){
                $data['description']="";
            }
            $category->parent_id=$data['parent_id'];
            $category->section_id=$data['section_id'];
            $category->category_name=$data['category_name'];
            $category->category_discount=$data['category_discount'];
            $category->description=$data['description'];
            $category->url=$data['url'];
            $category->meta_title=$data['meta_title'];
            $category->meta_description=$data['meta_description'];
            $category->meta_keywords=$data['meta_keywords'];
            $category->status=1;
            $category->save();

            Session::flash('success_message',$message);
            return redirect('admin/categories');

        }
        //Get all sections
        $getSections=Section::all();

        return view('admin.categories.add_edit_category')->with(compact('title','getSections','categorydata','getCategories'));
    }

    public function appenCategoryLevel(Request $request)
    {
        if ($request->ajax()){
            $data=$request->all();
            $getCategories=Category::with('subcategories')->where(['section_id'=>$data['getSectionId'],'parent_id'=>0,'status'=>1])->get();
            $getCategories=json_decode(json_encode($getCategories),true);
            return view('admin.categories.append_categories_level')->with(compact('getCategories'));
           /* return $getCategories;*/

        }

    }

    public function deleteCategoryImage($id)
    {
        //get category image
        $categoryImage=Category::select('category_image')->where('id',$id)->first();
        //get category image path
        $category_image_path='images/admin_images/category_images/';
        //delete category image from category_images folder if exist
        if (file_exists($category_image_path.$categoryImage->category_image)){
            unlink($category_image_path.$categoryImage->category_image);
        }
        //delete category image form categories table
        Category::where('id',$id)->update(['category_image'=>'']);
        return redirect()->back()->with('flash_message_success','Category image has been deleted successfully');

    }
    public function deleteCategory($id){
        //Delete category
        Category::where('id',$id)->delete();
        return redirect()->back()->with('flash_message_success','Category  has been deleted successfully');

    }
}
