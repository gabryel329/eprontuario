<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use SebastianBergmann\CodeUnit\FunctionUnit;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function redirectTo()
{
    return route('dashboard');
}


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // protected function sendFailedLoginResponse(Request $request)
    // {
    //     $user = \App\Models\User::where('email', $request->email)->first();

    //     if (!$user) {
    //         throw ValidationException::withMessages([
    //             'email' => [trans('E-email Incorreto')],
    //         ]);
    //     }

    //     throw ValidationException::withMessages([
    //         'password' => [trans('Senha Incorreta')],
    //     ]);
    // }

    public function name(){
        return 'name';
    }
}
