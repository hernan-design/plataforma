<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request, App\RegistroSesion, App\EvaluacionItemEmprendimiento;
use AWS;

class AdjuntoEvaluacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $attached = EvaluacionItemEmprendimiento::getAttachedEval($request->codigo_item);

            if($attached instanceof EvaluacionItemEmprendimiento) {
                $attached_build = EvaluacionItemEmprendimiento::buildAttached($attached);
            }

            return response()->json($attached_build);
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
        if($request->ajax()) {
            $file = $request->file('file');
            $s3 = AWS::createClient('s3');

            // Dynamic bucket
            $bucket = env('AWS_BUCKET_NAME', 'static-dev.tuproyecto.com');
            if(!$s3->doesBucketExist($bucket)) {
                $s3->createBucket(['Bucket' => $bucket]);
            }

            $key = sprintf('%s/%s/%s/%s', 'documents', 'innpulsa', 'evaluations', $request->codigo_item.'_'.date('his').'_'.$file->getClientOriginalName());

            // Upload file to S3
            $result = $s3->putObject([
                'Bucket' =>  $bucket,
                'Key'    =>  $key,
                'Body'   =>  fopen($file->getRealPath(), 'rb'),
                'ACL'    => 'public-read'
            ]);

            $request->session()->put('_inst_evaluation_temp', $result['ObjectURL']);

            return response()->json(['success' => true, 'file_path' => $result['ObjectURL']]);
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
}
