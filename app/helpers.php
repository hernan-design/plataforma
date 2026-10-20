<?php

use Illuminate\Support\Str;

/**
 * Missing HTML helper functions from laravelcollective/html
 */
if (! function_exists('link_to')) {
    function link_to($url, $title = null, $attributes = [], $secure = null) {
        return \App\Helpers\HtmlHelper::link($url, $title, $attributes, $secure);
    }
}

if (! function_exists('link_to_asset')) {
    function link_to_asset($url, $title = null, $attributes = [], $secure = null) {
        return \App\Helpers\HtmlHelper::link(asset($url, $secure), $title, $attributes, $secure);
    }
}

if (! function_exists('link_to_route')) {
    function link_to_route($name, $title = null, $parameters = [], $attributes = []) {
        return \App\Helpers\HtmlHelper::link(route($name, $parameters), $title, $attributes);
    }
}

if (! function_exists('link_to_action')) {
    function link_to_action($action, $title = null, $parameters = [], $attributes = []) {
        return \App\Helpers\HtmlHelper::link(action($action, $parameters), $title, $attributes);
    }
}

/**
 * Traducción personalizada con soporte de institución y fallback a tuproyecto.
 */
function transtp(string $keyname, array $parameters = [], string $domain = 'messages', ?string $locale = null): string
{
    $localKey = sprintf('%s.%s', App\RegistroSesion::getInstitutionSlug(), $keyname);
    $value = trans($localKey, $parameters, $domain, $locale);
    if ($value !== $localKey) {
        return $value;
    }

    return trans(sprintf('tuproyecto.%s', $keyname), $parameters, $domain, $locale);
}

/**
 * Obtiene la URL de un asset compilado por Vite.
 * Reemplaza la antigua función elixir() de Laravel Elixir (Laravel 5.x).
 * Compatible con Laravel 13 + Vite 6+.
 *
 * @param  string  $file  Ruta relativa al asset (ej: 'css/app.css')
 * @return string
 */
if (!function_exists('elixir')) {
    function elixir(string $file): string
    {
        $viteMap = [
            'css/application.css' => 'resources/assets/sass/application.scss',
            'css/landing.css' => 'resources/assets/sass/landing.scss',
            'js/app-client.js' => 'resources/assets/js/app-client.js'
        ];
        
        // Fuerza el uso del build de producción leyendo el manifest directamente
        if (isset($viteMap[$file])) {
            $manifestPath = public_path('build/manifest.json');
            if (file_exists($manifestPath)) {
                $manifest = json_decode(file_get_contents($manifestPath), true);
                $viteKey = $viteMap[$file];
                if (isset($manifest[$viteKey]['file'])) {
                    return asset('build/' . $manifest[$viteKey]['file']);
                }
            }
        }
        
        // Fallback para todo lo demás (archivos estáticos minificados, vendors, etc)
        return asset($file);
    }
}

/**
 * Genera un slug único verificando contra la base de datos.
 * Reemplaza el antiguo str_slug() eliminado en Laravel 9+.
 *
 * @param  string  $string       Texto a convertir en slug
 * @param  string  $table        Tabla a verificar unicidad
 * @param  string  $field        Campo de la tabla
 * @param  bool    $institution  Si debe filtrar por institución
 * @param  int     $contador     Contador para slugs duplicados
 * @return string
 */
function slugtp(string $string, string $table, string $field, bool $institution = false, int $contador = 0): string
{
    $string = Str::slug($string, '-');
    $slug   = $contador > 0 ? sprintf('%s-%d', $string, $contador) : $string;

    $query = DB::table($table);
    $query->whereRaw("trim(lower({$field})) = trim(lower(?))", [$slug]);

    if ($institution) {
        $query->where('codigo_institucion', App\RegistroSesion::getInstitution());
    }

    if (!is_null($query->first())) {
        $slug = slugtp($string, $table, $field, $institution, $contador + 1);
    }

    return $slug;
}
