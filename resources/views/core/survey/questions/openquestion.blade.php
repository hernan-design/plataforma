{{-- open question & answer survey --}}
<script type="text/template" id="survey-open-question-tpl">
	<% if(!opcional_pregunta_encuesta && tipo_campo_pregunta != window._tp.typeQuestionField['agree_terms'] && !review) { %>
		<em class="required-msg lighter-text gray-light-text text-xmd"><span class="alert-text">*</span> <%- window.formatMessage('survey/require_question_text')%></em>
	<% } %>
	<div class="title-question-survey">
		<span class="pos-question-survey"><%- numero_pregunta_encuesta ? numero_pregunta_encuesta +'.' : '' %></span>
		<%= texto_pregunta_encuesta %>
	</div>
	<% if(texto_opcional_pregunta) { %>
		<p class="text-xmd gray-dark-text thin-text"><%- texto_opcional_pregunta %></p>
	<% } %>

	{{-- review answer --}}
	<% if(review) { %>
		<% if(!_.isNull(respuesta) && !_.isUndefined(respuesta)) { %>
			<div class="row">
				<div class="small-12 columns">
					<% if(tipo_campo_pregunta == window._tp.typeQuestionField['cities']) { %>

						@foreach( App\Ciudad::getCities() as $city)
							<% if(respuesta == '{{ $city->key }}') { %>
								<p class="text-md">{{ $city->value }}</p>
							<% } %>
						@endforeach

					<% } else if(tipo_campo_pregunta == window._tp.typeQuestionField['date'] || tipo_campo_pregunta == window._tp.typeQuestionField['before_date']) { %>

						<p class="text-md"><%- window.moment(respuesta).format('YYYY-MM-DD') %></p>

					<% } else if(tipo_campo_pregunta == window._tp.typeQuestionField['number_format']) { %>

						<p class="text-md"><%- Globalize.formatNumber(parseFloat(respuesta)) %></p>

					<% } else if(tipo_campo_pregunta == window._tp.typeQuestionField['ciiu']) { %>

						@foreach( App\SectorInteres::getInterests() as $interest )
							<% if(respuesta == '{{ $interest->codigo_sector_interes }}') { %>
								<p class="text-md">{{ str_pad($interest->codigo_sector_interes,4,'0',STR_PAD_LEFT).' - '.$interest->nombre_sector_interes }}</p>
							<% } %>
						@endforeach

					<% } else if(tipo_campo_pregunta == window._tp.typeQuestionField['education_level']) { %>

						@foreach( App\NivelEducacion::getLevels() as $level )
							<% if(respuesta == '{{ $level->codigo_nivel_educacion }}') { %>
								<p class="text-md">{{ $level->nombre_nivel_educacion }}</p>
							<% } %>
						@endforeach

					<% } else if(tipo_campo_pregunta == window._tp.typeQuestionField['economic_sector']) { %>

						@foreach( App\SectorEconomico::getSectors() as $sector )
							<% if(respuesta == '{{ $sector->codigo_sector_economico }}') { %>
								<p class="text-md">{{ $sector->nombre_sector_economico }}</p>
							<% } %>
						@endforeach

					<% } else if(tipo_campo_pregunta == window._tp.typeQuestionField['currency'] || tipo_campo_pregunta == window._tp.typeQuestionField['negative_currency']) { %>

						<p class="text-md"><%- Globalize.formatCurrency(parseFloat(respuesta), sigla_moneda || 'COP', {style: "symbol", minimumFractionDigits: 0, maximumFractionDigits: 2}) %></p>

					<% } else { %>
						<p class="text-md"><%- respuesta %></p>
					<% } %>
				</div>
			</div>
		<% } %>
	<% }else { %>
		<div class="row">
			<div class="small-12 columns">
				<% if( !tipo_campo_pregunta || !_.contains(['full_year','longText','cities','pass_confirm','agree_terms','date','before_date','number_format', 'ciiu', 'education_level', 'economic_sector', 'currency', 'negative_currency', 'phone', 'integer', 'identification', 'select'], _.findKey(window._tp.typeQuestionField, function(type){return type == tipo_campo_pregunta;})) ) { %>

					<div class="row">
						<div class="tablet-6 medium-5 columns end input-field">
							<input type="text" name="pregunta_<%- codigo_pregunta_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" value="<%- respuesta %>" placeholder="Escribe tu respuesta..." <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-abide-validator="<%- pregunta_padre ? 'requiredOf ' : '' %><%- tipo_campo_pregunta == window._tp.typeQuestionField['singleText'] ? 'maxLength' : '' %>" <%- pregunta_padre ? 'data-requiredof=pregunta_'+ pregunta_padre + '_opcion_'+ (codigo_opcion_encuesta ? codigo_opcion_encuesta : '0') : '' %> <%- subpregunta_pregunta ? 'area-has-subquestion' : '' %> <%- tipo_campo_pregunta == window._tp.typeQuestionField['singleText'] ? (longitud_pregunta_encuesta ? 'length='+longitud_pregunta_encuesta : 'length=200') : '' %> pattern="<%- _.findKey(window._tp.typeQuestionField, function (validate) { return validate == tipo_campo_pregunta; }) || '' %>" class="<%- _.findKey(window._tp.typeQuestionField, function (validate) { return validate == tipo_campo_pregunta; }) || '' %>" maxlength="<%- longitud_pregunta_encuesta ? longitud_pregunta_encuesta : 200 %>" >
						</div>
					</div>

				<% } else if(tipo_campo_pregunta == window._tp.typeQuestionField['full_year']) { %>

					<div class="row">
						<div class="tablet-2 medium-1 columns end input-field">
							<input type="text" name="pregunta_<%- codigo_pregunta_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" value="<%- respuesta %>" placeholder="YYYY" <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-abide-validator="<%- pregunta_padre ? 'requiredOf' : '' %>" <%- pregunta_padre ? 'data-requiredof=pregunta_'+ pregunta_padre + '_opcion_'+ (codigo_opcion_encuesta ? codigo_opcion_encuesta : '0') : '' %> <%- subpregunta_pregunta ? 'area-has-subquestion' : '' %> pattern="full_year" class="full_year" maxlength="4" >
						</div>
					</div>

				<% }else if(tipo_campo_pregunta == window._tp.typeQuestionField['longText']) { %>
					<div class="row">
						<div class="small-12 columns input-field">
							<textarea name="pregunta_<%- codigo_pregunta_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" placeholder="Escribe tu respuesta..." <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-abide-validator="maxWords<%- pregunta_padre ? ' requiredOf' : '' %>" <%- pregunta_padre ? 'data-requiredof=pregunta_'+ pregunta_padre + '_opcion_'+ (codigo_opcion_encuesta ? codigo_opcion_encuesta : '0') : '' %> <%- subpregunta_pregunta ? 'area-has-subquestion' : '' %> data-maxlen="<%- longitud_pregunta_encuesta ? longitud_pregunta_encuesta : '200' %>" pattern="longText" class="materialize-textarea"><%- respuesta %></textarea>
						</div>
					</div>

				<% }else if(tipo_campo_pregunta == window._tp.typeQuestionField['cities']) { %>

					<div class="row">
						<div class="tablet-6 medium-5 columns end input-field">
							<select name="pregunta_<%- codigo_pregunta_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" class="choice-select browser-default" <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-placeholder="Selecciona una ubicación" placeholder="Selecciona una ubicación" data-abide-validator="<%- pregunta_padre ? 'requiredOf' : ''%>" <%- pregunta_padre ? 'data-requiredof=pregunta_'+ pregunta_padre + '_opcion_'+ (codigo_opcion_encuesta ? codigo_opcion_encuesta : '0') : '' %>>
								<option value=""></option>
								@foreach( App\Ciudad::getCities() as $city)
									<option value="{{ $city->key }}" <%- respuesta == '{{ $city->key }}' ? 'selected': ''%> >{{ $city->value }}</option>
								@endforeach
							</select>
						</div>
					</div>

				<% }else if(tipo_campo_pregunta == window._tp.typeQuestionField['pass_confirm']) { %>

					<div class="row">
						<div class="small-12 tablet-5 medium-4 columns input-field">
							<input type="password" name="pregunta_<%- codigo_pregunta_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" value="" <%- !opcional_pregunta_encuesta ? 'required' : '' %> pattern="alpha_num_dash" class="validate">
							<label for="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" data-error="La clave solo acepta caracteres alfanuméricos sin acentos, ni caracteres extraños.">Contraseña</label>
						</div>
						<div class="small-12 tablet-5 medium-4 columns end input-field">
							<input type="password" value="" data-equalto="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" <%- !opcional_pregunta_encuesta ? 'required' : '' %> pattern="alpha_num_dash" class="validate">
							<label for="" data-error="Las claves no coinciden">Confirmar contraseña</label>
						</div>
					</div>

				<% }else if(tipo_campo_pregunta == window._tp.typeQuestionField['agree_terms']) { %>

					<div class="row">
						<div class="small-12 columns">
							<div id="terms-content" class="terms-content text-center">
								<input type="checkbox" name="pregunta_<%- codigo_pregunta_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" value="yes" <%- !opcional_pregunta_encuesta ? 'required' : '' %> class="validate" >
								<label for="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" class="label-terms dark-text">
									Acepto los {!! link_to_route('terminos', 'Términos de Uso', [], ['target' => '_blank', 'class' => 'sky-blue-text bold-text']) !!} y
									{!! link_to_route('privacidad', 'Políticas de Privacidad', [], ['target' => '_blank', 'class' => 'sky-blue-text bold-text']) !!} de
									<span class="bold-text dark-text">{{{ ucwords( App\RegistroSesion::getInstitutionName() ) }}}.</span>
								</label>
								<span class="error">Para poder utilizar nuestros servicios, debes aceptar las condiciones del servicio de {{{ ucwords( App\RegistroSesion::getInstitutionName() ) }}}.</span>
							</div>
						</div>
					</div>

				<% } else if(tipo_campo_pregunta == window._tp.typeQuestionField['date'] || tipo_campo_pregunta == window._tp.typeQuestionField['before_date']) { %>

					<div class="row">
						<div class="tablet-3 medium-2 columns end input-field">
							<input type="text" name="pregunta_<%- codigo_pregunta_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" value="<%- respuesta %>" placeholder="Escribe tu respuesta..." <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-abide-validator="<%- pregunta_padre ? 'requiredOf' : '' %>" <%- pregunta_padre ? 'data-requiredof=pregunta_'+ pregunta_padre + '_opcion_'+ (codigo_opcion_encuesta ? codigo_opcion_encuesta : '0') : '' %> <%- subpregunta_pregunta ? 'area-has-subquestion' : '' %> <%- !opcional_pregunta_encuesta ? 'pattern=date' : '' %> class="<%- tipo_campo_pregunta == window._tp.typeQuestionField['before_date'] ? 'datebeforepk' : 'datepk'%>" >
						</div>
					</div>

				<% } else if(tipo_campo_pregunta == window._tp.typeQuestionField['number_format']) { %>

					<div class="row">
						<div class="tablet-3 medium-2 columns end input-field">
							<input type="text" name="pregunta_<%- codigo_pregunta_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" value="<%- !_.isEmpty(respuesta) || _.isNumber(respuesta) ? respuesta : 0 %>" placeholder="" <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-abide-validator="<%- pregunta_padre ? 'requiredOf' : '' %>" <%- pregunta_padre ? 'data-requiredof=pregunta_'+ pregunta_padre + '_opcion_'+ (codigo_opcion_encuesta ? codigo_opcion_encuesta : '0') : '' %> <%- subpregunta_pregunta ? 'area-has-subquestion' : '' %> pattern="<%- _.findKey(window._tp.typeQuestionField, function (validate) { return validate == tipo_campo_pregunta; }) || '' %>" class="number-mask" <%- longitud_pregunta_encuesta ? 'length='+longitud_pregunta_encuesta : '' %> <%- longitud_pregunta_encuesta ? 'maxlength='+longitud_pregunta_encuesta : '' %>>
						</div>
					</div>

				<% } else if(tipo_campo_pregunta == window._tp.typeQuestionField['ciiu']) { %>

					<div class="row">
						<div class="tablet-10 medium-8 columns end input-field">
							<select name="pregunta_<%- codigo_pregunta_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" class="choice-select browser-default" <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-placeholder="Seleccione actividad económica" placeholder="Seleccione actividad económica">
								<option value=""></option>
								@foreach( App\SectorInteres::getInterests() as $interest)
									<option value="{{ $interest->codigo_sector_interes }}" <%- respuesta == '{{ $interest->codigo_sector_interes }}' ? 'selected': ''%>>{{ str_pad($interest->codigo_sector_interes,4,'0',STR_PAD_LEFT).' - '.$interest->nombre_sector_interes }}</option>
								@endforeach
							</select>
						</div>
					</div>

				<% } else if(tipo_campo_pregunta == window._tp.typeQuestionField['education_level']) { %>

					<div class="row">
						<div class="tablet-6 medium-5 columns end input-field">
							<select name="pregunta_<%- codigo_pregunta_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" class="choice-select browser-default" <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-placeholder="Seleccione nivel de educación" placeholder="Seleccione nivel de educación">
								<option value=""></option>
								@foreach( App\NivelEducacion::getLevels() as $level)
									<option value="{{ $level->codigo_nivel_educacion }}" <%- respuesta == '{{ $level->codigo_nivel_educacion }}' ? 'selected': ''%>>{{ $level->nombre_nivel_educacion }}</option>
								@endforeach
							</select>
						</div>
					</div>

				<% } else if(tipo_campo_pregunta == window._tp.typeQuestionField['economic_sector']) { %>

					<div class="row">
						<div class="tablet-10 medium-8 columns end input-field">
							<select name="pregunta_<%- codigo_pregunta_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" class="choice-select browser-default" <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-placeholder="Seleccione sector económico" placeholder="Seleccione sector económico">
								<option value=""></option>
								@foreach( App\SectorEconomico::getSectors() as $sector)
									<option value="{{ $sector->codigo_sector_economico }}" <%- respuesta == '{{ $sector->codigo_sector_economico }}' ? 'selected': ''%>>{{ $sector->nombre_sector_economico }}</option>
								@endforeach
							</select>
						</div>
					</div>

				<% } else if(tipo_campo_pregunta == window._tp.typeQuestionField['currency'] || tipo_campo_pregunta == window._tp.typeQuestionField['negative_currency']) { %>

					<div class="row">
						<div class="tablet-3 medium-2 columns end input-field">
							<% var maskNegative = tipo_campo_pregunta == window._tp.typeQuestionField['negative_currency'] ? 'ncurrencyMasks' : 'currencyMasks'; %>

							<input type="text" name="pregunta_<%- codigo_pregunta_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" value="<%- !_.isEmpty(respuesta) || _.isNumber(respuesta) ? respuesta : 0 %>" placeholder="" <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-abide-validator="<%- pregunta_padre ? 'requiredOf' : '' %>" <%- pregunta_padre ? 'data-requiredof=pregunta_'+ pregunta_padre + '_opcion_'+ (codigo_opcion_encuesta ? codigo_opcion_encuesta : '0') : '' %> <%- subpregunta_pregunta ? 'area-has-subquestion' : '' %> class="<%- sigla_moneda ? window._tp[maskNegative][sigla_moneda.toLowerCase()] : window._tp[maskNegative]['cop'] %>" >
						</div>
					</div>

				<% } else if(tipo_campo_pregunta == window._tp.typeQuestionField['phone']) { %>
					<div class="row">
						<div class="tablet-6 medium-5 columns end input-field">
							<input type="text" name="pregunta_<%- codigo_pregunta_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" value="<%- !_.isEmpty(respuesta) || _.isNumber(respuesta) ? respuesta : '' %>" placeholder="Escribe tu respuesta..." <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-abide-validator="<%- pregunta_padre ? 'requiredOf' : '' %>" <%- pregunta_padre ? 'data-requiredof=pregunta_'+ pregunta_padre + '_opcion_'+ (codigo_opcion_encuesta ? codigo_opcion_encuesta : '0') : '' %> <%- subpregunta_pregunta ? 'area-has-subquestion' : '' %> class="phone-mask-co" >
						</div>
					</div>

				<% } else if(tipo_campo_pregunta == window._tp.typeQuestionField['integer']) { %>

					<div class="row">
						<div class="tablet-3 medium-2 columns end input-field">
							<input type="text" name="pregunta_<%- codigo_pregunta_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" value="<%- !_.isEmpty(respuesta) || _.isNumber(respuesta) ? respuesta : 0 %>" placeholder="" <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-abide-validator="<%- pregunta_padre ? 'requiredOf' : '' %>" <%- pregunta_padre ? 'data-requiredof=pregunta_'+ pregunta_padre + '_opcion_'+ (codigo_opcion_encuesta ? codigo_opcion_encuesta : '0') : '' %> <%- subpregunta_pregunta ? 'area-has-subquestion' : '' %> pattern="<%- _.findKey(window._tp.typeQuestionField, function (validate) { return validate == tipo_campo_pregunta; }) || '' %>" class="integer-mask" <%- longitud_pregunta_encuesta ? 'length='+longitud_pregunta_encuesta : '' %> <%- longitud_pregunta_encuesta ? 'maxlength='+longitud_pregunta_encuesta : '' %>>
						</div>
					</div>

				<% } else if(tipo_campo_pregunta == window._tp.typeQuestionField['identification']) { %>

					<div class="row">
						<div class="tablet-3 medium-2 columns end input-field">
							<input type="text" name="pregunta_<%- codigo_pregunta_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" value="<%- respuesta %>" placeholder="Escribe tu respuesta..." <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-abide-validator="<%- pregunta_padre ? 'requiredOf' : '' %>" <%- pregunta_padre ? 'data-requiredof=pregunta_'+ pregunta_padre + '_opcion_'+ (codigo_opcion_encuesta ? codigo_opcion_encuesta : '0') : '' %> <%- subpregunta_pregunta ? 'area-has-subquestion' : '' %> pattern="" class="indetification-mask" <%- longitud_pregunta_encuesta ? 'length='+longitud_pregunta_encuesta : '' %> <%- longitud_pregunta_encuesta ? 'maxlength='+longitud_pregunta_encuesta : '' %>>
						</div>
					</div>

				<% } else if(tipo_campo_pregunta == window._tp.typeQuestionField['select']) { %>
					<div class="row">
						<div class="tablet-6 medium-5 columns end input-field">
							<select name="pregunta_<%- codigo_pregunta_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" class="choice-select browser-default" <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-placeholder="Selecciona tu respuesta..." placeholder="Selecciona tu respuesta..." data-abide-validator="<%- pregunta_padre ? 'requiredOf' : '' %>" <%- pregunta_padre ? 'data-requiredof=pregunta_'+ pregunta_padre + '_opcion_'+ (codigo_opcion_encuesta ? codigo_opcion_encuesta : '0') : '' %> <%- subpregunta_pregunta ? 'area-has-subquestion' : '' %>>
								<option value=""></option>
								<% if(opciones && opciones.length) { %>
									<% _.each(opciones, function (option) { %>
										<option value="<%- option.codigo_opcion_encuesta %>" <%- respuesta == option.codigo_opcion_encuesta ? 'selected' : '' %> ><%- option.texto_opcion_encuesta %></option>
									<% }) %>
								<% } %>
							</select>
						</div>
					</div>

				<% } %>
			</div>
		</div>
	<% } %>
