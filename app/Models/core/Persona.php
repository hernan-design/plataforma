<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use TuProyecto;

use Validator, Input, Auth, DB;

class Persona extends BaseModel
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.persona';

    protected $primaryKey = 'codigo_persona';
       

   	public $timestamps = false;

    protected $fillable = ['primer_apellido_persona', 'segundo_apellido_persona', 'genero_persona', 'estado_civil_persona', 'codigo_nivel_educacion', 'codigo_profesion_persona', 'codigo_ocupacion_persona', 'jefe_hogar', 'discapacidad', 'codigo_tipo_vivienda', 'codigo_estrato', 'codigo_lista_ocupacion', 'codigo_autodenominacion', 'codigo_grupo_poblacional', 'codigo_grupo_comunitario', 'codigo_grupo_social', 'codigo_sector_trabajo', 'cor_codigo_ciudad', 'codigo_nivel_idioma', 'codigo_especialidad', 'forma_ayuda_mentoria', 'codigo_especialidad_destacada'];

    /**
	 * The attributes nulleables from the model.
	 *
	 * @var array
	 */
    protected $appends = ['codigo_especialidad_destacada'];
       
    /**
	 * The attributes nulleables from the model.
	 *
	 * @var array
	 */
    protected $nullable = ['estado_civil_persona', 'jefe_hogar', 'discapacidad', 'codigo_tipo_vivienda', 'codigo_estrato', 'codigo_lista_ocupacion', 'codigo_autodenominacion', 'codigo_grupo_poblacional', 'codigo_grupo_comunitario', 'codigo_grupo_social', 'codigo_sector_trabajo', 'cor_codigo_ciudad', 'codigo_nivel_idioma'];
    
    /**
	 * Homeboss status
	 *
	 * @var array
	 */
    public static $homeboss = ['true' => 'Sí', 'false' => 'No'];
     
    /**
	 * Disability status
	 *
	 * @var array
	 */
 	public static $disability = ['true' => 'Sí', 'false' => 'No'];

	public function isValid($data)
	{
		$rules = [
			'primer_apellido_persona' => 'max:250'
		];

		$validator = Validator::make($data, $rules);
		if ($validator->passes()) {
			return true;
		}
		$this->errors = $validator->errors();
		return false;
	}

	public static function getMentorsList()
   	{
   		$mentors = [];
		$query = Usuario::query();
		$query->select('persona.codigo_persona', 'usuario.codigo_usuario', 'usuario.experiencia_usuario','usuario.tipo_usuario','persona.forma_ayuda_mentoria', 'nombre_ciudad', 'nombre_pais','nombre_especialidad','imagen_usuario', 'nickname_usuario', DB::raw("(CASE usuario.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '') ELSE nombre_usuario END) as nombre_usuario"), DB::raw('(CASE WHEN rol_usuario.role_id IS NOT NULL THEN true ELSE false END) AS mentor'));

		// User Mentor
		$query->join('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');
		$query->leftJoin('core.especialidad', 'persona.codigo_especialidad', '=', 'especialidad.codigo_especialidad');
        $query->join('seguridad.rol_usuario', 'persona.codigo_usuario', '=', 'rol_usuario.user_id');
        
        //

        $query->join('core.usuario_institucion', function($join) {
            $join->on('usuario_institucion.codigo_usuario', '=', 'usuario.codigo_usuario')
                ->where('usuario_institucion.codigo_institucion', '=', RegistroSesion::getInstitution());
        });
        $query->join('seguridad.aceptacion_terminos', function($join) {
            $join->on('aceptacion_terminos.codigo_usuario_institucion', '=', 'usuario_institucion.codigo_usuario_institucion')
                ->where('usuario_institucion.codigo_institucion', '=', RegistroSesion::getInstitution());
        });
        $query->join('param.version_terminos','version_terminos.codigo_version_terminos','aceptacion_terminos.codigo_version_terminos');
        $query->join('param.terminos_condiciones', function($join) {
            $join->on('terminos_condiciones.codigo_terminos_condiciones', '=', 'version_terminos.codigo_terminos_condiciones')
                ->where('terminos_condiciones.tipo_terminos', '=', TerminosCondiciones::getTypeTerms('mentoring'));
        });

		// City / Country
		$query->leftJoin('core.ciudad', 'usuario.codigo_ciudad', '=', 'ciudad.codigo_ciudad');
		$query->leftJoin('core.pais', 'ciudad.codigo_pais', '=', 'pais.codigo_pais');

		$query->where('rol_usuario.role_id', Rol::getRole('mentor'));
		$query->where('rol_usuario.codigo_institucion', RegistroSesion::getInstitution());
		$query->where('rol_usuario.codigo_estado', Estado::getState('active'));
		
		if(Input::has('q') &&  Input::get('q') !== '') {
			$q = Input::get('q');
			$query->where( function($query) use ($q) {
				$query->whereRaw("nombre_usuario ilike '%".$q."%'");
				$query->orWhereRaw("nickname_usuario ilike '%".$q."%'");
				$query->orWhereRaw("persona.primer_apellido_persona ilike '%".$q."%'");
				$query->orWhereRaw("persona.segundo_apellido_persona ilike '%".$q."%'");
			});
		}
       
 		if(Input::has('specialty')) {
 			$specialty = (int) Input::get('specialty');

 			$query->where(function($query) use ($specialty) {
	         	$query->where('persona.codigo_especialidad', '=', $specialty);
	            $query->orWhere(function($query) use($specialty){

                	$query->whereIn('usuario.codigo_usuario', function($query) use($specialty){
					    $query->select('especialidad_usuario.codigo_usuario')
						    ->from('core.especialidad_usuario')
						    ->whereRaw('especialidad_usuario.codigo_usuario = usuario.codigo_usuario')
						    ->where('especialidad_usuario.codigo_especialidad', $specialty)
						    ->where('especialidad_usuario.codigo_estado', Estado::getState('active'));
					})->get();
	            });
            });
    	}

    	if(Input::has('sectors')) {
			$sectors = (int) Input::get('sectors');
 			$query->join('core.sector_economico_persona', function($query)  use ($sectors) {
		        $query->on('persona.codigo_persona', '=', 'sector_economico_persona.codigo_persona')
		            ->where('sector_economico_persona.codigo_sector_economico', '=', $sectors);
		    });
    	}

    	if(Input::has('level')) {
			$level = (int) Input::get('level');
    		$query->join('core.etapa_mentoria', function($query)  use ($level) {
		        $query->on('usuario.codigo_usuario', '=', 'etapa_mentoria.codigo_usuario')
		            ->where('etapa_mentoria.codigo_etapa_proyecto', '=', $level);
		    });
		}
		
    	if(Input::has('city')) {
    		$query->where('ciudad.codigo_ciudad', '=', Input::get('city'));    
    	}

		// Get total posts
		$total_entries = $query->count();

   		$query->orderBy('persona.codigo_persona','desc');
		// Get posts
		$data = $query->skip(Input::get('offset'))->take(Input::get('limit'))->get();

		if(count($data) > 0) {
			foreach ($data as $mentor) {
				$mentors[] = Usuario::buildUser($mentor);
			}
		}

		$response = new \stdClass();
		$response->total_entries = $total_entries;
		$response->items = $mentors;
   		return $response;
   	}

   	/**
	 * Defining Relations
	*/
	public function usuario()
    {
        return $this->hasOne('App\Usuario','codigo_usuario','codigo_usuario');
    }

    /**
     * acceder al valor de codigo_especialdiad usando el alias codigo_especialidad destacada.
     *
     * @return int
     */
    public function getCodigoEspecialidadDestacadaAttribute($value)
    {
        return $this->attributes['codigo_especialidad'];
    }

    /**
     * Set el valor codigo_esepcialidad_destacada
     *
     * @param  int  $value
     * @return void
     */
    public function setCodigoEspecialidadDestacadaAttribute($value)
    {
        $this->attributes['codigo_especialidad'] = $value;
    }

}
