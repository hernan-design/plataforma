<?php

use App\RegistroSesion, Carbon\Carbon;

class TuProyecto
{
	public static function timeAgo($date = null, $time = null)
	{

        if($time === null) {
			$time = '';
	    }

        if($date === null || $time === null) {
			return Lang::get('app.undefined_date_time');
        }


		$date_time = strtotime($date.' '.$time);

		$etime = time() - $date_time;
		if ($etime < 1) {
			$time_ago = "%s %s %s";
			return sprintf($time_ago, Lang::get('app.time_ago'), 1, strtolower(Lang::choice("app.second", 1)));
		}

		$a = array( 365 * 24 * 60 * 60  =>  'year',
			30 * 24 * 60 * 60  =>  'month',
			24 * 60 * 60  =>  'day',
			60 * 60  =>  'hour',
			60  =>  'minute',
			1  =>  'second'
		);

		foreach ($a as $secs => $str) {
			$d = $etime / $secs;
			if ($d >= 1) {
				$r = round($d);
				$time_ago = "%s %s %s";
				if(Cookie::get('_lang', 'es') == 'es') {
					return sprintf($time_ago, Lang::get('app.time_ago'), $r, strtolower(Lang::choice("app.$str", $r)));
				}else{
					return sprintf($time_ago, $r, Lang::choice("app.$str", $r), strtolower(Lang::get('app.time_ago')));
				}
			}
		}
	}

	public static function remainingDaysToEnd($date, $lang = 'es')
	{
		if($date === null) {
			return null;
		}
		//$date_time = strtotime($date);


		Carbon::setlocale(LC_TIME, 'es');


		$date2 = new  Carbon($date);
		$date1 = Carbon::now();

		if($date1->lessThan($date2)){
			$message = $date2->diffForHumans($date1, ['syntax' =>1]);
			return $message;
		}

		return false;
	}

	public static function remainingDaysToEndConvocatoria($date, $hour, $lang = 'es')
	{
		if ($date === null || $hour === null) {
			return null;
		}

		Carbon::setlocale(LC_TIME, 'es');

		$dateAndHour = "$date $hour";
		$date2 = new Carbon($dateAndHour);
		$date1 = Carbon::now();

		if ($date1->lessThan($date2)) {
			$message = $date2->diffForHumans($date1, ['syntax' => 1]);
			return $message;
		}

		return false;
	}

	public static function postsDateFormat($date = null, $time = null)
	{
		if($date === null || $time === null) {
			return Lang::get('app.undefined_date_time');
	    }
	    $time = strtotime($time);
	    $date = strtotime($date);
	    $month = strtolower(jdmonthname(gregoriantojd(date('m',$date), 1, 1), CAL_MONTH_GREGORIAN_LONG));

		$date_format = "%s %s, %d, %s";
		return sprintf($date_format, Lang::get("app.$month"), date(Lang::get('app.day_format'),$date), date('Y',$date), date('g:i a',$time));
	}

	public static function dateFormat($date = NULL, $type = 'large')
	{
		if($date === NULL) {
			return;
	    }

	    $date = strtotime($date);
	    $month = strtolower(jdmonthname(gregoriantojd(date('m',$date), 1, 1), CAL_MONTH_GREGORIAN_LONG));
	    $day_week = strtolower(jddayofweek ( cal_to_jd(CAL_GREGORIAN, date("m",$date),date("d",$date), date("Y",$date)) , 1 ));
	    $day_month = strftime('%e',strtotime($date));

	    switch ($type) {
	    	case 'short':
			    $date_format = "%s/%d";
				return sprintf($date_format, substr(strtoupper(Lang::get("app.$month")) ,0, 3), date('d',$date));
	    	case 'large':
	    		$date_format = "%d-%s-%d";
				return sprintf($date_format, date('d',$date), substr(Lang::get("app.$month") ,0, 3), date('y',$date));
			case 'complete':
	    		$date_format = "%s, %s %d, %d";
				return sprintf($date_format, substr(Lang::get("app.$day_week") ,0), substr(Lang::get("app.$month") ,0), date('d',$date), date('Y',$date));
			case 'daymonthnameyear':
				$date_format = "%d de %s, %d";
				return sprintf($date_format, date('d',$date),  substr(Lang::get("app.$month") ,0), date('Y',$date));
			case 'month':
			    $date_format = "%s %s";
				return sprintf($date_format, date('Y',$date), Lang::get("app.$month"));
			case 'day':
			    $date_format = "%s";
				return sprintf($date_format, mb_substr(Lang::get("app.$day_week") ,0, 3));
			case 'daymonthnameyeartime':
				$date_format = "%d de %s, %d %s";
				return sprintf($date_format, date('d',$date),  substr(Lang::get("app.$month") ,0), date('Y',$date), date('H:i', $date));
	    	default: return $date;
	    }
  	}
	public static function timeFormat($time = NULL)
	{
		if($time === NULL) {
			return;
	    };
		return sprintf(date("g:i A", strtotime($time)));
  	}