</script>

{{-- type open questions templates --}}
{{-- default field --}}
<script type="text/template" id="">
	<div class="row">
		<div class="tablet-6 medium-5 columns end input-field">
			<input type="text" name="pregunta_<%- codigo_pregunta_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" value="<%- respuesta %>" placeholder="Escribe tu respuesta..." <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-abide-validator="<%- pregunta_padre ? 'requiredOf ' : '' %><%- tipo_campo_pregunta == window._tp.typeQuestionField['singleText'] ? 'maxLength' : '' %>" <%- pregunta_padre ? 'data-requiredof=pregunta_'+ pregunta_padre + '_opcion_'+ (codigo_opcion_encuesta ? codigo_opcion_encuesta : '0') : '' %> <%- subpregunta_pregunta ? 'area-has-subquestion' : '' %> <%- tipo_campo_pregunta == window._tp.typeQuestionField['singleText'] ? (longitud_pregunta_encuesta ? 'length='+longitud_pregunta_encuesta : 'length=200') : '' %> pattern="<%- _.findKey(window._tp.typeQuestionField, function (validate) { return validate == tipo_campo_pregunta; }) || '' %>" class="<%- _.findKey(window._tp.typeQuestionField, function (validate) { return validate == tipo_campo_pregunta; }) || '' %>" maxlength="<%- longitud_pregunta_encuesta ? longitud_pregunta_encuesta : 200 %>" >
		</div>
	</div>
