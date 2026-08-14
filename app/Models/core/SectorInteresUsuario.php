<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

use TuProyecto;

use Input, App;

class SectorInteresUsuario extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.sector_interes_usuario';

	public $incrementing = false;

	public $timestamps = false;

	
	public static function getInterests()
	{
		$reasons = [];
		$query = SectorInteresUsuario::query();
		$query->select('sector_interes.codigo_sector_interes', 'sector_interes.nombre_sector_interes');
		$query->join('core.sector_interes', 'sector_interes_usuario.codigo_sector_interes', '=', 'sector_interes.codigo_sector_interes');
		$query->where('sector_interes_usuario.codigo_estado', '=', Estado::getState('active'));

		if(Input::has('codigo_usuario')) {
			// Decrypt src-params
			list($codigo_usuario) = TuProyecto::decryptSrcParams(Input::get('codigo_usuario'));
			if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
				App::abort(403);
			}
			$query->where('sector_interes_usuario.codigo_usuario', '=', $codigo_usuario);

	    	$query->orderBy('nombre_sector_interes','asc');
			$reasons = $query->get();
		}
		return $reasons;
	}
	/**
	* Defining Relations
	*/
	public function sectorinteres()
    {
        return $this->hasOne('App\SectorInteres','codigo_sector_interes','codigo_sector_interes');
    }
}
