<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use App\Observers\LikeObserver, App\Observers\DiscusionObserver, App\Observers\ComentarioDiscusionObserver;

use App\Like, App\DiscusionInstitucion, App\ComentarioDiscusion;

class EventServiceProvider extends ServiceProvider
{
	/**
	 * The event listener mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [];

	/**
	 * The subscriber classes to register.
	 *
	 * @var array
	 */
	protected $subscribe = [
		'App\Listeners\UserEventListener',
	];

	/**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

		// Like::observe(new LikeObserver);
		// DiscusionInstitucion::observe(new DiscusionObserver);
		// ComentarioDiscusion::observe(new ComentarioDiscusionObserver);
    }
}
