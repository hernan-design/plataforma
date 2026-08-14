<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Custom\Innpulsa;

class GrupoItemEval extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.grupo_item_eval';

	protected $primaryKey = 'codigo_grupo_item_eval';

	public $timestamps = false;

	public static function getGroup($average) {
		switch ($average) :
			case 'average_differential': return 1;
			case 'average_commercial': return 2;
			case 'validation_commercial': return 3;
			case 'average_work_team': return 4;
			case 'enterprising_team': return 5;
			case 'market': return 6;
			case 'product': return 7;
            case 'productive_chains': return 8;
            case 'average_differential_empodera': return 20;
			case 'average_commercial_empodera': return 21;
			case 'validation_commercial_empodera': return 22;
			case 'average_work_team_empodera': return 23;
			case 'enterprising_team_empodera': return 24;
			case 'market_empodera': return 25;
			case 'product_empodera': return 26;
			case 'productive_chains_empodera': return 27;
			case 'diferential_market_empodera_2020': return 28;
			case 'aldea_20': return 12;
			case 'innovation_component': return 34;
			case 'market_2020': return 35;
			case 'enterprising_team_2020': return 36;
			case 'objetives': return 37;
			case 'recomendations': return 38;
			default: return 'Not average identified';
		endswitch;
	}

	public function averageGroup(RegistroFaseUsuario $register)
	{
        if(in_array($this->codigo_grupo_item_eval, [self::getGroup('average_differential'), self::getGroup('average_commercial'), self::getGroup('validation_commercial'), self::getGroup('average_work_team'), self::getGroup('enterprising_team'), self::getGroup('market'), self::getGroup('product'), self::getGroup('productive_chains'), self::getGroup('average_differential_empodera'), self::getGroup('average_commercial_empodera'), self::getGroup('validation_commercial_empodera'), self::getGroup('average_work_team_empodera'), self::getGroup('enterprising_team_empodera'), self::getGroup('market_empodera'), self::getGroup('product_empodera'), self::getGroup('productive_chains_empodera')]))
		{            
            return Innpulsa::averageGroup($this, $register);
		}
		return null;
	}

	public function generalAverageGroup(RegistroFaseUsuario $register)
	{
		if(in_array($this->codigo_grupo_item_eval, [self::getGroup('enterprising_team'), self::getGroup('market'), self::getGroup('product'), self::getGroup('productive_chains')]))
		{
			return Innpulsa::generalAverageGroup($this, $register);
		}
		return null;
	}

	public function generalAverageGroupAldea2020(RegistroFaseUsuario $register)
	{
		if(in_array($this->codigo_grupo_item_eval, [self::getGroup('innovation_component'), self::getGroup('market_2020'), self::getGroup('enterprising_team_2020'), self::getGroup('objetives'), self::getGroup('recomendations')]))
		{
			return Innpulsa::generalAverageGroupAldea2020($this, $register);
		}
		return null;
	}
}