</script>
{{-- full_year --}}
<script type="text/template" id="">
	<div class="row">
		<div class="tablet-2 medium-1 columns end input-field">
			<input type="text" name="pregunta_<%- codigo_pregunta_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" value="<%- respuesta %>" placeholder="YYYY" <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-abide-validator="<%- pregunta_padre ? 'requiredOf' : '' %>" <%- pregunta_padre ? 'data-requiredof=pregunta_'+ pregunta_padre + '_opcion_'+ (codigo_opcion_encuesta ? codigo_opcion_encuesta : '0') : '' %> <%- subpregunta_pregunta ? 'area-has-subquestion' : '' %> pattern="full_year" class="full_year" maxlength="4" >
		</div>
	</div>
</script>
{{-- longText --}}
<script type="text/template" id="">
	<div class="row">
		<div class="small-12 columns input-field">
			<textarea name="pregunta_<%- codigo_pregunta_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" placeholder="Escribe tu respuesta..." <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-abide-validator="maxWords<%- pregunta_padre ? ' requiredOf' : '' %>" <%- pregunta_padre ? 'data-requiredof=pregunta_'+ pregunta_padre + '_opcion_'+ (codigo_opcion_encuesta ? codigo_opcion_encuesta : '0') : '' %> <%- subpregunta_pregunta ? 'area-has-subquestion' : '' %> data-maxlen="<%- longitud_pregunta_encuesta ? longitud_pregunta_encuesta : '200' %>" pattern="longText" class="materialize-textarea"><%- respuesta %></textarea>
		</div>
	</div>
