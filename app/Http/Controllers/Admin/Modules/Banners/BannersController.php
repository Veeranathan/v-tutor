<?php

namespace App\Http\Controllers\Admin\Modules\Banners;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Banners;
class BannersController extends Controller
{
    public function addBanner(Request $request)
    {
        if(@$request->all()){
            $bannerCount = Banners::count();
            if(@$bannerCount >=5){
                session()->flash("success","Maximum 5 banners can be added");
                return redirect()->back();
            }
            // $addBanner['banner_heading']=$request->banner_heading;
            // $addBanner['banner_subheading']=$request->banner_subheading;
            $addBanner['banner_name']=@$request->banner_name;
            $addBanner['banner_button_caption']=@$request->banner_button_caption;
            $addBanner['banner_button_url'] = @$request->banner_button_url;
            $addBanner['display_order'] = @$request->display_order;

            if(@$request->img){
                $image = $request->img;
                $filename = time().'-'.rand(1000,9999).'.'.$image->getClientOriginalExtension();
                $image->move('storage/banners/', $filename);
                $addBanner['banner_image'] = $filename;
            }
            $addbannerDetails = Banners::create($addBanner);
            session()->flash("success","Banner added successfully");
            return redirect()->back();
        }
        return view('admin.modules.banners.add_banner');
    }
    public function editBanner($id,Request $request){
        // dd($id);
        $data['banner']=Banners::where(['id'=>$id])->first();
        if(@$request->all()){
            // $editBanner['banner_heading']=$request->banner_heading;
            // $editBanner['banner_subheading']=$request->banner_subheading;
            $editBanner['banner_name']=@$request->banner_name;
            $editBanner['banner_button_caption']=@$request->banner_button_caption;
            $editBanner['banner_button_url'] = @$request->banner_button_url;
            $editBanner['display_order'] = @$request->display_order;
            if(@$request->img){
                $image = $request->img;
                $filename = time().'-'.rand(1000,9999).'.'.$image->getClientOriginalExtension();
                $image->move('storage/banners/', $filename);
                $editBanner['banner_image'] = $filename;
            }
            $addbannerDetails = Banners::where(['id'=>$id])->update($editBanner);
            session()->flash("success","Banner updated successfully");
            return redirect()->back();
        }
        return view('admin.modules.banners.edit_banner')->with($data);
    }
    public function manageBanner(){
        $data['bannerCount'] = Banners::count();

        $data['banners']=Banners::orderBy('display_order','asc')->get();
        return view('admin.modules.banners.list_banner')->with($data);
    }
    public function deleteBanner($id){
        Banners::where(['id'=>$id])->delete();
        session()->flash("success","Banner deleted successfully!");
        return redirect()->back();
    }
}
