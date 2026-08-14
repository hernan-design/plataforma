<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserOauth extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'user_oauth';

    protected $primaryKey = 'id';
       
    public $timestamps = false;

}
