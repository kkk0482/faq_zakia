<?php
namespace App\Http\Controllers;
use App\User;
use  App\Notifications\FollowNotified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    //
    public function index()
    {
        //return view('index', [
        return view('Follow', [
            'users' => User::where('id', '!=', Auth::id())->get()
        ]);
    }
    public function follow(User $user)
    {
        if (!Auth::user()->isFollowing($user->id)) {
            // Create a new follow instance for the authenticated user
            //Auth::user()->follows()->create([
            Auth::user()->followers()->create([
                'follower_id' => $user->id,
                //'name'=>$user->name,
            ]);
            //$user->notify(new UserFollowed(Auth()->user()) );
            $user->notify(new FollowNotified(Auth()->user()) );
            return redirect()->route('users.index')->with('message', 'You are now friends with '. $user->name);
            //return redirect()->route('users.index')->with('message', 'You are now friends with '. $user->id .'' .$user->name);
        } else {
            return redirect()->route('users.index')->with('message', 'You are already following this person');
        }
    }
    public function unfollow(User $user)
    {
        if (Auth::user()->isFollowing($user->id)) {
            $follow = Auth::user()->followers()->where('follower_id', $user->id)->first();
            $follow->delete();
            return redirect()->route('users.index')->with('message', 'You are no longer friends with '. $user->name);
            //return redirect()->route('users.index')->with('message', 'You are no longer friends with '.$user->id.'' . $user->name);
        } else {
            return redirect()->route('users.index')->with('message', 'You are not following this person');
        }
    }
}