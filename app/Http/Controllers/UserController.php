<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Album;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return view('user.list',[
            'users' => User::all(),
        ]);
    }
    
    public function admin(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_admin'=>1]);
        
        return redirect('/user');
    }
    
    public function invite(Request $request)
    {
        return view('user.invite',[
            'albums' => Album::all(),
        ]);
    }
    
    public function invitePost(Request $request)
    {
        /* @var $newUser /App/User */
        $newUser = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => 'temporary',
            'is_admin' => 0,
        ]);
        if($newUser->isValid()) {
            $album_ids = $request->input('albums',[]);
            foreach($album_ids as $album_id) {
                $newUser->albums()->attach($album_id);
            }
            $albums = Album::whereIn('id',$album_ids)->get();
            $token = base64_encode(sha1("{$newUser->id}_{$newUser->email}"));
            
            Mail::send('emails.invite', ['user' => $newUser,'albums' => $albums, 
                'current' => $request->user(), 'token' => $token, 'domain' => $request->server('HTTP_HOST')], function ($m) use ($newUser) {
                $m->to($newUser->email);
                $m->subject('Invitation');
            });
            return redirect('user/invite')->with('success','Invite sent.');
        } else {
            return redirect()->back()->withErrors($newUser->getErrors())->withInput();
        }
    }
    
    public function getInvited(Request $request)
    {
        $email = $request->input('email');
        $token = $request->input('token');
        
        $user = User::where('email','=',$email)->first();
        if(!$user) {
            return redirect('user/register')->with('error','User not found');
        }
        $generateToken = base64_encode(sha1("{$user->id}_{$user->email}"));
        if($token != $generateToken) {
            return redirect('user/register')->with('error','Invalid token');
        }
        if($user->password != 'temporary') {
            return redirect('user/register')->with('error','This invitation is no longer valid');
        }
        return view('user.invited',[
            'token' => $token,
            'email' => $email
        ]);
    }
    
    public function postInvited(Request $request)
    {
        $email = $request->input('email');
        $token = $request->input('token');
        
        $user = User::where('email','=',$email)->first();
        if(!$user) {
            return redirect('auth/register')->with('error','User not found');
        }
        $generateToken = base64_encode(sha1("{$user->id}_{$user->email}"));
        if($token != $generateToken) {
            return redirect('auth/register')->with('error','Invalid token');
        }
        if($user->password != 'temporary') {
            return redirect('auth/register')->with('error','This invitation is no longer valid');
        }
        
        $validator = Validator::make($request->only('password','password_confirmation'), [
            'password' => 'required|confirmed|min:6',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $user->password = bcrypt($request->input('password'));
        $user->save();
        Auth::login($user);
        return redirect('/')->with('success','Your password has been updated!');
    }
}
