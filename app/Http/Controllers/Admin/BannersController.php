<?php

namespace App\Http\Controllers\Admin;

use App\Banner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Image;

class BannersController extends Controller
{
    public function banners()
    {
        Session::put('page', 'banners');
        $banners = Banner::get()->toArray();

        return view('admin.banners.banners')->with(compact('banners'));
    }

    public function updateBannersStatus(Request $request)
    {
        if ($request->ajax()) {
            if ($request->bannerStatus == "Active") {
                $bannerStatus = 0;
            } else {
                $bannerStatus = 1;
            }
            Banner::where('id', $request->bannerId)->update(['status' => $bannerStatus]);
            return response()->json(['bannerStatus' => $bannerStatus, 'bannerId' => $request->bannerId]);
        }
    }

    public function deleteBanner($id)
    {
        $bannerImage = Banner::where('id', $id)->first();

        $banner_image_path = 'images/admin_images/banner_images/';

        if (file_exists($banner_image_path . $bannerImage->image)) {
            unlink($banner_image_path . $bannerImage->image);
        }
        Banner::where('id', $id)->delete();
        $message = 'Banner has been deleted successfully';
        Session::flash('flash_message_success', $message);
        return redirect()->back();
    }

    public function addeditBanner( Request $request,$id=null)
    {
        if ($id == '') {
            //Add banner
            $banner = new Banner;
            $title = "Add Banner Image";
            $message = "Banner added successfully!";
        } else {
            //Edit banner
            $banner = Banner::find($id);
            $title = "Edit Banner Image";
            $message = "Banner update successfully!";
        }
        if ($request->isMethod('post')) {
            $data = $request->all();
            $banner->link = $data['link'];
            $banner->title = $data['title'];
            $banner->alt = $data['alt'];
            if ($request->hasFile('image')) {
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {
                    //upload Image after Resize

                    $image_name = pathinfo($image_tmp->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = 'banner'.$image_name. rand(111, 99999) . '.' . $extension;
                    $large_image_path = 'images/admin_images/banner_images/'.$imageName;
                    Image::make($image_tmp)->resize(1170, 480)->save($large_image_path);
                    $banner->image = $imageName;
                }
                $banner->save();
                session::flash('flash_message_success', $message);
                return redirect('admin/banners');
            }



        }
        return view('admin.banners.add_edit_banner')->with(compact('title', 'banner'));

    }
}
