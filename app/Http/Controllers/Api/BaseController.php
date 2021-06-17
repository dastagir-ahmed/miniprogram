<?php
/**
 * Created by 喻品科技.
 * User: 化城
 * Email:info@yupinit.com
 * Date: 2021/3/6
 * Time: 17:28
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\User;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Matrix\Exception;

class BaseController extends Controller
{

    public function getJWTToken($value)
    {
        $time = time();
        $payload = [
            'iat' => $time,
            'nbf' => $time,
            'exp' => $time+7200,
            'data' => [
                'userid' => $value['userid'],
                'username' => $value['username']
            ]
        ];
        $key =  env('JWT_SECRET');
        $alg = 'HS256';
        $token = JWT::encode($payload,$key,$alg);
        Cache::put($token,$value,3600*24*30);
        return $token;
    }
    public function decodeJWTToken($value)
    {
        $time = time();
        $payload = [
            'iat' => $time,
            'nbf' => $time,
            'exp' => $time+7200,
            'data' => [
                'id' => $value['id'],
                'username' => $value['username']
            ]
        ];
        $key =  env('JWT_SECRET');
        $alg = 'HS256';
        $token = JWT::encode($payload,$key,$alg);
        Cache::put($token,$value,3600*24*30);
        return $token;
    }
}
