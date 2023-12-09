<?php



namespace App\Http\Controllers\Api\V1;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;



class AuthController extends Controller

{

    public function register(Request $request)

    {

        try {

            $validator = Validator::make($request->all(), [

                'name' => 'required|string|max:100',

                'email' => 'required|email|unique:users,email',

                'password' => 'required|min:6',

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

}

