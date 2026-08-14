<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Estado;

class RecomendacionMarketplace extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'param.reco_marketplace';

   	protected $primaryKey = 'codigo_reco_marketplace';

    public $timestamps = false;
}
