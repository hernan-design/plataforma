<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WishlistProducto extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.wishlist_producto';

    protected $primaryKey = 'codigo_wishlist_producto';

	public $timestamps = false;
}