</script>
{{-- cities --}}
<script type="text/template" id="">
	<div class="row">
		<div class="tablet-6 medium-5 columns end input-field">
			<select name="pregunta_<%- codigo_pregunta_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" class="choice-select browser-default" <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-placeholder="Selecciona una ubicación" placeholder="Selecciona una ubicación" data-abide-validator="<%- pregunta_padre ? 'requiredOf' : ''%>" <%- pregunta_padre ? 'data-requiredof=pregunta_'+ pregunta_padre + '_opcion_'+ (codigo_opcion_encuesta ? codigo_opcion_encuesta : '0') : '' %>>
				<option value=""></option>
				@foreach( App\Ciudad::getCities() as $city)
					<option value="{{ $city->key }}" <%- respuesta == '{{ $city->key }}' ? 'selected': ''%> >{{ $city->value }}</option>
				@endforeach
			</select>
		</div>
	</div>
</script>
{{-- pass_confirm --}}
<script type="text/template" id="">
	<div class="row">
		<div class="small-12 tablet-5 medium-4 columns input-field">
			<input type="password" name="pregunta_<%- codigo_pregunta_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" value="" <%- !opcional_pregunta_encuesta ? 'required' : '' %> pattern="alpha_num_dash" class="validate">
			<label for="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" data-error="La clave solo acepta caracteres alfanuméricos sin acentos, ni caracteres extraños.">Contraseña</label>
		</div>
		<div class="small-12 tablet-5 medium-4 columns end input-field">
			<input type="password" value="" data-equalto="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" <%- !opcional_pregunta_encuesta ? 'required' : '' %> pattern="alpha_num_dash" class="validate">
			<label for="" data-error="Las claves no coinciden">Confirmar contraseña</label>
		</div>
	</div>
