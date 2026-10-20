<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use TuProyecto;

use Request, Response, App, Lang, Log, Input, URL, File, Image;

use App\Adjunto;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class FileController extends Controller {

    /**
     * Instantiate a new FileController instance.
     */
    public function __construct()
    {
       $this->middleware('auth');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	/**
	 * Cropping resource.
	 *
	 * @return Response
	 */
	public function crop()
	{
		if (Request::ajax()) {
			Log::info("--- CROP CALLED ---", Input::all());
			try {
				// Output file
				$output_file_path = sprintf('%s/temp/%s', public_path(), rand().'.jpg');
				$file_name = rand().'.jpg';

				if(Input::has('file_name'))
				{
					switch (Input::get('crop_type')) {
						case 'name':
						case 'temp':
							// Local file
							$input_file_path = sprintf('%s/temp/%s', public_path(), Input::get('file_name'));
							if(!File::exists($input_file_path)) {
								throw new \Exception('file to crop did not found');
							}
							// open file a image resource
							$manager = new ImageManager(new Driver());
							$img = $manager->decodePath($input_file_path);
							break;

						case 'url':
							// Remote Input
							$input_file_path = sprintf('%s/temp/%s', public_path(), rand().'.'.Input::get('file_type'));
							copy(Input::get('file_name'), $input_file_path);

							// open file a image resource
							$manager = new ImageManager(new Driver());
							$img = $manager->decodePath($input_file_path);
							break;

						default:
							throw new \Exception('crop type is undefined');
					}
				}else{
					throw new \Exception('file to crop is undefined');
				}

				// crop image
				$img = $img->crop( intval(Input::get('w')), intval(Input::get('h')), intval(Input::get('x')), intval(Input::get('y')) );
				if(Input::has('targ_w') && Input::has('targ_h')) {
					// now you are able to resize the instance
					$img = $img->resize(intval(Input::get('targ_w')), intval(Input::get('targ_h')));
				}
				$img->save($output_file_path, 90);

				// Upload File
				$result = Adjunto::upload($output_file_path, $file_name, 'image');
				if(is_object($result) && $result->success === true) {
					if(File::exists($input_file_path)) {
						File::delete($input_file_path);
					}
					if(File::exists($output_file_path)) {
						File::delete($output_file_path);
					}
					Log::info("--- CROP SUCCESS ---", ['file_path' => $result->file_path]);
					return Response::json(['success' => true, 'file_path' => $result->file_path]);
				}
			}catch (\Throwable $e) {
				Log::error((string) $e);
				return Response::json(['success' => false, 'errors' => $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine()]);
			}
		}
    	App::abort(404);
	}

	/**
	 * Temporary resource.
	 *
	 * @return Response
	 */
	public function temp()
	{
		if (Request::ajax()) {
			if (Request::hasFile('file'))
			{
				try {
					$destinationPath = public_path().'/temp';

					$file = Input::file('file');
					$fileName = rand().'.'.$file->getClientOriginalExtension();
					$mimeType = $file->getMimeType();

					list($width, $height) = getimagesize($file->getRealPath());

					$file->move($destinationPath, $fileName);
					$file_path = sprintf('%s/temp/%s', URL::to('/'), $fileName);

					return Response::json(['success' => true, 'file_name' => $fileName, 'file_path' => $file_path, 'file_type' => $mimeType,
						'file_width' => $width, 'file_height' => $height]);
				} catch (\Exception $e) {
					Log::error($e->getMessage());
					return Response::json(['success' => false, 'errors' => Lang::get('app.exception')]);
				}
			}
			return Response::json(['success' => false, 'errors' => Lang::get('app.exception')]);
		}
    	App::abort(404);
	}

	/**
	 * Temporary resource.
	 *
	 * @return Response
	 */
	public function upload()
	{
		if (Request::ajax()) {
			if (Request::hasFile('file')) {
				try {
					$file = Request::file('file');
					$mimeType = $file->getMimeType();
					list($fileType) = explode('/', $mimeType);
					$file_name = $file->getClientOriginalName();
					$file_path = $file->getRealPath();
					$document_type = 'document';

					// check out if is image for resize it
					if($fileType === 'image') {
						$file_path = sprintf('%s/temp/%s', public_path(), rand().'.jpg');
						$file_name = rand().'.jpg';
						$manager = new ImageManager(new Driver());
						$img = $manager->decodePath($file->getRealPath());
						$document_type = 'image';

						if(Input::has('targ_w') || Input::has('targ_h')) {
							$img = $img->scaleDown(Input::get('targ_w'), Input::get('targ_h'));
						}
						$img->save($file_path, 85);
					}

					$result = Adjunto::upload($file_path, $file_name, $document_type);
					if(is_object($result) && $result->success === true) {
						if(File::exists($file_path)) {
							File::delete($file_path);
						}
					}
					return Response::json(['success' => true, 'file_path' => $result->file_path]);
				} catch (\Exception $e) {
					Log::error($e->getMessage());
                    return Response::json(['success' => false, 'errors' => Lang::get('app.exception')]);
				}
		    }
	    }
	}
}
