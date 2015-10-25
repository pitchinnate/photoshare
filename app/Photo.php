<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Watson\Validating\ValidatingTrait;
use Symfony\Component\HttpFoundation\File\File;
use Intervention\Image\ImageManagerStatic as Image;

/**
 * @property integer $id
 * @property integer $album_id
 * @property string $path
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 */
class Photo extends Model
{

    use ValidatingTrait;

    protected $table = 'photos';
    protected $fillable = ['album_id', 'path', 'name'];
    protected $rules = ['album_id' => 'exists:albums,id|integer|min:0|required',
        'path' => 'max:255|string',
        'name' => 'max:255|string',
    ];

    public function tags()
    {
        return $this->hasMany('App\Tag');
    }

    public function album()
    {
        return $this->belongsTo('App\Album');
    }

    public function getUrl()
    {
        return '/photo/' . $this->id;
    }
    public function getThumbnail()
    {
        return '/photo/thumb/' . $this->id;
    }
    
    public function makeThumbnail()
    {
        $file = new File($this->path);
        if(!is_file($this->path . '.' . $file->guessExtension())) {
            $image = Image::make($this->path);
            $percent = 175 / $image->getHeight();
            $width = $image->getWidth() * $percent;
            $image->resize(floor($width), 175);
            $image->save($this->path . '.' . $file->guessExtension());
        }
    }
    
    public function removeThumbnail()
    {
        $file = new File($this->path);
        if(is_file($this->path . '.' . $file->guessExtension())) {
            unlink($this->path . '.' . $file->guessExtension());
        }
    }
    
    public function rotate($angle)
    {
        $this->removeThumbnail();
        $file = new File($this->path);
        $newfilePath = $this->path . 'new.' . $file->guessExtension();
        $image = Image::make($this->path);
        $image->rotate($angle);
        $image->save($newfilePath);
        unlink($this->path);
        rename($newfilePath, $this->path);
        $this->makeThumbnail();
    }
}
