<?php

namespace App\Http\Controllers\Admin\Modules\Help;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HelpModel;
use App\Models\User;


class HelpController extends Controller
{
    
    public function help_list(Request $request){
    	$data['helps']=HelpModel::orderBy('id');
    	if(@$request->cat || @$request->status){
       // dd($request->all());
       
        if($request->status){
            $data['helps']=$data['helps']->where('status',$request->status);
        }
         if($request->cat){
            $data['helps']=$data['helps']->where('help_category',$request->cat);
        }
        $data['res']=$request->all();
     }
     $data['helps']=$data['helps']->get();
    	  return view('admin.modules.help.help_list')->with($data);
    }




     public function help_del($id){
    	$srch=HelpModel::where('id',$id)->first();
    	if(!$srch){
    		return back()->with('error','This help question id does not exists');
    	}
    	else{
    		$d=HelpModel::where('id',$id)->delete();
    		return back()->with('success','Help question removed successfully');
    	}
    }






      public function help_active($id){
    	$srch=HelpModel::where('id',$id)->first();
    	if(!$srch){
    		return back()->with('error','This help question id does not exists');
    	}
    	else{
    		$d=HelpModel::where('id',$id)->update(['status'=>'A']);
    		return back()->with('success','Help question successfully activated');
    	}
    }




      public function help_inactive($id){
    	$srch=HelpModel::where('id',$id)->first();
    	if(!$srch){
    		return back()->with('error','This help question id does not exists');
    	}
    	else{
    		$d=HelpModel::where('id',$id)->update(['status'=>'I']);
    		return back()->with('success','Help question successfully deactivated');
    	}
    }




    public function help_add_page(){
    	return view('admin.modules.help.help_add');
    }

    public function help_ins(Request $request){
    	//dd($request->all());
    	$request->validate([
	      'question' => 'required',
	      'answer' => 'required',
	      'help_cat' => 'required',                              
	    ]);

	    $obj=new HelpModel();
	    $obj->question=$request->question;
	    $obj->answer=nl2br($request->answer);
	    $obj->help_category=$request->help_cat;
        $obj->display_order=@$request->display_order;
	     $obj->status="A";
	    $obj->save();

	      return back()->with('success','Help Section updated');  

    }





       public function help_view($id){
    	$srch=HelpModel::where('id',$id)->first();
    	if(!$srch){
    		return back()->with('error','This help id does not exists');
    	}
    	else{
    		$data['help']=HelpModel::where('id',$id)->first();
    		return view('admin.modules.help.help_view')->with($data);
    	}
    }




    public function help_edit_page($id){
    	$srch=HelpModel::where('id',$id)->first();
    	if(!$srch){
    		return back()->with('error','This help id does not exists');
    	}
    	else{
    		$data['help']=HelpModel::where('id',$id)->first();
    		return view('admin.modules.help.help_edit')->with($data);
    	}
    }




     public function help_update(Request $request){
    	//dd($request->all());
    	$request->validate([
	      'question' => 'required',
	      'answer' => 'required',
	      'help_cat' => 'required',                              
	    ]);

	    $up=array(
          'question'=>$request->question,
           'answer'=>nl2br($request->answer),
            'help_category'=>$request->help_cat,
            'display_order'=>$request->display_order,
	    );

	    $u=HelpModel::where('id',$request->help_id)->update($up);
	    return back()->with('success','Help Section updated successfully');

    }


    public function help_get_all_ajax(){
         $data['helps']=HelpModel::orderBy('id')->get();
         return view('admin.modules.help.help_list_ajax')->with($data);
    }
}
