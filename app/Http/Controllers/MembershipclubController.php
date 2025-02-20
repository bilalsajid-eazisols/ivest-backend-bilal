<?php

namespace App\Http\Controllers;

use App\Models\blog;
use App\Models\token;
use Illuminate\Http\Request;
use App\Models\membershipclub;
use App\Models\membershipclubfile;
use App\Models\membershipclubuser;
use Illuminate\Support\Facades\Auth;
use App\Models\membershipclubcomment;
use App\Models\news;
use App\Models\User;
use App\Notifications\generalnotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class MembershipclubController extends Controller
{
    //
    public function index(){
        $membershipclubs = membershipclub::orderByDesc('id')->get();
        foreach ($membershipclubs as $membershipclub) {
             $membershipclub->totalclubmembers = membershipclubuser::where('membershipclub_id',$membershipclub->id)->count();

             $membershipclub->totalrating = membershipclubcomment::where('membershipclub_id',$membershipclub->id)->avg('rating')??0;
        }
        return view('admin.membershipclub.index',compact('membershipclubs'));
    }
    public function create(Request $request){
        if($request->id){
            $membershipclub = membershipclub::where('id',$request->id)->first();
            if($request->step == 3){

                $token = token::where('membershipclub_id',$membershipclub->id)->first();

                return view('admin.membershipclub.form',compact('membershipclub','token'));


            }
            if($request->step == 4){
                $blogs=blog::where('membershipclub_id',$membershipclub->id)->get(['id','title','content','type']);
                $news =news::where('membershipclub_id',$membershipclub->id)->get(['id','title','content','type']);


                return view('admin.membershipclub.form',compact('membershipclub','blogs'
               ,'news',));


            }
            if($request->step == 5){

                $membershipclubfiles  = membershipclubfile::where('membershipclub_id',$membershipclub->id)->get();
                return view('admin.membershipclub.form',compact('membershipclub','membershipclubfiles'));


            }
            return view('admin.membershipclub.form',compact('membershipclub'));

        }
        return view('admin.membershipclub.form');
    }

    public function club ($id){
        return response()->json(membershipclub::where('id',$id)->first());
    }
public function destroy($id){
    try {
        membershipclub::where('id',$id)->delete();
        return back()->with('success','MemberShip Club deleted Successfully');
    } catch (\Throwable $th) {
        //throw $th;
        return back()->with('failure','something went wrong ');
    }
}
    public function step1(Request $request){
        $request->validate(['title'=>'required','details'=>'required','overview'=>'required|max:255','price'=>'required']);


    if($request->id){
        $membershipclub = membershipclub::where('id',$request->id)->first();
        $membershipclub->updated_by = Auth::user()->id;

    }else{
        $membershipclub = new membershipclub();}
        $membershipclub->title = $request->title;
        $membershipclub->overview = trim($request->overview,' ');
        $membershipclub->content = $request->details;
        $membershipclub->price = $request->price;
        $membershipclub->status = $request->status;
        if($request->cover){
            $path = $request->file('cover')->store("public/membershipclub/thumbnails");
            $path = str_replace('public', 'storage', $path);
        $membershipclub->img = $path;
        }

        $membershipclub->created_by = Auth::user()->id;
        $membershipclub->save();
            $users = User::permission('membershipclub_view')->get();
            $message = "A new Membership CLub $request->title";
            Notification::send($users,new generalnotification($message));
            return redirect("admin/membershipclubs/new?step=2&id=$membershipclub->id");


    }
    public function step2(Request $request){


        $membershipclub = membershipclub::where('id',$request->id)->first();

        $membershipclub->features = $request->features;
        $membershipclub->goals = $request->goals;
        $membershipclub->publicYTembed = $request->ytembed;
        $membershipclub->discordwidget = $request->discordwidget;
        $membershipclub->privateYTembed = $request->ytvideo;
        $membershipclub->VideoTitle = $request->ytvideotitle;
        $membershipclub->save();
        if(createrole($membershipclub->discordwidget)){
            if(restrictrole($membershipclub->discordwidget)){
                return redirect("admin/membershipclubs/new?step=3&id=$membershipclub->id");

            }


        }



    }
    public function step3(Request $request){
        $membershipclub = membershipclub::where('id',$request->id)->first();

        $membershipclub->save();
        if(token::where('membershipclub_id',$membershipclub->id)->exists()){
            $token = token::where('membershipclub_id',$membershipclub->id)->first();
        }else{
            $token = new token();
        }
        $token->membershipclub_id = $membershipclub->id;
        $token->name = $request->title;
        // $token->logo = $request->logo;
        $token->symbol = $request->symbol;
        if($request->logo){
            $path = $request->file('logo')->store("public/membershipclub/token");
            $path = str_replace('public', 'storage', $path);
        $token->logo = $path;
        }
        $token->save();
        return redirect("admin/membershipclubs/new?step=4&id=$membershipclub->id");

    }
    public function step4(Request $request){

        return redirect("admin/membershipclubs/new?step=3&id=$request->id");
    }
    public function step5(Request $request){
        if ($request->hasFile('clubfiles')) {
            foreach ($request->file('clubfiles') as $clubfile) {

                // Get file information
                $name = $clubfile->getClientOriginalName();
                $ext = $clubfile->getClientOriginalExtension();
                $size = $clubfile->getSize();

                // Store the file and get the stored path
                $path = $clubfile->store('membershipclub/files', 'public');
                // print_r([$name,$ext,$size]);
                // Save file details to the database
                $membershipfile = membershipclubfile::create([
                    'membershipclub_id' => $request->id,
                    'user_id' => Auth::user()->id,
                    'file' => "storage/".$path,
                    'name' => $name,
                    'extension' => $ext,
                    'size' => $size,
                    'created_at' => Carbon::now(),
                ]);

                // You can remove this if you don't want to stop at the first file
                // dd($membershipfile); // This will show the first inserted file and stop further execution
            }
        }

        return back()->with('success','Action Performed Successfully');

    }
    public function guestlisting(Request $request){

        $limit = 6;
        if ($request->has('limit')) {
            $limit = $request->input('limit');
        }

        // Base query to select common fields from the membership clubs
        $query = membershipclub::select(['id', 'title', 'overview', 'img', 'price']);

        // Apply sorting filters
        if ($request->has('filter')) {
            $filter = $request->input('filter');

            if ($filter === 'asc') {
                $query->orderBy('title', 'asc');
            } elseif ($filter === 'desc') {
                $query->orderBy('title', 'desc');
            } elseif ($filter === 'lowtohigh') {
                $query->orderBy('price', 'asc');
            } elseif ($filter === 'hightolow') {
                $query->orderBy('price', 'desc');
            }
        } else {
            // Default ordering if no filter is specified
            $query->latest();
        }

        // Apply limit and execute query
        $membershipClubs = $query->limit($limit)->get();
        foreach ($membershipClubs as $membershipClub) {
        $membershipClub->joined = false;
        $membershipClub->members = membershipclubuser::where('membershipclub_id',$membershipClub->id)->count();
        $membershipClub->totalrating = membershipclubcomment::where('membershipclub_id',$membershipClub->id)->avg('rating')??0;
        }
        // Fetch all membership clubs the user has joined


        // Loop through all clubs and add 'joined' property


        // Return the result as a JSON response
        return response()->json($membershipClubs, 200);

    }
    public function listing(Request $request){
        $user = $request->user()??Auth::user();
        // dd($request->user());
        // Default limit
        $limit = 6;
        if ($request->has('limit')) {
            $limit = $request->input('limit');
        }

        // Base query to select common fields from the membership clubs
        $query = membershipclub::select(['id', 'title', 'overview', 'img', 'price']);

        // Apply sorting filters
        if ($request->has('filter')) {
            $filter = $request->input('filter');

            if ($filter === 'asc') {
                $query->orderBy('title', 'asc');
            } elseif ($filter === 'desc') {
                $query->orderBy('title', 'desc');
            } elseif ($filter === 'lowtohigh') {
                $query->orderBy('price', 'asc');
            } elseif ($filter === 'hightolow') {
                $query->orderBy('price', 'desc');
            }
        } else {
            // Default ordering if no filter is specified
            $query->latest();
        }

        // Apply limit and execute query
        $membershipClubs = $query->limit($limit)->get();

        // Fetch all membership clubs the user has joined
        $userMembershipClubs = membershipclubuser::where('user_id', $user->id)
            ->pluck('membershipclub_id')
            ->toArray();

        // Loop through all clubs and add 'joined' property
        foreach ($membershipClubs as $club) {
            $club->joined = in_array($club->id, $userMembershipClubs);
            $club->members = membershipclubuser::where('membershipclub_id',$club->id)->count();
        $club->totalrating = membershipclubcomment::where('membershipclub_id',$club->id)->avg('rating')??0;


        }

        // Return the result as a JSON response
        return response()->json($membershipClubs, 200);

    }
    public function publicview($id){
        $membershipsclub= membershipclub::where('id',$id)->first(['id','created_by','img','created_at','goals','features',
'overview','content','publicYTembed','title']);
            $membershipsclub->username = $membershipsclub->author->username;
            $membershipsclub->members = membershipclubuser::where('membershipclub_id',$membershipsclub->id)->count();
        return response()->json($membershipsclub);

    }
    public function detailsview($id){
        $membershipsclub = membershipclub::where('id',$id)->first();
        $membershipsclub->username = $membershipsclub->author->username;
        $membershipsclub->members = membershipclubuser::where('membershipclub_id',$membershipsclub->id)->count();
        $membershipsclub->memberorlist = $this->getmembers($id);

        // $membershipsclub->memberorlist =
        $membershipsclub->files = membershipclubfile::where('membershipclub_id',$membershipsclub->id)->latest()->limit(3)->get();
        $membershipsclub->commentlist =  $this->getusers($id);
        $membershipsclub->bloglist = blog::where('membershipclub_id',$id)->get();
        $membershipsclub->newslist = news::where('membershipclub_id',$id)->get();

        return response()->json($membershipsclub);

    }
    public function getmembers($id){
        $memberlist = membershipclubuser::where('membershipclub_id',$id)->with('user')->latest()->get();
        foreach ($memberlist as $member) {
            $member->user->profileimg =  $member->user->profileNodefault();
        }
   return $memberlist;
    }
    public function getusers($id){
        $memberlist = membershipclubcomment::where('membershipclub_id',$id)->with('user')->latest()->get();
        foreach ($memberlist as $member) {
            $member->user->profileimg =  $member->user->profileNodefault();
        }
   return $memberlist;
    }
    public function filesupload(Request $request,$id){
        $membershipclubfile = new membershipclubfile();
        $membershipclubfile->membershipclub_id = $id;
        $membershipclubfile->user_id = Auth::user()->id;

        if($request->file){
            $path = $request->file('file')->store("public/membershipclub/files");
            $path = str_replace('public', 'storage', $path);
        $membershipclubfile->file = $path;
        }
        $membershipclubfile->save();
        return response()->json('File Uploaded',200);
}
public function view_details($id){
    $membershipclub = membershipclub::find($id);
    // $membershipclub->username = $membershipclub->author->username;
    // $membershipclub->created_at = $membershipclub->created_at->format('y-m-d');
    $membershipclub->members = membershipclubuser::where('membershipclub_id',$membershipclub->id)->count();
    $membershipclub->token = token::where('membershipclub_id',$membershipclub->id)->first();

    return view('admin.membershipclub.details',compact('membershipclub'));
}
public function joinmembershipclub(Request $request, $id){
    $user = $request->user??Auth::user();
    if($user->discord_userid == null){
        return response()->json('Discord User Id is Missing',400);
    }
    if(membershipclubuser::where('user_id',$user->id)->where('membershipclub_id',$id)->exists() ){
        return response()->json(
            'User is Already a Part of Membership Club',200);

    }
    $usermembershipclub =new membershipclubuser();
    try {
        $usermembershipclub->user_id = $user->id;
        $usermembershipclub->membershipclub_id = $id;
        $usermembershipclub->save();

        $membershipclub = membershipclub::where('id',$id)->first();
        $message = "You Successfully Joined $membershipclub->title !";
        // Notification
        $user->notify(new generalnotification($message));
        assignrole($user->discord_userid,$membershipclub->title);
        return response()->json('user joined membershipclub',200);
    } catch (\Throwable $th) {
        return response()->json($th->getMessage(),400);

    }
}
public function joinedmembershipclublist(Request $request){
    $user = $request->user ?? Auth::user();

    // Use the query builder to apply withCount before fetching the collection
    $membershipClubs = membershipclub::select('id', 'title', 'img', 'overview')
    ->withCount('users') // Get the total number of users for each club
    ->get();

// Fetch all membership clubs the user has joined
$userMembershipClubs = membershipclubuser::where('user_id', $user->id)
    ->pluck('membershipclub_id') // Get only the IDs of clubs the user has joined
    ->toArray();

// Loop through all clubs and add 'joined' property
foreach ($membershipClubs as $club) {
    // If the club ID exists in the user's membership club IDs, mark as joined
    $club->joined = in_array($club->id, $userMembershipClubs);
}

// Return the list of membership clubs with 'joined' property
return response()->json($membershipClubs);

}
public function savecomment(Request $request,$id){
    $request->validate(['comment'=>'required',
        'rating'=>'required',
]);
    $user = $request->user()??Auth::user();
    $membershipclubcomment = new membershipclubcomment();
    $membershipclubcomment->comment	 = $request->comment;
    $membershipclubcomment->rating = $request->rating;
    $membershipclubcomment->user_id = $user->id;
    $membershipclubcomment->membershipclub_id = $id;
    $membershipclubcomment->save();

    return response()->json('membershipclubcomment added');
}
public function membersdetails($id){
    $members = membershipclubuser::where('membershipclub_id',$id)->with('user')->get();
    // dd($members);
    return view('admin.membershipclub.details',compact('members'));
}
public function deletefile($id){
    membershipclubfile::find($id)->delete();
    return back();
}
public function getAllClubsWithUserCount(Request $request)
{
    // Retrieve all membership clubs with the count of associated users
    $duration = $request->query('duration', 'all');

    // Determine the starting date based on the duration
    $startDate = match($duration) {
        '30days' => Carbon::now()->subDays(30),
        '6months' => Carbon::now()->subMonths(6),
        '1year' => Carbon::now()->subYear(),
        default => null,
    };

    // Query all membership clubs with user count, optionally filtered by start date
    $clubs = MembershipClub::withCount(['users' => function ($query) use ($startDate) {
            if ($startDate) {
                $query->where('created_at', '>=', $startDate);  // Filter by start date if specified
            }
        }])
        ->orderBy('users_count', 'desc')  // Sort by user count
        ->get();

    // Format the response data
    $data = $clubs->map(function ($club) {
        return [
            'name' => $club->title,
            'user_count' => $club->users_count,
        ];
    });

    return response()->json($data);
}
}
