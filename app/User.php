<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Watson\Validating\ValidatingTrait;

/**
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property string $created_at
 * @property string $updated_at
 * @property string $is_admin
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{

    use Authenticatable,
        Authorizable,
        CanResetPassword;

use ValidatingTrait;

    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password', 'remember_token', 'is_admin'];
    protected $hidden = ['password', 'remember_token'];
    protected $rules = ['name' => 'max:255|string',
        'email' => 'max:255|string',
        'password' => 'max:60|string',
        'remember_token' => 'max:100|string',
        'is_admin' => 'integer|min:0|required'];

    public function albums()
    {
        return $this->belongsToMany('App\Album', 'album_users', 'user_id', 'album_id');
    }

    public function hasAccess($album_id)
    {
        foreach($this->albums as $album) {
            if($album->id == $album_id) {
                return true;
            }
        }
        return false;
    }
}
