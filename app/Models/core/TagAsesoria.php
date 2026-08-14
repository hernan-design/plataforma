<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

class TagAsesoria extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.tag_asesoria';

	public $incrementing = false;

   	public $timestamps = false;

   	/**
	* Defining Relations
	*/
	public function tag()
    {
        return $this->hasOne('App\Tag','codigo_tag','codigo_tag');
    }

}
