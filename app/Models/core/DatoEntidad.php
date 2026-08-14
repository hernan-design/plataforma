<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\UsuarioInstitucion;
class DatoEntidad extends Model
{
   	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.dato_entidad';

	protected $primaryKey = 'codigo_dato_entidad';

	public $timestamps = false;

	/**
	 * Obtiene datos de entidad mediante el codigo_usuario_institucion.
	 *
	 * @access public
	 * @static function
	 * @param int $id_institution_user
	 * @return object $data
	 */
	public static function getDataEntity($id_institution_user)
	{
		$query = UsuarioInstitucion::query();
		$query->join('core.dato_entidad as data_entity',
			'core.usuario_institucion.codigo_usuario_institucion', 'data_entity.codigo_usuario_institucion' );
		$query->join('core.categoria_proyecto', 'categoria_proyecto.codigo_categoria_proyecto', 'data_entity.codigo_categoria_proyecto');
		$query->where('usuario_institucion.codigo_usuario', $id_institution_user);
		$data = $query->first();
		return $data;
	}
}
