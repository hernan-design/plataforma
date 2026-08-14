@extends('emails.layout')

@section('content')
	<p>
		<p style="text-align:center">
			{{{ Lang::get('tuproyecto.mentoring.emails.evaluation.mentor.text', ['entrepreneur' => $_from_name]) }}}
		</p>
		<p style="text-align:center">
			<a href="{{$_url_action}}" target="_blank"
				style="display:inline-block; background-color:{{ $_inst_color }}; color:#FFFFFF; padding:15px 10px; text-align:center; text-decoration:none">
				Evalua a tu emprendedor
			</a>
		</p>
		<br>
		<p style="text-align:center">
			@if (App\RegistroSesion::getInstitution() == 30)
			{{{ Lang::get('mentoring.mail.doubts.contact', ['email' => 'fomentoempresarial@compensar.com']) }}}
			@else
			{{{ Lang::get('mentoring.mail.doubts.contact', ['email' => '']) }}}
			@endif
		</p>
	</p>
@stop
