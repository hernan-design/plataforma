@extends('emails.layout')

@section('content')
	<p>
		<p style="text-align:center">
			{{{ Lang::get('tuproyecto.mentoring.emails.evaluation.entrepreneur.text') }}}
		</p>
		<p style="text-align:center">
			<a href="{{$_url_action}}" target="_blank"
				style="display:inline-block; background-color:{{ $_inst_color }}; color:#FFFFFF; padding:15px 10px; text-align:center; text-decoration:none">
				Ingresa aquí
			</a>
		</p>

		<p style="text-align:center">
			{{{ Lang::get('mentoring.mail.doubts.contact', ['email' => 'fomentoempresarial@compensar.com']) }}}
		</p>
	</p>
@stop
