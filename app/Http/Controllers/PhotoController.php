<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\File\File;

use App\Photo;

class PhotoController extends Controller
{
    public function upload(Request $request)
    {
        $files = $request->file();
        $file = $files['files'][0];
        if(!$file->isValid()) {
            return (new Response('Invalid Image ' . print_r($files,true),400));
        }
        
        $destinationPath = app()->storagePath() . '/photos/';
        $file->move($destinationPath, $file->getFilename());
        $photo = Photo::create([
            'path' => $destinationPath . $file->getFilename(),
            'name' => $file->getClientOriginalName(),
            'album_id' => 1,
        ]);
        $photoArray = $photo->toArray();
        $photoArray['url'] = '/photo/' . $photo->id;
        return [
            'status' => 'done',
            'files' => [$photoArray],
        ];
    }
    
    public function download(Request $request, $id)
    {
        $photo = Photo::findOrFail($id);
        $file = new File($photo->path);
        $headers = array(
            'Content-Type: ' . $file->getMimeType(),
        );
        return response()->download($photo->path, $photo->name, $headers);
    }
    
    public function view(Request $request, $id)
    {
        return view('photo.view',[
            'photo' => Photo::findOrFail($id),
        ]);
    }
}
