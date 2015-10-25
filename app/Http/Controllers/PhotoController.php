<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\File\File;

use Intervention\Image\ImageManagerStatic as Image;

use App\Photo;
use App\Album;

class PhotoController extends Controller
{
    public function upload(Request $request, $id)
    {
        $album = Album::findOrFail($id);
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
            'album_id' => $album->id,
        ]);
        $photoArray = $photo->toArray();
        $photoArray['url'] = '/photo/' . $photo->id;
        $photo->makeThumbnail();
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
    
    public function thumb(Request $request, $id) 
    {
        $photo = Photo::findOrFail($id);
        $file = new File($photo->path);
        $photo->makeThumbnail();
        $headers = array(
            'Content-Type: ' . $file->getMimeType(),
        );
        return response()->download($photo->path . '.' . $file->guessExtension(), $photo->name, $headers);
    }
    
    public function view(Request $request, $id, $move = null)
    {
        $photo = Photo::findOrFail($id);
        if($move) {
            if($move == 'next') {
                $newPhoto = $photo->album->nextPhoto($id);
            } else {
                $newPhoto = $photo->album->prevPhoto($id);
            }
            return redirect('/photo/view/'. $newPhoto->id);
        }
        $pageNumber = $photo->album->getPageNumber($photo->id);
        return view('photo.view',[
            'photo' => $photo,
            'pageNumber' => $pageNumber,
        ]);
    }
    
    public function rotate(Request $request, $id, $angle)
    {
        $photo = Photo::findOrFail($id);
        $photo->rotate($angle);
        return redirect('/photo/view/' . $id);
    }
    
    public function delete(Request $request, $id)
    {
        $photo = Photo::findOrFail($id);
        $photo->removeThumbnail();
        unlink($photo->path);
        $albumId = $photo->album_id;
        $photo->delete();
        return redirect('/album/' . $albumId);
    }
}
