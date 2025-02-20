<?php

namespace App\Http\Controllers;

use App\Models\newscomment;
use Illuminate\Http\Request;

class NewscommentController extends Controller
{
    //
    public function index($id)
    {
        $newscomments = newscomment::find($id);
        return response()->json($newscomments);
    }
    public function create(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'comment' => 'required|string|max:255',
            'rating' => 'required',
        ]);
        try {
            $newscomment = newscomment::insert([
                'comment' => $request->comment,
                'rating' => $request->rating,
                'created_by' => $user->id,
                'news_id' => $request->news,

            ]);
            return response()->json('comment added', 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json('Something Went Wrong', 400);
        }
    }
    public function update(Request $request, $id){
        $user = $request->user();
        $request->validate([
            'comment' => 'required|string|max:255',
            'rating' => 'required',
        ]);
        $newscomment = newscomment::find($id);
        if($newscomment->created_by == $user->id){
            try {
                $newscomment->insert([
                   'comment' => $request->comment,
                   'rating' => $request->rating,
                   'created_by' => $user->id,
                   'news_id' => $request->news,

               ]);
               return response()->json('comment added', 200);
           } catch (\Throwable $th) {
               //throw $th;
               return response()->json('Something Went Wrong', 400);
           }
        }else{
            return response()->json('You can only update your own comment',403);
        }


    }
    public function destroy(Request $request, $id){
        $user = $request->user();
        $comment = newscomment::find($id);
        if($comment){
            if($comment->created_by == $user->id){
                $comment->delete();
            }
            else{
                return response()->json('You can only delete your own comment',403);

            }
        }else{
            return response()->json('comment Not Found',404);

        }
    }
}
