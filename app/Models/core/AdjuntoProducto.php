<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

class AdjuntoProducto extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.adjunto_producto';

	public $timestamps = false;

	public $incrementing = false;

	public static function getAttached($codigo_producto)
	{
		$query = AdjuntoProducto::query();
		$query->select('adjunto.codigo_adjunto', 'codigo_tipo_adjunto', 'direccion_adjunto', 'nombre_adjunto');
    	$query->join('core.adjunto', 'adjunto_producto.codigo_adjunto', '=', 'adjunto.codigo_adjunto');
		$query->where('adjunto_producto.codigo_estado', '=', Estado::getState('active'));
		$query->where('adjunto.codigo_privacidad_contenido', '=', PrivacidadContenido::getPrivacy('public'));
		$query->where('adjunto_producto.codigo_producto', '=', $codigo_producto);
		$query->orderBy('adjunto.codigo_adjunto', 'asc');

        // Get posts
		return $query->get();
   	}

   	public static function getAttachedProduct($attached, $product)
	{
		$query = AdjuntoProducto::query();
		$query->select('adjunto.codigo_adjunto', 'codigo_tipo_adjunto', 'direccion_adjunto', 'nombre_adjunto');
    	$query->join('core.adjunto', 'adjunto_producto.codigo_adjunto', '=', 'adjunto.codigo_adjunto');
		$query->where('adjunto_producto.codigo_estado', '=', Estado::getState('active'));
		$query->where('adjunto.codigo_privacidad_contenido', '=', PrivacidadContenido::getPrivacy('public'));
		$query->where('adjunto_producto.codigo_adjunto', '=', $attached);
		$query->where('adjunto_producto.codigo_producto', '=', $product);
		
		return $query->first();
   	}
}
