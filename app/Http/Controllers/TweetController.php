<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TweetController extends Controller
{
    public function getAll()
    {
        $tweets = DB::select('SELECT * FROM `tweet-compare`.tweets');
        return $tweets;
        //return view('tweets.index', ['users' => $users]);
    }
}