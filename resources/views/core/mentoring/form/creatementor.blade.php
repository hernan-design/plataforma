<section id="create-mentor" class="">
	<div class="row mt-2">
		<!-- banner de vista de procesos -->
		<div class="large-12 mobile-12 columns no-padding person-info">
			<div class="rows panel rounded z-depth-1 columns gray-dark-bg">
				<div class="large-1 mobile-12 columns">
					<img src="{{ Auth::user()->imagen_usuario }}"  class="img-carduser size80 rounded-img center-block" onerror="imageDefault(this,'{{ config('tuproyecto.avatar_image') }}')">
				</div>
				<div class="hpanel-title show-for-medium-up">
					<h5 class="thin-header white-text">Hola <span class="bold-text"><%- nombre_usuario %></span>, conviértete en mentor. <i class="mdi mdi-tie"></i></h5>
					<p class="clean-bottom text-xmd thin-text white-text">Comparte tus conocimientos, experiencia e intereses con empresarios/emprendedores para conectarte en torno a procesos de acompañamiento. Siempre tendrás la opción de aceptar o rechazar tu participación en dichos procesos.</p>
				</div>
				<div class="hpanel-title show-for-mobile-only mobile-12 columns">
					<h5 class="thin-header white-text text-center">conviértete en mentor</h5>
				</div>
			</div>
		</div>
		<!-- componente formulario de creacion de mentor -->
		{!! Form::open(['action' => null, 'data-abide' => '', 'id' => 'form-mentor-profile']) !!}
		<div class="large-12 mobile-12 no-padding columns form-create-mentor">
			<div class="panel z-depth-1">
				<div class="panel-body">
					<div class="row">
						<div id="mentor-specialities-container" class="input-field large-6 columns">
							<h3>{!! transtp('mentoring.create.specialties') !!}</h3>
							<select name="codigo_especialidad" id="codigo_especialidad" class="choice-filter-specialities" placeholder="Seleccione una especialidad" data-placeholder="Seleccione una especialidad">
								<option value="" selected disabled>Seleccione una especialidad</option>
								@foreach( App\Especialidad::getSpecialties() as $key => $value)
									<option value="{{ $key }}">{{ $value }}</option>
								@endforeach
							</select>
							<div class="content-data-list content-specialities-list">
							<ul class="list-specialities-mentor list-highlighted text-md">
								{{-- Render views item of specialities id="specialities-item-mentor-tpl" --}}
								<!-- <li>
									<small class="gray-dark-text text-md">Especialidad 1</small>
									<a href=""><i class="mdi mdi-close right"></i></a>
								</li>
								<hr class="gray-dark">
								 -->
							</ul>
								<div id="other-specialty">
									{{-- Render template id="other-specialty-tpl" --}}
								</div>
							</div>
						</div>

						<div id="mentor-economic-sector-container" class="large-6 columns input-field ">
							<h3>{!! transtp('mentoring.create.sectors') !!}</h3>
							<select name="codigo_sector_economico" id="codigo_sector_economico" class="choice-filter-economic-sector" data-placeholder="Selecciona sector económico" placeholder="Selecciona sector económico">
								<option value="">Elije tus sectores de interés</option>
								@foreach( App\SectorEconomico::getSectors() as $sector)
									<option value="{{ $sector->codigo_sector_economico }}">{{ $sector->nombre_sector_economico }}</option>
								@endforeach
							</select>
							<div class="content-data-list content-economic-sector-list">
								<ul class="list-economic-sector-mentor list-highlighted text-md">
									{{-- Render views item of economic-sector --}}
									<!-- <li>
										<small class="gray-dark-text text-md">Industria 1</small>
										<a href=""><i class="mdi mdi-close right"></i></a>
									</li>
									<hr class="gray-dark"> -->
								</ul>
							</div>
						</div>
						<div id="mentor-specialities-container" class="small-12 columns input-field">
							<h3>Especialidad Destacada</h3>
							<select name="codigo_especialidad_destacada" id="codigo_especialidad_destacada" class="choice-filter-specialities" required data-placeholder="Seleccione una especialidad" placeholder="Seleccione una especialidad">
								<option value="" selected disabled>Seleccione una especialidad</option>
								@foreach( App\Especialidad::getSpecialties( App\Especialidad::getSpecialty('other') ) as $key => $value )
									<option value="{{ $key }}" <%- typeof codigo_especialidad_destacada !=='undefined' && codigo_especialidad_destacada == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
								@endforeach
							</select>
						</div>
						<div class="large-12 columns description-container">
							<h3>Experiencia profesional</h3>
							<p class="gray-base-text">
							¿Qué roles ha desempeñado durante su carrera profesional?,  ¿Qué experiencia le gustaría compartir en una relación de mentoría? ¿De qué logros se siente más orgulloso?
							</p>
							<div class="input-field">
								<textarea required name="experiencia_usuario" id="experiencia_usuario" cols="50" rows="2" class="materialize-textarea validate gray-light-text" data-abide-validator="maxWords" data-maxlen="200" ><%- experiencia_usuario %></textarea>
								<label for="experiencia_usuario" class="descripcion-label">Descripción</label>
							</div>
						</div>
						<div class="large-12 columns description-container">
							<h3>¿ Cómo le gustaría ayudar ?</h3>
							<p class="gray-base-text">
								¿Qué clase de retos de negocios le interesan más? ¿Qué actividades prefiere cuando brinda consejos a otros? ¿De qué manera cree que su ayuda puede generar más valor?
							</p>
							<div class="input-field">
								<textarea required name="forma_ayuda_mentoria" id="forma_ayuda_mentoria" cols="50" rows="2" class="materialize-textarea validate gray-light-text" data-abide-validator="maxWords" data-maxlen="200"><%- forma_ayuda_mentoria %></textarea>
								<label for="forma_ayuda_mentoria" class="descripcion-label">Descripción</label>
							</div>
						</div>
						<div class="large-6 columns description-container">
							<h3>Descripción breve</h3>
							<p class="gray-base-text">
								Describe tu producto en un breve resumen para que sea visto rápidamente junto a otros productos
							</p>
							<div class="input-field">
								<textarea required name="descripcion_adicional_usuario" id="descripcion_adicional_usuario" cols="50" rows="2" class="materialize-textarea validate gray-light-text" data-abide-validator="maxWords" data-maxlen="200"><%- typeof descripcion_adicional_usuario !== 'undefined' ? descripcion_adicional_usuario : ''%></textarea>
								<label for="descripcion_adicional_usuario" class="descripcion-label">Descripción</label>
							</div>
							<div class="description-container">
								<h4 class="thin-header sky-blue-text">Linkedin</h4>
								<input type="text" name="linkedin_usuario" id="linkedin_usuario" value="<%- linkedin_usuario %>" placeholder="https://linkedin.com" pattern="url" class="validate">
								<h4 class="thin-header sky-blue-text">{!! transtp('mentoring.create.attached') !!}</h4>
								<section id="wrap-documents" class="">
									{{-- Render Documents --}}
								</section>
							</div>
						</div>
						<div class="large-6 columns description-container">
							<h3>Nivel de desarrollo</h3>
							<p class="gray-base-text">
								¿En qué nivel de desarrollo le gustaría apoyar más?
							</p>
							@foreach( App\EtapaProyecto::getStages() as $value)
								<input type="checkbox" data-abide-validator="onChecked" data-relchecks="checkbox-group" name="codigo_etapa_proyecto_{{ $value->codigo_etapa_proyecto }}" class="etapa_proyecto" id="codigo_etapa_proyecto_{{ $value->codigo_etapa_proyecto }}" value="{{ $value->codigo_etapa_proyecto }}"  <%- (_.contains(stage_mentoring, {{ $value->codigo_etapa_proyecto }}) ? 'checked' : '')%> >
								<label for="codigo_etapa_proyecto_{{ $value->codigo_etapa_proyecto }}">
									{{ $value->nombre_etapa_proyecto }}
								</label><br>
							@endforeach
						</div>
						<div class="large-12 columns">
							@php
								$terms = App\TerminosCondiciones::termsAndConditions(App\TerminosCondiciones::getTypeTerms('mentoring'));
							@endphp
							@if($terms)
								<p id="terms-content" class="terms-content text-center input-field"  style="margin-top: 30px;">
									<small class="error">Para poder utilizar nuestros servicios, debes aceptar las condiciones del servicio de {{{ ucwords( App\RegistroSesion::getInstitutionName() ) }}}.</small>
									<input type="checkbox" data-abide-validator="onChecked" data-relchecks="checkbox-aceptacion_terminos" name="aceptacion_terminos" id="aceptacion_terminos" value="" class="filled-in validate" required>
									<label for="aceptacion_terminos" class="label-terms dark-text">
										{!! transtp('mentoring.create.terms1') !!}
										{!! link_to_route('terminos-mentoria', ' Términos y Políticas', [], ['target' => '_blank', 'class' => 'sky-blue-text bold-text']) !!}
										{!! transtp('mentoring.create.terms2') !!}
									</label>
								</p>
							@endif
							<div class="small-12 tablet-4 medium-2 center tablet-centered columns save-section">
								{!! Form::submit('Ser Mentor', ['class' => 'button small btn-sm z-depth-1 radius center-block']) !!}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		{!! Form::close() !!}
	</div>
</section>
