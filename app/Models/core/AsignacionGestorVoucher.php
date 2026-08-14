<?php
/**
 * Modelo AsignacionGestorVoucher, relaciona usuarios (gestores voucher).
 * @author Harold Rodríguez <hartuproyecto@gmail.com>
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class AsignacionGestorVoucher extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.asignacion_gestores_voucher';

	protected $primaryKey = 'codigo_asignacion_gestor';
	/**
	 * Define relación belongsTo con modelo Usuario  y id codigo_usuario.
	 * @access public
	 */
    public function user()
    {
        return $this->belongsTo('App\Usuario', 'codigo_usuario');
    }
}