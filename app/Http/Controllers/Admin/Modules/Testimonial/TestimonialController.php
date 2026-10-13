<?php

namespace App\Http\Controllers\Admin\Modules\Testimonial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TestimonialModel;
use App\Models\User;
Use DB;


class TestimonialController extends Controller
{
    public function test_list(Request $request){

    	$data['test']=TestimonialModel::orderBy('id');
    	if(@$request->ratting || @$request->status || @$request->keyword ){
       // dd($request->all());

        if($request->status){
             $data['test']= $data['test']->where('status',$request->status);
        }
         if($request->ratting){
             $data['test']= $data['test']->where('rating',$request->ratting);
        }
         if($request->keyword){
             $data['test']= $data['test']->where(DB::raw('CONCAT(name, " ", location)'),'LIKE', "%".$request->keyword."%");
        }

        $data['res']=$request->all();
     }
       $data['test']= $data['test']->get();
    	  return view('admin.modules.testimonial.test_list')->with($data);

    }





    public function test_add_page(){
    	return view('admin.modules.testimonial.test_add');
    }



    public function test_ins(Request $request){
    	//dd($request->all());
    	$request->validate([
	      'name' => 'required',
          'email' => 'required',
          'phone' => 'required',
	      'img' => 'required',
	      'rating' => 'required',
	      'source' => 'required',
	      'description' => 'required',
	    ]);


	    //img
	     $image = $request->img;
          $filename = time() . '-' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
          $image->move("storage/testimonial",$filename);



        $obj=new TestimonialModel();

	    $obj->name=$request->name;
        $obj->email=$request->email;
        $obj->phone=$request->phone;
	    $obj->source=$request->source;
	    $obj->rating=$request->rating;
	    $obj->text=$request->description;
	    $obj->status="A";
	    $obj->image=$filename;

	    $obj->save();
	    return back()->with('success','Testimonial added');


    }




    public function test_del($id){
    	$srch=TestimonialModel::where('id',$id)->first();
    	if(!$srch){
    		return back()->with('error','This testimonial id does not exists');
    	}
    	else{
    		$d=TestimonialModel::where('id',$id)->delete();
    		return back()->with('success','Testimonial removed successfully');
    	}
    }






      public function test_active($id){
    	$srch=TestimonialModel::where('id',$id)->first();
    	if(!$srch){
    		return back()->with('error','This testimonial id does not exists');
    	}
    	else{
    		$d=TestimonialModel::where('id',$id)->update(['status'=>'A']);
    		return back()->with('success','Testimonial successfully activated');
    	}
    }




      public function test_inactive($id){
    	$srch=TestimonialModel::where('id',$id)->first();
    	if(!$srch){
    		return back()->with('error','This testimonial id does not exists');
    	}
    	else{
    		$d=TestimonialModel::where('id',$id)->update(['status'=>'I']);
    		return back()->with('success','Testimonial successfully deactivated');
    	}
    }





    public function test_view($id){
    	$srch=TestimonialModel::where('id',$id)->first();
    	if(!$srch){
    		return back()->with('error','This testimonial id does not exists');
    	}
    	else{
    		$data['test']=TestimonialModel::where('id',$id)->first();
    		return view('admin.modules.testimonial.test_view')->with($data);
    	}
    }



    public function test_edit_page($id){
    	$srch=TestimonialModel::where('id',$id)->first();
    	if(!$srch){
    		return back()->with('error','This testimonial id does not exists');
    	}
    	else{
    		$data['test']=TestimonialModel::where('id',$id)->first();
    		return view('admin.modules.testimonial.test_edit')->with($data);
    	}
    }


    public function test_update(Request $request){
    	//dd($request->all());
    	//dd($request->all());
    	$request->validate([
	      'name' => 'required',
	      //'img' => 'required',
	      'rating' => 'required',
	      'source' => 'required',
          'email' => 'required',
          'phone' => 'required',
	      'description' => 'required',
	    ]);

	    if($request->img){
	    	 $srch=TestimonialModel::where('id',$request->test_id)->first();
           @unlink('storage/testimonial/'.$srch->image);

          $image = $request->img;
          $filename = time() . '-' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
          $image->move("storage/testimonial",$filename);

         $upd=array(
        'name'=>$request->name,
        'email'=>$request->email,
        'phone'=>$request->phone,
        'source'=>$request->source,
        'rating'=>$request->rating,
        'image'=>$filename,
        'text'=>@$request->description,

        );
        $u=TestimonialModel::where('id',$request->test_id)->update($upd);
        return back()->with('success','This testimonial updated successfully ');
	    }
	    else{
	    	 $upd=array(
        'name'=>$request->name,
        'email'=>$request->email,
        'phone'=>$request->phone,
        'source'=>$request->source,
        'rating'=>$request->rating,
       // 'image'=>$filename,
        'text'=>@$request->description,

        );
        $u=TestimonialModel::where('id',$request->test_id)->update($upd);
        return back()->with('success','This testimonial updated successfully without image');


	    }

    }




      public function test_get_all_ajax(){
         $data['test']=TestimonialModel::orderBy('id')->get();
         return view('admin.modules.testimonial.test_ajax')->with($data);
    }
}
