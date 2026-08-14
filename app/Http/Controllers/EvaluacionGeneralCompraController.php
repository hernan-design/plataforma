<?php

namespace App\Http\Controllers;

use App\Institucion;
use App\RegistroSesion;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use TuProyecto;

use DB, Log, Auth, Lang, Validator;

use App\Compra, App\EvaluacionCompra, App\ItemEvaluacionCompra, App\RespuestaEvalCompra, App\Estado;

class EvaluacionGeneralCompraController extends Controller
{

    /**
     * Instantiate a new EvaluacionCompraController instance.
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

		return view('public/marketplace/main');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $tab
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function evaluate()
    {

        return view('public/marketplace/main');
    }
}
