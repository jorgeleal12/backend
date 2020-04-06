<?php
namespace App\Http\Controllers;

use App\Contract;
use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['login']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function login()
    {
        $credentials = request(['id', 'password', 'company_idcompany']);

        $company_idcompany = request('company_idcompany');
        $id                = request('id');
        $password          = request('password');
        $contract          = request('contract');

        $user = User::where('id', $id)->where('company_idcompany', $company_idcompany)->first();

        $contract = Contract::where('idcontract', $contract)->where('users_idusers', $user->idusers)->first();

        if (!$contract) {
            return response()->json(['error' => true], 200);
        }
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => true], 200);
        }

        return $this->respondWithToken($token);
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function payload()
    {
        return response()->json(auth()->payload());
    }
    /**
     * Log the user out ( Invalidate the token ).
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }
    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60,
            'user'         => auth()->user(),
            'error'        => false,
        ]);
    }

}
