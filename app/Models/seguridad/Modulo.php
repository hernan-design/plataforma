<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

class Modulo extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'seguridad.modulo';

   	protected $primaryKey = 'codigo_modulo';

	public static function getModule($module) {
    	switch ($module) :
		    case 'forum': return 1;
		    case 'wall': return 2;
		    case 'header': return 3;
		    case 'banner': return 4;
		    case 'sitemap': return 7;
		    case 'projects': return 9;
		    case 'calendar': return 13;
		    case 'blog': return 14;
		    case 'mentoring': return 20;
		    case 'surveys': return 21;
		    case 'users': return 22;
		    case 'teams': return 23;
		    case 'learn': return 24;
		    case 'marketplace': return 25;
		    case 'calls': return 26;
		    case 'discussion': return 27;
		    case 'register': return 29;
		    case 'agreements': return 52;
		    case 'phases': return 53;
			default: return 'Not module identified';
		endswitch;
    }

    public static function getTypeModule($module) {
    	switch ($module) :
		    case 'platform': return 1;
		    case 'landing': return 2;
		    case 'administrator': return 3;
			default: return 'Not module identified';
		endswitch;
    }
}
