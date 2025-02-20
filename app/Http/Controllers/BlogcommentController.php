<?php

namespace App\Http\Controllers;

use App\Models\blogcomment;
use Illuminate\Http\Request;

class BlogcommentController extends Controller
{
    public function index($id)
    {
        $blogcomments = blogcomment::where('blog_id', $id)->Get();
        if ($blogcomments != null) {
            return response()->json($blogcomments);
        } else {
            return response()->json('404 Not Found', 404);
        }
    }
    public function create(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'comment' => 'required|string|max:255',
            'rating' => 'required',
        ]);
        try {
            $blogcomments = blogcomment::insert([
                'comment' => $request->comment,
                'rating' => $request->rating,
                'blog_id' => $request->blog_id,
                'created_by' => $user->id,
            ]);
            return response()->json('comment created', 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Something Went Wrong',
                'error' => $th,
            ], 400);

            //throw $th;
        }
    }
    public function update(Request $request, $id)
    {
        $user = $request->user();
        $request->validate([
            'comment' => 'required|string|max:255',
            'rating' => 'required',
        ]);
        $blogcomment = blogcomment::where('id', $id)->first();
        if ($blogcomment->created_by == $user->id) {
            $blogcomment->comment = $request->comment;
            $blogcomment->rating = $request->rating;
            try {
                $blogcomment->save();
                return response()->json('Blog Comment Updated');
            } catch (\Throwable $th) {
                //throw $th;
                return response()->json('Something Went Wrong', 400);
            }
        } else {
            return response()->json('You can only edit your own comment', 403);
        }
    }
    public function delete(Request $request, $id)
    {
        $user = $request->user();

        $blogcomment = blogcomment::where('id', $id)->first();
        if ($blogcomment->created_by == $user->id) {
            try {
                $blogcomment->delete();
                return response()->json('Blog Comment Deleted');
            } catch (\Throwable $th) {
                //throw $th;
                return response()->json('Something Went Wrong', 400);
            }
        } else {
            return response()->json('You can only delete your own comment', 403);
        }
    }

    //
}
