<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;
use Aws\S3\Exception\S3Exception;
use Auth, Config, App, AWS, Log;

class Adjunto extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.adjunto';

   	protected $primaryKey = 'codigo_adjunto';

   	public $timestamps = false;

	/**
	* Upload resource to S3.
	*
	* @param  file  $file
	* @return Response
	*/
	public static function upload($file_path, $file_name, $type)
	{
		if($file_path && $type) {
			try {
				$type = ($type == 'image') ? 'images' : 'documents';
				$s3 = AWS::createClient('s3');

				// Dynamic bucket
				$bucket = env('AWS_BUCKET_NAME', 'static-dev.tuproyecto.com');
				$key = sprintf('%s/%s/%s/%s-%s', $type, 'users', Auth::user()->codigo_usuario, date('YmdHis'), $file_name);

				// Upload file to S3
				if (env('APP_ENV') === 'local') {
					$local_path = sprintf('temp/%s-%s', date('YmdHis'), $file_name);
					copy($file_path, public_path($local_path));
					$result = ['ObjectURL' => url($local_path)];
				} else {
					$result = $s3->putObject([
						'Bucket' =>  $bucket,
						'Key'    =>  $key,
						'Body'   =>  fopen($file_path, 'rb'),
						'ACL'    => 'public-read'
					]);
				}

   				$response = new \stdClass();
				$response->success = true;
				$response->file_path = $result['ObjectURL'];
				return $response;
			} catch (S3Exception $e) {
				$errormsg = $e->getMessage();
				Log::error($errormsg);
				throw new \Exception($errormsg);
			}catch (\Exception $e) {
				$errormsg = $e->getMessage();
				Log::error($errormsg);
				throw new \Exception($errormsg);
			}
		}
		$errormsg = 'file is undefined';
		Log::error();
		throw new \Exception($errormsg);
	}
}
