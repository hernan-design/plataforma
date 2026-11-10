<?php

namespace App\Models\mongodb;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\BSON\ObjectID;
use MongoDB\Model\BSONArray;

use Auth;

use App\Models\mongodb\Usuario, App\RegistroSesion;

class Notificacion extends Model
{
    protected $connection = 'mongodb';
   	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'notifications';

    protected $dates = ['created'];

    public static function getType($type) {
    	switch ($type) :
		    case 'general': return 1;
		    case 'friendship': return 2;
		    case 'like': return 3;
		    case 'favorite': return 4;
		    case 'discussion': return 5;
		endswitch;
    }

    public static function getNotifications()
    {
    	// Get user
        $user = Usuario::getOrCreateAuthUser();
        if (!$user instanceof Usuario) {
            $response = new \stdClass();
            $response->total_entries = 0;
            $response->items = [];
            return $response;
        }
		// Get notifications
	   	$data = Notificacion::raw(function($collection) use ($user)
		{
		    return $collection->aggregate([
   				[ '$match' => ['institution' => ['$eq' => RegistroSesion::getInstitution()]] ],
				[ '$match' => ['$or' => [ ['receivedBy' => ['$in' => [new ObjectID($user->_id)]]], ['isGlobal' => ['$eq' => true]] ] ] ],
				[ '$match' => ['deletedBy' => ['$nin' => [new ObjectID($user->_id)]]] ],
				[ '$match' => ['type' => ['$in' => [Notificacion::getType('general'), Notificacion::getType('like'), Notificacion::getType('favorite'), Notificacion::getType('discussion')]]] ],
	 			[ '$skip' => intval(request('offset', 0)) ],
	 			[ '$limit' => (intval(request('limit', 15)) ?: 15) ],
			   	[
			   		'$project' => [
						'_id' => 1,
						'title' => [ '$ifNull' => ['$title', ''] ],
						'content' => [ '$ifNull' => ['$content', ''] ],
						'image' => [ '$ifNull' => ['$image', ''] ],
						'type' => 1,
						'url' => [ '$ifNull' => ['$url', ''] ],
						'created' => 1,
						'deliveredBy' => 1,
						'read' => [
			                '$anyElementTrue' =>
			                [
			                    [
			                        '$ifNull' =>
			                        [
			                      		[
			                                '$map' =>
		                            		[
			                                    'input' => '$readBy',
			                                    'as' => 'el',
			                                    'in' => [ '$eq' => [ '$$el', new ObjectID($user->_id)] ]
		                             	   ]
			                            ],
			                        	[false]
			                        ]
			                    ]
			                ]
						]
					]
				]
		   	]);
		});

		// Prepare deliveredBy
		foreach ($data as $item) {
			$item->deliveredBy = Usuario::find( $item->deliveredBy instanceof BSONArray ? end($item->deliveredBy) : $item->deliveredBy );
		}

		// Get count posts
    	$query = self::query();
		$query->where('institution', RegistroSesion::getInstitution());
		$query->where(function ($q) use ($user) {
			$q->whereIn('receivedBy', [new ObjectID($user->_id)])
			  ->orWhere('isGlobal', true);
		});
		$query->whereRaw(['deletedBy' => [ '$nin' => [new ObjectID($user->_id)] ]]);
		$query->whereIn('type', [self::getType('general'), self::getType('like'), self::getType('favorite'), self::getType('discussion')]);
		$total_entries = $query->count();

		// Prepare response
		$response = new \stdClass();
		$response->total_entries = $total_entries;
		$response->items = $data;
   		return $response;
    }
}
