<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

class Estado extends Model {

    protected $table = 'core.estado';

    protected $primaryKey = 'codigo_estado';

    public static function getState($state) {
    	switch ($state) :
		    case 'progress': return 1;
		    case 'review': return 2;
		    case 'cancelled': return 3;
		    case 'live': return 4;
		    case 'correction': return 5;
		    case 'confirm': return 6;
		    case 'confirmed': return 7;
		    case 'active': return 8;
		    case 'inactive': return 9;
		    case 'feedback': return 10;
		    case 'complete': return 11;
 		    case 'qualified': return 12;
 		    case 'removed': return 13;
 		    case 'pending': return 14;
 		    case 'evaluated': return 15;
 		    case 'closed': return 16;
 		    case 'locked': return 17;
 		    case 'pendinginstitution': return 18;
 		    case 'preinscription': return 19;
            case 'notified': return 20;
 		    case 'forward': return 21;
 		    case 'offer': return 22;
 		    case 'no_linked': return 23;
            case 'linked': return 24;
            case 'rejected': return 25;
            case 'returned': return 26;
            case 'finalized': return 29;
            case 'to_finalize': return 30;
			case 'review_deliverables': return 32;
			case 'rejection_of_deliverables': return 33;
			case 'pending_accept_session': return 34;
			default: return 'Not state identified';
		endswitch;
    }
}
