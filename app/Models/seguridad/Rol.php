<?php

namespace App;

use Zizaco\Entrust\EntrustRole;

use Config, Cache;

use App\Modulo;

class Rol extends EntrustRole {

	public static function getRole($role) {
    	switch ($role) :
		    case 'superadmin': return 1;
		    case 'admininstitution': return 2;
            case 'user': return 3;
            case 'mentor': return 7;
		    case 'seller': return 14;
			default: return 'Not role identified';
		endswitch;
    }

    public static function getType($type) {
    	switch ($type) :
		    case 'community': return 1;
		    case 'platform': return 2;
		endswitch;
    }

    /**
     * Many-to-Many relations with the permission model.
     * Named "perms" for backwards compatibility. Also because "perms" is short and sweet.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function perms()
    {
        return $this->belongsToMany(config('entrust.permission'), config('entrust.permission_role_table'), 'role_id', 'permission_id')->join('seguridad.modulo', 'modulo.codigo_modulo', '=', 'permiso_rol.codigo_modulo')->where('codigo_tipo_modulo', Modulo::getTypeModule('platform'));
    }

    //Big block of caching functionality.
    public function cachedPermissions($module = null)
    {
        $rolePrimaryKey = $this->primaryKey;
        $modulePrimaryKey = $module ?: 'general';
		$cacheKey = "entrust_permissions_for_role_{$this->$rolePrimaryKey}_$modulePrimaryKey";

		return Cache::tags(config('entrust.permission_role_table'))->remember($cacheKey, config('cache.ttl'), function () use($module) {
        	$query = $this->perms();
        	if( !is_null($module) ) {
            	$query->where('modulo.url_modulo', $module);
        	}
        	return $query->get();
        });
    }

    /**
     * Checks if the role has a permission by its name.
     *
     * @param string|array $name       Permission name or array of permission names.
     * @param bool         $requireAll All permissions in the array are required.
     *
     * @return bool
     */
    public function hasPermission($name, $module = null, $requireAll = false)
    {
       
        if (is_array($name)) {
            foreach ($name as $permissionName) {
                $hasPermission = $this->hasPermission($permissionName, $module);

                if ($hasPermission && !$requireAll) {
                    return true;
                } elseif (!$hasPermission && $requireAll) {
                    return false;
                }
            }

            // If we've made it this far and $requireAll is FALSE, then NONE of the permissions were found
            // If we've made it this far and $requireAll is TRUE, then ALL of the permissions were found.
            // Return the value of $requireAll;
            return $requireAll;
        } else {
            foreach ($this->cachedPermissions($module) as $permission) {
                if ($permission->name == $name) {
                    return true;
                }
            }
        }

        return false;
    }
}
