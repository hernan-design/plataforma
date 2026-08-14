@extends('layout.core.layout')
@section('content')
	
	<p style="text-align:center">
		{{{ $_message }}}
	</p>
	<br>
	<p style="text-align:center">
		<span>{{{ $_message_action }}} </span>
	</p>	
	<p style="text-align:center">
		<a href="{{{ $_url_action }}}" 
			style="display:inline-block; background-color:#e51e21; color:#FFFFFF; padding:15px 10px; text-align:center; text-decoration:none">
			{{{ $_message_action_button }}}
		</a>
	</p> 

@stop