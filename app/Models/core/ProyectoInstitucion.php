<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

class ProyectoInstitucion extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.proyecto_institucion';

	public $timestamps = false;

	public $incrementing = false;

	public static function getProjectInstitution($project, $institution)
	{
		return ProyectoInstitucion::where('core.proyecto_institucion.codigo_proyecto', $project)->where('core.proyecto_institucion.codigo_institucion', $institution)->first();
	}

}
