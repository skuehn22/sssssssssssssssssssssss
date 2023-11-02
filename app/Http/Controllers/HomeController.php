<?php

namespace App\Http\Controllers;
use App\Models\Task;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Get the user data from the session
        $user = Auth::user();


        // Pass the user data to the view
        return view('home', ['user' => $user]);
    }

    public function saveStatus()
    {

        $user = Auth::user();
        $user->status = 1;
        $user->save();

        return true;
    }

    /**
     * Get the authenticated user's data.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser()
    {
        // Fetch the authenticated user
        $user = Auth::user();

        // If there's no authenticated user, send an error response
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        // Check the beginning of the user's name and adjust the group_origin accordingly
        $prefix = strtolower(substr($user->name, 0, 2)); // Get the first two characters of the user's name

        switch ($prefix) {
            case 'g1':
                $user->group_origin = 'Gruppe 1';
                break;
            case 'g2':
                $user->group_origin = 'Gruppe 2';
                break;
            case 'g3':
                $user->group_origin = 'Gruppe 3';
                break;
            case 'g4':
                $user->group_origin = 'Gruppe 4';
                break;
            case 'g5':
                $user->group_origin = 'Gruppe 5';
                break;
            case 'g6':
                $user->group_origin = 'Lehrkräfte';
                break;
        }

        // Return the user's data as JSON
        return response()->json($user);
    }

    public function auswertung(Request $request)
    {
        // Get the user data from the session
        $authUser = Auth::user();

        $bid = $request->input('bid', 11489);


        // Fetch all users whose name ends with "_$bid"
        $users = User::where('name', 'LIKE', '%_'.$bid)
            ->get();

        $usersWithTasks = $users->map(function ($user) {
            $user->tasks = Task::where('user_uid', $user->id)
                ->orderBy('task', 'asc')
                ->get();
            return $user;
        });




        // Pass the user data to the view
        return view('auswertung', ['users' => $usersWithTasks]);
    }



}
