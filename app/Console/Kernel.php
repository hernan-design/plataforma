<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Algolia
        // Commands\Algolia\AlgoliaSync::class,
        // Commands\Algolia\AlgoliaSyncItem::class,
        // Commands\Algolia\AlgoliaDesync::class,
        // Commands\Algolia\AlgoliaDesyncItem::class,

        // GoogleApi
		Commands\GoogleApi\MakeCalendarConference::class,
		Commands\GoogleApi\MakeMentorConference::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //$schedule->command('algolia:sync')->daily();
        //$schedule->command('algolia:desync')->daily();
    }
}
