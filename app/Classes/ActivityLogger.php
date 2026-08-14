<?php

namespace App\Classes;

use Spatie\Activitylog\ActivitylogServiceProvider;

use App\RegistroSesion;

class ActivityLogger extends \Spatie\Activitylog\ActivityLogger
{
    /**
     * @param string $description
     *
     * @return null|mixed
     */
    public function log(string $description)
    {
        if ($this->logStatus->disabled()) {
            return;
        }

        $activity = ActivitylogServiceProvider::getActivityModelInstance();
        $activity->properties = $this->getActivity()->properties;
        $activity->description = $this->replacePlaceholders($description, $activity);
        $activity->log_name = $this->defaultLogName;
        $activity->codigo_institucion = RegistroSesion::getInstitution();
        $activity->save();

        return $activity;
    }
}
