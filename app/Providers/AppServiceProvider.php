<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Pagination\Paginator;
use Laravel\Socialite\One\TwitterProvider;
use Laravel\Socialite\Two\LinkedInProvider;
use Laravel\Socialite\Two\FacebookProvider;
use League\OAuth1\Client\Server\Twitter as TwitterServer;
use Carbon\Carbon;
use App\RegistroSesion;

use Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		Blade::withoutDoubleEncoding();
		Paginator::useBootstrap();
		Blade::withoutComponentTags();

    	// Carbon Locale
		Carbon::setLocale(config('app.locale'));


        // Socialite
        $socialite = $this->app->make('Laravel\Socialite\Contracts\Factory');
        $socialite->extend(
            'twitter',
            function ($app) use ($socialite) {
                $institution = RegistroSesion::institution();
                return new TwitterProvider(
                    $app['request'], new TwitterServer([
                        'identifier' => $institution->twitter_api_key,
                        'secret' => $institution->twitter_secret_key,
                        route('auth.provider.callback', ['provider' => 'twitter'])
                    ])
                );
            }
        );

        $socialite->extend(
            'linkedin',
            function ($app) use ($socialite) {
                $institution = RegistroSesion::institution();
                return new LinkedInProvider( $app['request'],
                    $institution->linkedin_api_key,
                    $institution->linkedin_secret_key,
                    route('auth.provider.callback', ['provider' => 'linkedin'])
                );
            }
        );

        $socialite->extend(
            'facebook',
            function ($app) use ($socialite) {
                $institution = RegistroSesion::institution();
                return new FacebookProvider( $app['request'],
                    $institution->facebook_api_key,
                    $institution->facebook_secret_key,
                    route('auth.provider.callback', ['provider' => 'facebook'])
                );
            }
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
