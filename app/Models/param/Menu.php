<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

use Cache, DB;

class Menu extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'param.menu';

   	protected $primaryKey = 'codigo_menu';

    public static function getType($type) {
        switch ($type) :
            case 'parent': return 1;
            case 'son': return 2;
            default: return 'Not type identified';
        endswitch;
    }

    public static function getTypeLink($type) {
        switch ($type) :
            case 'internal': return 1;
            case 'external': return 2;
            default: return 'Not type identified';
        endswitch;
    }

	public static function getOptionsMenu($type) {
        // $cache = sprintf('_%s_%s_%s', 'options_menu', RegistroSesion::getInstitution(), $type);
        // if (Cache::has($cache)) {
        //     return Cache::get($cache);
        // }

        // return Cache::rememberForever($cache, function() use($type) {
            $query = MenuInstitucion::query();
            $query->select('menu_institucion.codigo_menu_institucion', 'tipo_menu_institucion', 'tipo_enlace_menu_institucion', 'par_codigo_menu_institucion as menu_padre', 'icono_menu_item', 'clase_item_menu', DB::raw('COALESCE(nombre_menu_institucion, nombre_menu_item) as nombre_item_menu'), DB::raw('COALESCE(ruta_menu_institucion, url_menu_item) as ruta_menu_institucion'), DB::raw('COALESCE(descripcion_menu_institucion, descripcion_menu_item) as descripcion_menu_item'));

            $query->join('param.item_menu', 'menu_institucion.codigo_item_menu', '=', 'item_menu.codigo_item_menu');
            $query->join('param.menu', 'menu_institucion.codigo_menu', '=', 'menu.codigo_menu');
            $query->leftJoin('param.submenu_institucion', 'menu_institucion.codigo_menu_institucion', '=', 'submenu_institucion.codigo_menu_institucion');

    		$query->where('menu_institucion.codigo_estado', Estado::getState('active'));
    		$query->where('menu_institucion.codigo_institucion', RegistroSesion::getInstitution());
    		$query->where('menu.codigo_tipo_menu', $type);

            $query->orderby('menu_padre','asc')->orderby('orden_menu_institucion','asc');
            return $query->get();
        // });
	}

    public static function getParents($type) {
        $items = Menu::getOptionsMenu($type);
        return $items->where('tipo_menu_institucion', self::getType('parent'));
    }

    public static function getChildren($type, $parent) {
        $items = Menu::getOptionsMenu($type);
        return $items->where('tipo_menu_institucion', self::getType('son'))->where('menu_padre', $parent);
    }

    public static function getAllChildren($type) {
        $items = Menu::getOptionsMenu($type);
        return $items->where('tipo_menu_institucion', self::getType('son'));
    }
}
