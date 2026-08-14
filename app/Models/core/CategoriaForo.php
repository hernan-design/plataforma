<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

class CategoriaForo extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.categoria_foro';

   	protected $primaryKey = 'codigo_categoria_foro';

    public static function getForumCategory($category) {
        switch ($category) :
            case 'faq': return 7;
            default: return 'Not category identified';
        endswitch;
    }

   	public static function getCategory($category)
   	{
		return CategoriaForo::where('url_categoria_foro', '=', strtolower(trim($category)))->first();
   	}

 	public static function getCategories()
    {
    	return CategoriaForo::where('codigo_estado', Estado::getState('active'))->pluck('nombre_categoria_foro','codigo_categoria_foro')->toArray();
    }

    public static function getForumCategories()
    {   
    	$query = CategoriaForo::query();
        $query->select('categoria_foro.codigo_categoria_foro', 'nombre_categoria_foro', 'url_categoria_foro');
        $query->join('core.categoria_foro_institucion', function ($join) {
            $join->on('categoria_foro.codigo_categoria_foro', '=', 'categoria_foro_institucion.codigo_categoria_foro')
                ->where('categoria_foro_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
                ->where('categoria_foro_institucion.codigo_estado', '=', Estado::getState('active'));
        });
        $query->where('categoria_foro.codigo_estado', Estado::getState('active'));
        $query->whereNotIn('categoria_foro.codigo_categoria_foro', [CategoriaForo::getForumCategory('faq')]);
    	return $query->get();
    }

   	/**
	   * Defining Relations
	  */
   	public function foros()
    {
     	return $this->hasMany('App\Foro','codigo_categoria_foro','codigo_categoria_foro');
    }
}
