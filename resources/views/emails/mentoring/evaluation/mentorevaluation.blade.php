@extends('emails.layout')

@section('content')
	<p>
		<p style="text-align:center">
			{!! transtp('mentoring.emails.evaluation.mentor.bodyMentorEvaluation', [ 'usuario' => $_usuario, 'recomendacion_mentor' => $_commentary ]) !!}
		</p>
		<p style="text-align:center">
            {{-- <b> {{ $_commentary }} - {{ $_type_commentary }} </b> --}}
			{{{ Lang::get('mentoring.mail.doubts.contact', ['email' => 'fomentoempresarial@compensar.com']) }}}
		</p>
	</p>
@stop
