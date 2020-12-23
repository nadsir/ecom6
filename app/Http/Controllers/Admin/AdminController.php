<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Image;
use Illuminate\Http\Request;
use Auth;
use Session;
use App\Admin;
use Hash;



class AdminController extends Controller
{
    public function dashboard()
    {
        Session::put('page','dashboard');
        return view('admin.admin_dashboard');
    }

    public function setting()
    {
        Session::put('page','setting');
        $adminResult = Admin::where('email', Auth::guard('admin')->user()->email)->first();
        return view('admin.admin_setting', compact('adminResult'));
    }

    public function login(Request $request)
    {

        if ($request->isMethod('post')) {
            $data = $request->all();
            $role = [
                'email' => 'required|email|max:255',
                'password' => 'required'
            ];
            $customerror = [
                'email.required' => 'لطفا فیلد ایمیل را پر کنید',
                'email.email' => 'فرمت ایمیل درست نیست',
                'password.required' => 'لطفا فیلد پسورد را پر کنید'
            ];
            $this->validate($request, $role, $customerror);
            if (Auth::guard('admin')->attempt(['password' => $data['password'], 'email' => $data['email']])) {
                return redirect('admin/dashboard');
            } else {
                Session::flash('error_message', 'You enter wrong username or password');
                return redirect()->back();
            }
        }
        return view('admin.admin_login');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }

    public function chkCurrentPassword(Request $request)
    {

        if (Hash::check($request->currentpw, Auth::guard('admin')->user()->password)) {
            echo "true";
        } else {
            echo $request->currentpw;
        }

    }

    public function updateCurrentPassword(Request $request)
    {

        if ($request->isMethod('post')) {
            $data = $request->all();

            if (Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)) {
                if ($data['new_pwd'] == $data['confirm_pdw']) {
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password' => bcrypt($data['new_pwd'])]);
                    Session::flash('success_message', 'You successfully change the password');
                } else {
                    Session::flash('error_message', 'New password is not match with confirm password');
                }
            } else {
                Session::flash('error_message', 'Your current password is incorrect');
            }
            return redirect()->back();
        }
    }

    public function updateAdminDetails(Request $request)
    {
        Session::put('page','update-admin-details');
        if ($request->isMethod('post')) {
            $data = $request->all();
      ;
            $role = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile'=>'required|numeric',
                'admin_image'=>'image'

            ];
            $customMessage = [
                'admin_name.required' => 'Name is require',
                'admin_name.regex' => 'Valid name is require',
                'admin.mobile.required'=>'Mobile is required',
                'admin_mobile.numeric'=>'Valid mobile is required',
                'admin_image.image'=>'Valid Image is required'
            ];
            $this->validate($request, $role, $customMessage);
            if ($request->hasFile('admin_image')){
                $image_tmp=$request->file('admin_image');
                if ($image_tmp->isValid()){
                    $extension=$image_tmp->getClientOriginalExtension();
                    $imageName=rand(111,99999).'.'.$extension;
                    $imagePath='images/admin_images/admin_photos/'.$imageName;
                    Image::make($image_tmp)->resize(300,400)->save($imagePath);
                }else if(!empty($data['current_admin_image'])){
                    $imageName=$data['current_admin_image'];
                }else{
                    $imageName="";
                }
            }
            Admin::where('email',Auth::guard('admin')->user()->email)->update(['name'=>$data['admin_name'],'mobile'=>$data['admin_mobile'],'image'=>$imageName]);
            Session::flash('success_message','Your change successfully changed');
            return redirect()->back();
        } else {
            return view('admin.admin_update_details');
        }


    }

}

