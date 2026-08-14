<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use TuProyecto;

use DB, Auth, Input, Validator;

use App\Models;

class RegistroFaseUsuario extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.registro_fase_usuario';

    protected $primaryKey = 'codigo_registro_fase_usuario';

	public $timestamps = false;


    public function isValid($data)
    {
        $rules = [
            'entity' => 'required'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getRegisterPhase($registro)
	{
		$query = RegistroFaseUsuario::query();
		$query->select('registro_fase_usuario.codigo_registro_fase_usuario', 'registro_fase_usuario.valor_asignacion_rfu', 'registro_fase_usuario.codigo_usuario','fase.codigo_evaluacion_emprendimiento', 'registro_fase_usuario.codigo_registro_convocatoria',
			DB::raw("(person.nombre_usuario || ' ' || COALESCE(creador.primer_apellido_persona, '') || ' ' || COALESCE(creador.segundo_apellido_persona, '')) as nombre_usuario_creador" ),
			DB::raw("(CASE usuario.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN usuario.nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '') ELSE usuario.nombre_usuario END) as nombre_usuario"),'convocatoria.codigo_convocatoria','observaciones_registro_fase_usuario', 'usuario.biografia_usuario', 'registro_convocatoria.fecha_registro_convocatoria', 'registro_convocatoria.hora_registro_convocatoria',
			DB::raw('(CASE  WHEN observaciones_registro_fase_usuario IS NULL THEN false ELSE true END) as documentado'), 'nombre_fase'
		);
		$query->join('core.fase', 'fase.codigo_fase', '=', 'registro_fase_usuario.codigo_fase');
		$query->join('core.registro_convocatoria', 'registro_fase_usuario.codigo_registro_convocatoria', '=', 'registro_convocatoria.codigo_registro_convocatoria');
		// User Program
		$query->join('seguridad.usuario', 'registro_fase_usuario.codigo_usuario', '=', 'usuario.codigo_usuario');
		$query->join('core.entidad', 'usuario.codigo_usuario', '=', 'entidad.codigo_usuario');
		$query->join('seguridad.usuario as person', 'entidad.seg_codigo_usuario', '=', 'person.codigo_usuario');
		$query->leftJoin('core.persona as creador', 'person.codigo_usuario', '=', 'creador.codigo_usuario');
		$query->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');
		$query->join('core.convocatoria', 'fase.codigo_convocatoria', '=', 'convocatoria.codigo_convocatoria');
		$query->join('core.convocatoria_institucion', function($join) {
			$join->on('convocatoria.codigo_convocatoria', '=', 'convocatoria_institucion.codigo_convocatoria')
				->where('convocatoria_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('convocatoria_institucion.codigo_estado', '=', Estado::getState('active'));
		});
		$query->where('registro_fase_usuario.codigo_registro_fase_usuario', $registro);
		$query->where('convocatoria.codigo_estado', Estado::getState('active'));
		return  $query->first();
	}

	public static function getParticipants(Convocatoria $program)
    {
        $participants = [];
        $query = Fase::query();

        // Dynamic query select
        $select = ['usuario.codigo_usuario', DB::raw("(CASE usuario.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '') ELSE nombre_usuario END) as nombre_usuario"), 'imagen_usuario', DB::raw('trim(lower(nickname_usuario)) as nickname_usuario'), 'profesion_usuario', 'nombre_ciudad', 'nombre_pais'];

        if(Auth::check()) {
            $select = array_collapse([ $select, [DB::raw(sprintf('%s %s', RedUsuario::$raw_friendship, 'as state_friendship'))] ]);
        }
        $query->select($select);

        switch ($program->codigo_orientacion_convocatoria) {
            case OrientacionConvocatoria::getOrientation('entity'):
                $query->join('core.registro_fase_usuario as registro' , 'fase.codigo_fase', '=', 'registro.codigo_fase');
            break;
            case OrientacionConvocatoria::getOrientation('user'):
                $query->join('core.registro_fase_usuario as registro', 'fase.codigo_fase', '=', 'registro.codigo_fase');
            break;
        }

        // User Program
        $query->join('seguridad.usuario', 'registro.codigo_usuario', '=', 'usuario.codigo_usuario');
        $query->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');

        $query->join('core.convocatoria', 'fase.codigo_convocatoria', '=', 'convocatoria.codigo_convocatoria');

        // City / Country
        $query->leftjoin('core.ciudad', 'usuario.codigo_ciudad', '=', 'ciudad.codigo_ciudad');
        $query->leftjoin('core.pais', 'ciudad.codigo_pais', '=', 'pais.codigo_pais');

        $query->join('core.convocatoria_institucion', function($join) {
            $join->on('convocatoria.codigo_convocatoria', '=', 'convocatoria_institucion.codigo_convocatoria')
                ->where('convocatoria_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
                ->where('convocatoria_institucion.codigo_estado', '=', Estado::getState('active'));
        });

        if(Auth::check()) {
            // State friendship
            $query->leftjoin('core.red_usuario as invitation', function($join) {
                $join->on('usuario.codigo_usuario', '=', 'invitation.seg_codigo_usuario')
                    ->where('invitation.codigo_usuario', '=', Auth::user()->codigo_usuario)
                    ->where('invitation.codigo_institucion', '=', RegistroSesion::getInstitution());
            });

            $query->leftjoin('core.red_usuario as answer', function($join) {
                $join->on('usuario.codigo_usuario', '=', 'answer.codigo_usuario')
                    ->where('answer.seg_codigo_usuario', '=', Auth::user()->codigo_usuario)
                    ->where('answer.codigo_institucion', '=', RegistroSesion::getInstitution());
            });
        }

        $query-> where('convocatoria.codigo_convocatoria', $program->codigo_convocatoria);
        $query-> where('registro.codigo_estado', Estado::getState('active'));
        $query-> where('convocatoria.codigo_estado', Estado::getState('active'));
        $query->orderBy('usuario.codigo_usuario','asc');

        // Get total posts
        $total_entries = $query->get()->count();

        // Get posts
        $data = $query->skip(Input::get('offset'))->take(Input::get('limit'))->get();

        if(count($data) > 0) {
            foreach ($data as $participant) {
                $participants[] = RegistroFaseUsuario::buildParticipant($participant);
            }
        }

        $response = new \stdClass();
        $response->total_entries = $total_entries;
        $response->items = $participants;
        return $response;
    }

    /**
    * Build ParticipantProgram.
    */
    public static function buildParticipant($partcipant)
    {
        $object = new \stdClass();
        $object->codigo_usuario = TuProyecto::encryptSrcParams([$partcipant->codigo_usuario]);
        $object->nombre_usuario = $partcipant->nombre_usuario;
        $object->imagen_usuario = $partcipant->imagen_usuario;
        $object->nickname_usuario = $partcipant->nickname_usuario;
        $object->profesion_usuario = $partcipant->profesion_usuario;
        $object->nombre_ciudad = $partcipant->nombre_ciudad;
        $object->nombre_pais = $partcipant->nombre_pais;
        $object->state_friendship = $partcipant->state_friendship;
        $object->srcparams = TuProyecto::encryptSrcParams([$partcipant->codigo_usuario]);

        $object->url_profile = $partcipant->usuario->getProfileUrl();
        $object->owner =  Auth::check() && Auth::user()->codigo_usuario == $partcipant->codigo_usuario ? true : false;

        return $object;
    }


    /**
	 * Defining Relations
	*/
	public function project()
    {
        return $this->hasOne('App\Usuario','codigo_usuario','codigo_usuario');
    }

}
