<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

use Cache, DB,Log;

use App\Estado, App\RegistroSesion;

class ItemGeneralMentoria extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'aprende.item_general_mentoria';

	protected $primaryKey = 'codigo_item_general_mentoria';

	public $timestamps = false;

	/**
    * getItemEvalPurchaseList List.
    */
    public static function getItemMentoriaList()
    {

/*         if (Cache::has('_itemevalmentoring_list')) {
            return Cache::get('_itemevalmentoring_list');
        }
 */
        //return Cache::rememberForever('_itemevalmentoring_list', function() {
            $query = ItemGeneralMentoria::query();
            $query->where('codigo_estado', '=', Estado::getState('active'))
                    ->where('codigo_institucion','=',RegistroSesion::getInstitution());
            $query->orderby('nombre_item_general_mentoria', 'asc');
            return $query->get();
        //});
    }

}
