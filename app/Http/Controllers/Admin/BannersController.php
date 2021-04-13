<?php

namespace App\Http\Controllers\Admin;

use App\Banner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class BannersController extends Controller
{
    public function banners()
    {
        $banners=Banner::get()->toArray();

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
    public function deleteBanner($id){
        $bannerImage=Banner::where('id',$id)->first();

        $banner_image_path='images/admin_images/banner_images/';

        if (file_exists($banner_image_path.$bannerImage->image)){
            unlink($banner_image_path.$bannerImage->image);
        }
        Banner::where('id',$id)->delete();
        $message='Banner has been deleted successfully';
        Session::flash('flash_message_success',$message);
        return redirect()->back();
    }
}
