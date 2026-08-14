<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

class TagForo extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.tag_foro';

	public $incrementing = false;

   	public $timestamps = false;

 	/**
	 * Defining Relations
	 */
	public function tag()
    {
        return $this->hasOne('App\Tag','codigo_tag','codigo_tag');
    }

	/**
	 * Forum Posts grouped by category.
	 */
    public static function getMoreUsed()
    {
    	$moreUsed = array();
		$tags = Tag::orderBy('contador_tag_foro','desc')
			->where('contador_tag_foro','>','0')
			->take(20)->get();
		foreach ($tags as $tag) {
			$moreUsed[] = TagForo::buildTag($tag);
		}
		return $moreUsed;
    }

	/**
	 * Build Tag.
	 */
   	public static function buildTag($tag)
   	{
   		$object = new \stdClass();
		$object->text = $tag->texto_tag;
		$object->weight = $tag->contador_tag_foro;
		$object->link = "#{$tag->texto_tag}";
		return $object;
   	}
}
