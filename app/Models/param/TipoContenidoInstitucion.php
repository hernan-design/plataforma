<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoContenidoInstitucion extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	*/
	protected $table = 'core.tipo_contenido_insti';

   	protected $primaryKey = 'codigo_tipo_cont_institucion';

	public $timestamps = false;
}
