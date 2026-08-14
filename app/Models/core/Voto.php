<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use TuProyecto, Lang, AWS, Log, URL, SendEmail, DB;

class Voto extends BaseModel
{
    protected $table = 'core.voto';

    protected $primaryKey = 'codigo_voto';

    public $timestamps = false;

	protected $fillable = ['codigo_estado', 'codigo_usuario_institucion', 'cor_codigo_usuario_institucion', 'fecha_voto', 'clase_voto', 'correo_electronico_voto', 'numero_celular_voto'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['numero_voto'];

    public static function classVote($term) {
        switch ($term) {
            case 'register':
               return 1;
            break;
            case 'not_register':
                return 2;
             break;
            default:
                return null;
            break;
        }
    }

    public static function userVote($entity, $user_institution, $mail, $number, $state) {

        if ($user_institution) {
			$query = Voto::query();
			$query->select('codigo_voto');
            $query->where('cor_codigo_usuario_institucion', '=', $user_institution->codigo_usuario_institucion);
			$query->where('codigo_usuario_institucion', '=', $entity);
			$query->where('numero_celular_voto', '=', $number);
			$query->Where('correo_electronico_voto', $mail);
			$query->where('codigo_estado', $state);
            return $query->first();
        } else {
			$query = Voto::query();
			$query->select('codigo_voto');
			$query->where('codigo_usuario_institucion', '=', $entity);
			$query->where('numero_celular_voto', '=', $number);
			$query->Where('correo_electronico_voto', $mail);
			$query->where('codigo_estado', $state);
            return $query->first();
        }
	}

	public static function userMailVoteValidate($entity, $mail) {
		$query = Voto::query();
		$query->select('codigo_voto');
		$query->where('codigo_usuario_institucion', '=', $entity);
		$query->Where('correo_electronico_voto', $mail);
		$query->where('codigo_estado', Estado::getState('active'));

		return $query->first();
	}

	public static function userPhoneVoteValidate($entity, $phone) {
		$query = Voto::query();
		$query->select('codigo_voto');
		$query->where('codigo_usuario_institucion', '=', $entity);
		$query->Where('numero_celular_voto', $phone);
		$query->where('codigo_estado', Estado::getState('active'));

		return $query->first();
	}

    public static function verifyCode($vote) {
        $query = Voto::query();
        $query->where('codigo_voto', '=', $vote);
        $query->where('codigo_estado', '=', Estado::getState('pending'));

        return $query->first();
	}

	/**
	* Job Queue notification mail Confirm Evento.
	*/
	public function emailNotification($job, $data)
    {

	    $voto = Self::find($data['codigo_voto']);
	    if(!$voto instanceof Self) {
	      throw new \Exception("Voto not found");
		}

		// Get user entity
		$entidad = Usuario::select('usuario.nombre_usuario')->join('core.usuario_institucion', 'usuario_institucion.codigo_usuario', 'usuario.codigo_usuario')
		 ->where('usuario_institucion.codigo_usuario_institucion', '=', $voto->codigo_usuario_institucion)->first();

	    if(!$entidad instanceof Usuario) {
	      throw new \Exception("Event not found");
	    }
	    // Mail notification
		$data = [];
		$data['_subject'] = Lang::get('vote.mail.subject', ['project' =>$entidad->nombre_usuario]);
		$data['_template'] = 'emails.vote.resendcode';
		$data['_to'] = $voto->correo_electronico_voto;
		$data['_name_project'] =$entidad->nombre_usuario;
		$data['_url_confirm'] = URL::route('voto.verify',['vote'=>TuProyecto::encryptSrcParams([$voto->codigo_voto])], false);
		$data['_code'] = $voto->numero_voto;

		SendEmail::notification($data);

	    // Delete Job
	    $job->delete();
	  }

	  /**
	* Job Queue notification mail Confirm Evento.
	*/
	public function phoneNotification($job, $data)
    {

	    $voto = Self::find($data['codigo_voto']);
	    if(!$voto instanceof Self) {
	      throw new \Exception("Voto not found");
		}

		$sns = AWS::createClient('sns');
		$args = [
			"SenderID" => 'FundacionTerpel',
			"SMSType" => 'Transactional',
			"Message" => "Tu código de votación es {$voto->numero_voto}, gracias por apoyar el proyecto en diseña el cambio.",
			"PhoneNumber" => "+57 {$voto->numero_celular_voto}"
		];
		$sns->publish($args);

	    // Delete Job
	    $job->delete();
	  }


	/**
	* Build Voto.
	*/
	public static function buildVoto($voto)
	{
		$object = new \stdClass();
		$object->codigo_voto = TuProyecto::encryptSrcParams([$voto->codigo_voto]);
		$object->codigo_estado = $voto->codigo_estado;
		$object->codigo_usuario_institucion = $voto->codigo_usuario_institucion;
		$object->correo_electronico_voto = $voto->correo_electronico_voto;
		$object->numero_celular_voto = $voto->numero_celular_voto;
		$object->clase_voto = $voto->clase_voto;
		$object->fecha_voto = $voto->fecha_voto;

		return $object;
	}
}
