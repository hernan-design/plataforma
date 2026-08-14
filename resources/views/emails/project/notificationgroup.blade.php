@extends('emails.layout')

@section('content')
	<p>
		<span>{{{ Lang::get('project.mail.group.project.body') }}} <a href="{{{ $_inst_url.$url_nickname }}}" target="_blank">{{{$nombre_usuario}}}</a></span>
		<br/><span>{!! $invitation !!}</span>
		<br/><span>{{{ $rol }}}</span>
		<br/><span>{{{ $confirm }}}</span>

		<p style="text-align:center">
			<a href="{!! $_inst_url.$_url_confirm !!}" target="_blank"
				style="display:inline-block; background-color:{{ $_inst_color }}; color:#FFFFFF; padding:15px 10px; text-align:center; text-decoration:none">
				Confirmar
			</a>
		</p>
	</p>
@stop
