<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Validator, TuProyecto, DB, Input, Auth;

class NotaUsuario extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'aprende.nota_usuario';

	protected $primaryKey = 'codigo_nota_usuario';

	public $timestamps = false;

   	protected $fillable = ['texto_nota_usuario'];
    
    public function isValid($data)
    {
        $rules = array(
            'texto_nota_usuario' => 'required|string'
        );

     	$validator = Validator::make($data, $rules);
        if ($validator->passes()) {
     		return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getNotesUser($course)
   	{
   		$notesuser = [];
		$query = NotaUsuario::query();
		$query->select('nota_usuario.codigo_nota_usuario', 'nota_usuario.texto_nota_usuario', 'nota_usuario.codigo_usuario', 'nota_usuario.codigo_curso', 'usuario.nickname_usuario', 'usuario.imagen_usuario', DB::raw("(CASE usuario.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '') ELSE nombre_usuario END) as nombre_usuario"));

		$query->join('core.estado', 'nota_usuario.codigo_estado', '=', 'estado.codigo_estado');

		// User Note
		$query->join('seguridad.usuario', 'nota_usuario.codigo_usuario', '=', 'usuario.codigo_usuario');
		$query->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');

		$query-> where('nota_usuario.codigo_curso', $course);
		$query-> where('nota_usuario.codigo_usuario', Auth::user()->codigo_usuario);
		$query-> where('nota_usuario.codigo_estado', Estado::getState('active'));

   		$query->orderBy('nota_usuario.fecha_hora_nota_usuario','asc');

		// Get total posts
		$total_entries = $query->get()->count();

		// Get posts
		$data = $query->skip(Input::get('offset'))->take(Input::get('limit'))->get();

		if(count($data) > 0) {
			foreach ($data as $noteuser) {
				$notesuser[] = NotaUsuario::buildNoteUser($noteuser);
			}
		}

		$response = new \stdClass();
		$response->total_entries = $total_entries;
		$response->items = $notesuser;
   		return $response;
   	}

	/**
	* Build NoteUser.
	*/
   	public static function buildNoteUser($post)
   	{
		$object = new \stdClass();
		$object->codigo_nota_usuario = TuProyecto::encryptSrcParams([$post->codigo_nota_usuario]);
		$object->codigo_usuario = TuProyecto::encryptSrcParams([$post->codigo_usuario]);
		$object->codigo_curso = TuProyecto::encryptSrcParams([$post->codigo_curso]);
		$object->texto_nota_usuario = $post->texto_nota_usuario;

		$object->nombre_usuario = $post->nombre_usuario;
		$object->imagen_usuario = $post->imagen_usuario;
		$object->nickname_usuario = $post->nickname_usuario;
		
		return $object;
   	}


   	public static function getDataUserNotes($noteuser)
   	{
   		$query = NotaUsuario::query();
		$query->select('nota_usuario.codigo_nota_usuario', 'nota_usuario.texto_nota_usuario', 'nota_usuario.codigo_usuario', 'nota_usuario.codigo_curso', 'usuario.nickname_usuario', 'usuario.imagen_usuario', DB::raw("(CASE usuario.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '') ELSE nombre_usuario END) as nombre_usuario"));

		// User UserNote
		$query->join('seguridad.usuario', 'nota_usuario.codigo_usuario', '=', 'usuario.codigo_usuario');
		$query->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');

		$query->where('nota_usuario.codigo_nota_usuario', '=', $noteuser);
		$query->where('nota_usuario.codigo_estado', '=', Estado::getState('active'));
		$query-> where('nota_usuario.codigo_usuario', Auth::user()->codigo_usuario);
		$query->orderBy('nota_usuario.fecha_hora_nota_usuario','asc');
		return $query->first();
   	}
   	

   	/**
	 * Defining Relations
	*/
	public function usuario()
    {
        return $this->hasOne('App\Usuario','codigo_usuario','codigo_usuario');
    }

    public function estado()
    {
        return $this->hasOne('App\Estado','codigo_estado','codigo_estado');
    }

}
