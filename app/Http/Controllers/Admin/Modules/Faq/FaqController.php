<?php

namespace App\Http\Controllers\Admin\Modules\Faq;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FaqModel;
use App\Models\User;

class FaqController extends Controller
{
    

    public function faq_list(Request $request){
     $data['faqs']=FaqModel::orderBy('id');
     if(@$request->user_type || @$request->status){
       // dd($request->all());
       
        if($request->status){
             $data['faqs']= $data['faqs']->where('status',$request->status);
        }
         if($request->user_type){
             $data['faqs']= $data['faqs']->where('user_type',$request->user_type);
        }
        $data['res']=$request->all();
     }
       $data['faqs']= $data['faqs']->get();
      return view('admin.modules.faq.faq_list')->with($data);
    
    }


    public function faq_add_page(){
    	return view('admin.modules.faq.faq_add');
    }

    public function faq_ins(Request $request){
    	//dd($request->all());
    	$request->validate([
	      'question' => 'required',
	      'answer' => 'required',
	      'user_type' => 'required',                              
	    ]);

	    $obj=new FaqModel();
	    $obj->question=$request->question;
	    $obj->answer=$request->answer;
	    $obj->user_type=$request->user_type;
      $obj->display_order=$request->display_order;
	     $obj->status="A";
	    $obj->save();

	      return back()->with('success','Faq added successfully');  

    }



    public function faq_del($id){
    	$srch=FaqModel::where('id',$id)->first();
    	if(!$srch){
    		return back()->with('error','This faq id does not exists');
    	}
    	else{
    		$d=FaqModel::where('id',$id)->delete();
    		return back()->with('success','Faq removed successfully');
    	}
    }






      public function faq_active($id){
    	$srch=FaqModel::where('id',$id)->first();
    	if(!$srch){
    		return back()->with('error','This faq id does not exists');
    	}
    	else{
    		$d=FaqModel::where('id',$id)->update(['status'=>'A']);
    		return back()->with('success','Faq successfully activated');
    	}
    }




      public function faq_inactive($id){
    	$srch=FaqModel::where('id',$id)->first();
    	if(!$srch){
    		return back()->with('error','This faq id does not exists');
    	}
    	else{
    		$d=FaqModel::where('id',$id)->update(['status'=>'I']);
    		return back()->with('success','Faq successfully deactivated');
    	}
    }



    public function faq_view($id){
    	$srch=FaqModel::where('id',$id)->first();
    	if(!$srch){
    		return back()->with('error','This faq id does not exists');
    	}
    	else{
    		$data['faq']=FaqModel::where('id',$id)->first();
    		return view('admin.modules.faq.faq_view')->with($data);
    	}
    }




    public function faq_edit_page($id){
    	$srch=FaqModel::where('id',$id)->first();
    	if(!$srch){
    		return back()->with('error','This faq id does not exists');
    	}
    	else{
    		$data['faq']=FaqModel::where('id',$id)->first();
    		return view('admin.modules.faq.faq_edit')->with($data);
    	}
    }


    public function faq_update(Request $request){
    	//dd($request->all());
    	$request->validate([
	      'question' => 'required',
	      'answer' => 'required',
	      'user_type' => 'required',                              
	    ]);

	    $up=array(
          'question'=>$request->question,
           'answer'=>$request->answer,
            'user_type'=>$request->user_type,
            'display_order'=>$request->display_order,
	    );

	    $u=FaqModel::where('id',$request->faq_id)->update($up);
	    return back()->with('success','FAQ updated successfully.');

    }


    public function faq_get_all_ajax(){
         $data['faqs']=FaqModel::orderBy('id')->get();
         return view('admin.modules.faq.faq_list_ajax')->with($data);
    }

}