</script>
{{-- agree_terms --}}
<script type="text/template" id="">
	<div class="row">
		<div class="small-12 columns">
			<div id="terms-content" class="terms-content text-center">
				<input type="checkbox" name="pregunta_<%- codigo_pregunta_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" value="yes" <%- !opcional_pregunta_encuesta ? 'required' : '' %> class="validate" >
				<label for="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" class="label-terms dark-text" data-error="Para poder utilizar nuestros servicios, debes aceptar las condiciones del servicio de {{{ ucwords( App\RegistroSesion::getInstitutionName() ) }}}.">
					Acepto los {!! link_to_route('terminos', 'Términos de Uso', [], ['target' => '_blank', 'class' => 'sky-blue-text bold-text']) !!} y
					{!! link_to_route('privacidad', 'Políticas de Privacidad', [], ['target' => '_blank', 'class' => 'sky-blue-text bold-text']) !!} de
					<span class="bold-text dark-text">{{{ ucwords( App\RegistroSesion::getInstitutionName() ) }}}.</span>
				</label>
			</div>
		</div>
	</div>
</script>
{{-- date & before_date --}}
<script type="text/template" id="">
	<div class="row">
		<div class="tablet-3 medium-2 columns end input-field">
			<input type="text" name="pregunta_<%- codigo_pregunta_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" value="<%- respuesta %>" placeholder="Escribe tu respuesta..." <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-abide-validator="<%- pregunta_padre ? 'requiredOf' : '' %>" <%- pregunta_padre ? 'data-requiredof=pregunta_'+ pregunta_padre + '_opcion_'+ (codigo_opcion_encuesta ? codigo_opcion_encuesta : '0') : '' %> <%- subpregunta_pregunta ? 'area-has-subquestion' : '' %> <%- !opcional_pregunta_encuesta ? 'pattern=date' : '' %> class="<%- tipo_campo_pregunta == window._tp.typeQuestionField['before_date'] ? 'datebeforepk' : 'datepk'%>" >
		</div>
	</div>
