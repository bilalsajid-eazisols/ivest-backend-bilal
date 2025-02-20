<?php

namespace App\Http\Controllers;

use App\Models\blog;
use App\Models\news;
use App\Models\User;
use App\Models\category;
use App\Models\newscategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\generalnotification;
use Illuminate\Support\Facades\Notification;

class NewscategoryController extends Controller
{
    //

    public function index(){
        $categories = category::all();
        return view('categories.index',compact('categories'));
    }
    public function create(Request $request){
        $user = $request->user()??Auth::user();
        $request->validate(['name'=>'required|string|min:3|max:65']);
        $newscategory = new category();
        $newscategory->name=$request->name;
        $newscategory->status=$request->is_active?? 0;
        // $newscategory->created_by=$user->id;
        $newscategory->type = $request->type;
        try {
            $newscategory->save();
            $users = User::permission('blog_view')->get();
            $datetime =date('Y-m-d H:i:s');
            $message = "New Category   $request->name created ";
            Notification::send($users,new generalnotification($message));
            return response()->json('Category Created',200);
        }
         catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message'=>'Something went Wrong',
                'error'=>$th,
            ],400);

        }
        // $display
    }
    public function update(Request $request,$id){
        $user = $request->user()??Auth::user();

        $request->validate(['name'=>'required|string|min:3|max:65']);
        $newscategory =  category::find($id);
        // $name =str_replace(' ','_',$request->name);
        $newscategory->name=$request->name;
        // $newscategory->name=$request->name;
        $newscategory->status=$request->is_active?? 0;
        $newscategory->type=$request->type;
        try {
            $newscategory->save();
            return response()->json('Category Updated',200);
        }
         catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message'=>'Something went Wrong',
                'error'=>$th,
            ],400);

        }
        // $display
    }
    public function destroy($id){
        $blogcatgories = category::find($id);
        if ($blogcatgories) {
            if(news::where('newscategory_id',$id)->exists() ||blog::where('blogcategory_id',$id)->exists() ){
                return response()->json('Category is currently in use ',400);
            }
            else{
                $blogcatgories->delete();
                return response()->json(' Category deleted successfully.', 200);

            }
        }
        else{
            return response()->json(' Category not found.', 404);
        }
    }
}
