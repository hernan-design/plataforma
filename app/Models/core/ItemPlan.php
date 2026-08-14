<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemPlan extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.item_plan';

   	protected $primaryKey = 'codigo_item_plan';
}
