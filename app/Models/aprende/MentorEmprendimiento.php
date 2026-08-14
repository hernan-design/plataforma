<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

use TuProyecto;

use DB, Validator;

class MentorEmprendimiento extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'aprende.mentor_emprendimiento';

	public $incrementing = false;

	public $timestamps = false;

	public function isValid($data)
    {
        $rules = array(
            'codigo_usuario' => 'required',
            'codigo_proyecto' => 'required'
        );

     	$validator = Validator::make($data, $rules);
        if ($validator->passes()) {
     		return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getMentorEntrepreneur($user, $project){

        return MentorEmprendimiento::select('mentor_emprendimiento.*')
            ->where('codigo_usuario', '=', $user)
            ->where('codigo_proyecto', '=', $project)
            ->where('codigo_estado', '=', Estado::getState('confirm'))
            ->first();
    }

	public static function getMentoringStartup($project)
    {
    	$query = MentorEmprendimiento::query();
        $query->select('mentor_emprendimiento.codigo_usuario as key',DB::raw("(CASE usuario.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '') ELSE nombre_usuario END) as value"));
        $query->join('seguridad.usuario', 'mentor_emprendimiento.codigo_usuario', '=', 'usuario.codigo_usuario');
        $query->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');

        $query-> where('mentor_emprendimiento.codigo_proyecto',$project);
        $query-> where('mentor_emprendimiento.codigo_estado', '=', Estado::getState('active'));
        $query->orderby('value','asc');

        return TuProyecto::encryptList($query->get());
    }

}
