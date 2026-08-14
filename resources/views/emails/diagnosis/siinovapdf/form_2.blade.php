@if(isset($groupings) && count($groupings) > 0)
	@foreach ($groupings as $group)
		@if(isset($questions[$group->codigo_grupo_pregunta_encuesta]) && $group->codigo_grupo_pregunta_encuesta != 633)
			@include('emails.diagnosis.siinovapdf.questions_2', [
				'preguntas' => $questions[$group->codigo_grupo_pregunta_encuesta],
				'subpreguntas' => $subquestions
			])
		@endif
	@endforeach
@endif