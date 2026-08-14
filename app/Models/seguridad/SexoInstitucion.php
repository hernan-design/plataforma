<?php

namespace App\Models\Seguridad;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use TuProyecto, SendEmail;
use Cookie, Cache, Config, DB, Auth, Lang, Input, App, Validator, Hash, URL, Log, Session;
use App\Models;
use App\Estado;

class SexoInstitucion extends Model
{
    protected $table = 'seguridad.sexo_institucion';

	//protected $primaryKey = 'id';

	public $timestamps = false;
}
