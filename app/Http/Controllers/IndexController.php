<?php
namespace App\Http\Controllers;


use App, Request;
use App\Models\User;

use Illuminate\Support\Facades\Auth;


class IndexController extends Controller{

    public function index() {

        $user = Auth::user();

        return view('home', compact('user'));
    }


}

