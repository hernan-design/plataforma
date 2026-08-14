<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models;

class ConvocatoriaEtapa extends Model
{
	protected $table = 'core.convocatoria_etapa';

	public $incrementing = false;

	public $timestamps = false;

	protected $fillable = ['codigo_convocatoria_etapa', 'codigo_estado', 'codigo_convocatoria', 'codigo_etapa_proyecto'];

	public static function getStagePrograms($etapa, $codigo_eje) {
		$query = ConvocatoriaInstitucion::query();
		$query->select('convocatoria.codigo_convocatoria', 'estado.nombre_estado', 'estado.codigo_estado','convocatoria.nombre_convocatoria', 'convocatoria.imagen_convocatoria', 'convocatoria.descripcion_convocatoria','convocatoria.url_convocatoria', 'usuario.codigo_usuario', 'usuario.nombre_usuario', 'usuario.imagen_usuario', 'usuario.nickname_usuario',
			DB::raw("( SELECT string_agg(etapa_proyecto.nombre_etapa_proyecto::text, ',') as etapas
			 FROM core.etapa_proyecto
			LEFT JOIN core.convocatoria_etapa ON convocatoria_etapa.codigo_etapa_proyecto = etapa_proyecto.codigo_etapa_proyecto
		    WHERE etapa_proyecto.codigo_institucion = ".RegistroSesion::getInstitution()." AND convocatoria_etapa.codigo_convocatoria = convocatoria.codigo_convocatoria)"),
			DB::raw("( SELECT string_agg(categoria_proceso.nombre_categoria_proceso::text, ',') as categorias
			 FROM core.categoria_proceso
			LEFT JOIN core.categoria_proceso_insti ON categoria_proceso_insti.codigo_categoria_proceso = categoria_proceso.codigo_categoria_proceso
			LEFT JOIN core.convocatoria_categoria ON convocatoria_categoria.codigo_categoria_proceso = categoria_proceso.codigo_categoria_proceso
		    WHERE categoria_proceso_insti.codigo_institucion = ".RegistroSesion::getInstitution()." AND convocatoria_categoria.codigo_convocatoria = convocatoria.codigo_convocatoria)"));
		$query->join('core.convocatoria', 'convocatoria.codigo_convocatoria', '=', 'convocatoria_institucion.codigo_convocatoria');
		$query->join('core.convocatoria_etapa', 'convocatoria_etapa.codigo_convocatoria', '=', 'convocatoria.codigo_convocatoria');
		$query->leftJoin('seguridad.usuario', 'usuario.codigo_usuario', '=', 'convocatoria.seg_codigo_usuario');
		$query->leftJoin('core.estado', 'estado.codigo_estado', '=', 'convocatoria.codigo_estado');
		$query->where('convocatoria_etapa.codigo_etapa_proyecto', '=', $etapa);
		$query->where('convocatoria.codigo_eje', '=', $codigo_eje);
		$query->where('convocatoria_institucion.codigo_institucion', '=', 69);
		return $query->get();
	}
}
