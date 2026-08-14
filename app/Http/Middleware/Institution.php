<?php

namespace App\Http\Middleware;

use Closure;

use App\RegistroSesion, App\Institucion;

class Institution
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        if( !is_numeric(RegistroSesion::getInstitution()) ) {
            
            $institution = Institucion::getInstitutionSlug( Institucion::getInstitutionHost() );
            // Compile style institution
            Institucion::compileStyle($institution);

            // Data prepare
            RegistroSesion::dataPrepare($institution);
        }
        return $next($request);
    }
}