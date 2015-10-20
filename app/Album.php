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

class Album extends Model {

    use ValidatingTrait;

    protected $table = 'albums';
    protected $fillable = ['name'];
    protected $rules = ['name' => 'max:255|string|required|min:2'];
    
    public function users() {
        return $this->belongsToMany('App\User','album_users','album_id','user_id');
    }
    public function photos() {
        return $this->hasMany('App\Photo');
    }

}