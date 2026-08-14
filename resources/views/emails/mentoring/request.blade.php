@extends('emails.layout')

@section('content')
	<p>
		<a href="{{{ $_inst_url.$_url_user_action }}}">{{{ $_name_user_action }}}</a>
		<span>{{{ Lang::get('mentoring.mail.request.body') }}}
		<br>
		 	{{{ Lang::get('mentoring.mail.body.time.start') }}}
			{{{$date_start}}}
		<br>
		 	{{{ Lang::get('mentoring.mail.body.time.end') }}}
			{{{$date_end}}}
		<br>
			{{{ Lang::get('mentoring.mail.body.time.zone') }}}
		<br>
			{{{ Lang::get('mentoring.mail.body.site') }}}
		  	{{{$lugar_evento}}}
		<br>
		  	{{{ Lang::get('mentoring.mail.body.request.description') }}}
		  	{{{$descripcion_mentoria}}}
		<br>
	  		@if(count($objetivos_mentoria) > 0)
			  	{{{ Lang::get('mentoring.mail.body.request.objective') }}}
		  		<ul class="attached-list-theme">
					@foreach ($objetivos_mentoria as $objetivo)
			  			<li>{{ $objetivo->descripcion_objetivo_mentoria  }}</li>
			  		@endforeach
		  		</ul>
			@endif
		</span>
		<br/>
		{{{ Lang::get('mentoring.mail.request.confirm') }}}
		<p><a href="{{{ $_inst_url.$_url_user_action_owner }}}">{{{ Lang::get('mentoring.mail.request.view') }}}</a></p>
		@if($_url_survey);
			<br/>
			{{{ Lang::get('mentoring.mail.request.survey') }}}
			<p><a href="{{{ $_inst_url.$_url_survey_action }}}">{{{ Lang::get('mentoring.mail.request.viewsurvey') }}}</a></p>
		@endif
	</p>
@stop
