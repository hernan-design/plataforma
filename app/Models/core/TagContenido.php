<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

class TagContenido extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.tag_contenido';

	public $incrementing = false;

   	public $timestamps = false;

   	/**
	* Defining Relations
	*/
	public function tag()
    {
        return $this->hasMany('App\Tag','codigo_tag','codigo_tag');
    }

    public static function getTagsContent($content){
    	$query = TagContenido::query();
        $query->select('texto_tag');
        $query->join('core.tag','tag_contenido.codigo_tag','=','tag.codigo_tag');        
        $query->where('codigo_contenido','=',$content);
        $query->get();
        $tags = $query->pluck('texto_tag');
        return $tags->all();
    }

}