</script>
{{-- number_format --}}
<script type="text/template" id="">
	<div class="row">
		<div class="tablet-3 medium-2 columns end input-field">
			<input type="text" name="pregunta_<%- codigo_pregunta_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" value="<%- !_.isEmpty(respuesta) || _.isNumber(respuesta) ? respuesta : 0 %>" placeholder="" <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-abide-validator="<%- pregunta_padre ? 'requiredOf' : '' %>" <%- pregunta_padre ? 'data-requiredof=pregunta_'+ pregunta_padre + '_opcion_'+ (codigo_opcion_encuesta ? codigo_opcion_encuesta : '0') : '' %> <%- subpregunta_pregunta ? 'area-has-subquestion' : '' %> pattern="<%- _.findKey(window._tp.typeQuestionField, function (validate) { return validate == tipo_campo_pregunta; }) || '' %>" class="number-mask" <%- longitud_pregunta_encuesta ? 'length='+longitud_pregunta_encuesta : '' %> <%- longitud_pregunta_encuesta ? 'maxlength='+longitud_pregunta_encuesta : '' %>>
		</div>
	</div>
</script>
{{-- ciiu --}}
<script type="text/template" id="">
	<div class="row">
		<div class="tablet-10 medium-8 columns end input-field">
			<select name="pregunta_<%- codigo_pregunta_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" class="choice-select browser-default" <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-placeholder="Seleccione actividad económica" placeholder="Seleccione actividad económica">
				<option value=""></option>
				@foreach( App\SectorInteres::getInterests() as $interest)
					<option value="{{ $interest->codigo_sector_interes }}" <%- respuesta == '{{ $interest->codigo_sector_interes }}' ? 'selected': ''%>>{{ str_pad($interest->codigo_sector_interes,4,'0',STR_PAD_LEFT).' - '.$interest->nombre_sector_interes }}</option>
				@endforeach
			</select>
		</div>
	</div>
