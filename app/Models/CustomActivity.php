<?php

namespace App\Models;

use Spatie\Activitylog\Models\Activity;

class CustomActivity extends Activity
{
    protected $table = 'bita.activity_log';

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($activity) {
            // Drop columns added in v5/v4 because the DB schema is still v3
            unset($activity->attribute_changes);
            unset($activity->event);
            unset($activity->batch_uuid);

            // Populate the custom column required by this project's database schema
            if (empty($activity->codigo_institucion)) {
                $activity->codigo_institucion = \App\RegistroSesion::getInstitution() ?? 1; // Default to 1 if session is unavailable
            }
        });
    }
}
