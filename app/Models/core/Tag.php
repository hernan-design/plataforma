<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

class Tag extends Model {

    protected $table = 'core.tag';

    protected $primaryKey = 'codigo_tag';

	public $timestamps = false;

    protected $fillable = ['texto_tag'];

    public static function getTags(array $filters = [])
    {
    	$query = Tag::query();
        $query->select('codigo_tag as id', 'texto_tag as value');
        if (isset($filters["term"]) && !empty($filters["term"])) {
            $query->where('texto_tag', 'ilike', '%'.$filters["term"].'%');
        }
        $query->orderby('texto_tag','asc');
    	return $query->get();
    }
}
