<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Firebase\JWT\JWK;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Cache;

class UserCheck
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // dd($next);
        $user = new User;
        $token = $request->header('Authorization');
        if (empty($token)) {
            return response()->json(["code" => -1, "data" => "", "msg" => "鉴权失败！"]);
        }
        $jwt = trim(ltrim($token, 'Bearer'));
        $alg =
            [
                "typ" => "JWT", //声明类型为jwt
                "alg" => "HS256" //声明签名算法为SHA256
            ];
        $key = env('JWT_SECRET');
        try {
            $token = JWT::decode($jwt, $key, $alg);


            //判断用户是否存在
            if (empty($token->data->userid)) {
                return response()->json(["code" => -1, "data" => "", "msg" => "鉴权失败！"]);
            }
            $count = $user->where('id', $token->data->userid)->count();
            if ($count == 0) {
                return response()->json(["code" => -1, "data" => "", "msg" => "用户不存在！"]);
            }
            $request->userid = $token->data->userid;
            $request->username = $token->data->username;

        } catch (ExpiredException $th) {
            if (Cache::has($jwt)) {
                $tokenData = Cache::get($jwt);
                $request->userid = $tokenData["userid"];
                $request->username = $tokenData["username"];
                $response = $next($request);
                //自动延长token
                $newToken = $this->getJWTToken(['id' => $tokenData["userid"], 'username' => $tokenData["username"]]);
                return $next($request)->header('Authorization', 'Bearer ' . $newToken);
            } else {
                return response()->json(["code" => -2, "data" => "", "msg" => "账号信息过期了，请重新登录！"]);
            }
        } catch (\Exception $th) {
            return response()->json(["code" => -2, "data" => "", "msg" => "账号信息过期了，请重新登录！异常信息：" . $th]);
        }
        return $next($request);
    }

    public function getJWTToken($value)
    {
        $time = time();
        $payload = [
            'iat' => $time,
            'nbf' => $time,
            'exp' => $time + 7200,
            'data' => [
                'userid' => $value['userid'],
                'username' => $value['username']
            ]
        ];
        $key = env('JWT_SECRET');
        $alg = 'HS256';
        $token = JWT::encode($payload, $key, $alg);
        Cache::put($token, $value, 3600 * 24 * 30);
        return $token;
    }
}