</script>
{{-- education_level --}}
<script type="text/template" id="">
	<div class="row">
		<div class="tablet-6 medium-5 columns end input-field">
			<select name="pregunta_<%- codigo_pregunta_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" class="choice-select browser-default" <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-placeholder="Seleccione nivel de educación" placeholder="Seleccione nivel de educación">
				<option value=""></option>
				@foreach( App\NivelEducacion::getLevels() as $level)
					<option value="{{ $level->codigo_nivel_educacion }}" <%- respuesta == '{{ $level->codigo_nivel_educacion }}' ? 'selected': ''%>>{{ $level->nombre_nivel_educacion }}</option>
				@endforeach
			</select>
		</div>
	</div>
</script>
{{-- economic_sector --}}
<script type="text/template" id="">
	<div class="row">
		<div class="tablet-10 medium-8 columns end input-field">
			<select name="pregunta_<%- codigo_pregunta_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" class="choice-select browser-default" <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-placeholder="Seleccione sector económico" placeholder="Seleccione sector económico">
				<option value=""></option>
				@foreach( App\SectorEconomico::getSectors() as $sector)
					<option value="{{ $sector->codigo_sector_economico }}" <%- respuesta == '{{ $sector->codigo_sector_economico }}' ? 'selected': ''%>>{{ $sector->nombre_sector_economico }}</option>
				@endforeach
			</select>
		</div>
	</div>
