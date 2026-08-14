<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\RegistroSesion;
use Log;

class SearchController extends Controller
{
    /**
     * Instantiate a new SearchController instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $client = new \AlgoliaSearch\Client(config('algolia.id'), config('algolia.search_api_key'));
        $index = $client->initIndex("content");

        $numericFilters = [ '_institutions='.RegistroSesion::getInstitution() ];
		if( $request->has('stage') && !empty($request->stage) ){
			array_push($numericFilters, "_stagesid=$request->stage");
		}


		$facetFilters = [ $request->has('type') ? "type:$request->type" : '' ];

		if( $request->has('category_program') && !empty($request->category_program) ){
			array_push($numericFilters, "_categoriesid=$request->category_program");
		}

		if( $request->has('entity') && !empty($request->entity) ){
			array_push($numericFilters, "entity=$request->entity");
		}

		if( $request->has('page') && !empty($request->page) ){
			$page = (int) $request->page;
		}


        $response = $index->search(($request->has('search') ? $request->search : ''), [
            'numericFilters' => $numericFilters,
            'facetFilters' =>$facetFilters,
			'page' => $page ?? 0,
            'facets' => ['type'],
            'distinct'=>6,
            'hitsPerPage'=>160
        ]);


		$answer = [];
		foreach ($response['hits'] as $hit){

			if(!array_key_exists( $hit['type'] , $answer ) )
			{
				$answer[ (string) $hit['type']] = [];

			}

				$answer[(string) $hit['type']][] =  $hit;

		}

		$answer['total_count'] = $response['nbHits'];

		$answer['facets'] = $response['facets'];

		// Add the count of facets to obtain the number of total results
		$total = 0;
		if(isset($response['facets']['type']) && is_array($response['facets']['type']) && !empty($response['facets']['type'])) {
			foreach ($response['facets']['type'] as $facet => $value) {
				$total += (int)$value;
			}
		}

		if($total > 0) {
			$answer['total_count'] = $total;
		}


		return view('public.search.main', [ 'answer' =>  $answer ]);
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
