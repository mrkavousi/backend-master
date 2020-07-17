<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\RegisterUserRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        if (isMobile($request->user))
            $credentials = ['mobile' => $request->user, 'password' => $request->password];

        if (filter_var($request->user, FILTER_VALIDATE_EMAIL))
            $credentials = ['email' => $request->user, 'password' => $request->password];
        $user = User::first();
        $token = JWTAuth::fromUser($user);
        $customClaims = ['foo' => 'bar', 'baz' => 'bob'];
        if (!$token = JWTAuth::fromUser($user, $customClaims)) {
            return response([
                'status' => 'error',
                'error' => 'invalid.credentials',
                'msg' => 'Invalid Credentials.'
            ], 400);
        }

        return response([
            'status' => 'success'
        ])->header('Authorization', $token);
    }

    public function register(RegisterUserRequest $request)
    {
        $user = new User;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->save();
        return response([
            'status' => 'success',
            'data' => $user
        ], 200);
    }

    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->metadatas = [];
        foreach ($user->metadata as $meta) {
            if ($meta->value === 'true')
                $meta->value = true;
            if ($meta->value === 'false')
                $meta->value = false;

            $user->metadatas = array_merge($user->metadatas, [$meta->key => $meta->value]);
        }
        unset($user->metadata);
        return response([
            'status' => 'success',
            'data' => $user
        ]);
    }

    public function refresh()
    {
        return response([
            'status' => 'success'
        ]);
    }

    public function logout()
    {
        JWTAuth::invalidate();
        return response([
            'status' => 'success',
            'message' => 'Logged out Successfully.'
        ], 200);
    }
}
