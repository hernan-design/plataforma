<?php

namespace App\Http\Controllers;

use App\AcuerdoCompra;
use App\Adjunto;
use App\TipoAdjunto;
use Illuminate\Http\Request;
use TuProyecto;
use DB, Log;

class AdjuntoAcuerdoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
        	DB::beginTransaction();
        	try	{
				// Decrypt src-params
				list($codigo_compra) = TuProyecto::decryptSrcParams($request->codigo_compra);
				if(!$codigo_compra || !is_numeric($codigo_compra)) {
					Log::error(sprintf('%s:%s', 'AdjuntoAcuerdo:index', 'el codigo de compra no es valido'));
					abort(404);
				}

				if ($request->has('factura')) {
					DB::commit();
					return response()->json(AcuerdoCompra::getAttachmentBill($codigo_compra));
				} else if ($request->has('certificate')) {
					DB::commit();
					return response()->json(AcuerdoCompra::getAttachmentCertificate($codigo_compra));
				} else {
					DB::commit();
					return response()->json(AcuerdoCompra::getAttachment($codigo_compra));
				}
			} catch(\Exception $e) {
				DB::rollback();
				Log::error(sprintf('%s:%s', 'AdjuntoAcuerdo:index', $e->getMessage()));
				return response()->json(['success' => false, 'errors' => trans('app.exception')]);
			}
		}
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
    	if ($request->ajax()) {
			DB::beginTransaction();
    		try {
				$response = new \stdClass();
				// Decrypt src-params
				list($codigo_compra) = TuProyecto::decryptSrcParams($request->codigo_compra);
				if(!$codigo_compra || !is_numeric($codigo_compra)) {
					Log::error(sprintf('%s:%s', 'AdjuntoAcuerdo:store', 'el codigo de compra no es valido'));
					$response->uuid = false;
					$response->success = false;
					abort(404);
				}

				if ($request->hasFile('file')) {
					$file = $request->file('file');
					$result = Adjunto::upload($file->getRealPath(), $file->getClientOriginalName(), 'document');
					if(is_object($result) && $result->success === true) {
						$attachment = new Adjunto();
						$attachment->codigo_tipo_adjunto = TipoAdjunto::getTypeAttached('document');
						$attachment->direccion_adjunto = $result->file_path;
						$attachment->nombre_adjunto = $file->getClientOriginalName();
						$attachment->fecha_adjunto = date('Y-m-d H:i:s');
						$attachment->save();

						if (!$request->has('certificate')) {
							AcuerdoCompra::where('codigo_compra', $codigo_compra)
								->update(['codigo_adjunto' => $attachment->codigo_adjunto]);
						} else {
							if (isset($request->certificate)) {
								AcuerdoCompra::where('codigo_compra', $codigo_compra)
									->update(['camara_comercio_asesor' => $attachment->codigo_adjunto]);
							}
						}
						$response->uuid= $request->codigo_compra;
						$response->direccion_adjunto = $result->file_path;
						$response->codigo_adjunto = $attachment->codigo_adjunto;
						$response->success = true;
					}
				}

				DB::commit();
				return response()->json($response);
			} catch (\Exception $e) {
				DB::rollback();
				Log::error(sprintf('%s:%s', 'AdjuntoAcuerdo:store', $e->getMessage()));
				return response()->json(['success' => false, 'errors' => trans('app.exception')]);
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
    public function destroy(Request $request, $id)
    {
		if ($request->ajax()) {
			DB::beginTransaction();
			try {

				// Decrypt src-params
				list($codigo_compra) = TuProyecto::decryptSrcParams($request->codigo_compra);
				if(!$codigo_compra || !is_numeric($codigo_compra)) {
					Log::error(sprintf('%s:%s', 'AdjuntoAcuerdo:store', 'el codigo de compra no es valido'));
					abort(404);
				}
				AcuerdoCompra::where('codigo_compra', $codigo_compra)
					->update(['codigo_adjunto' => null]);

				DB::commit();
				return response()->json(['success' => true]);
			} catch (\Exception $e) {
				DB::rollback();
				Log::error(sprintf('%s:%s', 'AdjuntoAcuerdo:destroy', $e->getMessage()));
				return response()->json(['success' => false, 'errors' => trans('app.exception')]);
			}

		}
    }
}
