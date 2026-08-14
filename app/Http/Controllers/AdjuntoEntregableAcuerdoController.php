<?php

namespace App\Http\Controllers;

use App\AcuerdoCompra;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use TuProyecto;

use App, DB, Log, Lang, Auth, Response, SendEmail;

use App\Adjunto,
	App\EntregableAcuerdo,
	App\TipoAdjunto,
	App\Compra,
	App\PrivacidadContenido,
	App\AdjuntoUsuario,
	App\RegistroSesion,
	App\Usuario;

class AdjuntoEntregableAcuerdoController extends Controller
{
    /**
     * Instantiate a new AdjuntoEntregableAcuerdoController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if($request->ajax()) {
			$data =$request->all();

			$deliverableAgreement = EntregableAcuerdo::find($request->codigo_entregable_acuerdo);
			if(!$deliverableAgreement instanceof EntregableAcuerdo) {
				abort(404);
			}

			DB::beginTransaction();
			try {
				if ($request->hasFile('file'))
				{
					$file = $request->file('file');
					$result = Adjunto::upload($file->getRealPath(), $file->getClientOriginalName(), 'document');

					if(is_object($result) && $result->success === true) {

						// Adjunto
						$attached = new Adjunto();
						$attached->codigo_tipo_adjunto = TipoAdjunto::getTypeAttached('document');
						$attached->direccion_adjunto = $result->file_path;
						$attached->nombre_adjunto = $file->getClientOriginalName();
                        $attached->fecha_adjunto = date('Y-m-d H:i:s');
						$attached->save();

						// Adjunto Entregable
						$deliverableAgreement->codigo_adjunto = $attached->codigo_adjunto;
						$deliverableAgreement->save();

						// Update Acuerdo
						AcuerdoCompra::where('codigo_acuerdo_compra', $data['codigo_acuerdo_compra'])
							->update(['fecha_cargue_entregables' => date('Y-m-d')]);

						// Prepare response
						$response = new \stdClass();
						$response->uuid = TuProyecto::encryptSrcParams([$attached->codigo_adjunto]);
						$response->codigo_tipo_adjunto = $attached->codigo_tipo_adjunto;
						$response->direccion_adjunto = $attached->direccion_adjunto;
						$response->name = $attached->nombre_adjunto;
						$response->success = true;

						// Commit Transaction
						DB::commit();
						return response()->json($response);
					}
				}
				DB::rollback();
				return response()->json(['success' => false, 'errors' => trans('app.exception')]);
			}catch(\Exception $e){
				DB::rollback();
				Log::error($e->getMessage());
				return response()->json(['success' => false, 'errors' => trans('app.exception')]);
			}
		}
		abort(404);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getEntregables(Request $request)
	{
		if ($request->ajax()) {
			list($codigo_compra) = TuProyecto::decryptSrcParams($request->codigo_compra);
			return Response::json(AdjuntoUsuario::getEntregableUser($request->codigo_tipo_adjunto, $codigo_compra));
		}
		abort(404);
	}

	/**
	 * guardar entregables de compra, Rutan
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function storeEntregables(Request $request)
	{
		if($request->ajax()) {
			$data =$request->all();

			list($codigo_compra) = TuProyecto::decryptSrcParams($request->codigo_compra);

			DB::beginTransaction();
			try {
					\Log::info($codigo_compra);
					\Log::info($data['codigo_adjunto']);
					//fecha de ejecución de entregable
					$objeto_DateTime = date_create_from_format('Y-m-d', $data['year'].'-'.$data['month'].'-'.$data['day']);

					$attached = null;
					// Adjunto
					if (!empty($data['codigo_adjunto'])) {
						$attached = Adjunto::find($data['codigo_adjunto']);

						if ($attached instanceof Adjunto) {
							$attached->fecha_adjunto = date('Y-m-d H:i:s'); // date('Y-m-d H:i:s')
							$attached->save();
						}
					}

					// new Acuerdo Compra
					//permite llevar fecha creacion entregable, aceptación/aprobacion entregables
					$acuerdo_compra = AcuerdoCompra::where('codigo_compra', $codigo_compra)
													->first();
					if ($acuerdo_compra instanceof AcuerdoCompra) {
						$acuerdo_compra->codigo_estado	= 1; //progreso
						$acuerdo_compra->fecha_acuerdo_compra = date('Y-m-d H:i:s');
						$acuerdo_compra->fecha_cargue_entregables = date('Y-m-d'); //fecha/dia que fue cargado el adjunto/entregable
						$acuerdo_compra->comentario_finalizacion_actividades = $data['observacion'];
						$acuerdo_compra->codigo_adjunto = isset($attached->codigo_adjunto) ? $attached->codigo_adjunto : null;
					} else {
						$acuerdo_compra = new AcuerdoCompra;
						$acuerdo_compra->codigo_estado	= 1; //progreso
						$acuerdo_compra->codigo_compra	= $codigo_compra;
						$acuerdo_compra->codigo_usuario = Auth::user()->codigo_usuario;
						$acuerdo_compra->codigo_adjunto = isset($attached->codigo_adjunto) ? $attached->codigo_adjunto : null;
						$acuerdo_compra->alcance_acuerdo_compra = 'Carga de entregables';
						$acuerdo_compra->resultados_acuerdo_compra = 'Carga de entregables';
						$acuerdo_compra->fecha_acuerdo_compra = date_format($objeto_DateTime, "Y-m-d");
						$acuerdo_compra->fecha_cargue_entregables = date('Y-m-d'); //fecha/dia que fue cargado el adjunto/entregable
						//guardamos la observacion en comentario_finalizacion_actividades
						$acuerdo_compra->comentario_finalizacion_actividades = $data['observacion'];

					}

					$acuerdo_compra->save();

						//para guardar datos del entregable
						$acuerdo_entregable = new EntregableAcuerdo;
						$acuerdo_entregable->codigo_estado = 8;
						$acuerdo_entregable->codigo_acuerdo_compra = $acuerdo_compra->codigo_acuerdo_compra;
						$acuerdo_entregable->descripcion_entregable = $data['nombre_entregable'];
						$acuerdo_entregable->codigo_adjunto = isset($attached->codigo_adjunto) ? $attached->codigo_adjunto : null;
						$acuerdo_entregable->url_adjunto = isset($attached->direccion_adjunto) ? $attached->direccion_adjunto : null;
						$acuerdo_entregable->save();

					if (isset($attached) && $attached instanceof Adjunto) {

						$attachedUser = new AdjuntoUsuario;
						$attachedUser->codigo_documento	= 15; //documento
						$attachedUser->codigo_adjunto	= $attached->codigo_adjunto;
						$attachedUser->codigo_usuario	= Auth::user()->codigo_usuario;
						$attachedUser->codigo_institucion = RegistroSesion::getInstitution();
						$attachedUser->codigo_estado	= 8;
						$attachedUser->codigo_privacidad_contenido = PrivacidadContenido::getPrivacy('public');
						$attachedUser->fecha_adjunto_usuario = date('Y-m-d');
						$attachedUser->hora_adjunto_usuario = date('H:i:s');
						$attachedUser->save();

						$response = AdjuntoUsuario::buildEntregable(AdjuntoUsuario::getDataAttached($attachedUser->codigo_adjunto, $attachedUser->codigo_usuario));
						$response->message = 'Entregable cargado correctamente';

						DB::commit();
						return response()->json($response);
					}

					// Prepare response
					$response = new \stdClass();
					// $response->uuid = TuProyecto::encryptSrcParams([$attached->codigo_adjunto]);
					// $response->codigo_tipo_adjunto = $attached->codigo_tipo_adjunto;
					// $response->direccion_adjunto = $attached->direccion_adjunto;
					// $response->name = $attached->nombre_adjunto;
					$response->success = true;
					$response->message = 'Entregable cargado';

					// Commit Transaction
					DB::commit();
					return response()->json($response);
			}catch(\Exception $e){
				DB::rollback();
				Log::error($e->getMessage());
				return response()->json(['success' => false, 'errors' => trans('app.exception')]);
			}
		}
		abort(404);
	}


	public function storeAdjuntoEntregables(Request $request)
	{
		if($request->ajax()) {
			$data =$request->all();

			list($codigo_compra) = TuProyecto::decryptSrcParams($request->codigo_compra);

			DB::beginTransaction();
			try {
				if ($request->hasFile('file')) {
					$file = $request->file('file');

					$result = Adjunto::upload($file->getRealPath(), $file->getClientOriginalName(), 'document');

					if(is_object($result) && $result->success === true) {
						//fecha de ejecución de entregable
						// $objeto_DateTime = date_create_from_format('Y-m-d', $data['year'].'-'.$data['month'].'-'.$data['day']);

						// Adjunto
						$attached = new Adjunto();
						$attached->codigo_tipo_adjunto = TipoAdjunto::getTypeAttached('document');
						$attached->direccion_adjunto = $result->file_path;
						$attached->nombre_adjunto = $file->getClientOriginalName();
                        $attached->fecha_adjunto = date('Y-m-d H:i:s');
						$attached->save();


						// Prepare response
						$response = new \stdClass();
						$response->uuid = TuProyecto::encryptSrcParams([$attached->codigo_adjunto]);
						$response->codigo_tipo_adjunto = $attached->codigo_tipo_adjunto;
						$response->direccion_adjunto = $attached->direccion_adjunto;
						$response->codigo_adjunto = $attached->codigo_adjunto;
						$response->name = $attached->nombre_adjunto;
						$response->success = true;
						$response->message = 'Archivo cargado';

						// Commit Transaction
						DB::commit();
						return response()->json($response);
					}
				}
				DB::rollback();
				return response()->json(['success' => false, 'errors' => trans('app.exception')]);
			}catch(\Exception $e){
				DB::rollback();
				Log::error($e->getMessage());
				return response()->json(['success' => false, 'errors' => trans('app.exception')]);
			}
		}
		abort(404);
	}


	/**
	 * Enviar entregables de compraa, Rutan
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function sendDeliverables(Request $request)
	{
		if($request->ajax()) {

			list($codigo_compra) = TuProyecto::decryptSrcParams($request->codigo_compra);

			DB::beginTransaction();
			try {
					//permite llevar fecha creacion entregable, aceptación/aprobacion entregables
					//actualizamos estado a forward para indicar que envió entregables
					$acuerdo_compra = AcuerdoCompra::where('codigo_compra', $codigo_compra)
													->where('codigo_usuario', Auth::user()->codigo_usuario)
													->first();
					if ($acuerdo_compra instanceof AcuerdoCompra) {
						$acuerdo_compra->codigo_estado	= 21; //forward=21
						$acuerdo_compra->fecha_acuerdo_compra = date('Y-m-d H:i:s'); //fecha envio entregables
						$acuerdo_compra->save();

					} else {
						DB::rollback();
						return response()->json(['success' => false, 'errors' => 'No se pudo enviar']);
					}

					$response = new \stdClass();
					$response->message = 'Se enviaron los entregables';
					$response->success = true;

					// Prepare response
					// $response = AdjuntoUsuario::buildAttached(AdjuntoUsuario::getDataAttached($attachedUser->codigo_adjunto, $attachedUser->codigo_usuario));
					// Commit Transaction
					DB::commit();

					$data_sale = $this->getDataPurchaser($acuerdo_compra->codigo_compra);

					//Se envía corrreo alcomprador
					$data = [];
					$data['_template'] = 'emails.purchase.notificacionentregablesrutan';
					$data['_inst'] = 61;
					$data['_subject'] = "ENTREGABLES-COMPRA CODIGO $acuerdo_compra->codigo_compra";
					$data['_to'] = $data_sale->correo_electronico;
					$data['_to_name'] = $data_sale->nombre_usuario;
					$data['_name_seller'] = Auth::user()->nombre_usuario;
					$data['_id_sale'] = $acuerdo_compra->codigo_compra;
					$data['_go_marketplace']  = "/marketplace";

					SendEmail::notification($data);

					return response()->json($response);
			}catch(\Exception $e){
				DB::rollback();
				Log::error($e->getMessage());
				return response()->json(['success' => false, 'errors' => trans('app.exception')]);
			}
		}
		abort(404);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}

	/**
     * Show the form for editing the specified resource.
     *
     * @param  string  $tab
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function deliberable($tab, $id)
	{
		// Decrypt src-params
        list($codigo_compra) = TuProyecto::decryptSrcParams($id);
        if(!$codigo_compra || !is_numeric($codigo_compra)) {
            abort(403);
        }

        $purchase = Compra::find($codigo_compra);
        if(!$purchase instanceof Compra) {
            abort(404);
        }

        // Only the user evaluate the buyer
        if( in_array($tab, ['compras'])) {
            if( !in_array(Auth::user()->codigo_usuario, [$purchase->codigo_usuario]) ){
                abort(404);
            }
        }
        // Only the user evaluate the seller
        if( in_array($tab, ['ventas'])) {
            if( !in_array(Auth::user()->codigo_usuario, [$purchase->seg_codigo_usuario]) ){
                abort(404);
            }
        }
        return view('public/marketplace/main');
	}
	/**
	 * Se obtiene datos del comprador.
	 * @access private
	 * @param int $id_sale
	 * @return object Usuario
	 */
	private function getDataPurchaser($id_sale)
	{
		$query = Compra::query();
		$query->where('codigo_compra', $id_sale);
		$data = $query->first();

		$query = Usuario::query();
		$query->where('codigo_usuario', $data->codigo_usuario);
		$data_purchaser = $query->first();

		return $data_purchaser;
	}
}
