<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request, Redirect, View, Input, Response, Session, URL;

use TuProyecto;

use App\TerminosCondiciones, App\TipoPagoInstitucion, App\RegistroSesion, App\Institucion, App\LandingPage;

class HomeController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | Default Home Controller
    |--------------------------------------------------------------------------
    |
    | You may wish to use controllers instead of, or in addition to, Closure
    | based routes. That's great! Here is an example controller method to
    | get you started. To route to this controller, just add the route:
    |
    */

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $institution = Institucion::find(RegistroSesion::getInstitution());

        if($institution instanceof Institucion) {
            // Compile style institution
            Institucion::compileStyleLanding($institution);

            // Data prepare
            RegistroSesion::dataPrepare($institution);

            $data = Institucion::getLandingData($institution);

            // Redirect another landing
            if ($institution->landing_externo) {
                return Redirect::to($institution->landing_externo);
            }

            // Landing page personalization
            if($institution->personalizacion_landing) {
                return view("public.landing.institutions.{$institution->slug_institucion}", $data);
            }

            // Default Landing page
            return view('public.landing.landing', $data);
        }
        abort(404);
    }

    public function show($slug)
    {
        $institution = Institucion::getInstitutionSlug($slug);

        if($institution instanceof Institucion) {
            // Compile style institution
            Institucion::compileStyleLanding($institution);
            // Data prepare
            RegistroSesion::dataPrepare($institution);

            $data = Institucion::getLandingData($institution);

            // Redirect another landing
            if ($institution->landing_externo) {
                return Redirect::to($institution->landing_externo);
            }

            // Landing page personalization
            if($institution->personalizacion_landing) {
                return view("public.landing.institutions.{$institution->slug_institucion}", $data);
            }

            // Default Landing page
            return view('public.landing.landing', $data);
        }
        abort(404);
    }

    public function landing($category, $slug)
    {
        $page = LandingPage::getPage($category, $slug);
        if(!$page instanceof LandingPage){
            abort(404);
        }
        $institution = RegistroSesion::institution();

        return view("public.landing.institutions.{$institution->slug_institucion}.{$category}_{$slug}", compact('page', 'institution'));
    }

    public function terminos()
    {
        $data = [];
        $data['terminos'] = TerminosCondiciones::termsAndConditions(TerminosCondiciones::getTypeTerms('terms'));
        return View::make('public/terms', $data);
    }

    public function privacidad()
    {
        $data = [];
        $data['terminos'] = TerminosCondiciones::termsAndConditions(TerminosCondiciones::getTypeTerms('privacy'));
        return View::make('public/terms', $data);
    }

    public function politicaventas()
    {
        $data = [];
        $data['terminos'] = TerminosCondiciones::termsAndConditions(TerminosCondiciones::getTypeTerms('sales'));
        return View::make('public/terms', $data);
    }

    public function terminosmentoria()
    {
        $data = [];
        $data['terminos'] = TerminosCondiciones::termsAndConditions(TerminosCondiciones::getTypeTerms('mentoring'));
        return View::make('public/terms', $data);
    }

}
