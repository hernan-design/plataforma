<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

use Validator, Input, Auth, DB, Lang, Log;

use TuProyecto;

use App\Estado, App\ClaseProducto, App\TipoPago, App\RegistroSesion, App\Institucion, App\EntregableServicio, App\ActividadServicio;

class Producto extends BaseModel {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.producto';

   	protected $primaryKey = 'codigo_producto';

   	public $timestamps = false;

   	protected $fillable = ['nombre_producto', 'codigo_estado', 'descripcion_producto', 'codigo_categoria_prod_insti', 'precio_producto', 'codigo_iva_producto', 'codigo_clase_producto', 'resumen_producto', 'cantidad_producto', 'imagen_producto', 'domicilio_producto', 'producto_oferta', 'acuerdo_producto', 'modalidad_prestacion_servicio', 'producto_sin_precio'];

	protected $nullable = ['codigo_iva_producto', 'cantidad_producto', 'modalidad_prestacion_servicio'];

	public static $provisionServices = [1 => 'Virtual', 2 => 'Semipresencial', 3 => 'Presencial'];

   	/**
	* Valid create Product.
	*/
   	public function isValid($data)
    {
        $rules = array(
            'nombre_producto' => 'required|max:80',
            'resumen_producto' => 'required|string|words:1,200'
           );

        $messages = [
        	'precio_producto.required' => Lang::get('marketplace.publication.required', ['attribute' => 'precio']),
        	'precio_producto.min' => Lang::get('marketplace.publication.required', ['attribute' => 'precio'])
        ];

         $validator = Validator::make($data, $rules);
         $validator->sometimes('precio_producto', 'required|numeric|min:1', function ($input) {
            return !$input->producto_sin_precio;
        });
        if ($validator->passes()) {
     		return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

   	/**
	* Valid publication product.
	*/
   	public function isValidPublication($data)
    {
        $rules = [
          	'nombre_producto' => 'required|max:80',
            'resumen_producto' => 'required|string|words:1,200',
          	'imagen_producto' => 'required'
       	];

        $messages = [
        	'precio_producto.required' => Lang::get('marketplace.publication.required', ['attribute' => 'precio']),
        	'precio_producto.min' => Lang::get('marketplace.publication.required', ['attribute' => 'precio'])
        ];

        $validator = Validator::make($data, $rules, $messages);
        $validator->sometimes('precio_producto', 'required|numeric|min:1', function ($input) {
            return !$input->producto_sin_precio;
        });

        if ($validator->passes()) {
     		return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

   	/**
	 * SQL used to validate the state of product.
	 *
	 * @var string
	 */
	public static $raw_product = '(CASE
			WHEN (COALESCE(producto.codigo_estado, 0) = 8)  THEN \'published\'
			WHEN (COALESCE(producto.codigo_estado, 0) = 14) THEN \'pending\'
			WHEN (COALESCE(producto.codigo_estado, 0) = 2)  THEN \'review\'
		END)';

	/**
	* SQL used to validate the modality of product.
	*
	* @var string
	*/
	public static $raw_product_modality = '(CASE
			WHEN (COALESCE(producto.modalidad_prestacion_servicio, 0) = 1)  THEN \'Virtual\'
			WHEN (COALESCE(producto.modalidad_prestacion_servicio, 0) = 2) THEN \'Semipresencial\'
			WHEN (COALESCE(producto.modalidad_prestacion_servicio, 0) = 3)  THEN \'Presencial\'
		END)';


   	public static function getProducts()
   	{
   		$products = [];
		$query = Producto::query();
		$query->select('producto.codigo_categoria_prod_insti', 'producto.domicilio_producto', 'producto.codigo_producto', 'nombre_producto', 'acuerdo_producto', 'producto_oferta', 'descripcion_producto', 'url_producto',
		 	DB::raw("COALESCE(imagen_producto, '".config('tuproyecto.no_image')."') as imagen_producto"), 'producto.contador_like', 'precio_producto', 'producto_sin_precio','producto.codigo_clase_producto', 'nombre_categoria_producto','producto.codigo_iva_producto', 'valor_iva_producto', 'nombre_ciudad', 'nombre_pais', 'rol_usuario_institucion', 'usuario.profesion_usuario', 'usuario.nickname_usuario', 'usuario.imagen_usuario', 'resumen_producto','nombre_clase_producto', 'clase_producto.manejo_unidades', 'producto.codigo_usuario',
			(Auth::check() ? DB::raw(sprintf('%s %s', Producto::$raw_product, 'as state_product')) : DB::raw('\'\' as state_product')), DB::raw("(CASE usuario.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN usuario.nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '') ELSE usuario.nombre_usuario END) as nombre_usuario"), 'entity.nombre_usuario as nombre_entidad', 'modalidad_prestacion_servicio', 'usuario.promedio_evaluacion_compra_usuario as avg_purchase_user', DB::raw(sprintf('%s %s', Producto::$raw_product_modality, 'as modalidad_texto')),
			// Favorite
			(Auth::check() ?
			DB::raw('(CASE COALESCE(wishlist_producto.codigo_estado, 0) WHEN '.Estado::getState('active').' THEN true ELSE false END) AS favorito_auth') : DB::raw('false AS favorito_auth')),
			(Auth::check() ? 'codigo_wishlist_producto as codigo_favorito' : DB::raw('null AS codigo_favorito')),
            DB::raw("(CASE WHEN detalle_promocion.codigo_promocion IS NOT NULL THEN detalle_promocion.porcentaje_descuento_promocion / 100 * precio_producto ELSE null END) AS descuento"),
            DB::raw("(CASE WHEN detalle_promocion.codigo_promocion IS NOT NULL THEN detalle_promocion.porcentaje_descuento_promocion ELSE null END) AS porcentaje_descuento"),
			DB::raw("(CASE WHEN detalle_promocion.codigo_promocion IS NOT NULL THEN detalle_promocion.codigo_promocion ELSE null END) AS promotion_code"),
			DB::raw("(CASE WHEN detalle_promocion.codigo_promocion IS NOT NULL THEN (SELECT CURRENT_DATE <= promocion.fecha_fin_promocion FROM core.promocion WHERE detalle_promocion.codigo_promocion = promocion.codigo_promocion) ELSE null END) AS activation_promotion")
		);

    	$query->join('core.clase_producto', 'producto.codigo_clase_producto', '=', 'clase_producto.codigo_clase_producto');
		$query->leftJoin('core.iva_producto', 'producto.codigo_iva_producto', '=', 'iva_producto.codigo_iva_producto');

		// User Product
		$query->join('seguridad.usuario', 'producto.seg_codigo_usuario', '=', 'usuario.codigo_usuario');
		$query->join('core.usuario_institucion as usuario_institucion', function($join) {
			$join->on('usuario_institucion.codigo_usuario', '=', 'usuario.codigo_usuario')
				->where('usuario_institucion.codigo_institucion', '=', RegistroSesion::getInstitution());
        });
		$query->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');

		// Enterprise
		$query->leftJoin('seguridad.usuario as entity', 'producto.seg_codigo_usuario', '=', 'entity.codigo_usuario');

		// City / Country
		$query->leftjoin('core.ciudad', 'usuario.codigo_ciudad', '=', 'ciudad.codigo_ciudad');
		$query->leftjoin('core.pais', 'ciudad.codigo_pais', '=', 'pais.codigo_pais');

        $query->join('core.categoria_producto_insti', function($join) {
            $join->on('producto.codigo_categoria_prod_insti', '=', 'categoria_producto_insti.codigo_categoria_prod_insti')
                ->where('categoria_producto_insti.codigo_institucion', '=', RegistroSesion::getInstitution());
                // ->where('categoria_producto_insti.codigo_estado', '=', Estado::getState('active'));
        });
        $query->join('core.categoria_producto', 'categoria_producto_insti.codigo_categoria_producto', '=', 'categoria_producto.codigo_categoria_producto');

        $query->leftJoin('core.detalle_promocion', function($join){
            $join->on('producto.codigo_producto', '=', 'detalle_promocion.codigo_producto')
                ->where('detalle_promocion.codigo_estado', Estado::getState('active'));
		});

        if(Auth::check()) {
			$query->leftjoin('core.wishlist_producto', function($join) {
				$join->on('wishlist_producto.codigo_producto', '=', 'producto.codigo_producto')
					->where('wishlist_producto.codigo_usuario', '=', Auth::user()->codigo_usuario);
	        });
		}

		$query->where('producto.codigo_institucion', '=', RegistroSesion::getInstitution());
		switch (Input::get('type')) {
		    case 'trending':
     			$query->where('producto.codigo_estado', '=', Estado::getState('active'));
	            $query->where('producto.contador_like', '>', 0);
	        break;

		    case 'user':
		    	list($codigo_usuario) = TuProyecto::decryptSrcParams(Input::get('srcparams-user'));
		        if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
		            abort(403);
		        }

     			$query->where('producto.codigo_usuario', $codigo_usuario);
	     		if(Auth::check()) {
	     			if(Auth::user()->codigo_usuario != $codigo_usuario){
	     				$query->where('producto.codigo_estado', '=', Estado::getState('active'));
	     			}
	     		}
	        break;

	        case 'entity':
		    	// Decrypt src-params
		        list($codigo_usuario) = TuProyecto::decryptSrcParams(Input::get('srcparams-user'));
		        if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
		            abort(403);
		        }

	            $query->where('producto.codigo_usuario',$codigo_usuario);
				if(Auth::check()) {
					if(Auth::user()->codigo_usuario != $codigo_usuario){
           				$query->where('producto.codigo_estado', '=', Estado::getState('active'));
           			}
				}else{
           			$query->where('producto.codigo_estado', '=', Estado::getState('active'));
				}
    		break;

			case 'owner':
				$query->where('producto.codigo_estado', '!=', Estado::getState('removed'));
				$query->where('producto.codigo_usuario', '=', Auth::user()->codigo_usuario);
	        break;

	        case 'favorites':
	        	if(Auth::check()) {
					$query->where('wishlist_producto.codigo_usuario', '=', Auth::user()->codigo_usuario);
					$query->where('wishlist_producto.codigo_estado', '=', Estado::getState('active'));
	        	}
	        break;

		    default:
	    		$query->where(function($query)
	        	{
					$query->where('producto.codigo_estado', '=', Estado::getState('active'));
					if(Auth::check()) {
     					$query->orWhere('producto.codigo_usuario', Auth::user()->codigo_usuario);
					}
				});
			break;
		}

		// Filters
		if(Input::has('provider')) {

            $query->where("usuario.codigo_usuario", '=', Input::get('provider'));
        }

		if(Input::has('name')) {
            $query->whereRaw("producto.nombre_producto ILIKE '%".Input::get('name')."%'");
        }

        if(Input::has('city')){
			$query->where('usuario.codigo_ciudad', Input::get('city'));
		}

		if(Input::has('modality')){
			$query->where('producto.modalidad_prestacion_servicio', Input::get('modality'));
		}

		if(Input::has('price_max')){

			if ( Input::has( 'price_min' ) ) {
				$priceMin = Input::get( 'price_min' );
			}else {
				$priceMin = 0;
			}

			$query->whereBetween('precio_producto',[ $priceMin, Input::get('price_max')]);

		}elseif ( Input::has('price_min') ) {
			$query->where( 'precio_producto', '>=', Input::get('price_min') );
		}

		if(Input::has('category')){
			$query->where('categoria_producto_insti.codigo_categoria_prod_insti', Input::get('category'));
		}

		if(Input::has('class_product')){
			$query->where('producto.codigo_clase_producto', Input::get('class_product'));
		}

		// Institucion
		if(RegistroSesion::institution()->validacion_categorias_marketplace && !in_array(Input::get('type'), ['owner', 'user']) ) {
			$query->whereIn('categoria_producto_insti.codigo_cat_padre_producto', TipoPago::getCategoriasMarketplace());
		}

		// Total entries
		$total_entries = $query->count();
        // Get posts
    	$query->skip(Input::get('offset'))->take(Input::get('limit'));

    	if(Input::has('orderBy')){
	    	switch (Input::get('orderBy')) {
	    		case 'asc':
		            $query->orderBy('usuario.promedio_evaluacion_compra_usuario', Input::get('orderBy'));
		        break;

			    case 'desc':
		            $query->orderBy('usuario.promedio_evaluacion_compra_usuario', Input::get('orderBy'));
		        break;

			    case '>':
			    	$query->orderBy('producto.precio_producto','desc');
		        break;

		        case '<':
			    	$query->orderBy('producto.precio_producto','asc');
		        break;
			}
		}
		//$query->orderBy('producto.codigo_producto','asc');
		$query->inRandomOrder();
		$data = $query->get();

		if(count($data) > 0) {
			foreach ($data as $product) {
				$products[] = Producto::buildProduct($product);
			}
		}

	  	$response = new \stdClass();
		$response->total_entries = $total_entries;
		$response->items = $products;
   		return $response;

   	}