  	public static function randomPassword($length = 8)
  	{
	    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	    return substr( str_shuffle( $chars ), 0, $length );
	}

	/**
	  * Return URL-Friendly string slug
	  * @param string $string
	  * @return string
	  */
	public static function seoUrl($string)
	{
		$string = trim($string);
		// Cut string 45 characters by words
		$limit = 45;
		if(strlen($string) > $limit) {
			if(false !== ($breakpoint = strpos($string, ' ', $limit))) {
				if($breakpoint < strlen($string) - 1) {
					$string = substr($string, 0, $breakpoint);
				}
			}
		}
		// Unwanted:  {UPPERCASE} ; / ? : @ & = + $ , . ! ~ * ' ( )
	    $string = strtolower($string);
	    // Strip accents
		$string = strtr(utf8_decode($string), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
	    // Strip any unwanted characters
	    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
	    // Clean multiple dashes or whitespaces
	    $string = preg_replace("/[\s-]+/", " ", $string);
	    // Convert whitespaces and underscore to dash
	    $string = preg_replace("/[\s_]/", "-", $string);
	    return $string;
	}


	/**
	  * Cut string characters by words (...)
	  * @param string $string
	  * @return string
	  */
	public static function cutFormatString($string, $limit = 180)
	{
		if(strlen($string) > $limit) {
			if(false !== ($breakpoint = strpos($string, ' ', $limit))) {
				if($breakpoint < strlen($string) - 1) {
					$string = substr($string, 0, $breakpoint);
				}
			}
			$string .= '...';
		}
		return $string;
	}

	/**
	  * Cut string characters by words (...)
	  * @param string $string
	  * @return string
	  */
	public static function cutStrictFormatString($string, $limit = 180)
	{
		if(strlen($string) > $limit) {
			$string = substr($string, 0, $limit);
		}
		return $string;
	}

	/**
	  * Return breadcrumbs
	  * @param string $path
	  * @return string
	  */
	public static function breadcrumb($path = null)
	{
		$routes = collect( explode('/', $path) );
		$breadcrumbs = [];
		// Path Home
		$breadcrumbs[] = (object) ['title' => trans('app.home'), 'url' => url('/'), 'type' => 'home', 'current' => false, 'unavailable' => false];

		$path_url = '';
		foreach ($routes as $route) {
			if($route) {
				$current = $routes->last() == strtolower(trim($route)) ? true : false;
				$unavailable = false;

				$path_url .= "/$route";
				$title = collect( explode('?', $route) )->first();

				$breadcrumbs[] = (object) ['title' => $title, 'url' => $path_url, 'current' => $current, 'unavailable' => $unavailable];
			}
		}
		return $breadcrumbs;
	}

	public static function encryptSrcParams($data)
	{
		foreach($data as $index => $value) {
			$data[$index] = Crypt::encrypt($value);
	    }
	    return implode(Config::get('tuproyecto.src_params_separate'), $data);
	}

	public static function decryptSrcParams($data = null)
	{
		if($data != null) {
			$data = explode(Config::get('tuproyecto.src_params_separate'), $data);
			foreach($data as $index => $value) {
				$data[$index] = Crypt::decrypt($value);
			}
		}
		return $data;
	}

	/**
	  * Return encryptList
	  * @param string $array
	  * @return string
	  */
	public static function encryptList($array)
	{
		$lists=[];
		if(count($array) > 0) {
			foreach ($array as $list) {
				$encryptlist = new stdClass();
				$encryptlist->key = Crypt::encrypt($list->key);
				$encryptlist->value = $list->value;
				$lists[] = $encryptlist;
			}
		}
		return $lists;
	}

	public static function getYears($nextyears = 4)
	{
	    $anios = [];
	    for($i = date("Y"); $i  <= (date("Y") + $nextyears); $i++){
	        $anios[$i] = $i;
	    }
	    return $anios;
	}

	public static function getPastYears()
	{
	    $anios = [];
	    for($i = date('Y'); $i >= (date('Y') - 100); $i--){
	        $anios[$i] = $i;
	    }
	    return $anios;
	}

	public static function getMonths()
	{
	    $months = [];
		for ($x = 1; $x <= 12; $x++) {
			$month = strtolower(jdmonthname(gregoriantojd($x, 1, 1), CAL_MONTH_GREGORIAN_LONG));
		    $months[$x] = Lang::get("app.$month");
		}
		return $months;
	}

	public static function getTitleSection()
	{
		$section = Request::segment(1);
		switch ($section) {
			case 'foro': return Lang::choice('forum.forum', 0);
			case 'proyecto': return Lang::choice('project.project', 0);
			case 'convocatoria': return Lang::choice('call.call', 0);
			default: return;
		}
	}

	/**
	  * Algolia function
  	  * Return route hit
	  * @param string $hit
	  * @return string $route
	  */
	public static function getRouteSearch($hit)
	{
		switch ($hit['type']) {
			case 'article': return URL::route('blog.categoria.articulo', ['article' => $hit['url'], 'category' => self::category($hit['_categories'])], true);
			case 'forum': return URL::route('foro.categoria.tema', ['theme' => $hit['url'], 'category' => $hit['url_category']], true);
			case 'course': return URL::route('aprende.categoria.curso', ['course' => $hit['url'], 'category' => $hit['url_category'], 'type' => 'cursos'], true);
			case 'product': return URL::route('marketplace.show', ['product' => $hit['url']], true);
			case 'event': return URL::route('calendario.evento.show', ['event' => $hit['url']], true);
			case 'mentor': return URL::route('mentoria.mentores.show', ['mentor' => $hit['url']], true);
			case 'program': return URL::route('convocatoria.convocatoria', ['convocatoria' => $hit['url']], true);
			default: return;
		}
	}

	/**
	  * Algolia function
  	  * Return category hit institution
	  * @param string $categories
	  * @return string $category institution
	  */
    public static function category($hit_categories)
    {
        if(isset($hit_categories) && !empty($hit_categories)){
            $categories = explode(';', $hit_categories);
            foreach ($categories as $category) {
                $category = explode(',', $category);
                $institution = current($category);
                if(isset($institution) && $institution == RegistroSesion::getInstitution()) {
                    return end($category);
                    break;
                }
            }
        }
    }

	/**
	  * Return name user string
	  * @param string $string
	  * @return string
	  */
	public static function unwantedCharacters($string)
	{
		$string = trim($string);
		// Unwanted:  {UPPERCASE} ; / ? : @ & = + $ , . ! ~ * ' ( )
	    $string = strtolower($string);
	    // Strip accents
		$string = strtr(utf8_decode($string), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
	    // Strip any unwanted characters
	    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
	    return $string;
	}

	/**
	 *
	 *
	*/
	public static function parseFileJSON($pathFile)
	{
		$jsonString = file_get_contents($pathFile);
		$objFile = json_decode($jsonString, true);

		return $objFile;
	}

	/**
	 *
	 *
	*/
	public static function assetEnv($assetsObj, $refFile = '', $onProduction = false)
	{

		if( !$onProduction ) {
			return $refFile;

		} else {

			return $assetsObj[$refFile];
		}
	}


	public static function accents($cadena) {
		$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
		$permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
		$texto = str_replace($no_permitidas, $permitidas ,$cadena);
		return $texto;
	}
}
