<?php

namespace App;

use App\Estado;
use Illuminate\Database\Eloquent\Model;

use App\RegistroSesion;
use Auth, DB, Log;
use TuProyecto;

class Voucher extends Model
{
    /**
	 * The database table used by the model
	 *
	 * @var string
	 */
    protected $table = 'core.voucher';

   	protected $primaryKey = 'codigo_voucher';
	
	public $timestamps = false;

	/**
	 * Voucher data detail from id.
	 */
	public static function getUrlEncuestaGeneral()
	{
		$query = Voucher::query();
		$query->select('encuesta.url_encuesta','voucher.codigo_estado','voucher.codigo_voucher','voucher.codigo_encuesta','voucher.fecha_voucher','detalle_voucher.codigo_usuario');

		$query->join('core.detalle_voucher', function($join) {
			$join->on('detalle_voucher.codigo_voucher', '=', 'voucher.codigo_voucher')
				->where('detalle_voucher.codigo_usuario', '=', Auth::user()->codigo_usuario)
				->where('detalle_voucher.codigo_estado', '=', Estado::getState('finalized'));
		});

		$query->join('core.encuesta', function($join) {
			$join->on('encuesta.codigo_encuesta', '=', 'voucher.codigo_encuesta')
				 ->where('encuesta.codigo_institucion', '=', RegistroSesion::getInstitution())
				 ->where('encuesta.codigo_estado', '=', Estado::getState('active'));
		});

		$query->where('voucher.codigo_institucion', '=', RegistroSesion::getInstitution());
		$query->where('voucher.codigo_estado', '=', Estado::getState('active'));
        $query->orderBy('voucher.fecha_voucher','desc');
             
        return $query->first();
        

	}


	/**
	 * Voucher data detail from id.
	 */
	public static function isVoucherFinalized()
	{
		$query = Voucher::query();
		$query->select('detalle_voucher.codigo_estado as codigo_estado');

		$query->join('core.detalle_voucher', function($join) {
			$join->on('detalle_voucher.codigo_voucher', '=', 'voucher.codigo_voucher')
				->where('detalle_voucher.codigo_usuario', '=', Auth::user()->codigo_usuario);
		});

		$query->join('core.encuesta', function($join) {
			$join->on('encuesta.codigo_encuesta', '=', 'voucher.codigo_encuesta')
				->where('encuesta.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('encuesta.codigo_estado', '=', Estado::getState('active'));
		});

		$query->where('voucher.codigo_institucion', '=', RegistroSesion::getInstitution());
		$query->where('voucher.codigo_estado', '=', Estado::getState('active'));
		$query->orderBy('voucher.fecha_voucher','desc');
		$voucher = $query->first();
      
		if($voucher instanceof Voucher) {
			return $voucher->codigo_estado === Estado::getState('finalized');
		}
          
		return false;
	}

	/**
	 * Build  Buys User.
	 */
	public static function buildVoucherUser($voucher)
	{
		$object = new \stdClass();

		$object->codigo_voucher = $voucher->codigo_compra ? TuProyecto::encryptSrcParams([$voucher->codigo_compra]) : '';
		$object->codigo_institucion =$voucher->codigo_institucion ?  TuProyecto::encryptSrcParams([$voucher->codigo_institucion]) : '';
		$object->codigo_usuario = $voucher->codigo_usuario ? TuProyecto::encryptSrcParams([$voucher->codigo_usuario]) : '';
		$object->url_encuesta = $voucher->url_encuesta;
		$object->codigo_encuesta = $voucher->url_encuesta;
		$object->fecha_voucher= $voucher->fecha_voucher;


		return $object;
	}


}
