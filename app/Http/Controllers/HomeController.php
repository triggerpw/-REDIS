<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redis;



class HomeController extends Controller
{





    public function test() {


        $redis = Redis::connection();
        try{
            $redis->ping();
        } catch (Exception $e){
            $e->getMessage();
        }


    }



}