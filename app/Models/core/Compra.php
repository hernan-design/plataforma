<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Validator, TuProyecto, DB, Lang, Input, Auth, Config, SendEmail, URL, Log;

use  App\{CategoriaProductoInstitucion, ConsumoVoucher,
	Institucion,
	DetalleVoucher,
	RecomProductoEval,
	RegistroFaseUsuario};

use \App\Custom\Rutan;

use Custom\Innpulsa;


class Compra extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.compra';

	protected $primaryKey = 'codigo_compra';

	public $timestamps = false;

	/**
	* Valid create purchase.
	*/
   	public function isValid($data)
    {
        $rules = [
        	'codigo_producto' => 'required',
            'unidades' => 'integer',
            'valor_total_compra' => 'smaller_price:'.$data['precio_producto']
        ];
        $message = [
            'valor_total_compra.smaller_price' => trans('validation.smaller', [
                'value' => $data['valor_total_compra'],
                'comparator' => $data['precio_producto']
            ])
        ];

         $validator = Validator::make($data, $rules, $message);

        if ($validator->passes()) {
     		return true;
        }

        $this->errors = $validator->errors();
        return false;
    }

    /**
	 * Domain 1 Vendedor, 2 comprador.
	 *
	 * @var string $type
	 */
    public static function getTypeUser($type) {
        switch ($type):
            case 'seller': return 1;
            case 'purchaser': return 2;
            default: return 'Not type identified';
        endswitch;
    }

    /**
	 * Domain 1 Compra, 2 Oferta.
	 *
	 * @var string $type
	 */
    public static function getTypePurchase($type) {
        switch ($type):
            case 'compra': return 1;
            case 'oferta': return 2;
            default: return 'Not type identified';
        endswitch;
    }

    /**
	 * SQL used to validate the state of purchase.
	 *
	 * @var string
	 */
	public static $raw_purchase = '(CASE
			WHEN (COALESCE(compra.codigo_estado, 0) = 3)  THEN \'cancelled\'
			WHEN (COALESCE(compra.codigo_estado, 0) = 6)  THEN \'confirm\'
			WHEN (COALESCE(compra.codigo_estado, 0) = 7) THEN \'confirmed\'
			WHEN (COALESCE(compra.codigo_estado, 0) = 13) THEN \'removed\'
			WHEN (COALESCE(compra.codigo_estado, 0) = 14)  THEN \'pending\'
			WHEN (COALESCE(compra.codigo_estado, 0) = 22)  THEN \'offered\'
			WHEN (COALESCE(compra.codigo_estado, 0) = 25)  THEN \'rejected\'
			WHEN (COALESCE(compra.codigo_estado, 0) = 29)  THEN \'finalized\'
		END)';

    public static function getProductsUser($typeuser)
   	{

   		$buys = [];
		$query = Compra::query();
		$query->select('usuario.codigo_usuario', 'compra.codigo_compra', 'compra.valor_total_compra', 'compra.valor_total_iva',
					    'compra.fecha_compra', 'compra.hora_compra', 'compra.codigo_estado', 'usuario.imagen_usuario',
						'usuario.nickname_usuario', DB::raw("(CASE usuario.tipo_usuario WHEN ".Usuario::typeUser('person')."
						THEN usuario.nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' ||
						COALESCE(persona.segundo_apellido_persona, '') ELSE usuario.nombre_usuario END) as nombre_usuario"),
						'usuario.telefono_usuario', 'usuario.movil_usuario', 'usuario.correo_electronico', 'acuerdo_producto',
						'nombre_ciudad','nombre_pais', 'url_producto', 'imagen_producto', 'nombre_producto','precio_producto',
						'producto.producto_sin_precio', 'compra.codigo_tipo_pago', 'nombre_tipo_pago','nombre_tipo_envio',
						'compra.unidad_producto','resumen_producto', DB::raw('(CASE WHEN codigo_evaluacion_compra IS NULL
						THEN false ELSE true END) as evaluation_purchase'),  'entity.nombre_usuario as nombre_entidad',
						'entity.nickname_usuario as nickname_entidad', 'entity.imagen_usuario as imagen_entidad',
						'clase_emprendimiento.nombre_clase_emprendimiento',
						(Auth::check() ? DB::raw(sprintf('%s %s', Compra::$raw_purchase, 'as state_purchase')) : DB::raw('\'\' as state_purchase')),
			 		    'codigo_acuerdo_compra', DB::raw('(CASE WHEN acuerdo_compra.codigo_acuerdo_compra IS NOT NULL
						THEN true ELSE false END) as acuerdo_compra'), 'acuerdo_compra.codigo_estado as codigo_estado_acuerdo',
						'clase_emprendimiento_insti.nombre_clase_empren_insti');

		$query->join('core.estado', 'compra.codigo_estado', '=', 'estado.codigo_estado');
		$query->join('core.producto', 'compra.codigo_producto', '=', 'producto.codigo_producto');

		$query->leftJoin('core.tipo_pago', 'compra.codigo_tipo_pago', '=', 'tipo_pago.codigo_tipo_pago');
		$query->leftJoin('core.tipo_envio', 'compra.codigo_tipo_envio', '=', 'tipo_envio.codigo_tipo_envio');
		$query->leftJoin('core.acuerdo_compra', 'compra.codigo_compra', '=', 'acuerdo_compra.codigo_compra');

		switch ($typeuser) {
		    case Compra::getTypeUser('seller'):
				$query->join('core.usuario_institucion', function($join) {
					$join->on('usuario_institucion.codigo_usuario', '=', 'compra.seg_codigo_usuario')
						->where('usuario_institucion.codigo_institucion', '=', RegistroSesion::getInstitution());
		        });

	   			$query->leftJoin('core.evaluacion_compra', function($join) {
		       		$join->on('compra.codigo_compra', '=', 'evaluacion_compra.codigo_compra')
						->where('evaluacion_compra.tipo_evaluacion_compra', '=', Compra::getTypeUser('purchaser'));
				});

     			$query->join('seguridad.usuario', 'compra.codigo_usuario', '=', 'usuario.codigo_usuario');
				$query->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');

				$query->where('compra.seg_codigo_usuario', Auth::user()->codigo_usuario);
				$query->whereIn('compra.codigo_estado', [Estado::getState('finalized'), Estado::getState('confirm'), Estado::getState('confirmed'), Estado::getState('cancelled'), Estado::getState('offer'), Estado::getState('pending')]);
	    	break;

		    case Compra::getTypeUser('purchaser'):
			    $query->join('core.usuario_institucion', function($join) {
					$join->on('usuario_institucion.codigo_usuario', '=', 'compra.codigo_usuario')
						->where('usuario_institucion.codigo_institucion', '=', RegistroSesion::getInstitution());
		        });

			    $query->leftJoin('core.evaluacion_compra', function($join) {
		       		$join->on('compra.codigo_compra', '=', 'evaluacion_compra.codigo_compra')
						->where('evaluacion_compra.tipo_evaluacion_compra', '=', Compra::getTypeUser('seller'));
				});

     			$query->join('seguridad.usuario', 'compra.seg_codigo_usuario', '=', 'usuario.codigo_usuario');
				$query->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');

			    $query->where('compra.codigo_usuario', Auth::user()->codigo_usuario);

				$query->where(function($query)
	        	{
					$query->whereNotIn('compra.codigo_estado', [Estado::getState('rejected'), Estado::getState('removed')]);
					$query->orWhere(function($query)
	        		{
						$query->where('compra.codigo_estado', Estado::getState('removed'));
						$query->whereNull('codigo_evaluacion_compra');
					});
				});

	    	break;
		}

		$query->join('param.institucion', 'usuario_institucion.codigo_institucion', '=', 'institucion.codigo_institucion');
		$query->leftJoin('seguridad.usuario as entity', 'producto.seg_codigo_usuario', '=', 'entity.codigo_usuario');
		$query->leftJoin('core.entidad', 'entity.codigo_usuario', '=', 'entidad.codigo_usuario');

		$query->leftJoin('core.clase_emprendimiento_insti', function($join) {
            $join->on('entidad.codigo_clase_empre_insti', '=', 'clase_emprendimiento_insti.codigo_clase_empre_insti')
                ->where('clase_emprendimiento_insti.codigo_institucion', '=',RegistroSesion::getInstitution())
                ->where('clase_emprendimiento_insti.codigo_estado', '=', Estado::getState('active'));
        });

        $query->leftJoin('core.clase_emprendimiento', 'clase_emprendimiento_insti.codigo_clase_emprendimiento', '=', 'clase_emprendimiento.codigo_clase_emprendimiento');
		$query->leftjoin('core.ciudad', 'usuario.codigo_ciudad', '=', 'ciudad.codigo_ciudad');
		$query->leftjoin('core.pais', 'ciudad.codigo_pais', '=', 'pais.codigo_pais');

		$query->where('core.compra.codigo_institucion', '=', RegistroSesion::getInstitution());

   		$query->orderBy('compra.fecha_compra','desc');
   		$query->orderBy('compra.hora_compra','desc');

		// Get total posts
		$total_entries = $query->get()->count();

		// Get posts
		$data = $query->skip(Input::get('offset'))->take(Input::get('limit'))->get();

		if(count($data) > 0) {
			foreach ($data as $buy) {
				$buys[] = Compra::buildProductUser($buy);
			}
		}

		$response = new \stdClass();
		$response->total_entries = $total_entries;
		$response->items = $buys;
   		return $response;
       }



    public static function getFixedDeliverableList($producto)
   	{
   		$query = EntregableServicio::query();
		$query->select('descripcion_entregable_servicio', 'codigo_estado', 'codigo_entregable_servicio','codigo_producto');

        $query->where('entregable_servicio.codigo_producto', '=', $producto);
        $query->where('entregable_servicio.codigo_estado', '=', Estado::getState('active'));
   		$query->orderby('codigo_entregable_servicio','asc');
   		return $query->get()->toArray();
    }

   	/**
	* Purchase data detail from id.
	*/
	public static function getPurchase($purchase)
	{

		$query = Compra::query();
		$query->select('compra.codigo_usuario', 'compra.seg_codigo_usuario', 'compra.codigo_compra', 'compra.valor_total_compra', 'compra.valor_total_iva', 'compra.fecha_compra', 'compra.hora_compra', 'compra.codigo_estado', 'imagen_producto', 'nombre_producto', 'unidad_producto', 'resumen_producto', 'entidad.codigo_usuario as codigo_usuario_entidad', 'producto.producto_sin_precio','producto.codigo_producto', 'acuerdo_producto',
			(Auth::check() ? DB::raw(sprintf('%s %s', Compra::$raw_purchase, 'as state_purchase')) : DB::raw('\'\' as state_purchase')), 'codigo_acuerdo_compra', DB::raw('(CASE WHEN acuerdo_compra.codigo_acuerdo_compra IS NOT NULL THEN true ELSE false END) as acuerdo_compra'), 'acuerdo_compra.codigo_estado as codigo_estado_acuerdo', 'acuerdo_compra.codigo_adjunto',
			DB::raw('(CASE WHEN pepurchaser.codigo_evaluacion_compra IS NULL THEN false ELSE true END) as evaluation_purchase_purchaser'),
			DB::raw('(CASE WHEN peseller.codigo_evaluacion_compra IS NULL THEN false ELSE true END) as evaluation_purchase_seller'));

		$query->join('core.producto', 'compra.codigo_producto', '=', 'producto.codigo_producto');
		$query->leftJoin('core.acuerdo_compra', 'compra.codigo_compra', '=', 'acuerdo_compra.codigo_compra');

		$query->join('core.usuario_institucion', function($join) {
			$join->on('usuario_institucion.codigo_usuario', '=', 'compra.codigo_usuario')
				->where('usuario_institucion.codigo_institucion', '=', RegistroSesion::getInstitution());
        });

		$query->join('param.institucion', 'usuario_institucion.codigo_institucion', '=', 'institucion.codigo_institucion');
		$query->leftJoin('seguridad.usuario as entity', 'producto.seg_codigo_usuario', '=', 'entity.codigo_usuario');
		$query->leftJoin('core.entidad', 'entity.codigo_usuario', '=', 'entidad.codigo_usuario');

		$query->leftJoin('core.evaluacion_compra as peseller', function($join) {
			$join->on('compra.codigo_compra', '=', 'peseller.codigo_compra')
			->where('peseller.tipo_evaluacion_compra', '=', Compra::getTypeUser('seller'));
		});

		$query->leftJoin('core.evaluacion_compra as pepurchaser', function($join) {
			$join->on('compra.codigo_compra', '=', 'pepurchaser.codigo_compra')
			->where('pepurchaser.tipo_evaluacion_compra', '=', Compra::getTypeUser('purchaser'));
		});

		$query->where('compra.codigo_compra', '=', $purchase);
   		$query->orderBy('compra.fecha_compra','asc');
   		$query->orderBy('compra.hora_compra','asc');
		return $query->first();
	}


	/**
	* valid consume vouchers.
	*/
	public function consumeVoucher($balanceInitial = 0)
	{
		$query = DetalleVoucher::query();
		$query->select('codigo_detalle_voucher','saldo_detalle_voucher');
		$query->where('detalle_voucher.codigo_usuario', '=', Auth::user()->codigo_usuario);
		$query->where('detalle_voucher.saldo_detalle_voucher', '>', 0);
		$query->orderBy('detalle_voucher.codigo_detalle_voucher', 'asc');
        $balanceuser = $query->first();

		if($balanceuser instanceof DetalleVoucher) {
			if($balanceInitial <= $this->attributes['valor_total_compra']){
	       		$balanceInitial += $balanceuser->saldo_detalle_voucher;
				if($balanceInitial < $this->attributes['valor_total_compra']){
					$balance = 0;
				}else{
					$balance = $balanceInitial - $this->attributes['valor_total_compra'];
				}

				$balanceconsumption = $balanceuser->saldo_detalle_voucher - $balance ;

	    		// Set balance
	            DetalleVoucher::where('codigo_detalle_voucher', '=', $balanceuser->codigo_detalle_voucher)->update(['saldo_detalle_voucher' => $balance]);

	            $consumeVoucher = new ConsumoVoucher();
	        	$consumeVoucher->codigo_compra = $this->attributes['codigo_compra'];
	            $consumeVoucher->codigo_estado = Estado::getState('active');
	            $consumeVoucher->codigo_detalle_voucher = $balanceuser->codigo_detalle_voucher;
	            $consumeVoucher->valor_consumo_voucher = $balanceconsumption;
	            $consumeVoucher->fecha_consumo_voucher = date('Y-m-d H:m:s');
	            $consumeVoucher->save();

	        	$balanceInitial = Compra::consumeVoucher($balanceInitial);
	        }
        }
        return $balanceInitial;
    }

	/**
	 * consumo de tokens del voucher asignado, Rutan
	 */
	public function consumeVoucherRutan(): void
	{
		$mentoria = $this->getMentoriaConvocatory($this->attributes['codigo_compra'],$this->attributes['codigo_producto']);

		$query = DetalleVoucher::query();
		$query->select();
		$query->where('detalle_voucher.codigo_usuario', '=', Auth::user()->codigo_usuario);
		$query->where('detalle_voucher.saldo_detalle_voucher', '>', 0);
		$query->where('codigo_estado',  Estado::getState('active'));
		$query->where('codigo_registro_fase_usuario',  $mentoria->codigo_registro_fase_usuario);
        $balanceuser = $query->first();
		//dd($mentoria, $this->attributes);
		if($balanceuser instanceof DetalleVoucher) {

			$valor_consumo_voucher = $balanceuser->saldo_detalle_voucher - $this->attributes['valor_total_compra'] ;

			// Set balance
			DetalleVoucher::where('codigo_detalle_voucher', '=', $balanceuser->codigo_detalle_voucher)
							->update(['saldo_detalle_voucher' => $valor_consumo_voucher]);

			//eliminar token gastado
			RecomProductoEval::where('codigo_mentoria', '=', $mentoria->codigo_mentoria)
							->where('codigo_registro_fase_usuario', '=', $balanceuser->codigo_registro_fase_usuario)
							->where('codigo_categoria_producto', '=', $mentoria->codigo_categoria_producto)
							->where('codigo_estado', '=', Estado::getState('active'))
							->delete();


			$consumeVoucher = new ConsumoVoucher();
			$consumeVoucher->codigo_compra = $this->attributes['codigo_compra'];
			$consumeVoucher->codigo_estado = Estado::getState('active');
			$consumeVoucher->codigo_detalle_voucher = $balanceuser->codigo_detalle_voucher;
			$consumeVoucher->valor_consumo_voucher = $valor_consumo_voucher;
			$consumeVoucher->fecha_consumo_voucher = date('Y-m-d H:m:s');
			$consumeVoucher->save();

        } else {
			throw new \Exception("No tiene voucher asignado");
		}
    }

	private function getMentoriaConvocatory(int $codigo_compra, int $codigo_producto)
    {
        $query = RegistroFaseUsuario::query();
        $query->select('mentoria.*', 'registro_fase_usuario.*', 'rpe.*');
        $query->join('core.fase', 'fase.codigo_fase', 'registro_fase_usuario.codigo_fase');
        $query->join('core.entidad', 'entidad.codigo_usuario', '=', 'registro_fase_usuario.codigo_usuario');
        $query->join('core.recom_producto_eval as rpe', function($join) {
            $join->on('rpe.codigo_registro_fase_usuario', '=', 'registro_fase_usuario.codigo_registro_fase_usuario')
                ->where('rpe.codigo_estado', '=', 8);
        });
        $query->join('core.categoria_producto_insti as cpi', function ($join) {
            $join->on('cpi.codigo_categoria_producto', '=', 'rpe.codigo_categoria_producto')
                ->where('cpi.codigo_institucion', '=', 61)
                ->where('cpi.codigo_estado', '=', 8);
        });
        $query->join('core.convocatoria_mentoria as cm', 'cm.codigo_fase', '=', 'fase.codigo_fase');

        $query->join('aprende.mentoria', function ($join) {
            $join->on('mentoria.codigo_mentoria', '=', 'rpe.codigo_mentoria')
                ->where('mentoria.codigo_asesoria', '=', DB::raw('cm.codigo_asesoria::INTEGER'));
        });
        $query->join('core.compra', 'compra.codigo_usuario', '=', 'entidad.seg_codigo_usuario');
		$query->join('core.producto', 'producto.codigo_categoria_prod_insti', '=', 'cpi.codigo_categoria_prod_insti');
        $query->where('compra.codigo_compra', '=', $codigo_compra);
        $query->where('producto.codigo_producto', '=', $codigo_producto);

        return $query = $query->first();
    }

   	/**
	* Build  Buys User.
	*/
   	public static function buildProductUser($purchase)
   	{

		$object = new \stdClass();
		$object->codigo_compra = TuProyecto::encryptSrcParams([$purchase->codigo_compra]);
		$object->codigo_acuerdo_compra = TuProyecto::encryptSrcParams([$purchase->codigo_acuerdo_compra]);
		$object->acuerdo_compra = $purchase->acuerdo_compra;
		$object->codigo_adjunto = $purchase->codigo_adjunto;
		$object->id = $purchase->codigo_compra;
		$object->valor_total_compra = $purchase->valor_total_compra;
		$object->valor_total_iva = $purchase->valor_total_iva;
		$object->fecha_compra = $purchase->fecha_compra;
		$object->hora_compra = $purchase->hora_compra;
		$object->codigo_tipo_pago = $purchase->codigo_tipo_pago;
		$object->nombre_tipo_pago = $purchase->nombre_tipo_pago;
		$object->nombre_tipo_envio = $purchase->nombre_tipo_envio;
		$object->state_purchase = $purchase->state_purchase;
		$object->state_agreement = $purchase->codigo_estado_acuerdo;

		$object->url_producto = $purchase->url_producto;
		$object->unidad_producto = $purchase->unidad_producto;
		$object->resumen_producto = $purchase->resumen_producto;
		$object->nombre_producto = $purchase->nombre_producto;
        $object->precio_producto = $purchase->precio_producto;
        $object->producto_sin_precio = $purchase->producto_sin_precio;
		$object->acuerdo_producto = $purchase->acuerdo_producto;

		$object->nickname_usuario = $purchase->nickname_usuario;
		$object->nombre_usuario = $purchase->nombre_usuario;
		$object->imagen_usuario = $purchase->imagen_usuario;
		$object->telefono_usuario = $purchase->telefono_usuario;
		$object->movil_usuario = $purchase->movil_usuario;
		$object->correo_electronico = $purchase->correo_electronico;
		$object->nombre_ciudad = $purchase->nombre_ciudad;
		$object->nombre_pais = $purchase->nombre_pais;
		$object->codigo_usuario = $purchase->codigo_usuario ? TuProyecto::encryptSrcParams([$purchase->codigo_usuario]) : '';
		$object->codigo_usuario_entidad = $purchase->codigo_usuario_entidad ? TuProyecto::encryptSrcParams([$purchase->codigo_usuario_entidad]) : '';
		$object->purchaser = $purchase->codigo_usuario == Auth::user()->codigo_usuario ? true : false ;
		$object->seller = $purchase->seg_codigo_usuario == Auth::user()->codigo_usuario ? true : false ;
		$object->evaluation_purchase_seller = $purchase->evaluation_purchase_seller;
		$object->evaluation_purchase_purchaser = $purchase->evaluation_purchase_purchaser;

		$object->imagen_producto = $purchase->imagen_producto;
		$object->evaluation_purchase = $purchase->evaluation_purchase;
		$object->url_profile = $purchase->purchaser->getProfileUrl();
		$object->nombre_entidad = $purchase->nombre_entidad;
		$object->nickname_entidad = $purchase->nickname_entidad;
		$object->imagen_entidad = $purchase->imagen_entidad;
        $object->nombre_clase_emprendimiento = $purchase->nombre_clase_emprendimiento;
        $object->nombre_clase_empren_insti = $purchase->nombre_clase_empren_insti;
        $object->entregables_servicio = [];
        $object->actividades_servicio = [];

		if(empty($purchase->codigo_usuario_entidad)){
			$object->asesor_acuerdo = [
				'nombre_usuario_acuerdo' => Auth::user()->nombre_usuario,
				'cargo_usuario_acuerdo' => 'Miembro equipo de trabajo',
				'correo_usuario_acuerdo' => Auth::user()->correo_electronico
			];
        }


		if(!empty($purchase->codigo_producto)){

            $product = Producto::find($purchase->codigo_producto);

            if($product instanceof Producto) {
                $object->entregables_servicio = Producto::getDeliverableServicesArray($product);
                $object->actividades_servicio = Producto::getActivityServicesArray($product);
                $object->alcance_servicio = $product->alcance_servicio;
                $object->resultados_servicio = $product->resultados_servicio;
                $object->producto_sin_precio = $product->producto_sin_precio;
            }
		}

		return $object;
   	}

   	/**
	 * Defining Relations
	*/

	public function purchaser()
    {
        return $this->hasOne('App\Usuario','codigo_usuario','codigo_usuario');
    }

    public function seller()
    {
        return $this->hasOne('App\Usuario','codigo_usuario','seg_codigo_usuario');
    }

    public function consumedVoucher()
    {
        return $this->hasOne('App\ConsumoVoucher','codigo_compra','codigo_consumo_voucher');
    }

    /**
     *  Prepare and send the notification email after a succesful purchase
	 * @Annotation El parametro $product hace referencia al modelo Producto
     * @param  App\TipoPago|false  $payment
     * @param  App\TipoEnvio|false  $shipping
	 * @param  object $product
	 * @return true|Response
     */
    public function sendEmailPurchase( $payment, $shipping, $product)
    {
        $product = Producto::find($this->codigo_producto);
        if(!$product instanceof Producto) {
            abort(404);
        }

        $seller = Usuario::find($product->codigo_usuario);
        if(!$seller instanceof Usuario){
            abort(404);
        }


        $purchaser = Usuario::find(Auth::user()->codigo_usuario);
        if(!$purchaser instanceof Usuario){
            abort(404);
        }

        if($payment)
        {
            if(!$payment instanceof TipoPago) {
                abort(404);
            }
        }

        if($shipping)
        {
            if(!$shipping instanceof TipoEnvio) {
                abort(404);
            }
        }

		$data_seller = [];
		$data_purchaser = [];

		//Parametrización por institución
		switch (RegistroSesion::getInstitution()) {
			case Institucion::getInstitution('innpulsa'):
                $proyectEntity = Innpulsa::getProyectEntity($this);
                if(!$purchaser instanceof Usuario){
                    abort(404);
                }
				//Datos adjuntos en correo del vendedor.
				$data_seller['_template'] = 'emails.purchase.notificationsale';
                $data_seller['_name_entity_user_action'] = $proyectEntity->nombre_usuario ?? '';
				//Datos adjuntos en correo del comprador.
                $data_purchaser['_name_entity_user_action'] = '';
				$data_purchaser['_template'] = 'emails.purchase.notificationPurchaser';
			break;
			case Institucion::getInstitution('rutan'):
				$proyec_entity = Rutan::getProyectEntity($this);
                if(!$purchaser instanceof Usuario){
                    abort(404);
                }
				//Valdiación si la entidad es tipo empresa.
				if ( $proyec_entity->type_entity == 61 ) {
					$data_seller['_identify_entity'] = $proyec_entity->identify_entity;
				}
				//Datos adjuntos en correo del vendedor.
				$data_seller['_template'] = 'emails.purchase.notificationsalerutan';
                $data_seller['_name_entity_user_action'] = $proyec_entity->name_entity;
				$data_seller['_type_entity'] = $proyec_entity->type_entity;
				$category_product = CategoriaProductoInstitucion::getCategoryProduct($product->codigo_categoria_prod_insti);
				$data_seller['_category_producto'] = $category_product->nombre_categoria_producto;
				//Datos adjuntos en correo del comprador.
				$data_purchaser['_template'] = 'emails.purchase.notificationpurchaserrutan';
				$data_purchaser['_name_entity_user_action'] = '';
			break;
			default:
				//Datos adjuntos en correo del vendedor.
				$data_seller['_template'] = 'emails.purchase.notificationsale';
                $data_seller['_name_entity_user_action'] = '';
				//Datos adjuntos en correo del comprador.
				$data_purchaser['_name_entity_user_action'] = '';
				$data_purchaser['_template'] = 'emails.purchase.notificationPurchaser';
			break;
        }

		//Notificación por correo al vendedor
		$data_seller['_subject'] = transtp('marketplace.purchase.mail.subject', ['product' => $product->nombre_producto]);
        $data_seller['_name_user_action'] = $purchaser->nombre_usuario;
        $data_seller['_url_user_action'] = $purchaser->getProfileUrl();
        $data_seller['_to'] = $seller->correo_electronico;
        $data_seller['_to_name'] = $seller->nombre_usuario;
        $data_seller['_url_product'] = URL::route('marketplace.show',['marketplace' => $product->url_producto], false);
        $data_seller['_name_product'] = $product->nombre_producto;
        $data_seller['_image_product'] = $product->imagen_producto;
        $data_seller['_total_value_purchase'] = $this->valor_total_compra;
        $data_seller['_total_value_points'] = $this->valor_total_puntos;
        $data_seller['_product_unit'] = $this->unidad_producto;
        $data_seller['_payment'] = $payment->nombre_tipo_pago;
        $data_seller['_shipping'] = $shipping ?  $shipping->nombre_tipo_envio : NULL;
        $data_seller['_email_purchaser'] = $purchaser->correo_electronico;
        $data_seller['_phones_purchaser'] = sprintf('%s %s %s', $purchaser->telefono_usuario, '-' , $purchaser->movil_usuario);
        SendEmail::notification($data_seller);

		//Notificación por correo al comprador
		$data_purchaser['_subject'] = transtp('marketplace.purchase.mail.subjectPurchase', ['product' => $product->nombre_producto]);
        $data_purchaser['_name_user_action'] = $seller->nombre_usuario;
        $data_purchaser['_url_user_action'] = $purchaser->getProfileUrl();
        $data_purchaser['_to'] = $purchaser->correo_electronico;
        $data_purchaser['_to_name'] = $purchaser->nombre_usuario;
        $data_purchaser['_url_product'] = route('marketplace.show',['marketplace' =>$product->url_producto]);
        $data_purchaser['_name_product'] = $product->nombre_producto;
        $data_purchaser['_image_product'] = $product->imagen_producto;
        $data_purchaser['_total_value_purchase'] = $this->valor_total_compra;
        $data_purchaser['_total_value_points'] = $this->valor_total_puntos;
        $data_purchaser['_product_unit'] = $this->unidad_producto;
        $data_purchaser['_payment'] = $payment->nombre_tipo_pago;
        $data_purchaser['_shipping'] = $shipping ?  $shipping->nombre_tipo_envio : NULL;
        $data_purchaser['_email_seller'] = $seller->correo_electronico;
        $data_purchaser['_phones_seller'] = sprintf('%s %s %s', $seller->telefono_usuario, '-' , $seller->movil_usuario);
        SendEmail::notification($data_purchaser);
		return true;
    }

}
