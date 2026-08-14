<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioEmpresario extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.usuario_empresario';

	protected $primaryKey = 'codigo_usuario_empresario';

	public $timestamps = false;

	protected $fillable = array('nombre_usuario_empresario', 'cargo_usuario_empresario', 'correo_usuario_empresario');

   	public function isValid($data)
    {
        $rules = array(
			'nombre_usuario_empresario' => 'required',
			'cargo_usuario_empresario' => 'required',
			'correo_usuario_empresario' => 'required'
        );

     	$validator = Validator::make($data, $rules);
        if ($validator->passes()) {
     		return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
}
