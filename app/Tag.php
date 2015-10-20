<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Watson\Validating\ValidatingTrait;

/**
 * @property integer $id
 * @property integer $photo_id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 */

class Tag extends Model {

    use ValidatingTrait;

    protected $table = 'tags';
    protected $fillable = ['photo_id','name'];
    protected $rules = ['photo_id' => 'exists:photos,id|integer|min:0|required',
                            'name' => 'max:255|string'];
    
    public function photo() {
        return $this->belongsTo('App\Photo');
    }

}