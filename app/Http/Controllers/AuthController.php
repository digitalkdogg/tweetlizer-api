<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Request;
use Session;
use Illuminate\Support\Str;
use Carbon;
//use Header;
use App\Http\Controllers\RandomGeneratorController;

class AuthController extends Controller
{
    public function lookup($req)
    {
        $referrer = $this->getReferrer($req->getUri());

        $auth = DB::table('auth')
                ->where('host', $referrer)
                ->get();
        return $auth;
    }

    private function getReferrer($uri) {
        //$uri = $req->getUri();
        $uri = Str::of($uri)->replace('http://', '');
        $uri = Str::of($uri)->replace('https://', '');
        $urisplit = Str::of($uri)->split('/[\s\/]+/');
        $referrer = '';
        if ($urisplit->count()>=1) {
            $referrer = $urisplit[0];
        }

        return $referrer;
    }

    protected function genBearer() {
        $generator = (new RandomGeneratorController);
        $tokenLength = 77;
        $token = $generator->generate($tokenLength);

        return $token;
    }

    public function checkBearer($auth) {

        $currentBearer = DB::table('bearer')
        ->where('id', $auth->key)
        ->get();
        if ($currentBearer->count() == 0) {
            $token = $this->genBearer();
            
        } else {
            foreach ($currentBearer as $bearer) {   
                $datenow = Carbon\Carbon::now();
                if ($datenow->gt($bearer->expires_at)==true) {
                    $token = $this->genBearer();
                } else {
                    $token = $bearer->bearer;
                }
            }
        }
        Session::put('bearer', $token);
        return $token;
    }

    public function setBearer($data) {
      
           DB::table('bearer')->upsert([
                'id' => $data['id'],
                'bearer' => $data['bearer'],
                'expires_at' => $data['expires_at'],
                'auth_id' => $data['auth_id']
            ],
            ['id'],
            ['expires_at', 'bearer']
        );

        $bearer = DB::table('bearer')
        ->where('id', $data['id'])
        ->get();

        return ['bearer' => $bearer[0]->bearer];
    }
}