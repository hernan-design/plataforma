<?php

namespace App\Models\mongodb;

use MongoDB\Laravel\Eloquent\Model;
use Auth;

class Usuario extends Model
{
    protected $connection = 'mongodb';
   	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'users';

    protected $guarded = [];

    /**
     * Get the MongoDB user of the authenticated user, creating it if it does not exist yet.
     */
    public static function getOrCreateAuthUser()
    {
        if (!Auth::check()) {
            return null;
        }

        $authUser = Auth::user();
        $user = self::where('cod', (int) $authUser->codigo_usuario)->first();
        if (!$user instanceof self) {
            $user = self::create([
                'cod' => (int) $authUser->codigo_usuario,
                'name' => trim($authUser->nombre_usuario ?? ''),
                'nickname' => $authUser->nickname_usuario ?? '',
                'avatar' => $authUser->imagen_usuario ?? '',
            ]);
        }
        return $user;
    }

    /**
     * Get or create a MongoDB user by their SQL codigo_usuario.
     */
    public static function getOrCreateByCode($code)
    {
        if (!$code) {
            return null;
        }

        $code = (int) $code;
        $user = self::where('cod', $code)->first();
        if (!$user instanceof self) {
            $sqlUser = \App\Usuario::find($code);
            if ($sqlUser) {
                $user = self::create([
                    'cod' => $code,
                    'name' => trim($sqlUser->nombre_usuario ?? ''),
                    'nickname' => $sqlUser->nickname_usuario ?? '',
                    'avatar' => $sqlUser->imagen_usuario ?? '',
                ]);
            }
        }
        return $user;
    }
}
