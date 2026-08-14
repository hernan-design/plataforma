<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

use Validator, TuProyecto, DB, Input, Auth;

class InscripcionCurso extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'aprende.inscripcion_curso';

   	protected $primaryKey = 'codigo_inscripcion_curso';

	public $timestamps = false;

	protected $fillable = array('codigo_curso');

   	public function isValid($data)
    {
        $rules = array(
            'codigo_curso' => 'required'
        );

     	$validator = Validator::make($data, $rules);
        if ($validator->passes()) {
     		return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getRegistrationCourse($course)
    {
        $registrations = [];
        $query = InscripcionCurso::query();
        $query->select('inscripcion_curso.codigo_usuario','inscripcion_curso.codigo_curso','usuario.nickname_usuario', 'usuario.imagen_usuario', DB::raw("(CASE usuario.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '') ELSE nombre_usuario END) as nombre_usuario"), 'ciudad.nombre_ciudad', 'pais.nombre_pais');

        $query->join('core.estado', 'inscripcion_curso.codigo_estado', '=', 'estado.codigo_estado');

        // User Registration
        $query->join('seguridad.usuario', 'inscripcion_curso.codigo_usuario', '=', 'usuario.codigo_usuario');
        $query->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');

        // City / Country
        $query->leftjoin('core.ciudad', 'usuario.codigo_ciudad', '=', 'ciudad.codigo_ciudad');
        $query->leftjoin('core.pais', 'ciudad.codigo_pais', '=', 'pais.codigo_pais');

        $query->where('inscripcion_curso.codigo_curso', $course);
        $query->where('inscripcion_curso.codigo_estado', Estado::getState('active'));
        $query->where('inscripcion_curso.codigo_institucion', RegistroSesion::getInstitution());

        $query->orderBy('inscripcion_curso.fecha_inscripcion_curso','asc');
        $query->orderBy('inscripcion_curso.hora_inscripcion_curso','asc');

        // Get total posts
        $total_entries = $query->get()->count();

        // Get posts
        $data = $query->skip(Input::get('offset'))->take(Input::get('limit'))->get();

        if(count($data) > 0) {
            foreach ($data as $registration) {
                $registrations[] = InscripcionCurso::buildUserRegistration($registration);
            }
        }

        $response = new \stdClass();
        $response->total_entries = $total_entries;
        $response->items = $registrations;
        return $response;
    }

    /**
    * Build Registration.
    */
    public static function buildUserRegistration($post)
    {
        $object = new \stdClass();
        $object->codigo_curso = TuProyecto::encryptSrcParams([$post->codigo_curso]);
        $object->codigo_usuario = TuProyecto::encryptSrcParams([$post->codigo_usuario]);

        $object->nombre_usuario = $post->nombre_usuario;
        $object->imagen_usuario = $post->imagen_usuario;
        $object->nickname_usuario = $post->nickname_usuario;

        $object->nombre_ciudad = $post->nombre_ciudad;
        $object->nombre_pais = $post->nombre_pais;

        $object->url_profile = $post->usuario->getProfileUrl();

        return $object;
    }

    public static function registrationCourse($course, $user)
    {
        return InscripcionCurso::where('codigo_curso', '=', $course)
            ->where('codigo_usuario', '=', $user)
            ->where('codigo_institucion', '=', RegistroSesion::getInstitution())
            ->where('codigo_estado', '=', Estado::getState('active'))
            ->first();
    }

    /**
     * Defining Relations
    */
    public function usuario()
    {
        return $this->hasOne('App\Usuario','codigo_usuario','codigo_usuario');
    }
}
