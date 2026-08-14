<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

class Recurso extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.recurso';

   	protected $primaryKey = 'id_recurso';

    public static function getResource($resource) {
    	switch ($resource) :
		    case 'foro.gestion': return 1;
		    case 'foro.comentario': return 2;
		    case 'muro.gestion': return 3;
		    case 'muro.comentario': return 4;
		    case 'mentoria.gestion': return 6;
		    case 'mentoria.comentario': return 5;
		    case 'proyectos.gestion': return 7;
		    case 'proyectos.comentario': return 8;
		    case 'blog.gestion': return 9;
		    case 'blog.comentario': return 10;
		    case 'discusion.gestion': return 11;
		    case 'discusion.comentario': return 12;
		    case 'producto.gestion': return 13;
		    case 'convocatoria.gestion': return 14;
		    case 'eventos.gestion': return 15;
		    case 'aprende.gestion': return 16;
			default: return 'Not resource identified';
		endswitch;
    }
}
