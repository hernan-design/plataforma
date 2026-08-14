<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use TuProyecto, Validator, Auth;

use App\RegistroSesion, App\Estado;

class Promocion extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.promocion';

	protected $primaryKey = 'codigo_promocion';

	public $timestamps = false;

	protected $fillable = ['fecha_inicio_promocion', 'fecha_fin_promocion', 'imagen_promocion', 'tipo_promocion', 'descripcion_promocion'];

	/**
	 * Marital status
	 *
	 * @var array
	 */
 	public static $typePromo = [1 => 'Promoción', 2  => 'Anuncio'];

	public static function getTypePromo($typePromo)
	{
		switch ($typePromo) {
			case 'promotion': return 1;
			case 'advertisement': return 2;
			default: return 'Not type promotion identified';
		}
	}

	/**
	* Valid create Product.
	*/
   	public function isValid($data)
    {
        $rules = array(
			'fecha_inicio_promocion' => 'required',
            'fecha_fin_promocion' => 'required',
            'imagen_promocion' => 'required',
            'tipo_promocion' => 'required',
            'descripcion_promocion' => 'required|string|words:1,200'
       	);

     	$validator = Validator::make($data, $rules);
        if ($validator->passes()) {
     		return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

	public static function promotion($promotion_code)
	{
        $query = Promocion::query();
        $query->select('promocion.*', 'detalle_promocion.*');
		$query->join('core.detalle_promocion', 'promocion.codigo_promocion', '=', 'detalle_promocion.codigo_promocion');
		$query->join('core.producto', function($join){
            $join->on('core.detalle_promocion.codigo_producto', '=', 'producto.codigo_producto')
				->where('producto.codigo_institucion', '=', RegistroSesion::getInstitution());
		});
		$query->where('promocion.codigo_promocion', $promotion_code);
		return $query->first();
    }

	public static function promotions(array $filters = [])
	{

		$promotions = [];
		$query = Promocion::query();
		$query->select('promocion.*', 'codigo_detalle_promocion', 'valor_detalle_promocion', 'porcentaje_descuento_promocion', 'producto.codigo_producto', 'nombre_producto', 'url_producto', 'usuario_institucion.codigo_usuario');
		$query->join('core.usuario_institucion', function($join){
			$join->on('promocion.codigo_usuario_institucion', '=', 'usuario_institucion.codigo_usuario_institucion')
				->where('usuario_institucion.codigo_institucion', '=', RegistroSesion::getInstitution());
		});

		$query->leftjoin('core.detalle_promocion', 'promocion.codigo_promocion', '=', 'detalle_promocion.codigo_promocion');

		$query->leftjoin('core.producto', function($join){
			$join->on('core.detalle_promocion.codigo_producto', '=', 'producto.codigo_producto')
				->where('producto.codigo_estado','=' ,Estado::getState('active'))
				->where('producto.codigo_institucion', '=', RegistroSesion::getInstitution());
		});

		if(isset($filters['v']) && $filters['v'] == 'list'){
			$query->where('usuario_institucion.codigo_usuario', '=', Auth::user()->codigo_usuario);
        } else {
			$query->where('promocion.codigo_estado',Estado::getState('active'));
		}

		$query->where(function ($query) {
			$query->where('producto.codigo_estado', '=', Estado::getState('active'))
				  ->orWhere('producto.codigo_estado', '=', NULL);
		});

        if(isset($filters['view']) && !empty($filters['view']) && $filters['view']){
			$query->whereDate('promocion.fecha_fin_promocion', '>=', date("Y-m-d"));
		}

		$total_entries = $query->count();

		// Get posts
		$query->skip($filters['offset'])->take($filters['limit']);

		$query->orderBy('promocion.codigo_promocion', 'asc');
		$data = $query->get();

		if(count($data) > 0) {
			foreach ($data as $promotion) {
				$promotions[] = Promocion::buildPromotion($promotion);
			}
		}

		$response = new \stdClass();
		$response->total_entries = $total_entries;
		$response->items = $promotions;

		return $response;
	}

	public static function buildPromotion($promotion)
	{
		$object = new \stdClass();
		$object->codigo_promocion = TuProyecto::encryptSrcParams([$promotion->codigo_promocion]);
		$object->promotion_code = $promotion->codigo_promocion;
		$object->codigo_estado = $promotion->codigo_estado;
		$object->fecha_inicio_promocion = $promotion->fecha_inicio_promocion;
		$object->fecha_fin_promocion = $promotion->fecha_fin_promocion;
		$object->imagen_promocion = $promotion->imagen_promocion;
		$object->tipo_promocion = $promotion->tipo_promocion;
		$object->descripcion_promocion = $promotion->descripcion_promocion;
		$object->codigo_usuario_institucion = $promotion->codigo_usuario_institucion;
		$object->codigo_usuario = $promotion->codigo_usuario;
		$object->codigo_producto = $promotion->codigo_producto;
		$object->valor_detalle_promocion = $promotion->valor_detalle_promocion;
		$object->porcentaje_descuento_promocion = $promotion->porcentaje_descuento_promocion;
		$object->promo = $promotion->tipo_promocion == self::getTypePromo('promotion') ? true : false;
		$object->nombre_producto = $promotion->nombre_producto;
		$object->url_producto = $promotion->url_producto;
		return $object;
	}
}
