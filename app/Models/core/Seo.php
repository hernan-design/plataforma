<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

class Seo extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.seo';

   	protected $primaryKey = 'codigo_seo';

    public $timestamps = false;

    /**
	 * SQL used to validate the state of follow or no follow in seo.
	 *
	 * @var string
	 */
    public static $raw_follow= "(CASE WHEN enlaces_motores_busqueda IS NULL THEN '' ELSE CASE WHEN enlaces_motores_busqueda IS TRUE THEN 'follow' ELSE 'nofollow' END END)";
    
    /**
	 * SQL used to validate the state of index or no index in seo.
	 *
	 * @var string
	 */
	public static $raw_index = "(CASE WHEN indexar_motores IS NULL THEN '' ELSE CASE WHEN indexar_motores IS TRUE THEN 'index' ELSE 'noindex' END END)";
}