	public static function haveProducts($codigo_usuario)
	{
		$query = Producto::query();
		$query->select();
		// User Product
		$query->join('seguridad.usuario', 'producto.seg_codigo_usuario', '=', 'usuario.codigo_usuario');
		$query->join('core.usuario_institucion as usuario_institucion', function($join) {
			$join->on('usuario_institucion.codigo_usuario', '=', 'usuario.codigo_usuario')
				->where('usuario_institucion.codigo_institucion', '=', RegistroSesion::getInstitution());
		});
		// Enterprise
		$query->leftJoin('seguridad.usuario as entity', 'producto.seg_codigo_usuario', '=', 'entity.codigo_usuario');
	 	$query->where('producto.codigo_institucion', '=', RegistroSesion::getInstitution());
	 	$query->where('producto.codigo_estado', Estado::getState('active'));

		$query->where("usuario.codigo_usuario", '=', $codigo_usuario);
	 	// Total entries
	 	$total_entries = $query->count();
		$total_entries = $total_entries > 0 ? true : false;
		return $total_entries;
	}

	/*
	* Product list all
	*/
	public static function productsList()
	{
		$query = Producto::query();
		$query->select('codigo_producto as id', 'nombre_producto as text');
		$query->join('core.usuario_institucion', function($join) {
			$join->on('usuario_institucion.codigo_usuario', '=', 'producto.codigo_usuario')
				->where('usuario_institucion.codigo_institucion', '=', RegistroSesion::getInstitution());
        });

		$query->where('producto.codigo_usuario', '=', Auth::user()->codigo_usuario);
		$query->where('producto.codigo_institucion', '=', RegistroSesion::getInstitution());

		if(Input::has('q')){
			$query->whereRaw("producto.nombre_producto ILIKE '%".Input::get('q')."%'");
		}

		if(Input::has('dataId')){
			$query->where("producto.codigo_producto", Input::get('dataId'));
		}

		$query->orderBy('nombre_producto', 'asc');
		return $query->limit(50)->get();
	}

