<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Log;

use App\BeneficioPlan, App\Plan, App\Curso;

class PaymentsController extends Controller
{
	/**
	* Instantiate a new PaymentsController instance.
	*/
	public function __construct()
	{
		$this->middleware('react', ['only' => ['index']]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$data['key'] = 'pk_test_PusmBBxmdVmMBWs42wQvDa2q';
		if(in_array($request->segment(1), ['aprende'])) {			
			$course = Curso::getCourseUrl($request->segment(3));
			$data['title'] = $course->nombre_curso;
			$data['pricing'] = $course->precio_curso;
			$data['detail'] = $course->descripcion_curso;
		} else {
			$data['title'] = "Titulo de prueba";
			$data['pricing'] = "200000";
			$data['detail'] = "Este es el detalle";
		}

		$user = $request->user();

		$purchaser = [
			'name' => $user->getName(),
			'documentid' => $user->identificacion_usuario,
			'email' => $user->correo_electronico,
			'address' => $user->direccion_usuario,
			'cellphone' => $user->movil_usuario
		];
		$data['purchaser'] = $purchaser;

		return view('layout.document.layout', ['payment' => $data]);
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
		if( $request->has('token') ) {
			$user = $request->user();
			$institution = $user->institucion();

			// check out if the payment is a subscription or another charges type
			if( $request->has('course') ) {

				try {
					$institution->subscription()->create($request->token['id']);

					$optsPayment = [
						'source' => $request->token['id'],
						'receipt_email' => $request->purchaser_email,
						'currency' => 'usd',
						'description' => ''
					];
					$charge = $institution->charge($request->pricing, $optsPayment);

					if( !isset($request->pricing) || !$charge ) {
						throw new \Exception("Error performecing the charge", 1);

					}else {
						return response()->json(['success' => true, 'charge' => $charge->outcome]);
					}

				}catch(\Exception $e) {
					Log::error( $e->getMessage() );
					return response()->json(['success' => false, 'errors' => 'No se pudo realizar el pagó.']);
				}

			}else {

				$institution->subscription('plan_anual')->create($request->token['id'], [
					'email' => $request->purchaser_email
				]);
			}
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
	 * Display pricing.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function pricing()
	{
		// Prepare data
		$advantages = BeneficioPlan::getAdvantages();
		$plans = Plan::getPlans();

		return view('public.payments.pricing', compact('advantages', 'plans'));
	}

	public function reserve()
	{
		return view('public.payments.reserve');
	}
}
