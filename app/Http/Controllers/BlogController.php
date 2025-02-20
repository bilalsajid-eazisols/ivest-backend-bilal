<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\blog;
use App\Models\User;
use App\Models\category;
use App\Models\blogcategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\generalnotification;
use Illuminate\Support\Facades\Notification;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = blog::query() ;

            $blogs = Blog::where('type','blog')->with(['category', 'author'])->get(); // Eager load relationships for better performance
        return view('admin.blogs.index',compact('blogs'));
    }
    public function bloglist(Request $request)
    {
        $query = blog::query() ;

            $blogs = Blog::where('type','blog')->with(['category', 'author'])->get(); // Eager load relationships for better performance
        return response()->json($blogs);
            // return view('admin.blogs.index',compact('blogs'));
    }
    public function new(){
        $blogcategories = category::where('status',1)->where('type',1)->get();
        return view('admin.blogs.form',compact('blogcategories'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if($request->user()){
        $user = $request->user();}else{
            $user = Auth::user();
        }
        $request->validate([
            'title' => 'required|string',
            'filepond' => 'required|image',
            'details' => 'required',
            'excerpt'=>'required|max:255',
            'status'=>'required',
        ],[
            'filepond'=>'thumbnail is Required!'
        ]);
        try {
            $blog = new blog();
            if($request->membershipclub_id){
                $blog->membershipclub_id = $request->membershipclub_id;
            }
            $blog->title = $request->title;
            if ($request->filepond) {
                $path = $request->file('filepond')->store("public/blogs");
                $path = str_replace('public', 'storage', $path);
                $blog->thumnnail = $path;
            }
            $blog->excerpt=$request->excerpt;
            $blog->status=$request->status;

            if ($request->status ==2 ) {
                $blog->published_at = Carbon::now();
            }
            $blog->content = $request->details;
            $blog->blogcategory_id = $request->category;
            $blog->created_by = $user->id;
            $blog->save();
            $users = User::permission('blog_view')->get();
            $datetime =date('Y-m-d H:i:s');
            $message = "New Blog   $request->title created ";
            Notification::send($users,new generalnotification($message));
            return response()->json('Blog Created', 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'Something Went Wrong',
                // 'error' => $th->getMessage(),
            ], 400);
        }
    }
    public function blog($id){
        // return $id;
        $blog = blog::where('id',$id)->orWhere('title',$id)->with(['category', 'author'])->first();
    if($blog){
        $blog->thumbnail = asset($blog->thumnbail);
        return response()->json($blog);
    }else{
        return response()->json('Blog Not Found',404);
    }
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        if($request->user()){
            $user = $request->user();}else{
                $user = Auth::user();
            }
        $request->validate([
            'title' => 'required|string',
            // 'thumbnail'=>'nullable|image',
            'details' => 'required',
            'excerpt'=>'required|max:255',
            'status'=>'required',
        ]);
        try {
            $blog =  blog::find($id);
            // Storage::delete($blog->thumbnail);
            $blog->title = $request->title;
            if ($request->thumbnail) {
                $path = $request->file('thumbnail')->store("public/blogs");
                $path = str_replace('public', 'storage', $path);
                $blog->thumnnail = $path;
            }
            $blog->content = $request->details;
            $blog->blogcategory_id = $request->category;
            $blog->updated_by = $user->id;
            $blog->excerpt=$request->excerpt;
            $blog->status=$request->status;

            if ($request->status ==2 && $blog->status != 2 ) {
                $blog->published_at = Carbon::now();
            }
            $blog->save();
            return response()->json('Blog updated', 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'Something Went Wrong',
                // 'error' => $th->getMessage(),
            ], 400);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        try {
            $blog =blog::where('id', $id)->first();
            // return $blog;
            // dd($blog);
            $blog->delete();
            return response()->json('Blog Deleted', 200);
        } catch (\Throwable $th) {

            return response()->json([
                'message' => 'something went wrong',
                // 'error' => $th->getMessage(),
            ], 400);
        }
    }
    public function urlsave(Request $request){
        if($request->id > 0){
        $blog = blog::where('id',$request->id)->first();}
        else{
            $blog = new blog();
        }
        $blog->title = $request->title;
        $blog->content = $request->url;
        $blog->type ="url";
        $blog->membershipclub_id=$request->clubid;
        $blog->created_by = Auth::user()->id;
        $blog->status =2;
        try {
            $blog->save();
            return back()->with('success','Blog Added Successfull');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('success',$th->getMessage());

        }

    }
}
