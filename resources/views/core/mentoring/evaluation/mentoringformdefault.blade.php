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
						<p>{{ transtp('mentoring.evaluation.noteEntrepreneur') }}</p>
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
													<div class="right stars-rating stars-30">
														<input type="radio" name="evaluacion_item_asesoria_{{$itemeval->codigo_item_general_mentoria}}" id="evaluacion_item_asesoria_{{$itemeval->codigo_item_general_mentoria}}_5" value="5" required="required" class="check-star">
														<label for="evaluacion_item_asesoria_{{$itemeval->codigo_item_general_mentoria}}_5" class="label-terms"><i class="mdi mdi-star"></i></label>
														<input type="radio" name="evaluacion_item_asesoria_{{$itemeval->codigo_item_general_mentoria}}" id="evaluacion_item_asesoria_{{$itemeval->codigo_item_general_mentoria}}_4" value="4" required="required" class="check-star">
														<label for="evaluacion_item_asesoria_{{$itemeval->codigo_item_general_mentoria}}_4" class="label-terms"><i class="mdi mdi-star"></i></label>
														<input type="radio" name="evaluacion_item_asesoria_{{$itemeval->codigo_item_general_mentoria}}" id="evaluacion_item_asesoria_{{$itemeval->codigo_item_general_mentoria}}_3" value="3" required="required" class="check-star">
														<label for="evaluacion_item_asesoria_{{$itemeval->codigo_item_general_mentoria}}_3" class="label-terms"><i class="mdi mdi-star"></i></label>
														<input type="radio" name="evaluacion_item_asesoria_{{$itemeval->codigo_item_general_mentoria}}" id="evaluacion_item_asesoria_{{$itemeval->codigo_item_general_mentoria}}_2" value="2" required="required" class="check-star">
														<label for="evaluacion_item_asesoria_{{$itemeval->codigo_item_general_mentoria}}_2" class="label-terms"><i class="mdi mdi-star"></i></label>
														<input type="radio" name="evaluacion_item_asesoria_{{$itemeval->codigo_item_general_mentoria}}" id="evaluacion_item_asesoria_{{$itemeval->codigo_item_general_mentoria}}_1" value="1" required="required" class="check-star">
														<label for="evaluacion_item_asesoria_{{$itemeval->codigo_item_general_mentoria}}_1" class="label-terms"><i class="mdi mdi-star"></i></label>
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
					<div class="small-12 columns">
						<h4 class="thin-header sky-blue-text">Comentario</h4>
					</div>
				</div>
				<br>
				<div class="row col-equal-height align-bottom">
					<div class="small-8 columns">
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
					<div class="small-4 columns input-field">
						<select name="tipo_comentario_evaluacion" id="tipo_comentario_evaluacion" data-abide-validator="requiredOf" data-requiredof="cometario_evaluacion_asesoria">
							<option value="" selected disabled>Elige tipo de comentario</option>
								@foreach( App\Comentario::$evaluation as $key => $value)
								<option value="{{ $key }}">{{ $value }}</option>
							@endforeach
						</select>
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

