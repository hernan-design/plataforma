@extends('emails.layout')

@section('content')
	<p align="justify">{!! Lang::get('project.mail.create.body', ['url_call' => URL::route('convocatoria.index'),'url_mentoring' => URL::route('mentoria.index'),'url_proyecto' =>$_inst_url.$url_proyecto]) !!}</p>
@stop
