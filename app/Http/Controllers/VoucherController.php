<?php

namespace App\Http\Controllers;

use App\Compra;
use App\EntregableAcuerdo;
use App\Institucion;
use App\RegistroSesion;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use TuProyecto;

use DB, Log, Auth, Lang, Validator;

use App\Voucher, App\Estado;

class VoucherController extends Controller
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
	public function index(Request $request)
	{
		if ($request->ajax()) {

            $voucher = Voucher::getUrlEncuestaGeneral();
         
			if(!$voucher instanceof Voucher) {
                return response()->json(['success' => false, 'errors' => 'Voucher not found']);    
			}

			$response = Voucher::buildVoucherUser($voucher);


			return response()->json($response);
		}
		abort(404,'Voucher not found');
	}



}
