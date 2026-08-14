{{-- Matriz question survey --}}
<script type="text-template" id="survey-matriz-question-tpl">
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
	<table class="grid-matriz-survey responsive-table <%- review ? 'bordered' : ''%>">
		<thead>
			<tr>
				<th><%- titulo_opciones_pregunta ? titulo_opciones_pregunta : '' %></th>
				<% _.each(campos_opciones, function (fieldOption) { %>
					<th data-field="head_<%- fieldOption.codigo_opcion_encuesta %>"><%- fieldOption.texto_opcion_encuesta %></th>
				<% }); %>
			</tr>
		</thead>

		<tbody>
			{{-- review answer --}}
			<% if(review) { %>
				<% if(!_.isNull(respuesta) && !_.isUndefined(respuesta)) { %>
					<% _.each(opciones, function (option) { %>
						<tr>
							<th id="matriz-option-<%- option.codigo_opcion_encuesta %>" class="<%- option.calculado_opcion_encuesta ? 'dark-text bold-text' : ''%>"><%- option.texto_opcion_encuesta %></th>
							<% _.each(campos_opciones, function (fieldOption) {
								var typeField = option.tipo_campo_opcion || tipo_campo_pregunta;
								fieldOption.tipo_campo_opcion && (typeField = fieldOption.tipo_campo_opcion);
							%>
								<% if(typeField == window._tp.typeQuestionField['date'] || typeField == window._tp.typeQuestionField['before_date']) { %>

									<td><%- window.moment(respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta]).format('YYYY-MM-DD') %></td>

								<% } else if(typeField == window._tp.typeQuestionField['number_format']) { %>
									<td><%- respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta] == 0 ? '0' :  Globalize.formatNumber(parseFloat(respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta])) %></td>

								<% } else if( typeField == window._tp.typeQuestionField['currency'] || typeField == window._tp.typeQuestionField['negative_currency']) { %>

									<td class="text-right"><%- Globalize.formatCurrency(parseFloat(respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta]), sigla_moneda || 'COP', {style: "symbol", minimumFractionDigits: 0, maximumFractionDigits: 2}) %></td>

								<% } else if( typeField == window._tp.typeQuestionField['percentage'] ) { %>

									<td class="text-right"><%- Globalize.formatNumber(parseInt(respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta])/100, { style: "percent", round: 'round', }) %></td>

								<% } else if(typeField == window._tp.typeQuestionField['cities']) { %>

									@foreach( App\Ciudad::getCities() as $city)
										<% if(respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta] == '{{ $city->key }}') { %>
											<p class="text-md">{{ $city->value }}</p>
										<% } %>
									@endforeach

								<% } else if( typeField == window._tp.typeQuestionField['select'] ) { %>

                                    <td>
                                        <ul class="no-bullet">
											<% if(fieldOption.opciones.length) { %>
												<% _.chain(fieldOption.opciones).filter(function(fieldOpt) { return respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta] == fieldOpt.codigo_item_opcion_encuesta; }).each(function (fieldOpt) { %>
													<li><span class="text-md"><%- fieldOpt.nombre_item_opcion_encuesta %></span></li>
												<% }) %>
											<% } else { %>
												<% _.chain(option.opciones).filter(function(fieldOpt) { return respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta] == fieldOpt.codigo_item_opcion_encuesta; }).each(function (fieldOpt) { %>
													<li><span class="text-md"><%- fieldOpt.nombre_item_opcion_encuesta %></span></li>
												<% }) %>
											<% } %>
                                        </ul>
                                    </td>

								<% } else if( typeField == window._tp.typeQuestionField['image'] ) { %>

									<td>
                                        <div class="field-with-image">
                                            <img id="image-thumb-<%- codigo_pregunta_encuesta +'_'+ option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta %>" src="<%- respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta] %>" onerror="if (this.src != '{{ config('tuproyecto.no_image') }}') this.src = '{{ config('tuproyecto.no_image') }}';" />
                                        </div>
                                    </td>

								<% } else { %>

									<td><%- respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta] %></td>

								<% } %>
							<% }); %>
						</tr>
					<% }); %>
				<% } %>
			<% }else { %>
				<% _.each(opciones, function (option) { %>
					<tr>
						<th id="matriz-option-<%- option.codigo_opcion_encuesta %>" class="<%- option.calculado_opcion_encuesta ? 'dark-text bold-text' : ''%>"><%- option.texto_opcion_encuesta %></th>
						<% _.each(campos_opciones, function (fieldOption) {
							var typeField = option.tipo_campo_opcion || tipo_campo_pregunta;
							fieldOption.tipo_campo_opcion && (typeField = fieldOption.tipo_campo_opcion);
						%>
							<td headers="matriz-option-<%- option.codigo_opcion_encuesta %>">
							<% if( !typeField || !_.contains(['full_year','date','before_date','number_format','currency','negative_currency','single_check','multiple_check','percentage','integer','select','cities','image'], _.findKey(window._tp.typeQuestionField, function(type){return type == typeField;})) ) { %>
								<div class="">
									<input type="text" name="pregunta_<%- codigo_pregunta_encuesta %>_opcion_<%- option.codigo_opcion_encuesta %>_campo_<%- fieldOption.codigo_opcion_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_<%- option.codigo_opcion_encuesta %>_campo_<%- fieldOption.referencia_opcion_encuesta || fieldOption.codigo_opcion_encuesta %>" value="<%- _.isObject(respuesta) ? respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta] : '' %>" placeholder="Escribe tu respuesta..." <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-abide-validator="<%- pregunta_padre ? '' : '' %><%- typeField == window._tp.typeQuestionField['singleText'] ? 'maxLength' : '' %>" <%- pregunta_padre ? 'data-requiredof=pregunta_'+ pregunta_padre + '_opcion_'+ (codigo_opcion_encuesta ? codigo_opcion_encuesta : '0') : '' %> <%- subpregunta_pregunta ? 'area-has-subquestion' : '' %> <%- typeField == window._tp.typeQuestionField['singleText'] ? (longitud_pregunta_encuesta ? 'length='+longitud_pregunta_encuesta : 'length=200') : '' %> pattern="<%- _.findKey(window._tp.typeQuestionField, function (validate) { return validate == typeField; }) || '' %>" class="<%- option.calculado_opcion_encuesta ? 'calculate-field' : '' %>" <%- option.calculado_opcion_encuesta ? 'readonly=readonly' : '' %> <%- fieldOption.referencia_opcion_encuesta ? 'data-slug='+fieldOption.referencia_opcion_encuesta : '' %> >
								</div>

							<% } else if(typeField == window._tp.typeQuestionField['full_year']) { %>

								<div class="">
									<input type="text" name="pregunta_<%- codigo_pregunta_encuesta %>_opcion_<%- option.codigo_opcion_encuesta %>_campo_<%- fieldOption.codigo_opcion_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_<%- option.codigo_opcion_encuesta %>_campo_<%- fieldOption.codigo_opcion_encuesta %>" value="<%- _.isObject(respuesta) ? respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta] : '' %>" placeholder="YYYY" <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-abide-validator="<%- pregunta_padre ? '' : '' %>" <%- pregunta_padre ? 'data-requiredof=pregunta_'+ pregunta_padre + '_opcion_'+ (codigo_opcion_encuesta ? codigo_opcion_encuesta : '0') : '' %> <%- subpregunta_pregunta ? 'area-has-subquestion' : '' %> pattern="full_year" class="full_year" maxlength="4" >
								</div>

							<% } else if(typeField == window._tp.typeQuestionField['date'] || typeField == window._tp.typeQuestionField['before_date']) { %>

								<div class="">
									<input type="text" name="pregunta_<%- codigo_pregunta_encuesta %>_opcion_<%- option.codigo_opcion_encuesta %>_campo_<%- fieldOption.codigo_opcion_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_<%- option.codigo_opcion_encuesta %>_campo_<%- fieldOption.codigo_opcion_encuesta %>" value="<%- _.isObject(respuesta) ? respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta] : '' %>" placeholder="Escribe tu respuesta..." <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-abide-validator="<%- pregunta_padre ? 'requiredOf' : '' %>" <%- pregunta_padre ? 'data-requiredof=pregunta_'+ pregunta_padre + '_opcion_'+ (codigo_opcion_encuesta ? codigo_opcion_encuesta : '0') : '' %> <%- subpregunta_pregunta ? 'area-has-subquestion' : '' %> pattern="date" class="<%- typeField == window._tp.typeQuestionField['before_date'] ? 'datebeforepk' : 'datepk'%>" >
								</div>

							<% } else if(typeField == window._tp.typeQuestionField['number_format']) { %>

								<div class="">
									<input type="text" name="pregunta_<%- codigo_pregunta_encuesta %>_opcion_<%- option.codigo_opcion_encuesta %>_campo_<%- fieldOption.codigo_opcion_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_<%- option.codigo_opcion_encuesta %>_campo_<%- fieldOption.referencia_opcion_encuesta || fieldOption.codigo_opcion_encuesta %>" value="<%- _.isObject(respuesta) && respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta] != null ? respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta] : 0 %>" placeholder="" <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-abide-validator="<%- pregunta_padre ? 'requiredOf' : '' %>" <%- pregunta_padre ? 'data-requiredof=pregunta_'+ pregunta_padre + '_opcion_'+ (codigo_opcion_encuesta ? codigo_opcion_encuesta : '0') : '' %> <%- subpregunta_pregunta ? 'area-has-subquestion' : '' %> pattern="<%- _.findKey(window._tp.typeQuestionField, function (validate) { return validate == typeField; }) || '' %>" class="number-mask" <%- longitud_pregunta_encuesta ? 'length='+longitud_pregunta_encuesta : '' %> <%- longitud_pregunta_encuesta ? 'maxlength='+longitud_pregunta_encuesta : '' %> <%- fieldOption.referencia_opcion_encuesta ? 'data-slug='+fieldOption.referencia_opcion_encuesta : '' %> >
								</div>

							<% } else if( typeField == window._tp.typeQuestionField['currency'] || typeField == window._tp.typeQuestionField['negative_currency']) { %>
								<% var maskNegative = typeField == window._tp.typeQuestionField['negative_currency'] ? 'ncurrencyMasks' : 'currencyMasks'; %>

								<div class="">
									<input type="text" name="pregunta_<%- codigo_pregunta_encuesta %>_opcion_<%- option.codigo_opcion_encuesta %>_campo_<%- fieldOption.codigo_opcion_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_<%- option.codigo_opcion_encuesta %>_campo_<%- fieldOption.referencia_opcion_encuesta || fieldOption.codigo_opcion_encuesta %>" value="<%- _.isObject(respuesta) && respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta] != null ? respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta] : 0 %>" placeholder="" <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-abide-validator="<%- pregunta_padre ? 'requiredOf' : '' %>" <%- pregunta_padre ? 'data-requiredof=pregunta_'+ pregunta_padre + '_opcion_'+ (codigo_opcion_encuesta ? codigo_opcion_encuesta : '0') : '' %> <%- subpregunta_pregunta ? 'area-has-subquestion' : '' %> class="<%- sigla_moneda ? window._tp[maskNegative][sigla_moneda.toLowerCase()] : window._tp[maskNegative]['cop'] %> <%- option.calculado_opcion_encuesta ? 'calculate-field' : '' %>" <%- option.calculado_opcion_encuesta ? 'readonly=readonly' : '' %> <%- fieldOption.referencia_opcion_encuesta ? 'data-slug='+fieldOption.referencia_opcion_encuesta : '' %> >
								</div>

							<% } else if( typeField == window._tp.typeQuestionField['single_check'] ) { %>

								<div class="">
									<input type="radio" name="pregunta_<%- codigo_pregunta_encuesta %>_opcion_<%- option.codigo_opcion_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_<%- option.codigo_opcion_encuesta %>_campo_<%- fieldOption.codigo_opcion_encuesta %>" value="<%- option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta %>" <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-abide-validator="<%- pregunta_padre ? 'requiredOf' : '' %>" <%- pregunta_padre ? 'data-requiredof=pregunta_'+ pregunta_padre + '_opcion_'+ (codigo_opcion_encuesta ? codigo_opcion_encuesta : '0') : '' %> <%- subpregunta_pregunta ? 'area-has-subquestion' : '' %> <%- _.isObject(respuesta) ? (respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta] ? 'checked' : '') : '' %> class="with-gap" >
									<label for="pregunta_<%- codigo_pregunta_encuesta %>_opcion_<%- option.codigo_opcion_encuesta %>_campo_<%- fieldOption.codigo_opcion_encuesta %>"></label>
								</div>

							<% } else if( typeField == window._tp.typeQuestionField['multiple_check'] ) { %>

								<div class="">
									<input type="checkbox" name="pregunta_<%- codigo_pregunta_encuesta %>_opcion_<%- option.codigo_opcion_encuesta %>_campo_<%- fieldOption.codigo_opcion_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_<%- option.codigo_opcion_encuesta %>_campo_<%- fieldOption.codigo_opcion_encuesta %>" value="<%- option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta %>" data-abide-validator="<%- !opcional_pregunta_encuesta ? 'onChecked' : '' %><%- pregunta_padre ? ' requiredOf' : '' %>" data-relchecks="pregunta_<%- codigo_pregunta_encuesta %>_opcion_<%- option.codigo_opcion_encuesta %>" <%- pregunta_padre ? 'data-requiredof=pregunta_'+ pregunta_padre + '_opcion_'+ (codigo_opcion_encuesta ? codigo_opcion_encuesta : '0') : '' %> <%- subpregunta_pregunta ? 'area-has-subquestion' : '' %> <%- _.isObject(respuesta) ? (respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta] ? 'checked' : '') : '' %> class="filled-in" >
									<label for="pregunta_<%- codigo_pregunta_encuesta %>_opcion_<%- option.codigo_opcion_encuesta %>_campo_<%- fieldOption.codigo_opcion_encuesta %>"></label>
								</div>

							<% } else if( typeField == window._tp.typeQuestionField['percentage'] ) { %>

								<div class="">
									<input type="text" name="pregunta_<%- codigo_pregunta_encuesta %>_opcion_<%- option.codigo_opcion_encuesta %>_campo_<%- fieldOption.codigo_opcion_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_<%- option.codigo_opcion_encuesta %>_campo_<%- fieldOption.referencia_opcion_encuesta || fieldOption.codigo_opcion_encuesta %>" value="<%- _.isObject(respuesta) && respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta] != null ? respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta] : 0 %>" placeholder="" <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-abide-validator="<%- pregunta_padre ? 'requiredOf' : '' %>" <%- pregunta_padre ? 'data-requiredof=pregunta_'+ pregunta_padre + '_opcion_'+ (codigo_opcion_encuesta ? codigo_opcion_encuesta : '0') : '' %> <%- subpregunta_pregunta ? 'area-has-subquestion' : '' %> class="percentage-mask <%- option.calculado_opcion_encuesta ? 'calculate-field' : '' %>" <%- option.calculado_opcion_encuesta ? 'readonly=readonly' : '' %> <%- fieldOption.referencia_opcion_encuesta ? 'data-slug='+fieldOption.referencia_opcion_encuesta : '' %> >
								</div>

							<% } else if( typeField == window._tp.typeQuestionField['integer'] ) { %>

								<div class="">
									<input type="text" name="pregunta_<%- codigo_pregunta_encuesta %>_opcion_<%- option.codigo_opcion_encuesta %>_campo_<%- fieldOption.codigo_opcion_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_<%- option.codigo_opcion_encuesta %>_campo_<%- fieldOption.referencia_opcion_encuesta || fieldOption.codigo_opcion_encuesta %>" value="<%- _.isObject(respuesta) && respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta] != null ? respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta] : 0 %>" placeholder="" <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-abide-validator="<%- pregunta_padre ? 'requiredOf' : '' %>" <%- pregunta_padre ? 'data-requiredof=pregunta_'+ pregunta_padre + '_opcion_'+ (codigo_opcion_encuesta ? codigo_opcion_encuesta : '0') : '' %> <%- subpregunta_pregunta ? 'area-has-subquestion' : '' %> pattern="<%- _.findKey(window._tp.typeQuestionField, function (validate) { return validate == typeField; }) || '' %>" class="integer-mask" <%- longitud_pregunta_encuesta ? 'length='+longitud_pregunta_encuesta : '' %> <%- longitud_pregunta_encuesta ? 'maxlength='+longitud_pregunta_encuesta : '' %> <%- fieldOption.referencia_opcion_encuesta ? 'data-slug='+fieldOption.referencia_opcion_encuesta : '' %> >
								</div>

							<% } else if( typeField == window._tp.typeQuestionField['select'] ) { %>

								<div class="">
									<select name="pregunta_<%- codigo_pregunta_encuesta %>_opcion_<%- option.codigo_opcion_encuesta %>_campo_<%- fieldOption.codigo_opcion_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_<%- option.codigo_opcion_encuesta %>_campo_<%- fieldOption.codigo_opcion_encuesta %>" data-placeholder="Selecciona tu respuesta..." placeholder="Selecciona tu respuesta..." <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-abide-validator="<%- pregunta_padre ? ' requiredOf' : '' %>" <%- pregunta_padre ? 'data-requiredof=pregunta_'+ pregunta_padre + '_opcion_'+ (codigo_opcion_encuesta ? codigo_opcion_encuesta : '0') : '' %> <%- subpregunta_pregunta ? 'area-has-subquestion' : '' %> class="choice-select browser-default" >
										<option value=""></option>
										<% if(fieldOption.opciones.length) { %>
											<% _.each(fieldOption.opciones, function (fieldOpt) { %>
												<option value="<%- fieldOpt.codigo_item_opcion_encuesta %>" <%- _.isObject(respuesta) ? (respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta] == fieldOpt.codigo_item_opcion_encuesta ? 'selected' : '') : '' %> ><%- fieldOpt.nombre_item_opcion_encuesta %></option>
											<% }) %>
										<% } else { %>
											<% _.each(option.opciones, function (fieldOpt) { %>
												<option value="<%- fieldOpt.codigo_item_opcion_encuesta %>" <%- _.isObject(respuesta) ? (respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta] == fieldOpt.codigo_item_opcion_encuesta ? 'selected' : '') : '' %> ><%- fieldOpt.nombre_item_opcion_encuesta %></option>
											<% }) %>
										<% } %>
									</select>
								</div>

							<% } else if( typeField == window._tp.typeQuestionField['cities'] ) { %>

								<div class="">
									<select name="pregunta_<%- codigo_pregunta_encuesta %>_opcion_<%- option.codigo_opcion_encuesta %>_campo_<%- fieldOption.codigo_opcion_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_<%- option.codigo_opcion_encuesta %>_campo_<%- fieldOption.codigo_opcion_encuesta %>" class="choice-select browser-default" <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-placeholder="Selecciona una ubicación" placeholder="Selecciona una ubicación" data-abide-validator="<%- pregunta_padre ? 'requiredOf' : ''%>" <%- pregunta_padre ? 'data-requiredof=pregunta_'+ pregunta_padre + '_opcion_'+ (codigo_opcion_encuesta ? codigo_opcion_encuesta : '0') : '' %>>
										<option value=""></option>
										@foreach( App\Ciudad::getCities() as $city)
											<option value="{{ $city->key }}" <%- _.isObject(respuesta) ? (respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta] == '{{ $city->key }}' ? 'selected': '') : ''%> >{{ $city->value }}</option>
										@endforeach
									</select>
								</div>

							<% } else if( typeField == window._tp.typeQuestionField['image'] ) { %>

								<div class="wrapper-image-survey field-with-image">
									<div class="item-gallery-image image-area-drop">
										<a class="upload-image-survey-question" title="Cargar imagen">
											<img id="image-thumb-<%- codigo_pregunta_encuesta +'_'+ option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta %>" src="<%- _.isObject(respuesta) ? respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta] : '{{ config('tuproyecto.no_image') }}' %>" onerror="if (this.src != '{{ config('tuproyecto.no_image') }}') this.src = '{{ config('tuproyecto.no_image') }}'" class="thumbnail-image-survey item-thumb">
											<i class="mdi mdi-plus hidesoft"></i>
										</a>
									</div>
									<input type="hidden" name="pregunta_<%- codigo_pregunta_encuesta %>_opcion_<%- option.codigo_opcion_encuesta %>_campo_<%- fieldOption.codigo_opcion_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_<%- option.codigo_opcion_encuesta %>_campo_<%- fieldOption.codigo_opcion_encuesta %>" value="<%- _.isObject(respuesta) ? respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta] : '' %>" <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-field-data="opcion_<%- option.codigo_opcion_encuesta %>_campo_<%- fieldOption.codigo_opcion_encuesta %>" >
								</div>

							<% } %>
							</td>
						<% }); %>
					</tr>
				<% }); %>
			<% } %>
		</tbody>
	</table>
</script>
