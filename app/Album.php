<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Watson\Validating\ValidatingTrait;

/**
 * @property integer $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 */
class Album extends Model
{

    use ValidatingTrait;

    protected $table = 'albums';
    protected $fillable = ['name'];
    protected $rules = ['name' => 'max:255|string|required|min:2'];

    public function users()
    {
        return $this->belongsToMany('App\User', 'album_users', 'album_id', 'user_id');
    }

    public function photos()
    {
        return $this->hasMany('App\Photo');
    }

    public function getKeys()
    {
        $photos = $this->photos->keyBy('id');
        return $photos->keys()->all();
    }
    
    public function getPhotoIndex($photoId)
    {
        $keys = $this->getKeys();
        foreach($keys as $index => $key) {
            if($key == $photoId) {
                return $index;
            }
        }
    }
    
    public function nextPhoto($photoId)
    {
        $photoIndex = $this->getPhotoIndex($photoId);
        $photoCount = $this->photos()->count();
        $photoIndex += 1;
        if($photoIndex == $photoCount) {
            $photoIndex = 0;
        }
        return $this->photos[$photoIndex];
    }
    
    public function prevPhoto($photoId)
    {
        $photoIndex = $this->getPhotoIndex($photoId);
        $photoCount = $this->photos()->count();
        $photoIndex -= 1;
        if($photoIndex < 0) {
            $photoIndex = $photoCount - 1;
        }
        return $this->photos[$photoIndex];
    }
    
    public function getPageNumber($photoId)
    {
        $photoIndex = $this->getPhotoIndex($photoId) + 1;
        $pageSize = env('PAGE_SIZE',15);
        return ceil($photoIndex / $pageSize);
    }
}
