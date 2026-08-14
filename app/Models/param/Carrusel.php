<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrusel extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'param.carousel';

	protected $primaryKey = 'codigo_carousel';

   	public static function getImages()
   	{
		$query = self::query();
		$query->select('direccion_adjunto', 'nombre_adjunto');
		$query->join('core.adjunto', 'carousel.codigo_adjunto', '=', 'adjunto.codigo_adjunto');
		$query->where('carousel.codigo_estado', Estado::getState('active'));
		$query->where('carousel.codigo_institucion', '=', RegistroSesion::getInstitution());
		$query->orderBy('codigo_carousel','asc');
		return $query->get();
   	}
}
