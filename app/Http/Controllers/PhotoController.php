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
            $photos = $photo->album->photos->keyBy('id');
            $keys = $photos->keys()->all();
            foreach($keys as $index => $key) {
                if($key == $id) {
                    $photoIndex = $index;
                    break;
                }
            }
            if($move == 'next') {
                $photoIndex += 1;
            }
            if($move == 'prev') {
                $photoIndex -= 1;
            }
            if($photoIndex < 0) {
                $photoIndex = count($keys) - 1;
            }
            if($photoIndex == count($keys)) {
                $photoIndex = 0;
            }
            return redirect('/photo/view/'. $keys[$photoIndex]);
        }
        return view('photo.view',[
            'photo' => $photo,
        ]);
    }
}
