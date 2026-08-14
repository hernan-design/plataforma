<div class="row">
	<div class="small-12 columns">
		<section id="becoming-mentor-section" class="panel-content radius with-header">
			{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-mentor-evaluation') ) !!}
				{{-- header panel --}}
				<div id="header-becoming-a-mentor" class="content-header-panel radius-top no-shadow">
					<div class="becoming-mentor-image wrap-avatar-circle-mentoring">
						<img src="<%- emprendedor ? imagen_usuario_mentor : imagen_usuario_emprendedor %>" alt="<%- emprendedor ? nickname_usuario_mentor : nickname_usuario_emprendedor %>" title="<%- emprendedor ? nickname_usuario_mentor : nickname_usuario_emprendedor %>" class="image-user-profile rounded-img size80" onerror="if (this.src != '{{ config('tuproyecto.avatar_image') }}') this.src = '{{ config('tuproyecto.avatar_image') }}';">
						<span class="circle-entrepreneurship <%- emprendedor ? 'mentor' : 'entrepreneur' %> invert tiny icon-18 circle-shadow">
							<i class="mdi <%- emprendedor ? 'mdi-tie' : 'mdi-lightbulb' %>"></i>
						</span>
					</div>
					<div class="hpanel-title">
						<span class="text-md thin-text gray-dark-text">Evalúa a tu <% if(emprendedor) { %> {{ transtp('mentoring.evaluateTo') }} <% } else { %>  {{ transtp('mentoring.evaluateEntrepreneurship') }}  <% } %></span>
						<h3 class="thin-header clean-bottom dark-text"><%- emprendedor ? nombre_usuario_mentor :  nombre_usuario_emprendedor %></h3>
					</div>
				</div>
				<% if(emprendedor) { %>
				<div class="row">
					<div class="small-12 columns paragraph-hpadding-both">
						<h5 class="thin-header sky-blue-text">Apreciado Emprendedor:</h5><br>
						<h6>Buscando la excelencia en la calidad de nuestros servicios y trabajando para un mejoramiento continuo, le agradecemos realizar la evaluación del mentor.</h6>
						<br>
						<h6>Nota: Las preguntas de la 1 a la 6 tendrán una calificación que va de 1 siendo esta la menor calificación hasta 5 siendo esta la mayor calificación.</h6>
					</div>
				</div>
				<% } %>
				<div class="row">
					<div class="small-12 columns paragraph-hpadding-both">
						<ul id="" class="list-mentor-evaluation-item list-separator list-ordering list-highlighted light-text no-bullet">
							@foreach(App\ItemGeneralMentoria::getItemMentoriaList() as $itemeval)
								<% if( {{ $itemeval->tipo_item_general_mentoria }} == window._tp.typeItemMentoring[ (emprendedor ? 'mentor' : 'entrepreneurship') ]) {  %>
									<li>
										<div class="clearfix">
											<span class="text-md">{{ $itemeval->nombre_item_general_mentoria }}</span>
											<ul class="inline-list-items right">
												<li>
													<a href="" title="Información" data-dropdown="drop-evaluation-{{$itemeval->codigo_item_general_mentoria}}" aria-controls="drop-evaluation-{{$itemeval->codigo_item_general_mentoria}}" data-options="align:left;is_hover:true;" aria-expanded="false" class="right"><i class="mdi mdi-information mdi-18"></i></a>
													<div id="drop-evaluation-{{$itemeval->codigo_item_general_mentoria}}" class="md-dropdown content radius" data-dropdown-content aria-hidden="true" >
														<ul class="disc text-xmd">
															{{ $itemeval->descripcion_item_general_mentoria }}
														</ul>
													</div>
												</li>
												<li>
													<div class="right">

														<select id="modalidad_prestacion_servicio" name="evaluacion_item_asesoria_{{$itemeval->codigo_item_general_mentoria}}" id="evaluacion_item_asesoria_{{$itemeval->codigo_item_general_mentoria}}_5" class="choice-modality-product" data-placeholder="Seleccione" required="required" placeholder="Seleccione">
															<option value="" disabled selected>Seleccione</option>
															<option value="1">1</option>
															<option value="2">2</option>
															<option value="3">3</option>
															<option value="4">4</option>
															<option value="5">5</option>

														</select>
													</div>
												</li>
											</ul>
										</div>
									</li>
								<% } %>
							@endforeach
						</ul>
					</div>
				</div>

				<div class="row col-equal-height align-bottom">
					<div class="small-6 columns">
						<h5 class="thin-header sky-blue-text">{{ transtp('mentoring.evaluation.totalScoreEntrepreneur') }}</h5>
					</div>

					<div class="small-6 columns">
						<% if(emprendedor) { %>
							<h5 class="thin-header sky-blue-text">{{ transtp('mentoring.evaluation.comentaryEntrepreneur') }}</h5>
						<% } else { %>
							<h5 class="thin-header sky-blue-text">{{ transtp('mentoring.evaluation.comentaryMentor') }}</h5>
						<% } %>
					</div>
				</div>
				<br>
				<div class="row col-equal-height align-bottom">
					<div class="small-6 columns input-field">

						<% if(emprendedor) { %>
							<select name="tipo_comentario_evaluacion" id="tipo_comentario_evaluacion" data-abide-validator="requiredOf" data-requiredof="cometario_evaluacion_asesoria">
								<option value="" disabled selected>Calificación total</option>
								<option value="6">1</option>
								<option value="7">2</option>
								<option value="8">3</option>
								<option value="9">4</option>
								<option value="10">5</option>
							</select>
						<% } else {%>
							<select name="tipo_comentario_evaluacion" id="tipo_comentario_evaluacion" data-abide-validator="requiredOf" data-requiredof="cometario_evaluacion_asesoria">
								<option value="" selected disabled>Elige tipo de comentario</option>
									@foreach( App\Comentario::$evaluation as $key => $value)
									<option value="{{ $key }}">{{ $value }}</option>
								@endforeach
							</select>
						<%}%>
					</div>

					<div class="small-6 columns">
						<div class="row">
							<div class="small-12 columns input-field">
								<textarea required name="comentario_evaluacion_asesoria" id="comentario_evaluacion_asesoria" cols="50" rows="2" class="materialize-textarea validate" data-abide-validator="maxWords" data-maxlen="300"></textarea>
								<% if(typeof mentor !=='undefined' && mentor ) {  %>
										<label for="comentario_evaluacion_asesoria">{{ transtp('mentoring.evaluation.noteMentor') }}</label>
								<% } else {%>
										<label for="comentario_evaluacion_asesoria">{{ transtp('mentoring.evaluation.suggestionEntrepreneur') }}</label>
								<%}%>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="mobile-11 tablet-3 medium-2 right columns save-section">
						{!! Form::submit('Evaluar', ['class' => 'button medium sky-blue expand btn-shadow radius']) !!}
					</div>
				</div>
			{!! Form::close() !!}
		</section>
	</div>
</div>


