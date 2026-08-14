<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

class TipoMenu extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'param.tipo_menu';

   	protected $primaryKey = 'codigo_tipo_menu';

	public static function getType($type) {
    	switch ($type) :
		    case 'landing': return 1;
		    case 'platform': return 2;
		    case 'sitemap': return 3;
			default: return 'Not type identified';
		endswitch;
    }
}
