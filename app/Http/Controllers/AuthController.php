<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use App\Notifications\SignupActivate;

class AuthController extends Controller
{

    //get social info
    //check-> registered? login : register with active = 1
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'type' => $request->type,
            'activation_token' => str_random(60),
        ]);
        $user->save();
        $user->notify(new SignupActivate($user));
        return response()->json([
            // 'result' => 1,
            'message' => 'Successfully created user!'
        ], 201);
    }

    public function resendEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'message' => 'No user with this email'
            ], 404);
        }
        if ($user->active == 1) {
            return response()->json([
                'message' => 'user is active'
            ], 409);
        }
        $user->activation_token = str_random(60);
        $user->save();
        $user->notify(new SignupActivate($user));
        return response()->json([
            'message' => 'New Link sent successfully!'
        ], 200);
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        // if($request->type){
        //     return response()->json([
        //         'message' => 'type is '.$request->type,
        //     ], 200);
        // }
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean',
            'type' => 'required|string',
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Not Found',
            ], 404);
        $credentials['active'] = 0;
        $credentials['deleted_at'] = null;
        if (Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
        if($user->type != $request->type){
            return response()->json([
                'message' => 'Forbbiden'
            ], 403);
        }
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            // 'result' => 1
        ]);
    }

    public function loginWith(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Not Found',
            ], 404);
        $credentials['active'] = 0;
        $credentials['deleted_at'] = null;

        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
        if($user->type == "client"){
            return response()->json([
                'message' => 'Forbbiden'
            ], 403);
        }
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        $user = User::with('provider.location')->find($user->id);
        // return response()->json($user);
        return response()->json(
            array_merge(
                $user->toArray(),
                [
                    'access_token' => $tokenResult->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
                ]
            )
        );
    }

    public function findOrCreate(Request $request)
    {
        //check-> registered? login : register with active = 1
        //login-> getaccesstoken -> getuser
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $isUser = User::where('email', $request->email)->first();
        $credentials = request(['email', 'password']);
        ////////////////
        if ($isUser && !Auth::attempt($credentials)) // there is a user with same email but with different account
        {
            return response()->json([
                'message' => 'email taken',
            ], 409);
        } else if (!Auth::attempt($credentials)) { // no user with this email and password
            //register a new user path
            $user = new User([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'type' => 'client',
                'activation_token' => str_random(60),
            ]);
            $user->save();
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return response()->json([
                    // 'result' => 0,
                    'message' => 'This activation token is invalid.'
                ], 404);
            }
            $user->active = 1;
            $user->activation_token = '';
            $user->save();
            return $user;
            // return response()->json([
            //     'message' => 'Not Found',
            // ], 404);
        }
        $credentials['active'] = 0;
        $credentials['deleted_at'] = null;
        if (Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        // $user = $request->user();
        return response()->json($request->user());
        // $tokenResult = $user->createToken('Personal Access Token');
        // $token = $tokenResult->token;
        // if ($request->remember_me)
        //     $token->expires_at = Carbon::now()->addWeeks(1);
        // $token->save();

        // return response()->json([
        //     'access_token' => $tokenResult->accessToken,
        //     'token_type' => 'Bearer',
        //     'expires_at' => Carbon::parse(
        //         $tokenResult->token->expires_at
        //     )->toDateTimeString(),
        //     // 'result' => 1
        // ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            // 'result' => 1,
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function signupActivate($token)
    {
        $user = User::where('activation_token', $token)->first();
        if (!$user) {
            return response()->json([
                // 'result' => 0,
                'message' => 'This activation token is invalid.'
            ], 404);
        }
        $user->active = true;
        $user->activation_token = '';
        $user->email_verified_at = Carbon::now();
        $user->save();
        // return $user;
        return view('email_verfication_result');
    }
}
