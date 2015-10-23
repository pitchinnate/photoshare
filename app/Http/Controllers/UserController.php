<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

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
}
