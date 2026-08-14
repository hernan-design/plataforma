<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth, DB;

class DetalleVoucher extends Model{

    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.detalle_voucher';

   	protected $primaryKey = 'codigo_detalle_voucher';

	public $timestamps = false;

	public static function getBalanceVoucher()
	{
		return DetalleVoucher::where('codigo_usuario', '=', Auth::user()->codigo_usuario)
			->where('codigo_estado', '=',Estado::getState('active'))
			->sum('saldo_detalle_voucher');
	}

	public static function getDetailVoucher()
	{
		$query = DetalleVoucher::query();
		$query->select('saldo_detalle_voucher', DB::raw("(detalle_voucher.valor_detalle_voucher - detalle_voucher.saldo_detalle_voucher) as valor_total_acuerdos"));
		$query->where('codigo_usuario', '=', Auth::user()->codigo_usuario);
		return $query->first();
	}
}
