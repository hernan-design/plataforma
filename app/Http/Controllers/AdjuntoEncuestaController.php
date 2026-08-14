<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\AdjuntoRespuestaEncuesta, App\Adjunto;

use Log;

class AdjuntoEncuestaController extends Controller
{
    /**
     * Instantiate a new AdjuntoEncuestaController instance.
     */
    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            return response()->json(AdjuntoRespuestaEncuesta::getAttachedAnswer($request));
        }
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            $data = $request->all();
            try {
                if ($request->hasFile('file'))
                {
                    $file = $request->file('file');
                    $result = Adjunto::upload($file->getRealPath(), $file->getClientOriginalName(), 'document');
                    if(is_object($result) && $result->success === true) {
                        return response()->json(['success' => true, 'direccion_adjunto' => $result->file_path]);
                    }
                }
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }catch(\Exception $e) {
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
}