	/*
	* Product list all
	*/
	public static function productsByUser()
	{
		$query = Producto::query();
		$query->join('core.usuario_institucion', function($join) {
			$join->on('usuario_institucion.codigo_usuario', '=', 'producto.codigo_usuario')
				->where('usuario_institucion.codigo_institucion', '=', RegistroSesion::getInstitution());
        });

		$query->where('producto.codigo_estado', '=', Estado::getState('active'));
		$query->where('producto.codigo_usuario', '=', Input::get('user'));
		$query->where('producto.codigo_institucion', '=', RegistroSesion::getInstitution());

		$query->orderBy('nombre_producto', 'asc');
		// Total entries
		$total_entries = $query->count();
		// Get posts
		$data = $query->skip(Input::get('offset'))->take(Input::get('limit'))->get();

		if(count($data) > 0) {
			foreach ($data as $product) {
				$products[] = Producto::buildProduct($product);
			}
		}else $products = $data;

		$response = new \stdClass();
		$response->total_entries = $total_entries;
		$response->items = $products;
		
   		return $response;
	}

   	/**
	* Product data detail from url.
	*/
	public static function getProductUrl($product)
	{
		$query = Producto::query();
		$query->select(
			'producto.codigo_categoria_prod_insti',
			'producto.domicilio_producto',
			'producto.codigo_producto',
			'nombre_producto',
			'modalidad_prestacion_servicio',
			'acuerdo_producto',
			'producto_oferta',
			'descripcion_producto',
			'url_producto',
			'categoria_producto.codigo_categoria_producto',
			'nombre_categoria_producto',
			'producto.contador_like',
			'cantidad_producto',
			'producto.codigo_clase_producto',
			'producto.codigo_iva_producto',
			'valor_iva_producto',
			'nombre_ciudad',
			'nombre_pais',
			'rol_usuario_institucion',
			'usuario.profesion_usuario',
			'usuario.nickname_usuario',
			'usuario.imagen_usuario',
			'resumen_producto',
			'nombre_clase_producto',
			'clase_producto.manejo_unidades',
			'producto.codigo_usuario',
			'producto.codigo_estado',
			'entity.nickname_usuario as nickname_entidad',
			'entity.nombre_usuario as nombre_entidad',
			'entity.codigo_usuario as seg_codigo_usuario',
			'usuario.promedio_evaluacion_compra_usuario as avg_purchase_user',
			'usuario.correo_electronico',
			'usuario.telefono_usuario',
			'usuario.movil_usuario',
			'entity.numero_whatsapp',
			DB::raw("COALESCE(imagen_producto, '".config('tuproyecto.no_image')."') as imagen_producto"),
			DB::raw("(CASE entity.tipo_usuario WHEN ".Usuario::typeUser('entity')." THEN entity.tipo_usuario ELSE usuario.tipo_usuario END) as tipo_usuario"),
			DB::raw("(CASE usuario.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN usuario.nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '') ELSE usuario.nombre_usuario END) as nombre_usuario"), 'precio_producto','producto_sin_precio',
			(Auth::check() ? DB::raw(sprintf('%s %s', Producto::$raw_product, 'as state_product')) : DB::raw('\'\' as state_product')), DB::raw(sprintf('%s %s', Producto::$raw_product_modality, 'as modalidad_texto')),
			// Favorite
			(Auth::check() ?
			DB::raw('(CASE COALESCE(wishlist_producto.codigo_estado, 0) WHEN '.Estado::getState('active').' THEN true ELSE false END) AS favorito_auth') : DB::raw('false AS favorito_auth')),
            (Auth::check() ? 'codigo_wishlist_producto as codigo_favorito' : DB::raw('null AS codigo_favorito')),
            DB::raw("(CASE WHEN detalle_promocion.codigo_promocion IS NOT NULL THEN detalle_promocion.porcentaje_descuento_promocion / 100 * precio_producto ELSE null END) AS descuento"),
			DB::raw("(CASE WHEN detalle_promocion.codigo_promocion IS NOT NULL THEN detalle_promocion.porcentaje_descuento_promocion ELSE null END) AS porcentaje_descuento"),
			DB::raw("(CASE WHEN detalle_promocion.codigo_promocion IS NOT NULL THEN (SELECT CURRENT_DATE <= promocion.fecha_fin_promocion FROM core.promocion WHERE detalle_promocion.codigo_promocion = promocion.codigo_promocion) ELSE null END) AS activation_promotion")
		);

		// Enterprise
		$query->leftJoin('seguridad.usuario as entity', 'producto.seg_codigo_usuario', '=', 'entity.codigo_usuario');

		$query->join('core.clase_producto', 'producto.codigo_clase_producto', '=', 'clase_producto.codigo_clase_producto');
    	$query->leftJoin('core.iva_producto', 'producto.codigo_iva_producto', '=', 'iva_producto.codigo_iva_producto');

    	$query->join('core.usuario_institucion', function($join) {
			$join->on('usuario_institucion.codigo_usuario', '=', 'producto.codigo_usuario')
				->where('usuario_institucion.codigo_institucion', '=', RegistroSesion::getInstitution());
        });
		$query->join('param.institucion', 'usuario_institucion.codigo_institucion', '=', 'institucion.codigo_institucion');

        $query->join('core.categoria_producto_insti', function($join) {
            $join->on('producto.codigo_categoria_prod_insti', '=', 'categoria_producto_insti.codigo_categoria_prod_insti')
                ->on('categoria_producto_insti.codigo_institucion', '=', 'institucion.codigo_institucion')
                ->where('categoria_producto_insti.codigo_estado', '=', Estado::getState('active'));
        });
        $query->join('core.categoria_producto', 'categoria_producto_insti.codigo_categoria_producto', '=', 'categoria_producto.codigo_categoria_producto');

    	// User Product
		$query->join('seguridad.usuario', 'producto.codigo_usuario', '=', 'usuario.codigo_usuario');
		$query->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');

		// City / Country
		$query->leftjoin('core.ciudad', 'usuario.codigo_ciudad', '=', 'ciudad.codigo_ciudad');
        $query->leftjoin('core.pais', 'ciudad.codigo_pais', '=', 'pais.codigo_pais');

        $query->leftJoin('core.detalle_promocion', function($join){
            $join->on('producto.codigo_producto', '=', 'detalle_promocion.codigo_producto')
                ->where('detalle_promocion.codigo_estado', Estado::getState('active'));
        });

		if(Auth::check()) {
			$query->leftjoin('core.wishlist_producto', function($join) {
				$join->on('wishlist_producto.codigo_producto', '=', 'producto.codigo_producto')
					->where('wishlist_producto.codigo_usuario', '=', Auth::user()->codigo_usuario);
	        });
		}

		// Institucion
		if(RegistroSesion::institution()->validacion_categorias_marketplace) {
			$query->where(function ($query) {
                $query->whereIn('categoria_producto_insti.codigo_cat_padre_producto', TipoPago::getCategoriasMarketplace());
                if(Auth::check()) {
	                $query->orWhere('producto.codigo_usuario', Auth::user()->codigo_usuario);
        		}
            });
		}

		$query->where('producto.codigo_institucion', '=', RegistroSesion::getInstitution());
		$query->whereRaw("trim(lower(url_producto)) = trim(lower('$product'))");
		return $query->first();
	}



