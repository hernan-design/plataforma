<?php
/**
 * Modelo ConvocatoriaMentoria, relaciona asesorias, convocatorias y usuario (rol mentor).
 * @author Harold Rodríguez <hartuproyecto@gmail.com>
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConvocatoriaMentoria extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.convocatoria_mentoria';
    protected $primaryKey = 'codigo_convocatoria_mentoria';

    /**
     * Relación hasOne entre modelos ConvocatoriaMentoria y Asesoria.
     * @access public
     */
	public function asesoria()
	{
		return $this->hasOne('App\Asesoria', 'codigo_asesoria', 'codigo_asesoria');
	}

	/**
     * Relación hasOne entre modelos ConvocatoriaMentoria y Convocatoria.
     * @access public
     */
	public function convocatoria()
	{
		return $this->hasOne('App\Convocatoria', 'codigo_convocatoria', 'codigo_convocatoria');
	}

	/**
     * Relación hasOne entre modelos ConvocatoriaMentoria y Usuario.
     * @Annotation Permite obtener el mentor.
     * @access public
     */
	public function mentor()
    {
        return $this->hasOne('App\Usuario', 'codigo_usuario', 'seg_codigo_usuario');
    }
}
