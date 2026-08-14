<?php

namespace App\Console\Commands\GoogleApi;

use Illuminate\Console\Command;
use Carbon\Carbon;

use App\Mentoria, App\Evento, App\RegistroSesion, App\Institucion;

use URL, Log, Lang, Google, SendEmail, TuProyecto;

  class MakeMentorConference extends Command
  {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
	protected $signature = 'googleapi:makementorconference
							{mentoringID : Id of the mentoring process}
							{sessionID : Id of the  mentoring session event}
							{institution : codigo of the institution}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make a mentoring session conference';
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

		$this->info('a new mentoring session conference is being created!');

	try {

			$mentoringID = (int) $this->argument('mentoringID');
			$mentoring = Mentoria::find($mentoringID);
			if(!$mentoring instanceof Mentoria) {
				throw new \Exception(sprintf("Mentoring not found Id:%s", $mentoringID) );
			}

			$sessionID = (int) $this->argument('sessionID');
			$session = Evento::find($sessionID);
			if(!$session instanceof Evento) {
			throw new \Exception(sprintf("Event not found Id:%s", $sessionID));
			}

			$institutionID = (int) $this->argument('institution');
			$institution = Institucion::find($institutionID);
			if(!$institution instanceof Institucion) {
			throw new \Exception(sprintf("Institution not found Id:%s", $institutionID));
			}

			// $client = Google::getClient();
			// $client->setSubject('comunicaciones@tuproyecto.com');
			// $service =  Google::make('Calendar');



			// Print the next 10 events on the user's calendar.
			$calendarId = 'comunicaciones@tuproyecto.com';
			$optParams = array(
				'maxResults' => 10,
				'orderBy' => 'startTime',
				'singleEvents' => true,
				'timeMin' => date('c'),
			);


			// start event datetime
			// $start format = '2020-05-05T17:00:00-07:00';
			$now = Carbon::now();
			$start = Carbon::createFromFormat('Y-m-d H:i:s', sprintf('%s %s',$session->fecha_evento,$session->hora_inicio_evento));
			$start = $start->greaterThan($now) ? $start : $now;
			$start = $start->subMinutes(13)->subSecond()->toIso8601String();
			// $eventDateTimeStart =  Google::make('Calendar_EventDateTime');
			// $eventDateTimeStart->setDateTime($start);

			// end event datetime
			// $end  format = '2020-05-05T17:01:00-07:00';
			$now =  Carbon::now()->addHour();
			$end = Carbon::createFromFormat('Y-m-d H:i:s', sprintf('%s %s',$session->fecha_evento,$session->hora_inicio_evento));
			$end = $end->greaterThan($now) ? $end : $now;
			$end = $end->addMinutes(13)->addSecond()->toIso8601String();
			// $eventDateTimeEnd =  Google::make('Calendar_EventDateTime');
			// $eventDateTimeEnd->setDateTime($end);


			$eventAtendeesList = [];
			// event attendee
			// $eventAtendee =  Google::make('Calendar_EventAttendee');
			// $eventAtendee->setEmail($mentoring->mentor->correo_electronico);
			// $eventAtendeesList[] = $eventAtendee;

			// $eventAtendee =  Google::make('Calendar_EventAttendee');
			// $eventAtendee->setEmail($mentoring->usuario->correo_electronico);
			// $eventAtendeesList[] = $eventAtendee;

			$events = [];

			// $results = $service->events->listEvents($calendarId, $optParams);

			// $events = $results->getItems();

			$count =  !empty($events) ? count($events) : 0 ;


			// $event
			// $event =  Google::make('Calendar_Event');
			// $event->setSummary('Evento virtual del ' . $start);
			// $event->setLocation('VideoConference');
			// $event->setDescription("VideoConference");
			// $event->setStart($eventDateTimeStart);
			// $event->setEnd($eventDateTimeEnd);
			// $event->setAttendees($eventAtendeesList);

			// $this->info(sprintf("Summary: %s\n", $event->getSummary()));
			// $this->info(sprintf("Location: %s\n", $event->getLocation()));
			// $this->info(sprintf("Description: %s\n", $event->getDescription()));
			// $this->info(sprintf("start: %s\n", $event->start->getDateTime()));
			// $this->info(sprintf("end: %s\n", $event->end->getDateTime()));

			$response = '';

			// $event = $service->events->insert($calendarId, $event);
			$this->info('Event Created!');

			// $conference = Google::make('Calendar_ConferenceData');
			// $conferenceRequest = Google::make('Calendar_CreateConferenceRequest');
			// $conferenceRequest->setRequestId('randomString12345');
			// $conference->setCreateRequest($conferenceRequest);
			// $event->setConferenceData($conference);
			// $event->setAnyoneCanAddSelf(true);
			// $event = $service->events->patch($calendarId, $event->id, $event, ['conferenceDataVersion' => 1]);

			// get URL conference
			// $url_conference = $event->hangoutLink;
			// $this->info(sprintf('Conference created: %s', $url_conference ));
			// Log::info(sprintf('Conference created: %s',$url_conference));

			//contact email
			switch ( RegistroSesion::getInstitution() ) {

				case 30: //compensar ajuste del correo notificacion sesiones
					$contactEmail = 'fomentoempresarial@compensar.com';
					break;
				case 60: //atrévete mipyme
					$contactEmail = 'emprendimiento@ventures.com.co';
					break;
				case 61: //ruta n
					$contactEmail = 'rutan@rutan.co';
					break;
				default:
					$contactEmail = '';
					break;
			}
			//
			/*function shortrUrl($url){
				$len = strlen($url);
				if($len > 45){
					$len = $len - 30;
					$ini_url = substr($url, 0, -$len);
					$fin_url = substr($url, -15);
					$new_url = $ini_url;
					return $new_url;
				}else{
					return $url;
				}
			}*/

			//$url_larga = "http://www.google.com.pe/search?hl=en&q=ribosomatic&btnG=Google+Search&meta=";

			// User Mail Notification
			$data = [];
			switch ($institutionID) {
				case '30':
					$data['_template'] = 'emails.mentoring.confirm.compensar';
					$data['_subject'] = Lang::get('mentoring.mail.confirm.subject.compensar',['user' => $session->usuario->nombre_usuario]);
					break;
				case '61':
					Log::info('template de ruta n');
					$data['_template'] = 'emails.mentoring.confirm.rutan';
					$data['_subject'] = Lang::get('mentoring.mail.confirm.subject',['user' => $session->usuario->nombre_usuario]);
					break;
				default:
					$data['_template'] = 'emails.mentoring.confirm';
					$data['_subject'] = Lang::get('mentoring.mail.confirm.subject',['user' => $session->usuario->nombre_usuario]);
					break;
			}
			$data['_contactEmail'] = $contactEmail;
			$data['_name_user_action'] = $session->usuario->nombre_usuario;
			$data['_url_user_action'] = URL::route('usuario.nickname',['nickname' => $session ->usuario->nickname_usuario], false);
			// $data['_url'] = $url_conference ;
			$data['_inst'] = $institutionID;
			$data['_lugar_evento'] = $session->lugar_evento;
			$data['date_start'] = sprintf("%s %s", TuProyecto::dateFormat($session->fecha_evento, $type="complete"), TuProyecto::timeFormat($session->hora_inicio_evento));
			$data['date_end'] = sprintf("%s %s", TuProyecto::dateFormat($session->fecha_fin_evento, $type="complete"), TuProyecto::timeFormat($session->hora_fin_evento));
			$data['_to'] = $mentoring->usuario->correo_electronico;
			$data['_to_name'] = $mentoring->usuario->nombre_usuario;
			SendEmail::notification($data);


			// Mentor Mail Notification
			switch ($institutionID) {
				case '30':
					$data['_template'] = 'emails.mentoring.mentorconfirm.compensar';
					break;
				case '61':
					Log::info('template de ruta n');
					$data['_template'] = 'emails.mentoring.mentorconfirm.rutan';
					break;
				default:
					$data['_template'] = 'emails.mentoring.mentorconfirm.tuproyecto';
					break;
			}
			$data['_contactEmail'] = $contactEmail;
			$data['_subject'] = Lang::get('mentoring.mail.mentorconfirm.subject',['user' => $mentoring->usuario->nombre_usuario]);
			$data['_name_user_action'] = $mentoring->usuario->nombre_usuario;
			$data['_url_user_action'] = URL::route('usuario.nickname',['nickname' => $mentoring->usuario->nickname_usuario], false);
			// $data['_url'] = $url_conference ;
			$data['_inst'] = $institutionID;
			$data['_lugar_evento'] = $session->lugar_evento;
			$data['date_start'] = sprintf("%s %s", TuProyecto::dateFormat($session->fecha_evento, $type="complete"), TuProyecto::timeFormat($session->hora_inicio_evento));
			$data['date_end'] = sprintf("%s %s", TuProyecto::dateFormat($session->fecha_fin_evento, $type="complete"), TuProyecto::timeFormat($session->hora_fin_evento));
			$data['_to'] = $mentoring->mentor->correo_electronico;
			$data['_to_name'] = $mentoring->mentor->nombre_usuario;
			$data['_sessionID'] = $mentoring->codigo_mentoria;
			SendEmail::notification($data);

		} catch (\Exception $e) {
			$message = $e->getMessage();
			Log::error(sprintf('%s:%s', 'App\Console\Commands\GoogleApi\MakeCalandarConference', $message));
			$this->error($message);
			dd($message);
		}

    }

  }