</script>
{{-- currency & negative_currency --}}
<script type="text/template" id="">
	<div class="row">
		<div class="tablet-3 medium-2 columns end input-field">
			<% var maskNegative = tipo_campo_pregunta == window._tp.typeQuestionField['negative_currency'] ? 'ncurrencyMasks' : 'currencyMasks'; %>

			<input type="text" name="pregunta_<%- codigo_pregunta_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" value="<%- !_.isEmpty(respuesta) || _.isNumber(respuesta) ? respuesta : 0 %>" placeholder="" <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-abide-validator="<%- pregunta_padre ? 'requiredOf' : '' %>" <%- pregunta_padre ? 'data-requiredof=pregunta_'+ pregunta_padre + '_opcion_'+ (codigo_opcion_encuesta ? codigo_opcion_encuesta : '0') : '' %> <%- subpregunta_pregunta ? 'area-has-subquestion' : '' %> class="<%- sigla_moneda ? window._tp[maskNegative][sigla_moneda.toLowerCase()] : window._tp[maskNegative]['cop'] %>" >
		</div>
	</div>
</script>
{{-- phone --}}
<script type="text/template" id="">
	<div class="row">
		<div class="tablet-6 medium-5 columns end input-field">
			<input type="text" name="pregunta_<%- codigo_pregunta_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" value="<%- !_.isEmpty(respuesta) || _.isNumber(respuesta) ? respuesta : '' %>" placeholder="Escribe tu respuesta..." <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-abide-validator="<%- pregunta_padre ? 'requiredOf' : '' %>" <%- pregunta_padre ? 'data-requiredof=pregunta_'+ pregunta_padre + '_opcion_'+ (codigo_opcion_encuesta ? codigo_opcion_encuesta : '0') : '' %> <%- subpregunta_pregunta ? 'area-has-subquestion' : '' %> class="phone-mask-co" >
		</div>
	</div>
</script>
{{-- integer --}}
<script type="text/template" id="">
	<div class="row">
		<div class="tablet-3 medium-2 columns end input-field">
			<input type="text" name="pregunta_<%- codigo_pregunta_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" value="<%- !_.isEmpty(respuesta) || _.isNumber(respuesta) ? respuesta : 0 %>" placeholder="" <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-abide-validator="<%- pregunta_padre ? 'requiredOf' : '' %>" <%- pregunta_padre ? 'data-requiredof=pregunta_'+ pregunta_padre + '_opcion_'+ (codigo_opcion_encuesta ? codigo_opcion_encuesta : '0') : '' %> <%- subpregunta_pregunta ? 'area-has-subquestion' : '' %> pattern="<%- _.findKey(window._tp.typeQuestionField, function (validate) { return validate == tipo_campo_pregunta; }) || '' %>" class="integer-mask" <%- longitud_pregunta_encuesta ? 'length='+longitud_pregunta_encuesta : '' %> <%- longitud_pregunta_encuesta ? 'maxlength='+longitud_pregunta_encuesta : '' %>>
		</div>
	</div>
</script>
{{-- identification --}}
<script type="text/template" id="">
	<div class="row">
		<div class="tablet-3 medium-2 columns end input-field">
			<input type="text" name="pregunta_<%- codigo_pregunta_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" value="<%- respuesta %>" placeholder="Escribe tu respuesta..." <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-abide-validator="<%- pregunta_padre ? 'requiredOf' : '' %>" <%- pregunta_padre ? 'data-requiredof=pregunta_'+ pregunta_padre + '_opcion_'+ (codigo_opcion_encuesta ? codigo_opcion_encuesta : '0') : '' %> <%- subpregunta_pregunta ? 'area-has-subquestion' : '' %> pattern="" class="indetification-mask" <%- longitud_pregunta_encuesta ? 'length='+longitud_pregunta_encuesta : '' %> <%- longitud_pregunta_encuesta ? 'maxlength='+longitud_pregunta_encuesta : '' %>>
		</div>
	</div>
</script>
