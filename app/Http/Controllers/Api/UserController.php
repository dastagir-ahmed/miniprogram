<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\UserCoin;
use App\Models\UserStar;
use Carbon\Carbon;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations\RequestBody;

/**
 * @SWG\Swagger(
 *     @OA\Info(title="在家办公小程序接口文档", version="1.0")
 * )
 */
class UserController extends BaseController
{
    /**
     * @OA\Get(
     *     tags={"用户管理"},
     *     path="/api/user/login",
     *     summary="账号+密码登录",
     *    @OA\Parameter(
     *          name="username",
     *          description="账号",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *    @OA\Parameter(
     *          name="password",
     *          description="密码",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="返回token"
     *       )
     *     )
     */
    public function login(Request $request)
    {
        $user_name = $request->get('username', '');
        $password = $request->get('password', '');
        $user = User::where(['username' => $user_name])->first();
        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json(["code" => -1, "data" => "", "msg" => "用户名或密码错误！"]);
        }
        //登录成功token
        $userinfo = ['userid' => $user->id, 'username' => $user->username];
        $token = $this->getJWTToken($userinfo);
        return response()->json(['token' => $token]);
    }

    /**
     * @OA\Get(
     *     tags={"用户管理"},
     *     path="/api/user/phonelogin",
     *     summary="手机号+密码登录",
     *    @OA\Parameter(
     *          name="phone",
     *          description="手机号",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *    @OA\Parameter(
     *          name="password",
     *          description="密码",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="返回token"
     *       )
     *     )
     */
    public function phoneLogin(Request $request)
    {
        $phone = $request->get('phone', '');
        $password = $request->get('password', '');
        $user = User::where(['tel' => $phone])->first();
        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json(["code" => -1, "data" => "", "msg" => "账号或密码错误！"]);
        }
        //登录成功token
        $userinfo = ['userid' => $user->id, 'username' => $user->username];
        $token = $this->getJWTToken($userinfo);
        return response()->json(['token' => $token]);
    }

    /**
     * @OA\Post(
     *     tags={"用户管理"},
     *     path="/api/user/register",
     *     summary="用户名注册",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"username","tel","email","password","password_confirmation"},
     *              @OA\Property(property="username", type="string",description="用户名"),
     *              @OA\Property(property="tel", type="string",description="手机号"),
     *              @OA\Property(property="email", type="string",description="邮箱"),
     *              @OA\Property(property="password", type="string",description="密码"),
     *              @OA\Property(property="password_confirmation", type="string",description="确认密码"),
     *              ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="成功"
     *       )
     *     )
     */
    public function register(Request $request)
    {
        $rules = [
            'username' => 'required|unique:users|max:100',
            'tel' => 'regex:/^1[0-9][0-9]{9}$/|unique:users',
            'email' => 'required|email|max:50|unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ];
        $messages = [
            'username.required' => '用户名不能为空',
            'username.unique' => '用户名已存在',
            'tel.regex' => '手机号格式不正确',
            'tel.unique' => '手机号已存在',
            'email.required' => '邮箱不能为空',
            'email.unique' => '邮箱已存在',
            'email.email' => '邮箱格式不正确',
            'password.required' => '密码不能为空',
            'password.confirmed' => '2次输入密码不一致'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'code' => -1,
                'msg' => $validator->errors()->first()
            ]);
        }
        $user = new User();
        $user->username = $request->post('username');
        $user->email = $request->post('email');
        $user->subscribe_email = $request->post('email');
        $user->tel = $request->post('tel');
        $user->password = bcrypt($request->post('password'));
        if ($user->save()) {
            return response()->json([
                'code' => 0,
                'msg' => '成功'
            ]);
        }
        return response()->json([
            'code' => -1,
            'msg' => '失败'
        ]);
    }

    /**
     * @OA\Post(
     *     tags={"用户管理"},
     *     path="/api/user/phoneregister",
     *     summary="手机号+验证码注册",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"username","tel","code","password","password_confirmation"},
     *              @OA\Property(property="tel", type="string",description="手机号"),
     *              @OA\Property(property="code", type="string",description="验证码"),
     *              @OA\Property(property="password", type="string",description="密码"),
     *              @OA\Property(property="password_confirmation", type="string",description="确认密码"),
     *              ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="成功"
     *       )
     *     )
     */
    public function phoneRegister(Request $request)
    {
        $rules = [
            'tel' => 'regex:/^1[0-9][0-9]{9}$/|unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'code' => 'required'
        ];
        $messages = [
            'tel.regex' => '手机号格式不正确',
            'tel.unique' => '手机号已存在',
            'password.required' => '密码不能为空',
            'password.confirmed' => '2次输入密码不一致'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'code' => -1,
                'msg' => $validator->errors()->first()
            ]);
        }
        $user = new User();
        $user->tel = $request->post('tel');
        $user->password = bcrypt($request->post('password'));
        if ($user->save()) {
            return response()->json([
                'code' => 0,
                'msg' => '成功'
            ]);
        }
        return response()->json([
            'code' => -1,
            'msg' => '失败'
        ]);
    }

    /**
     * @OA\Post(
     *     security={{"bearer":{}}},
     *     tags={"用户管理"},
     *     path="/api/user/updatepwd",
     *     summary="修改密码",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"oldpassword","password","password_confirmation"},
     *              @OA\Property(property="oldpassword", type="string",description="旧密码"),
     *              @OA\Property(property="password", type="string",description="新密码"),
     *              @OA\Property(property="password_confirmation", type="string",description="确认密码"),
     *              ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="成功"
     *       ),
     *     )
     */
    public function updatePwd(Request $request)
    {
        $rules = [
            'oldpassword' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ];
        $messages = [
            'oldpassword.required' => '旧密码不能为空',
            'password.required' => '新密码不能为空',
            'password.confirmed' => '2次输入密码不一致'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'code' => -1,
                'msg' => $validator->errors()->first()
            ]);
        }
        $user = User::find($id = $request->id);
        if (!$user || !Hash::check($request->post('oldpassword'), $user->password)) {
            return response()->json(["code" => -1, "data" => "", "msg" => "旧密码错误！"]);
        }
        $user->password = bcrypt($request->post('password'));
        if ($user->save()) {
            return response()->json([
                'code' => 0,
                'msg' => '成功'
            ]);
        } else {
            return response()->json([
                'code' => -1,
                'msg' => '失败'
            ]);
        }
    }

    /**
     * @OA\Post(
     *     tags={"用户管理"},
     *     path="/api/user/resetpwd1",
     *     summary="重置密码第一步 验证手机号",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"phone","code"},
     *              @OA\Property(property="phone", type="string",description="手机号"),
     *              @OA\Property(property="code", type="string",description="验证码"),
     *              ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="成功"
     *       ),
     *     )
     */
    public function resetPwd1(Request $request)
    {
        $phone = $request->post(phone);
        $code = $request->post(code);
        $cacheCode = Cache::get($phone);
        if ($cacheCode && $code == $cacheCode) {
            Cache::put($phone, 1, Carbon::now()->addMinutes(10));
            return response()->json([
                'code' => 0,
                'msg' => '成功'
            ]);
        }
        return response()->json([
            'code' => -1,
            'msg' => '手机号或验证码错误'
        ]);
    }

    /**
     * @OA\Post(
     *     tags={"用户管理"},
     *     path="/api/user/resetpwd2",
     *     summary="重置密码第二步 验证手机号",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"password","password_confirmation"},
     *              @OA\Property(property="password", type="string",description="新密码"),
     *              @OA\Property(property="password_confirmation", type="string",description="确认密码"),
     *              ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="成功"
     *       ),
     *     )
     */
    public function resetPwd2(Request $request)
    {
        $rules = [
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ];
        $messages = [
            'password.required' => '新密码不能为空',
            'password.confirmed' => '2次输入密码不一致'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'code' => -1,
                'msg' => $validator->errors()->first()
            ]);
        }
        $phone = $request->post(phone);
        $user = User::where(['tel' => $phone])->first();
        $status = Cache::pull($phone);
        if ($status && $status == 1) {
            $user->password = bcrypt($request->post('password'));
            if ($user->save()) {
                return response()->json([
                    'code' => 0,
                    'msg' => '成功'
                ]);
            } else {
                return response()->json([
                    'code' => 0,
                    'msg' => '重置密码失败'
                ]);
            }
        }
        return response()->json([
            'code' => -1,
            'msg' => '验证失败，请重新验证'
        ]);
    }

    /**
     * @OA\Get(
     *     security={{"bearer":{}}},
     *     tags={"用户管理"},
     *     path="/api/user/getinfo",
     *     summary="获取基本信息",
     *      @OA\Response(
     *          response=200,
     *          description="成功"
     *       ),
     *     )
     */
    public function getInfo(Request $request)
    {
        //用户id
        $id = $request->id;
        $user = User::find($id = $id);
        if ($user) {
            return response()->json([
                "code" => 0
                , "data" => array([
                    'username' => $user->username,
                    'tel' => $user->tel,
                    'email' => $user->email,
                    'avatar_url' => $user->avatar_url
                ])
                , "msg" => "成功"
            ]);
        }
        return response()->json([
            'code' => -1,
            'msg' => '失败'
        ]);
    }

    /**
     * @OA\Post(
     *     security={{"bearer":{}}},
     *     tags={"用户管理"},
     *     path="/api/user/updateinfo",
     *     summary="更新用户基本信息",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"username","tel","email"},
     *              @OA\Property(property="username", type="string",description="用户名"),
     *              @OA\Property(property="tel", type="string",description="手机号"),
     *              @OA\Property(property="email", type="string",description="邮箱"),
     *              @OA\Property(property="avatar_url", type="string",description="头像地址"),
     *              ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="成功"
     *       ),
     *     )
     */
    public function updateInfo(Request $request)
    {
        $rules = [
            'username' => 'required|max:100',
            'tel' => 'regex:/^1[0-9][0-9]{9}$/',
            'email' => 'required|email|max:50',
            'avatar_url' => 'required'
        ];
        $messages = [
            'username.required' => '用户名不能为空',
            'tel.regex' => '手机号格式不正确',
            'email.required' => '邮箱不能为空',
            'email.email' => '邮箱格式不正确',
            'avatar_url.required' => '请上传头像'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'code' => -1,
                'msg' => $validator->errors()->first()
            ]);
        }
        $username = $request->post('username');
        $email = $request->post('email');
        $tel = $request->post('tel');
        $id = $request->id;
        $getcount = User::where([['tel', '=', $tel], ['id', '<>', $id]])->count();
        if ($getcount > 0) {
            return response()->json([
                'code' => -1,
                'msg' => '手机号已存在'
            ]);
        }
        $getcount = User::where([['username', '=', $username], ['id', '<>', $id]])->count();
        if ($getcount > 0) {
            return response()->json([
                'code' => -1,
                'msg' => '用户名已存在'
            ]);
        }
        $getcount = User::where([['email', '=', $email], ['id', '<>', $id]])->count();
        if ($getcount > 0) {
            return response()->json([
                'code' => -1,
                'msg' => '邮箱已存在'
            ]);
        }
        $user = User::find($id = $id);
        if ($user) {
            $user->username = $username;
            $user->email = $email;
            $user->subscribe_email = $email;
            $user->tel = $tel;
            $user->avatar_url = $request->post('avatar_url');
            if ($user->save()) {
                return response()->json([
                    "code" => 0
                    , "data" => ""
                    , "msg" => "成功"
                ]);
            }
            return response()->json([
                'code' => -1,
                'msg' => '失败'
            ]);
        }
        return response()->json([
            'code' => -1,
            'msg' => '失败'
        ]);
    }


}
