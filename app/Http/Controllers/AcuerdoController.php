<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Collection as Collection;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB, Lang, Log, Auth, TuProyecto, SendEmail;

use Custom\Innpulsa;

use App\Compra, App\AcuerdoCompra, App\ActividadAcuerdo, App\UsuarioAcuerdo, App\EntregableAcuerdo, App\UsuarioEmpresario, App\Estado, App\RegistroSesion, App\Usuario, App\Producto, App\AsignacionMarketplace, App\Institucion, App\GrupoUsuario, App\RolUsuarioGrupo;

class AcuerdoController extends Controller
{
	/**
	 * Instantiate a new AdjuntoCursoController instance.
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
	   abort(404);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('public.marketplace.main');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if ($request->ajax()) {
			$data = $request->all();
			$purchaseAgreement = new AcuerdoCompra;
			if ($purchaseAgreement->isValid($data)) {

				// Decrypt src-params
				list($codigo_compra) = TuProyecto::decryptSrcParams($request->codigo_compra);
				if(!$codigo_compra || !is_numeric($codigo_compra)) {
                    Log::error(sprintf('%s:%s', 'AcuerdoController:store', 'el codigo de compra no es valido'));
					App::abort(403);
				}

				$purchase = Compra::find($codigo_compra);
				if(!$purchase instanceof Compra) {
                    Log::error(sprintf('%s:%s', 'AcuerdoController:store', 'No se encuentra la compra'));
					abort(404);
                }

                $product = Producto::find($purchase->codigo_producto);
                if(!$product instanceof Producto) {
                    abort(404);
                }
                
				DB::beginTransaction();
				try {
					// Purchase agreement
					$purchaseAgreement->codigo_compra = $purchase->codigo_compra;
					$purchaseAgreement->codigo_estado = Estado::getState('progress');
                    $purchaseAgreement->fecha_acuerdo_compra = date('Y-m-d');
					$purchaseAgreement->seg_codigo_usuario = $purchase->seg_codigo_usuario;
  
                    if($request->has('alcance_acuerdo_compra')) {
                        $purchaseAgreement->alcance_acuerdo_compra = $request->input('alcance_acuerdo_compra') ;
                    }else{
                        $purchaseAgreement->alcance_acuerdo_compra =  $product->alcance_servicio ?? '';
                    }

                    if($request->has('resultados_acuerdo_compra')) {
                        $purchaseAgreement->resultados_acuerdo_compra = $request->input('resultados_acuerdo_compra');
                    }else{
                        $purchaseAgreement->resultados_acuerdo_compra = $product->resultados_servicio ?? '';
                    }
					 
					
					$purchaseAgreement->save();

					// Activity agreement
					$activities = collect($request->input('actividad_acuerdo'));
					foreach ($activities as $act_agreement) {

						// Insert Activity Agreement
						$activityAgreement = new ActividadAcuerdo();
						$activityAgreement->codigo_acuerdo_compra = $purchaseAgreement->codigo_acuerdo_compra;
						$activityAgreement->codigo_estado = Estado::getState('active');
						$activityAgreement->desc_actividad_acuerdo = $act_agreement['desc_actividad_acuerdo'];
						$activityAgreement->sesiones_presencial = $act_agreement['sesiones_presencial'];
						$activityAgreement->sesiones_presencial_horas = $act_agreement['sesiones_presencial_horas'];
						$activityAgreement->sesiones_virtual = $act_agreement['sesiones_virtual'];
						$activityAgreement->sesiones_virtual_horas = $act_agreement['sesiones_virtual_horas'];
						$activityAgreement->resp_comprador_actividad = $act_agreement['resp_actividad_acuerdo'] == 'resp_comprador_actividad' ? true : false;
						$activityAgreement->resp_proveedor_actividad = $act_agreement['resp_actividad_acuerdo'] == 'resp_proveedor_actividad' ? true : false;
						$activityAgreement->fecha_inicial_actividad_acuerdo = $act_agreement['fecha_inicial_actividad_acuerdo'];
                        $activityAgreement->fecha_final_actividad_acuerdo = $act_agreement['fecha_final_actividad_acuerdo'];
                        if(isset($act_agreement['actividad_acuerdo_fija']) ){
                            $activityAgreement->actividad_acuerdo_fija = $act_agreement['actividad_acuerdo_fija'];
                        }
						$activityAgreement->save();
					}

					// User agreement
                    $usersAgreement = collect($request->input('asesor_acuerdo'));
                    
					foreach ($usersAgreement as $user_agreement) {

						if(empty($user_agreement['codigo_grupo_usuario'])){
							$member = GrupoUsuario::where('seg_codigo_usuario', '=', $purchase->seg_codigo_usuario)->where('codigo_usuario', '=', $purchase->seg_codigo_usuario)->where('codigo_estado', '=', Estado::getState('active'))->first();
							if(!$member instanceof GrupoUsuario){
								$member = new GrupoUsuario;
								$member->seg_codigo_usuario = $purchase->seg_codigo_usuario;
								$member->codigo_usuario = $purchase->seg_codigo_usuario;
								$member->codigo_estado = Estado::getState('active');
								$member->codigo_rol_usuario_grupo_insti = RolUsuarioGrupo::getGroupUserRol('teamWork');
								$member->fecha_hora_grupo_usuario = date('Y-m-d H:m:s');
								$member->save();
							}

							$user_agreement['codigo_grupo_usuario'] = $member->codigo_grupo_usuario;
						}

						// Insert User Agreement
						$userAgreement = new UsuarioAcuerdo();
						$userAgreement->codigo_acuerdo_compra = $purchaseAgreement->codigo_acuerdo_compra;
						$userAgreement->codigo_estado = Estado::getState('active');
						$userAgreement->codigo_grupo_usuario = $user_agreement['codigo_grupo_usuario'];
                        $userAgreement->save();   
					}

					// Deliverable agreement
					$deliverablesAgreement = collect($request->input('entregable_acuerdo'));
					foreach ($deliverablesAgreement as $deliverable_agreement) {

						// Insert Deliverable Agreement
						$deliverableAgreement = new EntregableAcuerdo();
						$deliverableAgreement->codigo_acuerdo_compra = $purchaseAgreement->codigo_acuerdo_compra;
						$deliverableAgreement->codigo_estado = Estado::getState('active');
                        $deliverableAgreement->descripcion_entregable = $deliverable_agreement['descripcion_entregable'];
                        if(isset($deliverable_agreement['entregable_acuerdo_fijo']) ){
                            $deliverableAgreement->entregable_acuerdo_fijo = $deliverable_agreement['entregable_acuerdo_fijo'];
                        }
						$deliverableAgreement->save();
					}

					// Work team agreement
					$workteamAgreement = collect($request->input('equipo_trabajo_acuerdo'));
					foreach ($workteamAgreement as $member_workteam_agreement) {

						// Insert member to agreement work team
						$memberWorkteamAgreement = new UsuarioEmpresario();
						$memberWorkteamAgreement->codigo_acuerdo_compra = $purchaseAgreement->codigo_acuerdo_compra;
						$memberWorkteamAgreement->codigo_estado = Estado::getState('active');
						$memberWorkteamAgreement->nombre_usuario_empresario = $member_workteam_agreement['nombre_usuario_empresario'];
						$memberWorkteamAgreement->cargo_usuario_empresario = $member_workteam_agreement['cargo_usuario_empresario'];
						$memberWorkteamAgreement->correo_usuario_empresario = $member_workteam_agreement['correo_usuario_empresario'];
						$memberWorkteamAgreement->save();
					}

					// Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'toedit' => true, 'message' => transtp('marketplace.agreement.create'), 'codigo_acuerdo_compra' => TuProyecto::encryptSrcParams([$purchaseAgreement->codigo_acuerdo_compra])]);
				}catch(\Exception $e){
					DB::rollback();
					Log::error(sprintf('%s:%s', 'AcuerdoController:store', $e->getMessage()));
					return response()->json(['success' => false, 'errors' => Lang::get('app.exception')]);
				}
			}
			return response()->json(['success' => false, 'errors' => $purchaseAgreement->errors]);
		}
		abort(404);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(Request $request, $id)
	{
        // Decrypt src-params
		list($codigo_acuerdo_compra) = TuProyecto::decryptSrcParams($id);
		if(!$codigo_acuerdo_compra || !is_numeric($codigo_acuerdo_compra)) {
			abort(403);
		}

        $purchaseAgreement = AcuerdoCompra::getAgreement($codigo_acuerdo_compra);
        if(!$purchaseAgreement instanceof AcuerdoCompra) {
            abort(404);
        }

        if ($request->ajax()) {
            return response()->json(AcuerdoCompra::buildPurchaseAgreement($purchaseAgreement));
        }
		return view('public.marketplace.main');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		// Decrypt src-params
		list($codigo_acuerdo_compra) = TuProyecto::decryptSrcParams($id);
		if(!$codigo_acuerdo_compra || !is_numeric($codigo_acuerdo_compra)) {
			abort(403);
		}

		return view('public.marketplace.main');
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
		// Decrypt src-params
		list($codigo_acuerdo_compra) = TuProyecto::decryptSrcParams($id);
		if(!$codigo_acuerdo_compra || !is_numeric($codigo_acuerdo_compra)) {
			abort(403);
		}

        $purchaseAgreement = AcuerdoCompra::find($codigo_acuerdo_compra);
        if(!$purchaseAgreement instanceof AcuerdoCompra) {
            abort(404);
        }

		$purchase = Compra::find($purchaseAgreement->codigo_compra);
		if(!$purchase instanceof Compra) {
			abort(404);
		}

		$purchaser = Usuario::find($purchase->codigo_usuario);
		if(!$purchaser instanceof Usuario){
			abort(404);
		}

		$product = Producto::find($purchase->codigo_producto);
		if(!$product instanceof Producto) {
			abort(404);
		}

		$seller = Usuario::find($product->seg_codigo_usuario);
		if(!$seller instanceof Usuario){
			abort(404);
		}

		if($request->ajax()) {
			DB::beginTransaction();
            try
            {
            	// Purchase agreement
                if($request->has('alcance_acuerdo_compra')) {
                    $purchaseAgreement->alcance_acuerdo_compra = $request->input('alcance_acuerdo_compra') ;
                }else{
                    $purchaseAgreement->alcance_acuerdo_compra =  $product->alcance_servicio ?? '';
                }

                if($request->has('resultados_acuerdo_compra')) {
                    $purchaseAgreement->resultados_acuerdo_compra = $request->input('resultados_acuerdo_compra');
                }else{
                    $purchaseAgreement->resultados_acuerdo_compra = $product->resultados_servicio ?? '';
                }
				$purchaseAgreement->save();

				$activities = collect($request->input('actividad_acuerdo'));
				$arActivities = $activities->pluck('codigo_actividad_acuerdo');
				foreach ($activities as $act_agreement) {
					if(!isset($act_agreement['codigo_actividad_acuerdo'])) {
						// Insert Activity Agreement
						$activityAgreement = new ActividadAcuerdo();
						$activityAgreement->codigo_acuerdo_compra = $purchaseAgreement->codigo_acuerdo_compra;
						$activityAgreement->codigo_estado = Estado::getState('active');
						$activityAgreement->desc_actividad_acuerdo = $act_agreement['desc_actividad_acuerdo'];
						$activityAgreement->sesiones_presencial = $act_agreement['sesiones_presencial'];
						$activityAgreement->sesiones_presencial_horas = $act_agreement['sesiones_presencial_horas'];
						$activityAgreement->sesiones_virtual = $act_agreement['sesiones_virtual'];
						$activityAgreement->sesiones_virtual_horas = $act_agreement['sesiones_virtual_horas'];
						$activityAgreement->resp_comprador_actividad = $act_agreement['resp_actividad_acuerdo'] == 'resp_comprador_actividad' ? true : false;
						$activityAgreement->resp_proveedor_actividad = $act_agreement['resp_actividad_acuerdo'] == 'resp_proveedor_actividad' ? true : false;
						$activityAgreement->fecha_inicial_actividad_acuerdo = $act_agreement['fecha_inicial_actividad_acuerdo'];
                        $activityAgreement->fecha_final_actividad_acuerdo = $act_agreement['fecha_final_actividad_acuerdo'];
                        if(isset($act_agreement['actividad_acuerdo_fija']) ){
                            $activityAgreement->actividad_acuerdo_fija = $act_agreement['actividad_acuerdo_fija'];
                        }
						$activityAgreement->save();

						$arActivities[] = $activityAgreement->codigo_actividad_acuerdo;
					}elseif(!empty($act_agreement['codigo_actividad_acuerdo'])){
                        $activityAgreement = ActividadAcuerdo::find($act_agreement['codigo_actividad_acuerdo']);

                        if($activityAgreement instanceof ActividadAcuerdo){
                            $activityAgreement->fecha_inicial_actividad_acuerdo = $act_agreement['fecha_inicial_actividad_acuerdo'];
						    $activityAgreement->fecha_final_actividad_acuerdo = $act_agreement['fecha_final_actividad_acuerdo'];
						    $activityAgreement->save();
                        }else{  
                            $message = 'No se encuentra la ActividadAcuerdo de codigo: ' . $act_agreement['codigo_actividad_acuerdo'] ;
                            Log::error(sprintf('%s:%s', 'AcuerdoController:update',$message ));
                        }
                        
                    }
				}
				$filteredAct = $arActivities->filter(function ($item) { return $item != NULL; });
				// Set removed activity
                ActividadAcuerdo::whereNotIn('codigo_actividad_acuerdo', $filteredAct->all())->where('codigo_acuerdo_compra', $purchaseAgreement->codigo_acuerdo_compra )
                    ->update(['codigo_estado' => Estado::getState('removed')]);

                // User agreement
				$users = collect($request->input('asesor_acuerdo'));
				$arUsers = $users->pluck('codigo_usuario_acuerdo');
				foreach ($users as $user_agreement)
				{
					if(!isset($user_agreement['codigo_usuario_acuerdo'])){
						if(!isset($user_agreement['codigo_grupo_usuario'])){
							$member = GrupoUsuario::where('seg_codigo_usuario', '=', $purchase->seg_codigo_usuario)->where('codigo_usuario', '=', $purchase->seg_codigo_usuario)->where('codigo_estado', '=', Estado::getState('active'))->first();
							if(!$member instanceof GrupoUsuario){
								$member = new GrupoUsuario;
								$member->seg_codigo_usuario = $purchase->seg_codigo_usuario;
								$member->codigo_usuario = $purchase->seg_codigo_usuario;
								$member->codigo_estado = Estado::getState('active');
								$member->codigo_rol_usuario_grupo_insti = RolUsuarioGrupo::getGroupUserRol('teamWork');
								$member->fecha_hora_grupo_usuario = date('Y-m-d H:m:s');
								$member->save();
							}

							$user_agreement['codigo_grupo_usuario'] = $member->codigo_grupo_usuario;
						}

						$userAgreement = UsuarioAcuerdo::where('codigo_grupo_usuario', $user_agreement['codigo_grupo_usuario'])->where('codigo_acuerdo_compra', $purchaseAgreement->codigo_acuerdo_compra)->first();
						if(!$userAgreement instanceof UsuarioAcuerdo){
							$userAgreement = new UsuarioAcuerdo();
						}

						// Insert User Agreement
						$userAgreement->codigo_acuerdo_compra = $purchaseAgreement->codigo_acuerdo_compra;
						$userAgreement->codigo_estado = Estado::getState('active');
						$userAgreement->codigo_grupo_usuario = $user_agreement['codigo_grupo_usuario'];
                        $userAgreement->save();
                        
						$arUsers[] = $userAgreement->codigo_usuario_acuerdo;
					}
				}
				$filteredUser = $arUsers->filter(function ($item) { return $item != NULL; });

				// Set removed users
                UsuarioAcuerdo::whereNotIn('codigo_usuario_acuerdo', $filteredUser->all())->where('codigo_acuerdo_compra', $purchaseAgreement->codigo_acuerdo_compra )
                    ->update(['codigo_estado' => Estado::getState('removed')]);

				// Deliverable agreement
				$deliverables = collect($request->input('entregable_acuerdo'));
				$ardeliverables = $deliverables->pluck('codigo_entregable_acuerdo');
				foreach ($deliverables as $deliverable_agreement) {
					if(!isset($deliverable_agreement['codigo_entregable_acuerdo'])){
						// Insert Deliverable Agreement
						$deliverableAgreement = new EntregableAcuerdo();
						$deliverableAgreement->codigo_acuerdo_compra = $purchaseAgreement->codigo_acuerdo_compra;
						$deliverableAgreement->codigo_estado = Estado::getState('active');
                        $deliverableAgreement->descripcion_entregable = $deliverable_agreement['descripcion_entregable'];
                        
                        if(isset($deliverable_agreement['entregable_acuerdo_fijo']) ){
                            $deliverableAgreement->entregable_acuerdo_fijo = $deliverable_agreement['entregable_acuerdo_fijo'];    
                        }
						$deliverableAgreement->save();  
						$ardeliverables[] = $deliverableAgreement->codigo_entregable_acuerdo;
					}
				}

				$filteredDeliverable = $ardeliverables->filter(function ($item) { return $item != NULL; });
				// Set removed users
                EntregableAcuerdo::whereNotIn('codigo_entregable_acuerdo', $filteredDeliverable->all())->where('codigo_acuerdo_compra', $purchaseAgreement->codigo_acuerdo_compra )
                    ->update(['codigo_estado' => Estado::getState('removed')]);

				// Work team agreement
				$workteamAgreement = collect($request->input('equipo_trabajo_acuerdo'));
				$arWorkteamAgreement = $workteamAgreement->pluck('codigo_usuario_empresario');
				foreach ($workteamAgreement as $member_workteam_agreement) {
					if(!isset($member_workteam_agreement['codigo_usuario_empresario'])) {

						// Insert member to agreement work team
						$memberWorkteamAgreement = new UsuarioEmpresario();
						$memberWorkteamAgreement->codigo_acuerdo_compra = $purchaseAgreement->codigo_acuerdo_compra;
						$memberWorkteamAgreement->codigo_estado = Estado::getState('active');
						$memberWorkteamAgreement->nombre_usuario_empresario = $member_workteam_agreement['nombre_usuario_empresario'];
						$memberWorkteamAgreement->cargo_usuario_empresario = $member_workteam_agreement['cargo_usuario_empresario'];
						$memberWorkteamAgreement->correo_usuario_empresario = $member_workteam_agreement['correo_usuario_empresario'];
						$memberWorkteamAgreement->save();

						$arWorkteamAgreement[] = $memberWorkteamAgreement->codigo_usuario_empresario;
					}
				}

				$filterWorkteamAgreement = $arWorkteamAgreement->filter(function ($item) { return $item != NULL; });
				// Set removed users
				UsuarioEmpresario::whereNotIn('codigo_usuario_empresario', $filterWorkteamAgreement->all())->where('codigo_acuerdo_compra', $purchaseAgreement->codigo_acuerdo_compra )
					->update(['codigo_estado' => Estado::getState('removed')]);


				if($request->has('send_confirm')) {
			        // Agreement to active
			        $purchaseAgreement->codigo_estado = Estado::getState('active');
			        $purchaseAgreement->fecha_aprobacion_asesor_acuerdo_compra = date('Y-m-d');
			        $purchaseAgreement->save();

					// Send notification
					$data = [];
					$data['_template'] = 'emails.marketplace.agreement';
					$data['_inst'] = RegistroSesion::getInstitution();
					$data['_subject'] = 'Creación de acuerdo compra';
					$data['_to'] = $purchaser->correo_electronico;
					$data['_to_name'] = ucwords(strtolower($purchaser->nombre_usuario));
					$data['_url_action'] = route('marketplace.compras.acuerdo.show', ['acuerdo' => TuProyecto::encryptSrcParams([$purchaseAgreement->codigo_acuerdo_compra])]);
					$data['_seller'] = ucwords(strtolower($seller->nombre_usuario));
					$data['_product'] = $product->nombre_producto;
					SendEmail::notification($data);

			        DB::commit();
					return response()->json(['success' => true, 'toconfirm' => true, 'message' => transtp('marketplace.agreement.send')]);
				}

	            // Commit Transaction
				DB::commit();
                return response()->json(['success' => true, 'toedit' => true, 'message' => 'El acuerdo se ha editado correctamente!!']);

            }catch(\Exception $e){
            	DB::rollback();
				Log::error(sprintf('%s:%s', 'AcuerdoController:update', $e->getMessage()));
				return response()->json(['success' => false, 'errors' => Lang::get('app.exception')]);

            }
        }
        abort(404);
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
	 * Confirm resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function confirmar(Request $request)
	{
		if ($request->ajax()) {
			DB::beginTransaction();
			try {
		        // Decrypt src-params
				list($codigo_acuerdo_compra) = TuProyecto::decryptSrcParams($request->codigo_acuerdo_compra);
				if(!$codigo_acuerdo_compra || !is_numeric($codigo_acuerdo_compra)) {
		           	throw new \Exception("No es posible recuperar acuerdo de compra obligatorio");
				}

		        $agreement = AcuerdoCompra::find($codigo_acuerdo_compra);
		        if(!$agreement instanceof AcuerdoCompra) {
		           	throw new \Exception("No es posible recuperar acuerdo de compra $codigo_acuerdo_compra");
		        }

		        $purchase = Compra::find($agreement->codigo_compra);
		        if(!$purchase instanceof Compra) {
		           	throw new \Exception("No es posible recuperar compra $codigo_acuerdo_compra");
		        }

		        if(!in_array(Auth::user()->codigo_usuario, [$purchase->codigo_usuario])) {
			        DB::rollback();
					return response()->json(['success' => false, 'errors' => "El acuerdo de compra solo puede ser confirmado por el COMPRADOR."]);
		        }

				$institution = Institucion::find(RegistroSesion::getInstitution());
				if(!$institution instanceof Institucion){
					throw new \Exception("No es posible recuperar la institution ".RegistroSesion::getInstitution());
				}

                $assignmentMembers = AsignacionMarketplace::getAssignmentsMember($agreement->codigo_acuerdo_compra);
                
                
				// Other actions institution
				switch (RegistroSesion::getInstitution()) {
					case Institucion::getInstitution('innpulsa'):
						Innpulsa::sendEmailConfirmAgreement($assignmentMembers, $institution->url_admin_institucion, $agreement->codigo_acuerdo_compra);
					break;
					default:
						foreach ($assignmentMembers as $value) {
							// Send notification
							$data = [];
							$data['_template'] = 'emails.marketplace.agreementconfirm';
							$data['_inst'] = RegistroSesion::getInstitution();
							$data['_subject'] = 'Acuerdo de negociación por revisar';
							$data['_to'] = $value->correo_electronico;
							$data['_to_name'] = ucwords(strtolower($value->nombre_usuario));
							$data['_url_admin_institution'] = $institution->url_admin_institucion.'/marketplace/transacciones/acuerdo/'.TuProyecto::encryptSrcParams([$agreement->codigo_acuerdo_compra]);
							SendEmail::notification($data);
						}
					break;
				}

	        	// Agreement confirm
		        $agreement->codigo_estado = Estado::getState('confirm');
				$agreement->fecha_acuerdo_aceptacion_compra = date('Y-m-d');
		        $agreement->save();

				// Commit Transaction
				DB::commit();
				return response()->json(['success' => true,  'message' => transtp('marketplace.agreement.confirmed')]);
			}catch(\Exception $e){
				DB::rollback();
				Log::error(sprintf('%s:%s', 'AcuerdoController confirmar', $e->getMessage()));
				return response()->json(['success' => false, 'errors' => trans('app.exception')]);
			}
		}
		abort(404);
	}
}
