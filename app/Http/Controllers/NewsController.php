<?php

namespace App\Http\Controllers;

use App\Models\news;
use App\Models\User;
use App\Models\category;
use App\Models\newscategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\generalnotification;
use Illuminate\Support\Facades\Notification;

class NewsController extends Controller
{
    //

    public function index(Request $request)
    {
        $news = news::query() ;

            $newss = news::where('type','news')->with(['category', 'author'])->get(); // Eager load relationships for better performance


// dd(newss);
        return view('admin.news.index',compact('newss'));
    }
    public function new(){
        $newscategories = category::where('status',1)->where('type',2)->get();
        return view('admin.news.form',compact('newscategories'));
    }
    public function create(Request $request){
        $user = $request->user()??Auth::user();
        $request->validate([
            'title' => 'required|string',
            'filepond' => 'required|image',
            'details' => 'required',
        ]);
        try {
            $news = new news();
            $news->title = $request->title;
            $news->content = $request->details;
            $news->newscategory_id = $request->category;
            $news->created_by = $user->id;
            $news->membershipclub_id = $request->membershipclub_id;
            if ($request->filepond) {
                $path = $request->file('filepond')->store("public/blogs");
                $path = str_replace('public', 'storage', $path);
                $news->thumbnail = $path;
            }
            $users = User::permission('blog_view')->get();
            $datetime =date('Y-m-d H:i:s');
            $message = "New News  $request->title created ";
            Notification::send($users,new generalnotification($message));
            $news->save();
            return response()->json('News added',200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json($th,400);

        }
    }
    public function update(Request $request, $id){
        $user = $request->user()??Auth::user();
        $request->validate([
            'title' => 'required|string',
            'filepond' => 'required|image',
            'details' => 'required',
        ]);
        $news = news::find($id);
        if($news){
            try {
                // Storage::delete($news->thumbnail);

                $news->title = $request->title;
                $news->content = $request->details;
                $news->newscategory_id = $request->category;
                $news->created_by = $user->id;
               $news->membershipclub_id = $request->membershipclub_id;

                if ($request->filepond) {
                    $path = $request->file('filepond')->store("public/blogs");
                    $path = str_replace('public', 'storage', $path);
                    $news->thumbnail = $path;
                }
                $news->save();
                return response()->json('News added',200);
            } catch (\Throwable $th) {
                //throw $th;
                return response()->json('Something Went Wrong',400);

            }
        }else{
            return response()->json('News Not Found',404);
        }

    }
    public function delete(Request $request , $id){
        $news = news::find($id);
        if($news){
            $news->delete();
            return response()->json('News Deleted',200);
        }
        else
        return response()->json('News Not Found',404);

    }
    public function news($id){
        $news = news::where('id',$id)->orWhere('title',$id)->first();
        if($news){
            return response()->json($news);
        }else{
            return response()->json('404 News Not Found',404);
        }
    }
    public function destroy($id)
    {

        try {
            $blog =news::where('id', $id)->first();
            $blog->delete();
            return response()->json('News Deleted', 200);
        } catch (\Throwable $th) {

            return response()->json([
                'message' => 'something went wrong',
                'error' => $th->getMessage(),
            ], 400);
        }
    }
    public function urlsave(Request $request){
        if($request->id < 0){
        $blog = news::where('id',$request->id)->first();}
        else{
            $blog = new news();
        }
        $blog->title = $request->title;
        $blog->content = $request->url;
        $blog->type ="url";
        $blog->membershipclub_id=$request->clubid;
        $blog->created_by = Auth::user()->id;

        try {
            $blog->save();
            return back()->with('success','News  Added Successfull');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('success',$th->getMessage());

        }

    }
}