	/**
	 * Build Producto.
	*/
   	public static function buildProduct($product)
   	{
		$object = new \stdClass();
		$object->codigo_producto = TuProyecto::encryptSrcParams([$product->codigo_producto]);
		$object->imagen_producto = $product->imagen_producto;
		$object->id_producto = $product->codigo_producto;
		$object->validacion_categorias_marketplace = $product->validacion_categorias_marketplace;

		$object->nombre_producto = $product->nombre_producto;
		$object->descripcion_producto =  $product->descripcion_producto;
		$object->contador_like =  $product->contador_like;
        $object->url_producto = $product->url_producto;
        $precio_producto = $product->producto_sin_precio ? 0 : doubleval($product->precio_producto);
        $object->precio_producto =  $precio_producto;
        $object->producto_sin_precio = $product->producto_sin_precio;
		$object->cantidad_producto = $product->cantidad_producto?:0;
		$object->manejo_unidades = $product->manejo_unidades;
		$object->codigo_favorito = $product->codigo_favorito;
		$object->favorito_auth = $product->favorito_auth;
		$object->avg_purchase_user = $product->avg_purchase_user;
		$object->modalidad_prestacion_servicio = $product->modalidad_prestacion_servicio;
		$object->modalidad_texto = $product->modalidad_texto;
		$object->tipo_usuario = $product->tipo_usuario;

		$object->nombre_categoria_producto= $product->nombre_categoria_producto;
		$object->valor_iva_producto= $product->valor_iva_producto;

		$object->codigo_categoria_prod_insti = $product->codigo_categoria_prod_insti;
		$object->codigo_iva_producto = $product->codigo_iva_producto;
		$object->state_product = $product->state_product;
		$object->resumen_producto = $product->resumen_producto;
		$object->nombre_clase_producto = $product->nombre_clase_producto;
		$object->codigo_clase_producto = $product->codigo_clase_producto;
		$object->codigo_estado = $product->codigo_estado;
		$object->domicilio_producto = $product->domicilio_producto;
		$object->acuerdo_producto = $product->acuerdo_producto;
        $object->producto_oferta = $product->producto_oferta;
        $descuento = !is_null($product->descuento) ? doubleval($precio_producto - $product->descuento) : $product->descuento;
		$object->descuento = ($descuento > 0) ? $descuento : null;
		$object->porcentaje_descuento = $product->porcentaje_descuento;
		$object->promotion_code = $product->promotion_code;
		$object->activacion_promocion = $product->activation_promotion;

		// Data user seller
		$object->nombre_usuario = $product->nombre_usuario;
		$object->imagen_usuario = $product->imagen_usuario;
		$object->nickname_usuario = $product->nickname_usuario;
		$object->profesion_usuario = $product->profesion_usuario;
		$object->nombre_ciudad = $product->nombre_ciudad;
		$object->nombre_pais = $product->nombre_pais;
		$object->rol_usuario_institucion = $product->rol_usuario_institucion;
		$object->nickname_entidad = $product->nickname_entidad;
		$object->nombre_entidad = $product->nombre_entidad;
		$object->seg_codigo_usuario = $product->seg_codigo_usuario;
		$object->url_profile = $product->usuario->getProfileUrl();
		$object->owner = (Auth::check() && Auth::user()->codigo_usuario == $product->codigo_usuario) ? true : false;
		$object->restriction_edit = RegistroSesion::institution()->restriccion_edicion_marketplace;
		$object->numero_whatsapp = $product->numero_whatsapp;
        $object->visibility_info_provider = RegistroSesion::institution()->visibilidad_info_vendedor;
        if($object->visibility_info_provider){
            $object->movil_usuario = $product->movil_usuario;
            $object->telefono_usuario = $product->telefono_usuario;
            $object->correo_electronico = $product->correo_electronico;
        }

        // marketplace recommendation
        $object->recomendaciones = Institucion::find(RegistroSesion::getInstitution())->marketplaceRecommendation()->get();

		// Secure srcparams
		$object->srcparams = TuProyecto::encryptSrcParams([$product->codigo_producto, Recurso::getResource('producto.gestion')]);
		return $object;
   	}

