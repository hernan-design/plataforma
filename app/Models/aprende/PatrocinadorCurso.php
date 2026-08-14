<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

class PatrocinadorCurso extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'aprende.patrocinador_curso';

	public $incrementing = false;

	public $timestamps = false;

    public function patrocinador()
    {
        return $this->hasOne('App\Patrocinador','codigo_patrocinador','codigo_patrocinador');
    }
}
