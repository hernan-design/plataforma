<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

class TipoAdjunto extends Model {

    protected $table = 'core.tipo_adjunto';

    protected $primaryKey = 'codigo_tipo_adjunto';

    public static function getTypeAttached($attached) {
    	switch ($attached) :
		    case 'document': return 1;
		    case 'youtube': return 2;
		    case 'flash': return 3;
		    case 'vimeo': return 4;
		    case 'html': return 5;
		    case 'image': return 6;
		    case 'gallery': return 7;
			default: return 'Not attached identified';
		endswitch;
    }
}

