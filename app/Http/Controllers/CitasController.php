<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use TuProyecto;

use DB, Lang, App, Log, View, Auth, Input;

use App\Ciudad, App\Estado, App\RegistroSesion;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CitasController extends Controller
{


	/**
     * Instantiate a new ProyectoController instance.
     */
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['index']]);
		// $this->middleware('subscription', ['only' => ['create', 'showUrl']]);
		$this->middleware('subscription', ['only' => ['create']]);
		$this->middleware('intended', ['only' => ['index', 'showUrl']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(

	)
    {

		//Información para enviar al endpoint

		$identity = Auth::user()->identificacion_usuario;
		$ent = 'e442b5e49ceccc9a4fae477dd124f412';
		$name = Auth::user()->nombre_usuario;
		$last_name = Auth::user()->primer_apellido_usuario_v1." ".Auth::user()->segundo_apellido_usuario_v1;
		$email = Auth::user()->correo_electronico;
		$phone = Auth::user()->movil_usuario;
		$document_type = '1';

    // Datos del usuario a registrar
    $userData = [
        'identity' => $identity,
        'ent' => $ent,
        'name' => $name,
        'last_name' => $last_name,
        'email' => $email,
        'phone' => $phone,
        'document_type' => $document_type,
        'code' => ''
    ];

    // Endpoint para registrar usuario
    $url = 'https://doctorcloud.app/api/register';

    // Iniciar sesión cURL
    $ch = curl_init();

    // Establecer las opciones de la solicitud
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($userData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

	curl_setopt($ch, CURLOPT_VERBOSE, true);


    // Ejecutar la solicitud
    $response = curl_exec($ch);

    // Obtener el código de estado de la respuesta
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Cerrar la sesión cURL
    curl_close($ch);

    // Verificar el código de estado de la respuesta
    if ($statusCode == 200 || $response->status == "EXIST") {

		//Traer el historial de citas del usuario
		// Datos del usuario a registrar
		$userHistorial = json_encode([
			'ent' => $ent,
			'email' => $email,
		]);

		// Endpoint para registrar usuario
		$urlHistorial = 'https://doctorcloud.app/api/nextday';

		// Iniciar sesión cURL
		$chh = curl_init();

		// Establecer las opciones de la solicitud
		curl_setopt($chh, CURLOPT_URL, $urlHistorial);
		curl_setopt($chh, CURLOPT_POST, 1);
		curl_setopt($chh, CURLOPT_POSTFIELDS, $userHistorial);
		curl_setopt($chh, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($userHistorial))
		);
		curl_setopt($chh, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($chh, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($chh, CURLOPT_SSL_VERIFYHOST, false);

		curl_setopt($chh, CURLOPT_VERBOSE, true);


		// Ejecutar la solicitud
		$responseHistorial = curl_exec($chh);

		// Obtener el código de estado de la respuesta
		$statusCodeHistorial = curl_getinfo($chh, CURLINFO_HTTP_CODE);

		// Cerrar la sesión cURL
		curl_close($chh);

		// dd($statusCodeHistorial);
		 // Verificar el código de estado de la respuesta
		 if ($statusCodeHistorial == 200){
			$responseHistorial = json_decode($responseHistorial, true);
			$historialCitas = $responseHistorial["message"];

		// Obtener una lista de los valores 'id'
		$ids = array_column($historialCitas, 'id');

		// Ordenar $historialCitas en base a los valores 'id' de forma descendente
		array_multisort($ids, SORT_DESC, $historialCitas);


			// Usuario registrado correctamente, mostrar la vista
			return view('citas.index', compact('historialCitas', 'userData'));
		 }

    } else {
        // Ocurrió un error al registrar el usuario, redirigir
        return redirect()->back()->with('error', 'Error al registrar el usuario');
    }

		// return view('citas/index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
{
    // Datos para la solicitud en formato JSON
    $requestData = json_encode([
        'ent' => 'e442b5e49ceccc9a4fae477dd124f412'
    ]);

    // Endpoint para obtener la lista de tratamientos
    $url = 'https://doctorcloud.app/api/get_treatment';

    // Iniciar sesión cURL
    $ch = curl_init();

    // Establecer las opciones de la solicitud
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($requestData))
    );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

	curl_setopt($ch, CURLOPT_VERBOSE, true);

    // Ejecutar la solicitud
    $response = curl_exec($ch);

    // Obtener el código de estado de la respuesta
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Cerrar la sesión cURL
    curl_close($ch);
	// dd(json_decode($response, true), $response);
    // Verificar el código de estado de la respuesta
    if ($statusCode == 200) {
		$response = json_decode($response, true);
        // Decodificar la respuesta JSON
        $treatments = $response["message"];
		$sucursales = $response["address"];
		$name = Auth::user()->nombre_usuario;
		$last_name = Auth::user()->primer_apellido_usuario_v1." ".Auth::user()->segundo_apellido_usuario_v1;

        // Mostrar la vista con la lista de tratamientos
        return view('citas.agendar', compact('treatments', 'sucursales', 'name', 'last_name'));
    } else {
        // Ocurrió un error al obtener la lista de tratamientos, redirigir o mostrar un mensaje de error
        return redirect()->back()->with('error', 'Error al obtener la lista de tratamientos');
    }
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$tratamientoArray = explode(',', $request->tratamiento);

		// Obtener el segundo elemento del array, que es el texto deseado
		$tratamientoText = $tratamientoArray[1];
		$tratamientoCategory= $tratamientoArray[2];
		$tratamientoId = $tratamientoArray[0];
		// Datos para la solicitud en formato JSON
		$requestData = json_encode([
			'ent' => 'e442b5e49ceccc9a4fae477dd124f412',
			"email" => Auth::user()->correo_electronico,
			"date" => $request->date,
			"hour" => $request->hora,
			"typeRoom" => $request->tipoCita,
			"treatment"=> $tratamientoText,
			"duration" => 60,
			"comment" => "Creación consulta medica desde TuProyecto",
			"mode" => intval($request->tipoCita),
			"identity" => "",
			"category"=> $tratamientoCategory,
			"treatment_id" => $tratamientoId,
			"branchEntity" => intval($request->sucursal)
		]);


		// Endpoint para obtener la lista de tratamientos
		$url = 'https://doctorcloud.app/api/createDate';

		 // Iniciar sesión cURL
		 $ch = curl_init();

		 // Establecer las opciones de la solicitud
		 curl_setopt($ch, CURLOPT_URL, $url);
		 curl_setopt($ch, CURLOPT_POST, 1);
		 curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
		 curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			 'Content-Type: application/json',
			 'Content-Length: ' . strlen($requestData))
		 );
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		 curl_setopt($ch, CURLOPT_VERBOSE, true);

		 // Ejecutar la solicitud
		 $response = curl_exec($ch);

		 // Obtener el código de estado de la respuesta
		 $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		 // Cerrar la sesión cURL
		 curl_close($ch);

		 // dd(json_decode($response, true), $response);
		// Verificar el código de estado de la respuesta
		if ($statusCode == 200) {

			return json_decode($response, true);
		}
        //
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

	public function availability(Request $request)
    {
		// dd($request);
		$tratamientoArray = explode(',', $request->category);

		// Obtener el segundo elemento del array, que es el texto deseado
		$tratamientoText = $tratamientoArray[1];
		$tratamientoCategory= $tratamientoArray[2];
		$tratamientoId = $tratamientoArray[0];
		// Datos para la solicitud en formato JSON
		$requestData = json_encode([
			'ent' => 'e442b5e49ceccc9a4fae477dd124f412',
			"duration" => 60,
			"date" => $request->date,
			"category"=> $tratamientoCategory
		]);

		// Endpoint para obtener la lista de tratamientos
		$url = 'https://doctorcloud.app/api/availability';

		 // Iniciar sesión cURL
		 $ch = curl_init();

		 // Establecer las opciones de la solicitud
		 curl_setopt($ch, CURLOPT_URL, $url);
		 curl_setopt($ch, CURLOPT_POST, 1);
		 curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
		 curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			 'Content-Type: application/json',
			 'Content-Length: ' . strlen($requestData))
		 );
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		 curl_setopt($ch, CURLOPT_VERBOSE, true);

		 // Ejecutar la solicitud
		 $response = curl_exec($ch);

		 // Obtener el código de estado de la respuesta
		 $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		 // Cerrar la sesión cURL
		 curl_close($ch);

		 // dd(json_decode($response, true), $response);
		// Verificar el código de estado de la respuesta
		if ($statusCode == 200) {

			return json_decode($response, true);
		}
        //
    }
}
