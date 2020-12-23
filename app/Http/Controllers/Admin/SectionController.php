<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Section;
use Session;
class SectionController extends Controller
{
    public function sections(){
        Session::put('page','sections');
        $sections =Section::get();
        return view('admin.sections.sections')->with(compact('sections'));
    }

    public function updateSectionStatus(Request $request)
    {
        if ($request->ajax()){
            if ($request->par1=="Active"){
            $status=0;
            }else{
                $status=1;
            }
            Section::where('id',$request->par2)->update(['status'=>$status]);
            return response()->json(['status'=>$status,'section_id'=>$request->par2]);
         /*   return $request->all();*/
        }


    }


}
