<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

class AdjuntoConvocatoria extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.adjunto_convocatoria';

	public $timestamps = false;

	public $incrementing = false;

	public function adjunto()
    {
        return $this->hasOne('App\Adjunto','codigo_adjunto','codigo_adjunto');
    }
}
