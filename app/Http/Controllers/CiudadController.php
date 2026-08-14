<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use TuProyecto;

use DB, Lang, App, Log, View, Auth, Input;

use App\Ciudad, App\Estado, App\RegistroSesion;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CiudadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
			$data = [];

			if($request->dep == "true" || ($request->dataId && !is_numeric($request->dataId))){
				$query = Ciudad::query();
				$query->select(DB::raw('DISTINCT distrito_ciudad as id'),
					DB::raw("trim( COALESCE(initcap(distrito_ciudad), '') || ' - ' || COALESCE(pais.codigo_pais, '')) as text") );
				$query->join('core.pais', 'ciudad.codigo_pais', '=', 'pais.codigo_pais');
				$query->join('core.pais_institucion', function($join) {
					$join->on('pais.codigo_pais', '=', 'pais_institucion.codigo_pais')
					->where('pais_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
					->where('pais_institucion.codigo_estado', '=', Estado::getState('active'));
				});

				if(!empty($request->q)) {
					$query->whereRaw("distrito_ciudad ilike '%".$request->q."%'");
				}elseif ($request->dataId) {
					$query->whereRaw("distrito_ciudad ilike '%".$request->dataId."%'");
				}else{
					$query->whereNotNull('distrito_ciudad');
					$query->whereRaw("distrito_ciudad != ''");
					$query->where('ciudad.codigo_estado', Estado::getState('active'));
                    $query->orderby('text','asc');
					$data = $query->limit( 50 )->get();
					return response()->json($data);
				}

				$data[] = $query->first();
			}else{
				$query = Ciudad::query();
				$query->select('codigo_ciudad as id', DB::raw("trim(initcap(nombre_ciudad) || ' - ' || COALESCE(initcap(distrito_ciudad), '') || ' - ' || COALESCE(pais.codigo_pais, '')) as text"));
				$query->join('core.pais', 'ciudad.codigo_pais', '=', 'pais.codigo_pais');

				$query->join('core.pais_institucion', function($join) {
					$join->on('pais.codigo_pais', '=', 'pais_institucion.codigo_pais')
					->where('pais_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
					->where('pais_institucion.codigo_estado', '=', Estado::getState('active'));
				});

				if($request->has('department')){
					$query->whereRaw("distrito_ciudad ilike '%".$request->department."%'");
				}

				if($request->has('id') ){
					$query->where("ciudad.codigo_ciudad", "=", $request->id);
				}

				if($request->has('q')) {
					$query->where( function($query) use($request) {
						$query->whereRaw("nombre_ciudad ilike '%".$request->q."%'");
						$query->orWhereRaw("distrito_ciudad ilike '%".$request->q."%'");
					});
				}

				if($request->has('dataId')) {
					$query->where("ciudad.codigo_ciudad", "=", $request->dataId);
				}

				$query->whereNotNull('distrito_ciudad');
				$query->whereRaw("distrito_ciudad != ''");
				$query->where('ciudad.codigo_estado', Estado::getState('active'));

                $query->orderby('nombre_ciudad','asc');
				$query->orderby('distrito_ciudad','asc');
				$data = $query->limit( 50 )->get();
				$data = $query->get();
			}

            return response()->json($data);
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
}
