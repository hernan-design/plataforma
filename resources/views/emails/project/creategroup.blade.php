@extends('emails.layout')

@section('content')
	<p>
		<span><p align="justify">{!! Lang::get('project.mail.create.group.body',array('url_proyecto' =>$_inst_url.$url_proyecto)) !!}</p></span>
	</p>
@stop