   	/**
	* Product data validate from url.
	*/
	public static function validateUrl($url_product, $contador = 0)
	{
		$newurl = $contador > 0 ? sprintf("%s-%d", $url_product, $contador) : $url_product;
		$query = Producto::query();
		$query->select('producto.*');
		$query->whereRaw(("trim(lower(url_producto)) = trim(lower('$newurl'))"));
		$entity = $query->first();

		$contador ++;
		if($entity instanceof Producto){
			$newurl = Producto::validateUrl($url_product, $contador);
		}
		return $newurl;
    }

    public static function getActivityServicesArray($product)
    {
        $query = ActividadServicio::query();
        $query->select('descripcion_actividad_servicio as desc_actividad_acuerdo', 'responsable_actividad',
        'sesiones_presenciales_actividad as sesiones_presencial',
        'horas_sesiones_presen_actividad as sesiones_presencial_horas',
        'sesiones_virtuales_actividad as sesiones_virtual',
        'horas_sesiones_virtua_actividad as sesiones_virtual_horas',
        DB::raw('(CASE WHEN actividad_servicio.responsable_actividad = 1 THEN 1 ELSE 0 END) AS resp_proveedor_actividad'),
        DB::raw('(CASE WHEN actividad_servicio.responsable_actividad = 2 THEN 1 ELSE 0 END) AS resp_comprador_actividad'),
        'codigo_estado', 'codigo_producto', 'codigo_actividad_servicio');
        $query->where('actividad_servicio.codigo_producto', '=', $product->codigo_producto);
        $query->where('actividad_servicio.codigo_estado', '=', Estado::getState('active'));
        $query->orderby('codigo_actividad_servicio','asc');

        return $query->get()->toArray();
    }

    public static function getDeliverableServicesArray($product)
    {
        $query = EntregableServicio::query();
        $query->select('descripcion_entregable_servicio as descripcion_entregable', 'codigo_estado', 'codigo_producto', 'codigo_entregable_servicio');
        $query->where('entregable_servicio.codigo_producto', '=', $product->codigo_producto);
        $query->where('entregable_servicio.codigo_estado', '=', Estado::getState('active'));
        $query->orderby('codigo_entregable_servicio','asc');

        return $query->get()->toArray();
    }

   	/**
	 * Defining Relations
	*/
	public function usuario()
    {
        return $this->hasOne('App\Usuario','codigo_usuario','codigo_usuario');
    }

    public function activityServices()
    {
        return $this->hasMany('App\ActividadServicio','codigo_producto','codigo_producto');
    }


    public function deliverableServices()
    {
        return $this->hasMany('App\EntregableServicio','codigo_producto','codigo_producto');
    }
}
