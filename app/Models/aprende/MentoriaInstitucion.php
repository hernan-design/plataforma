<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

class MentoriaInstitucion extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'aprende.mentoria_institucion';

	public $timestamps = false;

	public $incrementing = false;
}
