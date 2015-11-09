<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PasswordController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Password Reset Controller
      |--------------------------------------------------------------------------
      |
      | This controller is responsible for handling password reset requests
      | and uses a simple trait to include this behavior. You're free to
      | explore this trait and override any methods you wish to tweak.
      |
     */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['getUpdate','postUpdate']]);
    }

    public function getUpdate(Request $request)
    {
        return view('auth.passwordchange', [
            'user' => $request->user(),
        ]);
    }
    
    public function postUpdate(Request $request)
    {
        $response = Auth::attempt(['email'=>$request->user()->email,'password'=>$request->input('oldpassword')]);
        if(!$response) {
            return redirect('/password/update')->withErrors('Old Password did not match');
        }
        
        $validator = Validator::make($request->only('password','password_confirmation'), [
            'password' => 'required|confirmed|min:6',
        ]);
        if ($validator->fails()) {
            return redirect('/password/update')->withErrors($validator);
        }
        
        return redirect('/')->with('success','Password has been updated');
    }
}
