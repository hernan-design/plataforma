<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

use TuProyecto;

use DB, Input, Auth, Cookie;


class TemaCurso extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'aprende.tema_curso';

   	protected $primaryKey = 'codigo_tema_curso';


   	public static function getThemes($course)
	{
		$query = TemaCurso::query();
		$query->select('tema_curso.codigo_tema_curso','tema_curso.codigo_curso','tema_curso.nombre_tema_curso','tema_curso.objetivo_tema_curso','tema_curso.url_tema_curso');
		$query-> where('aprende.tema_curso.codigo_curso',$course);
		return $query->get();
	}

	public static function getThemesCourse($course)
	{
		$attachments = array();
		$query = TemaCurso::query();
		$query->select('adjunto_tema.url_adjunto','tema_curso.codigo_tema_curso','tema_curso.codigo_curso','tema_curso.nombre_tema_curso',
			'tema_curso.objetivo_tema_curso','tema_curso.url_tema_curso','adjunto_tema.codigo_adjunto','adjunto.direccion_adjunto', 'adjunto_tema.url_adjunto', 'adjunto.codigo_tipo_adjunto',
			'categoria_curso.url_categoria_curso','curso.url_curso','curso.log_curso', 'curso.log_biofacial', 'adjunto.nombre_adjunto', 'adjunto_tema.codigo_adjunto', 'contenido_curso.codigo_estado', 'contenido_curso.*',
			// state_review
			( Auth::check() ? DB::raw('(CASE COALESCE(estado_adjunto_usuario.codigo_estado, 0) WHEN '.Estado::getState('active').' THEN true ELSE false END) AS state_review') :
				DB::raw('false AS state_review') )
		);
		$query->join('aprende.curso', function($join){
			$join->on('tema_curso.codigo_curso', '=', 'curso.codigo_curso')
				->where('tema_curso.codigo_estado', '=', Estado::getState('active'));
		});
		$query->join('aprende.contenido_curso', function($join) {
			$join->on('contenido_curso.codigo_tema_curso', '=', 'tema_curso.codigo_tema_curso')
				->where('contenido_curso.codigo_estado', '=', Estado::getState('active'));
		});
		$query->join('aprende.categoria_curso', 'curso.codigo_categoria_curso', '=', 'categoria_curso.codigo_categoria_curso');
		$query->leftJoin('aprende.adjunto_tema', 'aprende.adjunto_tema.codigo_contenido_curso','=', 'aprende.contenido_curso.codigo_contenido_curso');
		$query->leftJoin('core.adjunto', 'core.adjunto.codigo_adjunto', '=', 'aprende.adjunto_tema.codigo_adjunto');

		if(Auth::check()) {
			$query->leftjoin('aprende.estado_adjunto_usuario', function($join) {
	            $join->on('adjunto_tema.codigo_adjunto', '=', 'estado_adjunto_usuario.codigo_adjunto')
	                ->on('adjunto_tema.codigo_tema_curso', '=', 'estado_adjunto_usuario.codigo_tema_curso')
					->where('estado_adjunto_usuario.codigo_usuario', '=', Auth::user()->codigo_usuario);
	        });
	  	}

		$query->where('aprende.tema_curso.codigo_curso', $course);
		$query->orderBy('tema_curso.orden_tema', 'asc');
		$query->orderBy('tema_curso.codigo_tema_curso', 'asc');
		$query->orderBy('contenido_curso.orden_contenido_curso', 'asc');
		$data = $query->get();

		$themes = [];
		$attachments = [];
		$lasttheme = $lastitem = '';

		if(count($data) > 0) {
			foreach ($data as $item) {
				if($lastitem == $item->codigo_tema_curso){
					if(Input::has('content') && Input::get('content')) {
						$attachment = new \stdClass();
						$attachment->direccion_adjunto = $item->direccion_adjunto;
						$attachment->url_adjunto = $item->url_adjunto;
                        $attachment->nombre_adjunto = $item->nombre_adjunto;
                        $attachment->nombre_contenido = $item->titulo_contenido_curso;
                        $attachment->url_contenido = $item->url_contenido_curso;
						$attachment->codigo_tipo_adjunto = $item->codigo_tipo_adjunto;
						$attachment->state_review = $item->state_review;
						$attachment->srcparams = TuProyecto::encryptSrcParams([$item->codigo_tema_curso, $item->codigo_adjunto]);

						if(Input::has('advance') && Input::get('advance') && ($item->codigo_tipo_adjunto == TipoAdjunto::getTypeAttached('flash')) ) {
							$attachment->includeparams = sprintf("?email=%s&curso=%s&tema=%s&escena=%s&evaluacion=%s&tiempo=%s", Auth::user()->correo_electronico, $item->codigo_curso,
								$item->codigo_tema_curso, ($item->avance_tema_usuario ? $item->avance_tema_usuario : 0),
								$item->evaluacion_tema_usuario, $item->tiempo_tema_curso
							);
						}
						$attachments[] = $attachment;
					}
				}else{
					if(is_object($lasttheme)){
						$lasttheme->adjuntos = $attachments;
						$themes[] = $lasttheme;
						$attachments = [];
					}
					$theme = new \stdClass();
					$theme->codigo_tema_curso = $item->codigo_tema_curso;
					$theme->nombre_tema_curso = $item->nombre_tema_curso;
					$theme->url_tema_curso = $item->url_tema_curso;
					$theme->url_categoria_curso = $item->url_categoria_curso;
					$theme->url_curso = $item->url_curso;
					$theme->log_curso = $item->log_curso;
					$theme->log_biofacial = $item->log_biofacial;
					$theme->objetivo_tema_curso = $item->objetivo_tema_curso;

					if(Input::has('content') && Input::get('content')) {
						$attachment = new \stdClass();
						$attachment->direccion_adjunto = $item->direccion_adjunto;
						$attachment->url_adjunto = $item->url_adjunto;
						$attachment->nombre_adjunto = $item->nombre_adjunto;
						$attachment->codigo_tipo_adjunto = $item->codigo_tipo_adjunto;
						$attachment->state_review = $item->state_review;
						$attachment->srcparams = TuProyecto::encryptSrcParams([$item->codigo_tema_curso, $item->codigo_adjunto]);
						$attachment->codigo_estado = $item->codigo_estado;

						if(Input::has('advance') && Input::get('advance') && ($item->codigo_tipo_adjunto == TipoAdjunto::getTypeAttached('flash')) ) {
							$attachment->includeparams = sprintf("?email=%s&curso=%s&tema=%s&escena=%s&evaluacion=%s&tiempo=%s", Auth::user()->correo_electronico, $item->codigo_curso,
								$item->codigo_tema_curso, ($item->avance_tema_usuario ? $item->avance_tema_usuario : 0),
								$item->evaluacion_tema_usuario, $item->tiempo_tema_curso
							);
						}
						$attachments[] = $attachment;
					}
					$lasttheme = $theme;
				}
				$lastitem = $item->codigo_tema_curso;
			}
			if(is_object($lasttheme)){
				$lasttheme->adjuntos = $attachments;
				$themes[] = $lasttheme;
				$attachments = [];
			}
		}
        return $themes;
	}
}
