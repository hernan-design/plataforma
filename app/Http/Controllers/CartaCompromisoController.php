<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB, Lang, Log, Auth, App, SendEmail;

use TuProyecto;

use App\CartaCompromisoCompra, App\RegistroSesion, App\RegistroConvocatoria, App\ClaseEmprendimiento, App\Usuario, App\RegistroFaseUsuario, App\CategoriaProducto, App\Fase, App\DetalleVoucher, App\Estado;

class CartaCompromisoController extends Controller
{
	/**
	 * Instantiate a new AdjuntoUsuarioController instance.
	 */
	public function __construct()
	{
		$this->middleware('auth', ['except' => ['show']]);
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
	public function create(Request $request)
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
		// Decrypt src-params
		list($codigo_carta_compromiso) = TuProyecto::decryptSrcParams($request->codigo_carta_compromiso);
		if(!$codigo_carta_compromiso || !is_numeric($codigo_carta_compromiso)) {
			$errormsg = "El codigo de carta de compromiso es invalido";
			Log::error(sprintf('%s:%s: %s', 'App\Http\Controllers\CartaCompromisoController@store',$errormsg, $codigo_carta_compromiso));
			abort(403);
		}

		$commitment = CartaCompromisoCompra::find($codigo_carta_compromiso);
		if(!$commitment instanceof CartaCompromisoCompra) {
			$errormsg = "Error recuperando la carta de compromiso de codigo";
			Log::error(sprintf('%s:%s: %s', 'App\Http\Controllers\CartaCompromisoController@store',$errormsg, $codigo_carta_compromiso));
			abort(500);
		}

		$registrofase = RegistroFaseUsuario::find($commitment->codigo_registro_fase_usuario);
		if(!$registrofase instanceof RegistroFaseUsuario) {
			$errormsg = "Error recuperando el registro de fase de usuario de codigo";
			Log::error(sprintf('%s:%s: %s', 'App\Http\Controllers\CartaCompromisoController@store',$errormsg, $commitment->codigo_registro_fase_usuario));
			abort(500);
		}

		$project = 	$registrofase->project()->first();
		if(!$project instanceof Usuario) {
			$errormsg = "Error recuperando el projecto  de codigo";
			Log::error(sprintf('%s:%s: %s', 'App\Http\Controllers\CartaCompromisoController@store',$errormsg, $registrofase->codigo_usuario));
			abort(500);
		}

		DB::beginTransaction();
		try {
			$commitment->fecha_aceptacion_carta_compormiso_compra = date('Y-m-d');
			$commitment->save();
			$registrofase->codigo_estado = Estado::getState('linked');
			$registrofase->save();

			switch ($registrofase->codigo_fase) {
				case Fase::getIdPhase('three_challenge'):
					$llave_deacceso = DetalleVoucher::where('codigo_usuario', '=', Auth::user()->codigo_usuario)
						->where('codigo_registro_fase_usuario', '=', $registrofase->codigo_registro_fase_usuario)
						->where('codigo_estado', '=', Estado::getState('pending'))
						->first();

					if(!$llave_deacceso instanceof DetalleVoucher) {
						throw new \Exception("Error recuperando llave de acceso");
					}

					$llave_deacceso->codigo_estado = Estado::getState('active');
					$llave_deacceso->save();

							// Enable term marketplace user
					$userInstitution = Auth::user()->institucion;
					$userInstitution->validacion_terminos_marketplace = true;
					$userInstitution->save();

				break;
				case Fase::getIdPhase('reto3_aldea20'):

					$llave_deacceso = DetalleVoucher::where('codigo_usuario', '=', Auth::user()->codigo_usuario)
						->where('codigo_registro_fase_usuario', '=', $registrofase->codigo_registro_fase_usuario)
						->where('codigo_estado', '=', Estado::getState('pending'))
						->first();

					if(!$llave_deacceso instanceof DetalleVoucher) {
						throw new \Exception("Error recuperando llave de acceso");
					}

					$llave_deacceso->codigo_estado = Estado::getState('active');
					$llave_deacceso->save();

					// Enable term marketplace user
					$userInstitution = Auth::user()->institucion;
					$userInstitution->validacion_terminos_marketplace = true;
					$userInstitution->save();

					// Send Mails

					$recipients = [
						'roberto.manrique@innpulsacolombia.com', 'julian.rocha@innpulsacolombia.com',
						'ruben.gantiva@innpulsacolombia.com', 'Maria.Soler@innpulsacolombia.com'
					];

					$registerProgram = RegistroConvocatoria::find($registrofase->codigo_registro_convocatoria);
					if (!$registerProgram instanceof RegistroConvocatoria) {
						$errormsg = "Error recuperando el registro de la convocatoria";
						Log::error(sprintf('%s:%s: %s', 'App\Http\Controllers\CartaCompromisoController@store',$errormsg, $registrofase->codigo_usuario));
						abort(500);
					}

					$data = [];
					$data['_subject'] = 'Aceptacion carta de compromiso';
					$data['_template'] = 'emails.letter.letterAceptation';
					$data['_register'] = $registerProgram->numero_registro_convocatoria;
					$data['_name'] = $project->nombre_usuario;
					$data['_inst'] = RegistroSesion::getInstitution();

					foreach ($recipients as $recipient) {
						$data['_to'] = $recipient;
						SendEmail::notification($data);
					}


				break;

			}


			// Commit Transaction
			DB::commit();
			switch ($registrofase->codigo_fase) {
				case Fase::getIdPhase('three_challenge'):
					return redirect()->route('marketplace.index');
				break;
				case Fase::getIdPhase('reto3_aldea20'):
					
					return redirect()->route('marketplace.index');
				break;
			}

			return redirect()->route('proyecto.proyecto', ['proyecto' => $project->nickname_usuario]);;
		 }catch(\Exception $e){
            DB::rollback();
			Log::error(sprintf('%s:%s', 'App\Http\Controllers\CartaCompromisoController@store', $e->getMessage()));
           	abort(500);
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{		
		//Decrypt src-params
		list($codigo_carta_compromiso) = TuProyecto::decryptSrcParams($id);		
		//$codigo_carta_compromiso = $id;
		if(!$codigo_carta_compromiso || !is_numeric($codigo_carta_compromiso)) {
			abort(403);
		}

		$dataCommitment = CartaCompromisoCompra::getDataCommitment($codigo_carta_compromiso);
		if($dataCommitment instanceof RegistroFaseUsuario)
		{
			//dd($dataCommitment);

			switch ($dataCommitment->codigo_fase) {
				case Fase::getIdPhase('three_challenge'):
				case Fase::getIdPhase('four_challenge'):
					// Allowed users
					if( in_array(Auth::user()->codigo_usuario, [$dataCommitment->owner]) || Auth::user()->ability('admin,super-admin', 'view-letter-of-engagement', ['module'  => '/marketplace']) )
					{
						$data = [];
						$data['data'] = $dataCommitment;
						$data['title'] = "Carta de compromiso";

						// Date of aceptation
						list($data['ano'], $data['mes'], $data['dia']) = explode('-', $dataCommitment->fecha_aceptacion_carta_compormiso_compra ? $dataCommitment->fecha_aceptacion_carta_compormiso_compra : date('Y-m-d'));
						//dd($dataCommitment);
						// Get Register phase two for the categories
						$oldRegister = RegistroFaseUsuario::where('codigo_usuario', $dataCommitment->codigo_usuario)->where('codigo_fase', Fase::getIdPhase('two_challenge'))->first();



						$data['categories'] = CategoriaProducto::getCategoriesListPdf($oldRegister->codigo_registro_fase_usuario);
						$data['valor_llave_acceso'] = $dataCommitment->valor_asignacion_rfu;
						$data['valor_llave_acceso_letras'] = \NumeroALetras::convertir($dataCommitment->valor_asignacion_rfu, 'PESOS M/CTE');

						// Export pdf
						$pdf = App::make('dompdf.wrapper');
						//dd($data);
						switch ($dataCommitment->codigo_clase_emprendimiento) {
							case ClaseEmprendimiento::getTypeClass('project'):
								$pdf->loadHTML(view('reports.marketplace.innpulsa.cartacompromiso_project', $data)->render());
							break;

							case ClaseEmprendimiento::getTypeClass('company'):
								$pdf->loadHTML(view('reports.marketplace.innpulsa.cartacompromiso', $data)->render());
							break;
						}

						return @$pdf->stream(sprintf('%s.pdf', 'Carta Compromiso'));
					}
				break;
				case Fase::getIdPhase('empodera2020_1_2'):
					// Allowed users
					if( in_array(Auth::user()->codigo_usuario, [$dataCommitment->owner]) || Auth::user()->ability('admin,super-admin', 'view-letter-of-engagement') )
					{
						$data = [];
						$data['data'] = $dataCommitment;
						$data['title'] = "Carta de compromiso";

						// Date of aceptation
						list($data['ano'], $data['mes'], $data['dia']) = explode('-', $dataCommitment->fecha_aceptacion_carta_compormiso_compra ? $dataCommitment->fecha_aceptacion_carta_compormiso_compra : date('Y-m-d'));
						 //       s dd($data);
						// Get Register phase two for the categories

						// Export pdf
						$pdf = App::make('dompdf.wrapper');
						$pdf->loadHTML(view('reports.innpulsa.compromiso.emprende2020.cartacompromiso', $data)->render());

						return @$pdf->stream(sprintf('%s.pdf', 'Carta Compromiso'));
					}
				break;
				case Fase::getIdPhase('reto3_aldea20'):
					// Allowed users
					if( in_array(Auth::user()->codigo_usuario, [$dataCommitment->owner]) || Auth::user()->ability('admin,super-admin', 'view-letter-of-engagement', ['module'  => '/marketplace']) )
					{
						$data = [];
						$data['data'] = $dataCommitment;
						$data['title'] = "Carta de compromiso";

						// Date of aceptation
						list($data['ano'], $data['mes'], $data['dia']) = explode('-', $dataCommitment->fecha_aceptacion_carta_compormiso_compra ? $dataCommitment->fecha_aceptacion_carta_compormiso_compra : date('Y-m-d'));
						//dd($dataCommitment);
						// Get Register phase two for the categories
						$oldRegister = RegistroFaseUsuario::where('codigo_usuario', $dataCommitment->codigo_usuario)->where('codigo_fase', Fase::getIdPhase('moment_3__Aldea20'))->first();



						$data['categories'] = CategoriaProducto::getCategoriesListPdf($oldRegister->codigo_registro_fase_usuario);
						$data['valor_llave_acceso'] = $dataCommitment->valor_asignacion_rfu;
						$data['valor_llave_acceso_letras'] = \NumeroALetras::convertir($dataCommitment->valor_asignacion_rfu, 'PESOS M/CTE');

						// Export pdf
						$pdf = App::make('dompdf.wrapper');
						//dd($data);
						switch ($dataCommitment->codigo_clase_emprendimiento) {
							case ClaseEmprendimiento::getTypeClass('project'):
								$pdf->loadHTML(view('reports.marketplace.innpulsa.cartacompromiso_project', $data)->render());
							break;

							case ClaseEmprendimiento::getTypeClass('company'):
								$pdf->loadHTML(view('reports.marketplace.innpulsa.cartacompromiso', $data)->render());
							break;
						}

						return @$pdf->stream(sprintf('%s.pdf', 'Carta Compromiso'));
					}
				break;
				default:
					abort(403);
				break;
			}
			abort(403);
		}
		abort(404);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{		
		return view('core.middleware.commitment')->with('compromiso', $id);
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
}
