<?php

use App\Classes\ActivityLogger;

function transtp($keyname, $parameters = [], $domain = 'messages', $locale = null)
{
	$localKey = sprintf('%s.%s', App\RegistroSesion::getInstitutionSlug(), $keyname);
	$value = trans($localKey, $parameters, $domain, $locale);
	if($value != $localKey) {
		return $value;
	}

	return trans(sprintf('tuproyecto.%s', $keyname), $parameters, $domain, $locale);
}

/**
 * Get the path to a versioned Elixir file.
 *
 * @param  string  $file
 * @return string
 *
 * @throws \InvalidArgumentException
 */
function elixir($file, $buildPath = 'build/')
{
    $manifest = null;

    if (is_null($manifest)) {
        $manifest = json_decode(file_get_contents(public_path($buildPath .'rev-manifest.json')), true);
    }

    if (isset($manifest[$file])) {
        return url($buildPath . $manifest[$file]);
    }

    throw new InvalidArgumentException("File {$file} not defined in asset manifest.");
}

/**
 * Get URL friendly "slug" from the given string
 *
 * @param  string  $string
 * @return string
 *
 * @throws \InvalidArgumentException
 */
function slugtp($string, $table, $field, $institution = false, $contador = 0)
{
	$string = str_slug($string, "-");
	$slug = $contador > 0 ? sprintf("%s-%d", $string, $contador) : $string;

	$query = DB::table($table);
	$query->whereRaw("trim(lower($field)) = trim(lower('$slug'))");
	if($institution) {
		$query->where("codigo_institucion", RegistroSesion::getInstitution());
	}
	$object = $query->first();

	if(!is_null($object)) {
		$contador ++;
		$slug = slugtp($string, $table, $field, $institution, $contador);
	}

	return $slug;
}

if (!function_exists('activity')) {
    function activity(string $logName = null): ActivityLogger
    {
        $defaultLogName = config('activitylog.default_log_name');
        return app(ActivityLogger::class)->useLog($logName ?? $defaultLogName);
    }
}