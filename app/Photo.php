<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Watson\Validating\ValidatingTrait;

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
}
