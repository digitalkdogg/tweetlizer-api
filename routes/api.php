<?php

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RandomGeneratorController;
use Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/genkey', function() {
    var_dump(Session::get('bearer'));
    $generator = (new RandomGeneratorController);

    // Set token length.
    $tokenLength = 150;

    // Call method to generate random string.
    $token = $generator->generate($tokenLength);
    return response($token, 200)->header('Content-Type', 'application/json');
});

Route::get('/auth', function () {
    $auth = (new AuthController);
    $auth_rec = $auth->lookup();

    if ($auth_rec->count()==1) {
        foreach ($auth_rec as $rec) {
            $token = $auth->checkBearer($rec);
        }
        $mytime = Carbon\Carbon::now()->addHour();
        $data = ['id' => $auth_rec[0]->key, 'bearer'=> $token, 'expires_at'=> $mytime, 'auth_id' => $auth_rec[0]->id];
        $bearer = $auth->setBearer($data);
        return response($bearer, 200)->header('Content-Type', 'application/json');
    } else {
        $not_auth = ['bearer'=>'not_authorized', 'ip'=> Request::ip()];
        return response($not_auth, 401)->header('Content-Type', 'application/json');
    }
   
});

Route::get('/test', function () {

    //$results=DB::select('select * from posts where id=?',[1]);  
    $tweets = (new TweetController)->getAll();

    return response($tweets, 200)->header('Content-Type', 'application/json');
});