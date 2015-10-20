<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;

use App\Album;
use App\User;

class AlbumController extends Controller
{
    public function index(Request $request)
    {
        if($request->user()->is_admin == 1) {
            $albums = Album::all();
        } else {
            $albums = $request->user()->albums;
        }
        return view('album.list',[
            'albums' => $albums,
        ]);
    }
    
    public function view(Request $request, $id)
    {
        return view('album.view',[
            'album' => Album::findOrFail($id),
        ]);
    }
    
    public function create(Request $request)
    {
        $album = new Album();
        return view('album.form',[
            'album' => $album,
        ]);
    }
    
    public function save(Request $request)
    {
        $album = Album::create($request->input('Album',[]));
        if($album->isInvalid()) {
            return redirect('/album/new')->withErrors($album->getErrors());
        }
        
        return redirect('/albums')->with('success','Album created!');
    }
    
    public function upload(Request $request, $id)
    {
        return view('album.upload',[
            'album' => Album::findOrFail($id),
        ]);
    }
    
    public function users(Request $request, $id)
    {
        return view('album.users',[
            'album' => Album::findOrFail($id),
            'users' => User::where('is_admin','=',0)->get(),
        ]);
    }
    
    public function updateUser(Request $request, $id)
    {
        /* @var $album \App\Album */
        $album = Album::findOrFail($id);
        $data = $request->input('album_user',[]);
        if($data['access'] == 1) {
            $album->users()->attach($data['user']);
        } else {
            $album->users()->detach($data['user']);
        }
        return (new Response('',200));
    }
}
