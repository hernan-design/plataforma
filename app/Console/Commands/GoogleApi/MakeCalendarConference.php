<?php

namespace App\Console\Commands\GoogleApi;

use Illuminate\Console\Command;
use Carbon\Carbon;

use URL, DB, Log, Google, SendEmail;

  class MakeCalendarConference extends Command
  {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'googleapi:makecalendarconference';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List events GoogleCalendar';
    private $index = null;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {

      parent::__construct();
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     *
     */
    public function handle()
    {

		$this->info('googleapi is running make calendar conference');

        $client = Google::getClient();
        $client->setSubject('comunicaciones@tuproyecto.com');
        $service =  Google::make('Calendar');



        // Print the next 10 events on the user's calendar.
        $calendarId = 'comunicaciones@tuproyecto.com';
        $optParams = array(
        'maxResults' => 10,
        'orderBy' => 'startTime',
        'singleEvents' => true,
        'timeMin' => date('c'),
        );


        // start event datetime
        // $start = '2020-05-05T17:00:00-07:00';
        $start =  Carbon::now()->toIso8601String();
        $eventDateTimeStart =  Google::make('Calendar_EventDateTime');
        $eventDateTimeStart->setDateTime($start);

        // end event datetime
        // $end = '2020-05-05T17:01:00-07:00';
        $end =  Carbon::now()->addHour()->toIso8601String();
        $eventDateTimeEnd =  Google::make('Calendar_EventDateTime');
        $eventDateTimeEnd->setDateTime($end);

        $eventAtendeesList = [];
         // event attendee
         $eventAtendee =  Google::make('Calendar_EventAttendee');
         $eventAtendee->setEmail('diego.gomez@tuproyecto.com');
         $eventAtendeesList[] = $eventAtendee;

         $eventAtendee =  Google::make('Calendar_EventAttendee');
         $eventAtendee->setEmail('sebastians@me.com');
         $eventAtendeesList[] = $eventAtendee;


        $events = [];
        try {
            $results = $service->events->listEvents($calendarId, $optParams);

            $events = $results->getItems();

        } catch (Exception $e) {
            $message = $e->getMessage();
			Log::error(sprintf('%s:%s', 'App\Console\Commands\GoogleApi\MakeCalandarConference', $message));
			$this->info($message);
			dd($message);
        }

        $count =  !empty($events) ? count($events) : 0 ;


        // $event
        $event =  Google::make('Calendar_Event');
        $event->setSummary('VideoConference start at ' . $start);
        $event->setLocation('VideoConference');
        $event->setDescription("VideoConference");
        $event->setStart($eventDateTimeStart);
        $event->setEnd($eventDateTimeEnd);
        $event->setAttendees($eventAtendeesList);

        $this->info(sprintf("Summary: %s\n", $event->getSummary()));
        $this->info(sprintf("Location: %s\n", $event->getLocation()));
        $this->info(sprintf("Description: %s\n", $event->getDescription()));
        $this->info(sprintf("start: %s\n", $event->start->getDateTime()));
        $this->info(sprintf("end: %s\n", $event->end->getDateTime()));

        $response = '';

        try {
            $event = $service->events->insert($calendarId, $event);
            $this->info('Event Created!');

        } catch (Exception $e) {
			$message = $e->getMessage();
			Log::error(sprintf('%s:%s', 'App\Console\Commands\GoogleApi\MakeCalandarConference', $message));
			$this->info($message);
            dd($message);
        }

        try {

          // $entryPoint = Google::make('Calendar_EntryPoint');
          // $entryPoint->setAccessCode('wx12z3s');
          // $entryPoint->setEntryPointType('video');
          // $entryPoint->setLabel('meet.google.com/wx12z3s');
          // $entryPoint->setMeetingCode('wx12z3s');
          // $entryPoint->setPasscode('wx12z3s');
          // $entryPoint->setPassword('wx12z3s');
          // $entryPoint->setPin('wx12z3s');
          // $entryPoint->setUri('https://meet.google.com/wx12z3s');

          $conference = Google::make('Calendar_ConferenceData');
         // $conference->setEntryPoints($entryPoint);
          $conferenceRequest = Google::make('Calendar_CreateConferenceRequest');
          $conferenceRequest->setRequestId('randomString12345');
          $conference->setCreateRequest($conferenceRequest);
          $event->setConferenceData($conference);
          $event->setAnyoneCanAddSelf(true);
          $event = $service->events->patch($calendarId, $event->id, $event, ['conferenceDataVersion' => 1]);

		  $this->info(sprintf('Conference created: %s', $event->hangoutLink));
		  Log::info(sprintf('Conference created: %s', $event->hangoutLink));

          $response = $event->htmlLink;
          // Send mail
          // $data = [];
          // $data['_template'] = 'emails.meet';
          // $data['_subject'] = "Agenda de meet";
          // $data['_to'] = "diego.gomez@tuproyecto.com";
          // $data['_to_name'] = "Diego Gomez";
          // $data['_inst'] = 51;
          // $data['_url'] = $event->hangoutLink;
          // SendEmail::notification($data);

          // $data = [];
          // $data['_template'] = 'emails.meet';
          // $data['_subject'] = "Agenda de meet";
          // $data['_to'] = "sebastians@me.com";
          // $data['_to_name'] = "Sebastian";
          // $data['_inst'] = 51;
          // $data['_url'] = $event->hangoutLink;
          // SendEmail::notification($data);

        } catch (Exception $e) {
			$message = $e->getMessage();
			Log::error(sprintf('%s:%s', 'App\Console\Commands\GoogleApi\MakeCalandarConference', $message));
			$this->info($message);
			dd($message);
        }

        return $response;
    }

  }
