<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

use scssc;

use Config, Request, DB;

class Institucion extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'param.institucion';

	protected $primaryKey = 'codigo_institucion';

	public static function getInstitutionHost()
	{
		if (strpos(Request::getHost(), 'redemprendedoresbavaria') !== false) {
			return 'redemprendedoresbavaria';
  		}elseif (strpos(Request::getHost(), 'colabora') !== false) {
			return 'colabora';
		}elseif (strpos(Request::getHost(), 'andidelfuturo') !== false) {
			return 'andifuturo';
  		}elseif (strpos(Request::getHost(), 'hilandoempresa') !== false) {
			return 'hilandoempresa';
  		}elseif (strpos(Request::getHost(), 'rnai') !== false) {
			return 'rnai';
  		}elseif (strpos(Request::getHost(), 'inversionangel') !== false) {
			return 'rnai';
  		}elseif (strpos(Request::getHost(), 'seissabana') !== false) {
			return 'unisabana';
		}elseif (strpos(Request::getHost(), 'cecar') !== false) {
			return 'cecar';
		}elseif (strpos(Request::getHost(), 'redmentor') !== false) {
			return 'mentor';
		}elseif (strpos(Request::getHost(), 'premioalainnovacion') !== false) {
			return 'premioecopetrol';
		}elseif (strpos(Request::getHost(), 'innpulsa') !== false) {
			return 'innpulsa';
		}elseif (strpos(Request::getHost(), 'redcoo') !== false) {
			return 'redcoo';
		}elseif (strpos(Request::getHost(), 'mapacine') !== false) {
			return 'mapacine';
		}elseif (strpos(Request::getHost(), 'medellinstartupcity') !== false) {
			return 'startupcitymed';
		}elseif (strpos(Request::getHost(), 'bavariadestapafuturo') !== false) {
			return 'destapafuturo';
		}elseif (strpos(Request::getHost(), 'demo') !== false) {
			return 'demo';
		}elseif (strpos(Request::getHost(), 'emprendimientometropol') !== false) {
            return 'creame';
        }elseif (strpos(Request::getHost(), 'dinamiza') !== false) {
            return 'dinamiza';
        }elseif (strpos(Request::getHost(), 'comunidademprendepais') !== false) {
            return 'bolivar';
		}elseif (strpos(Request::getHost(), 'lms') !== false) {
			return 'muy';
		}elseif (strpos(Request::getHost(), 'compensar') !== false) {
			return 'compensar';
		}elseif (strpos(Request::getHost(), 'cenisoft') !== false) {
			return 'cenisoft';
		}elseif (strpos(Request::getHost(), 'jucapp') !== false) {
			return 'jucapp';
		}elseif (strpos(Request::getHost(), 'serviu') !== false) {
			return 'serviu';
		}elseif (strpos(Request::getHost(), 'sja') !== false) {
			return 'sja';
		}elseif (strpos(Request::getHost(), 'propace') !== false) {
			return 'propace';
		}elseif (strpos(Request::getHost(), 'bwee') !== false) {
			return 'bwee';
		}elseif (strpos(Request::getHost(), 'tureto') !== false) {
			return 'tureto';
		}elseif (strpos(Request::getHost(), 'hogarescomunidad') !== false) {
			return 'hogarescomunidad';
		}elseif (strpos(Request::getHost(), 'ninojesus') !== false) {
			return 'ninojesus';
		}elseif (strpos(Request::getHost(), 'atrevetemipyme') !== false) {
			return 'atrevetemipyme';
		}elseif (strpos(Request::getHost(), 'rutan') !== false) {
			return 'rutan';
		}elseif (strpos(Request::getHost(), 'mipymeinnovabolivar') !== false) {
			return 'siinova';
		}elseif (strpos(Request::getHost(), 'betsalem') !== false) {
			return 'betsalem';
		}elseif (strpos(Request::getHost(), 'metamorfosis') !== false) {
			return 'metamorfosis';
		}elseif (strpos(Request::getHost(), 'saroa') !== false) {
			return 'saroa';
		}elseif (strpos(Request::getHost(), 'prana') !== false) {
			return 'prana';
		}elseif (strpos(Request::getHost(), 'copo') !== false) {
			return 'copo';
		}
		// elseif (strpos(Request::getHost(), 'fundacionterpel') !== false) {
		// 	return 'fundacionterpel';
		// }

		if (Request::getHost() === '127.0.0.1' || Request::getHost() === 'localhost') {
			return 'compensar';
		}

		return 'tuproyecto';
	}

	public static function getTypeMembership($type)
	{
    	switch ($type) :
		    case 'subscription': return 1;
		    case 'plans': return 2;
			case 'non-plan': return 3;
			case 'purchase': return 4;
			default: return 'Not type identified';
		endswitch;
    }

	public static function getTypeRegister($type)
	{
    	switch ($type) :
		    case 'default': return 1;
		    case 'html': return 2;
		    case 'survey': return 3;
			default: return 'Not type identified';
		endswitch;
    }

    public static function getInstitution($institution) {
    	switch ($institution) :
		    case 'copo': return 1;
		    case 'redcoo': return 29;
		    case 'terpel': return 37;
		    case 'innpulsa': return 51;
		    case 'ecopetrol': return 53;
		    case 'creame': return 64;
			case 'dinamiza': return 69;
			case 'compensar': return 30;
			case 'cenisoft': return 46;
			case 'demo': return 48;
			case 'jucapp' : return 56;
			case 'serviu': return 74;
			case 'sja': return 57;
			case 'saroa': return 57;
			case 'propace': return 75;
			case 'bwee': return 73;
			case 'colabora': return 79;
			case 'tureto': return 77;
			case 'hogarescomunidad': return 58;
			case 'muy': return 47;
			case 'ninojesus': return 59;
			case 'atrevetemipyme': return 60;
			case 'rutan': return 61;
			case 'siinova': return 62;
			case 'prana': return 81;
			default: return 'Not institution identified';
		endswitch;
    }

	public static function getInstitutionSlug($slug)
	{
		return Institucion::where('slug_institucion', '=', $slug)->where('codigo_estado', Estado::getState('active'))->first();
	}

	public static function getLandingData(Institucion $institution)
	{
		$chanels = CanalRegistro::getChanels();
		$modules = VisibilidadInstitucion::getInstitutionModules();
		$parameters = ParametroModulo::getParametersLanding();
		$parameters_institution = ParametroInstitucion::getParametersLanding();
		$images_carrusel = [];

		// Images carrusel
		if($institution->carrousel_institucion) {
			$images_carrusel = Carrusel::getImages();;
		}

		foreach ($modules as $module) {
			if(!$module->bloque_texto_modulo) {
				switch ($module->name) {
					case 'cifras':
						$stadistics = MetricaInstitucion::getStadistics();
						break;
					case 'entidades':
						$entities = Entidad::getLastEntitys();
						break;
					case 'beneficios':
						$advantage = Beneficio::getAdvantage();
						break;
					case 'aliados':
						$partners = Aliado::getPartners();
						break;
					case 'blog':
						$articles = Contenido::getLastArticles(true);
						break;
					case 'eventos':
						$events = Evento::getEvents(['limit' => 10]);
						break;
					case 'convocatorias':
						$programs = Convocatoria::getOpenCalls();
						break;
				}
			}
		}

		return [
			'institution' => $institution,
			'chanels' => $chanels,
			'modules' => $modules,
			'parameters' => $parameters,
			'parameters_institution' => $parameters_institution,
			'images_carrusel' => $images_carrusel,
			'stadistics' => isset($stadistics) ? $stadistics :[],
			'entities' => isset($entities) ? $entities :[],
			'articles' => isset($articles) ? $articles :[],
			'partners' => isset($partners) ? $partners :[],
			'advantage' => isset($advantage) ? $advantage :[],
			'programs' => isset($programs) ? $programs :[],
			'events' => isset($events) ? $events :[]
		];
	}

	public static function compileStyleLanding($institution)
	{
		$file = public_path().'/css/institution/'.$institution->slug_institucion.'_landing.css';
		if (file_exists($file)) {
			return;
		}

		if (class_exists('ScssPhp\ScssPhp\Compiler')) {
			$scss_compiler = new \ScssPhp\ScssPhp\Compiler();
			$scss_compiler->setOutputStyle(\ScssPhp\ScssPhp\OutputStyle::COMPRESSED ?? 'compressed');
			$scss_compiler->setImportPaths(base_path().'/resources/assets/sass/');
		} elseif (class_exists('scssc')) {
			$scss_compiler = new scssc();
			$scss_compiler->setFormatter('scss_formatter_compressed');
			$scss_compiler->setImportPaths(base_path().'/resources/assets/sass/');
		} else {
			return; // Gracefully skip if no SCSS compiler is installed
		}

		$sass_params = NULL;
		// Prepare primary colors (Default landing colors)
		$query = ParametroInstitucion::query();
		$query->select('nombre_parametro', 'valor_parametro');
		$query->join('param.parametro', 'parametro_institucion.codigo_parametro', '=', 'parametro.codigo_parametro');
		$query->where('parametro.codigo_tipo_parametro', TipoParametro::getType('color'));
		$query->where('parametro_institucion.codigo_estado', Estado::getState('active'));
		$query->where('parametro_institucion.codigo_institucion', $institution->codigo_institucion);
		$query->where('parametro.codigo_clase_parametro', ClaseParametro::getClass('landing'));
		$params = $query->get();
		foreach($params as $param) {
			$sass_params .= '$'.strtolower(trim($param->nombre_parametro)).': '.trim($param->valor_parametro).';';
		}

		// Prepare params modules
		$query = ParametroModulo::query();
		$query->select(DB::raw("lower(nombre_parametro || '_' || nombre_modulo) as nombre_parametro"), 'valor_parametro_modulo', 'codigo_tipo_parametro');
		$query->join('seguridad.modulo', 'parametro_modulo.codigo_modulo', '=', 'modulo.codigo_modulo');
		$query->join('param.parametro', 'parametro_modulo.codigo_parametro', '=', 'parametro.codigo_parametro');
		$query->where('parametro_modulo.codigo_estado', Estado::getState('active'));
		$query->where('parametro.codigo_clase_parametro', ClaseParametro::getClass('landing'));
		$query->where(function ($query) {
			$query->whereNotIn('parametro_modulo.codigo_parametro', [Parametro::getParameter('imagen'), Parametro::getParameter('title'), Parametro::getParameter('text')]);
			$query->orWhere(function ($query) {
				$query->where('parametro_modulo.codigo_parametro', Parametro::getParameter('imagen'))->where('parametro_modulo.codigo_modulo', Modulo::getModule('banner'));
			});
		});

		$query->where('parametro_modulo.codigo_institucion', $institution->codigo_institucion);
   		$query->orderBy('parametro_modulo.codigo_modulo','asc');
   		$query->orderBy('parametro_modulo.codigo_parametro','asc');
		$params = $query->get();

		foreach($params as $param) {
			$sass_params .= '$'.trim($param->nombre_parametro).'_land: ';
			if(TipoParametro::getType('image') == $param->codigo_tipo_parametro){
				$sass_params .= "'".trim($param->valor_parametro_modulo)."'";
			}else{
				$sass_params .= trim($param->valor_parametro_modulo);
			}
			$sass_params .= ';';
		}

        $string_sass = $sass_params.file_get_contents(base_path().'/resources/assets/sass/institution_landing.scss');
        if (method_exists($scss_compiler, 'compileString')) {
            $string_css = $scss_compiler->compileString($string_sass)->getCss();
        } else {
            $string_css = $scss_compiler->compile($string_sass);
        }
		$file = public_path().'/css/institution/'.$institution->slug_institucion.'_landing.css';
		file_put_contents($file, $string_css);
	}

	public static function compileStyle($institution)
	{
		$file = public_path().'/css/institution/'.$institution->slug_institucion.'.css';
		if (file_exists($file)) {
			return;
		}

		if (class_exists('ScssPhp\ScssPhp\Compiler')) {
			$scss_compiler = new \ScssPhp\ScssPhp\Compiler();
			$scss_compiler->setOutputStyle(\ScssPhp\ScssPhp\OutputStyle::COMPRESSED ?? 'compressed');
			$scss_compiler->setImportPaths(base_path().'/resources/assets/sass/');
		} elseif (class_exists('scssc')) {
			$scss_compiler = new scssc();
			$scss_compiler->setFormatter('scss_formatter_compressed');
			$scss_compiler->setImportPaths(base_path().'/resources/assets/sass/');
		} else {
			return; // Gracefully skip if no SCSS compiler is installed
		}

		$sass_params = NULL;
		$query = $institution->parametros();
		$query->join('param.parametro', 'parametro_institucion.codigo_parametro', '=', 'parametro.codigo_parametro');
		$query->where('param.parametro_institucion.codigo_estado', Estado::getState('active'));
		$query->where(function($query)
        {
			$query->where('parametro.codigo_clase_parametro', ClaseParametro::getClass('platform'));
			$query->orWhere(function($query)
        	{
				$query->where('parametro.codigo_clase_parametro', ClaseParametro::getClass('landing'));
				$query->where('parametro.codigo_tipo_parametro', TipoParametro::getType('color'));
        	});
        });
		$params = $query->get();

		foreach($params as $param) {
			$sass_params .= '$'.trim($param->parametro->nombre_parametro).': ';
            $type = array(TipoParametro::getType('image_logo_header'), TipoParametro::getType('image'));
			if(in_array($param->parametro->codigo_tipo_parametro, $type)){
				$sass_params .= "'".trim($param->valor_parametro)."'";
			}else{
				$sass_params .= trim($param->valor_parametro);
			}
			$sass_params .= ';';
		}

        $string_sass = $sass_params.file_get_contents(base_path().'/resources/assets/sass/institution.scss');
        if (method_exists($scss_compiler, 'compileString')) {
            $string_css = $scss_compiler->compileString($string_sass)->getCss();
        } else {
            $string_css = $scss_compiler->compile($string_sass);
        }

		$file = public_path().'/css/institution/'.$institution->slug_institucion.'.css';
		file_put_contents($file, $string_css);
	}

	public static function getMentoringDirectRequest($codigo_institucion)
	{
		$query = Institucion::query();
		$query->where('codigo_institucion', $codigo_institucion);
		return $query->pluck('solicitud_directa_mentoria')->first();
    }

    public static function getMartketplaceOnlyEntitiesOwner($codigo_institucion)
	{
		$query = Institucion::query();
		$query->where('codigo_institucion', $codigo_institucion);
		return $query->pluck('marketplace_entidad')->first();
    }

    public static function getMartketplaceOnlyServices($codigo_institucion)
	{
		$query = Institucion::query();
		$query->where('codigo_institucion', $codigo_institucion);
		return $query->pluck('marketplace_servicios')->first();
	}

	public static function getStateValidation($codigo_institucion)
	{
		$query = ValidacionEstadoLogin::query();
		$query->where('codigo_institucion', $codigo_institucion);
		return $query->pluck('codigo_estado')->toArray();
	}

	public static function getColor($codigo_institucion)
	{
		return DB::table('param.institucion')
			->leftjoin('param.parametro_institucion', function($join) {
	            $join->on('param.institucion.codigo_institucion', '=', 'param.parametro_institucion.codigo_institucion')
	        		->where('param.parametro_institucion.codigo_parametro', '=', Parametro::getParameter('secondary_color'))
					->where('param.parametro_institucion.codigo_estado', '=', Estado::getState('active'));
	        })
			->select(DB::raw("COALESCE(valor_parametro, '".Config::get('tuproyecto.color')."') AS color_institucion"))
			->where('param.parametro_institucion.codigo_institucion', '=', $codigo_institucion)
		   	->value('color_institucion');
	}

	public static function getMetaTags($codigo_institucion)
	{
		return (Object) DB::table('param.meta')
			->leftjoin('param.meta_institucion', function($join) use($codigo_institucion) {
				$join->on('param.meta.codigo_meta', '=', 'param.meta_institucion.codigo_meta')
					->where('param.meta_institucion.codigo_institucion', '=', $codigo_institucion)
					->where('param.meta_institucion.codigo_estado', '=', Estado::getState('active'));
	        })
	     	->select('meta_institucion.valor_meta_institucion', 'meta.nombre_meta')
	   		->pluck('valor_meta_institucion', 'nombre_meta')->toArray();
	}

	public static function getSocialLinks($codigo_institucion)
	{
		return (Object) DB::table('param.red_social')
			->leftjoin('param.red_social_instituci', function($join) use($codigo_institucion) {
				$join->on('param.red_social.codigo_red_social', '=', 'param.red_social_instituci.codigo_red_social')
					->where('param.red_social_instituci.codigo_institucion', '=', $codigo_institucion);
	        })
	     	->select('red_social_instituci.valor_red_social_institucion', 'red_social.nombre_red_social')
	   		->pluck('valor_red_social_institucion', 'nombre_red_social')->toArray();
	}

    /**
    * Checks if the role institution has a permission by its name.
    *
    * @param string $permissionName - Permission name.
    *
    * @return bool
    */
    public static function hasPermission($permissionName)
    {
        $role = Rol::where('name', RegistroSesion::getInstitution())->first();
        return $role->hasPermission($permissionName);
    }

	/**
	 * Defining Relations
	*/

	public function parametros()
    {
        return $this->hasMany('App\ParametroInstitucion','codigo_institucion','codigo_institucion');
    }

    public function metas()
    {
        return $this->hasMany('App\MetaInstitucion','codigo_institucion','codigo_institucion');
    }

    public function social()
    {
        return $this->hasMany('App\RedSocialInstitucion','codigo_institucion', 'codigo_institucion');
    }

    public function marketplaceRecommendation()
    {
        return $this->hasMany('App\RecomendacionMarketplace','codigo_institucion', 'codigo_institucion')->where('codigo_estado', Estado::getState('active'));
    }
}
