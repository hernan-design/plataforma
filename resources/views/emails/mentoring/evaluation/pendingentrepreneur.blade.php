@extends('emails.layout')

@section('content')
	<p>
		<a href="{{{ $_inst_url.$_url_user_action }}}">{{{ $_name_user_action }}}</a>
		<span>{{{ Lang::get('mentoring.mail.evaluation.entrepreneur.body') }}}
		<p style="text-align:center">
			<a href="{{ $_inst_url }}{{$_url_qualification}}" target="_blank"
				style="display:inline-block; background-color:{{ $_inst_color }}; color:#FFFFFF; padding:15px 10px; text-align:center; text-decoration:none">
				{{{ Lang::get('mentoring.mail.evaluation.qualification') }}}
			</a>
		</p>
	</p>
@stop
