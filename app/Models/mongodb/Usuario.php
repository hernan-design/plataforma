<?php

namespace App\Models\mongodb;

use MongoDB\Laravel\Eloquent\Model;

class Usuario extends Model
{
    protected $connection = 'mongodb';
   	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $collection = 'users';
}
