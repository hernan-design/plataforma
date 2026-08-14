@extends('emails.layout')

@section('content')
	<p>
		<span><p align="justify">{!! Lang::get('project.mail.create.company.body', array('url_call' => URL::route('convocatoria.index'),'url_mentoring' => URL::route('mentoria.index'),'url_proyecto' =>$_inst_url.$url_proyecto)) !!}</p></span>
	</p>
@stop
