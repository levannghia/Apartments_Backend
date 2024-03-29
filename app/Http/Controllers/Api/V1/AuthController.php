<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Notifications\ResetPassword;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Str;

class AuthController extends Controller

{

    public function register(Request $request)

    {

        try {

            $validator = Validator::make($request->all(), [

                'name' => 'required|string|max:100',

                'email' => 'required|email|unique:users,email',

                'password' => 'required|min:8',

                'password_confirmation' => 'required|same:password',

            ]);



            if ($validator->fails()) {

                return response()->json([

                    'errors' => $validator->errors(),

                    'message' => 'Fails'

                ], 400);
            }

            $user = User::create([

                'name' => $request->input('name'),

                'email' => $request->input('email'),

                'password' => Hash::make($request->input('password'))

            ]);

            $token = $user->createToken('user_token')->plainTextToken;

            return response()->json([

                'data' => $user,

                'token' => $token

            ], 201);
        } catch (\Exception $e) {
            Log::error("message: " . $e->getMessage() . ' ---- line: ' . $e->getLine());
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Register error!'
            ], 500);
        }
    }

    public function login(Request $request)

    {

        try {

            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                    'message' => 'error'
                ], 400);
            }

            $user = User::where('email', $request->input('email'))->first();

            if ($user) {

                if (Hash::check($request->input('password'), $user->password)) {

                    $token = $user->createToken('user_token')->plainTextToken;

                    return response()->json([

                        'data' => $user,

                        'token' => $token

                    ], 200);
                }

                return response()->json([

                    'message' => 'Mật khẩu không chính xác',

                ], 400);
            } else {

                return response()->json([

                    'error' => 'Tài khoản không tồn tại!',

                    'message' => 'error'

                ], 400);
            }
        } catch (\Exception $e) {
            Log::error("message: " . $e->getMessage() . ' ---- line: ' . $e->getLine());
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Login error!'
            ], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        try {
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                    'message' => 'error'
                ]);
            }

            $user = User::where('email', $request->input('email'))->first();
            $token = Str::random(6);
            $url = URL::temporarySignedRoute('auth.update.password', now()->addMinute(30), [
                'token' => $token,
                'email' => $request->email,
            ]);
            $expires = null;
            if ($user) {
                $resetPassword = DB::table('password_resets')->updateOrInsert(
                    ['email' => $request->input('email')],
                    ['token' => Hash::make($token), 'created_at' => Carbon::now()]
                );
                $urlParts = parse_url($url);
                if ($urlParts && isset($urlParts['path']) && isset($urlParts['query'])) {
                    parse_str($urlParts['query'], $query);
                    // Lấy các phần từ URL
                    // $pathSegments = explode('/', $urlParts['path']);
                    // Lấy token và email từ phần đường dẫn của URL
                    // $tokenUrl = $pathSegments[count($pathSegments) - 2];
                    // $emailUrl = end($pathSegments);
                    $expires = $query['expires'] ?? null;
                }


                Notification::send($user, new ResetPassword($user, $token, $url));

                return response()->json([
                    'data' => [
                        'token' => $token,
                        'url' => $url,
                        'expires' => $expires,
                    ],
                    'message' => 'Success'
                ], 200);
            }

            return response()->json([
                'error' => 'Email vẫn chưa được đăng ký',
                'message' => 'Reset Password error!'
            ]);
        } catch (\Exception $e) {
            Log::error("message: " . $e->getMessage() . ' ---- line: ' . $e->getLine());
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Reset password!'
            ], 500);
        }
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'new_password' => 'string|required|min:8',
            'password_confirmation' => 'required|same:new_password',
            'token' => 'required'
        ]);

        try {
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                    'message' => 'error'
                ]);
            }

            $email = $request->input('email');
            $token = $request->input('token');
            $expiresDay = $request->input('expires');
            $dateNow = time();
            $expires = false;
            if ($dateNow > $expiresDay) {
                $expires = true;
            }

            if ($expires == false) {
                $resetPassword = DB::table('password_resets')->where('email', $email);
                if (Hash::check($token, $resetPassword->first()->token)) {

                    $user = User::where('email', $resetPassword->first()->email)->first();
                    if ($user) {
                        $user->password = Hash::make($request->input('new_password'));
                        $user->save();
                        $resetPassword->delete();
                        return response()->json([
                            'message' => 'Đổi mật khẩu thành công'
                        ], 200);
                    }
                    return response()->json([
                        'error' => 'Lỗi',
                        'message' => 'user không tồn tại'
                    ]);
                }

                return response()->json([
                    'error' => 'Lỗi',
                    'message' => 'Token không chính xác'
                ]);
            }

            return response()->json([
                'error' => 'Lỗi',
                'message' => 'Token hết hạn'
            ]);
        } catch (\Exception $e) {
            Log::error("message: " . $e->getMessage() . ' ---- line: ' . $e->getLine());
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Update password!'
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = User::findOrFail($request->input('user_id'));
            $user->tokens()->delete();
            return response()->json('User logged out!', 200);
        } catch (\Exception $e) {
            Log::error("message: " . $e->getMessage() . ' ---- line: ' . $e->getLine());
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Logout error!'
            ]);
        }
    }

    public function refreshToken(Request $request)
    {
        $refreshToken = $request->bearerToken();
        $token = DB::table('personal_access_tokens')->where('token', $refreshToken)->first();

        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = User::find($token->tokenable_id);
        $newAccessToken = '';
        if($user){
            $user->tokens()->delete();
            $newAccessToken = $user->createToken('user_token')->plainTextToken;
            dd("OK");
        }

        return response()->json([
            'access_token' => $newAccessToken,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ], 200);
    }
}

// $url = URL::temporarySignedRoute('shared.post', now()->addDays(30),[
//     'post' => $post->id
// ]);
