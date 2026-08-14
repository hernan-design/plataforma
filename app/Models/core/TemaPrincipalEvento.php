<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemaPrincipalEvento extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.tema_principal_evento';

	protected $primaryKey = 'codigo_tema_principal_evento';

	public $incrementing = false;

	public $timestamps = false;

	public static function getPrincipalTheme($theme) {
		// switch ($theme) {
		// 	case 'financial':
		// 		return 1;
		// 	break;
		// 	case 'deal':
		// 		return 2;
		// 	break;
		// }
	}
}
