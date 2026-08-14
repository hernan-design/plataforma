@extends('emails.layout')

@section('content')
	<p>
		<a href="{{{ $_inst_url.$_url_user_action }}}">{{{ $_name_user_action }}}</a>
			<span>{{{ Lang::get('mentoring.request.entrepreneur.project') }}} 
				<a href="{{{ $_inst_url.$_url_project }}}">{{{ $_name_project }}}</a>
			</span>
		<br/><br/>
		<span>{{{ Lang::get('mentoring.request.entrepreneur.project.confirm') }}} </span>
		<br/><br/>
		<p style="text-align:center">
			<a href="{{{ $_inst_url.$_url_user_action_owner }}}" target="_blank" 
				style="display:inline-block; background-color:{{ $_inst_color }}; color:#FFFFFF; padding:15px 10px; text-align:center; text-decoration:none">
				{{{ Lang::get('mentoring.request.entrepreneur.project.view') }}}
			</a>
		</p> 
	</p>
@stop
