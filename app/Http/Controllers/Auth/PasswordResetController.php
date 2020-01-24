<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use App\PasswordReset;
use App\User;
use Illuminate\Http\Request;

class PasswordResetController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('jwt', ['except' => ['login']]);
    // }
    /**
     * Create token password reset
     *
     * @param  [string] email
     * @return [string] message
     */
    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',

        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'message' => 'We can\'t find a user with that e-mail address.',
            ], 404);
        }

        $passwordReset = User::updateOrCreate(
            ['email' => $user->email],
            [
                // 'email' => $user->email,
                'token' => str_random(60),
            ]
        );

        // var_dump($passwordReset);
        if ($user && $passwordReset) {

            $user->notify(
                new PasswordResetRequest($passwordReset->token, $request->token)
            );
        }

        return response()->json([
            'message' => 'We have e-mailed your password reset link!',
        ]);
    }
    /**
     * Find token password reset
     *
     * @param  [string] $token
     * @return [string] message
     * @return [json] passwordReset object
     */
    public function find($token)
    {
        $passwordReset = User::where('token', $token)
            ->first();
        if (!$passwordReset) {
            return response()->json([
                'message' => 'This password reset token is invalid.',
            ], 404);
        }

        // if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
        //     $passwordReset->delete();
        //     return response()->json([
        //         'message' => 'This password reset token is invalid.',
        //     ], 404);
        // }
        return response()->json($passwordReset);
    }
    /**
     * Reset password
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @param  [string] token
     * @return [string] message
     * @return [json] user object
     */
    public function reset(Request $request)
    {

        $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|string|confirmed',
            'token'    => 'required|string',
        ]);

        $passwordReset = User::where('remember_token', $request->token)->first();
        if (!$passwordReset) {
            return response()->json([
                'message' => 'This password reset token is invalid.',
            ], 404);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'message' => 'We can\'t find a user with that e-mail address.',
            ], 404);
        }

        $user->password = bcrypt($request->password);
        $user->save();
        $passwordReset->delete();
        $user->notify(new PasswordResetSuccess($passwordReset));
        return response()->json($user);
    }
}