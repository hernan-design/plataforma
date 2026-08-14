<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class AdjuntoFaseUsuario extends Model
{
	protected $table = 'core.adjunto_fase_usuario';

	protected $primaryKey = 'codigo_adjunto_fase_usuario';

	public $timestamps = false;

	public $incrementing = false;

	protected $fillable = ['codigo_adjunto_fase_usuario', 'codigo_usuario_institucion', 'codigo_adjunto_fase', 'fecha_adjunto_fase_usuario'];
}


