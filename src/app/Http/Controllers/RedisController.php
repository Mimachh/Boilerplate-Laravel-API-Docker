<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class RedisController extends Controller
{
    public function index() {
        // Redis::set('user:1', 'Taylor');
        // Redis::set('user:2', 'Jean mi');
        // Redis::set('user:3', 'Carole');

        // for($i = 1; $i <= 3; $i++) {
        //     $user = Redis::get('user:' . $i);
        //     echo $user . '<br>';
        // }
        return ApiResponse::ok(['message' => 'Redis controller']);
    }
}
