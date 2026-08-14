{{-- single question & answer survey --}}
<script type="text/template" id="survey-single-answer-tpl">
	<% if(!opcional_pregunta_encuesta && !review) { %>
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
					<ul class="disc">
						<% _.chain(opciones).filter(function(option) { return respuesta == option.codigo_opcion_encuesta; }).each(function (option) { %>
							<li><span class="text-md"><%- option.texto_opcion_encuesta %></span></li>
						<% }) %>
					</ul>
				</div>
			</div>
		<% } %>
	<% }else if(tipo_campo_pregunta == window._tp.typeQuestionField['select']) { %>
		<div class="row">
			<div class="tablet-6 medium-5 columns end input-field">
				<select name="pregunta_<%- codigo_pregunta_encuesta %>_opcion" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" data-placeholder="Selecciona tu respuesta..." placeholder="Selecciona tu respuesta..." <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-abide-validator="<%- pregunta_padre ? ' requiredOf' : '' %>" <%- pregunta_padre ? 'data-requiredof=pregunta_'+ pregunta_padre + '_opcion_'+ (codigo_opcion_encuesta ? codigo_opcion_encuesta : '0') : '' %> <%- subpregunta_pregunta ? 'area-has-subquestion' : '' %> class="choice-select browser-default" >
					<option value=""></option>
					<% _.each(opciones, function (option) { %>
						<option value="<%- option.codigo_opcion_encuesta %>" <%- _.isArray(respuesta) ? (_.contains(respuesta, option.codigo_opcion_encuesta) ? 'selected' : '') : (respuesta == option.codigo_opcion_encuesta ? 'selected' : '')%> id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_<%- option.codigo_opcion_encuesta %>" ><%- option.texto_opcion_encuesta %></option>
					<% }) %>
				</select>
			</div>
		</div>
	<% } else { %>
		<div class="row">
			<div class="small-12 columns">
				<ul class="list-checked-survey no-bullet">
					<% _.each(opciones, function(option) { %>
						<li>
							<input type="radio" name="pregunta_<%- codigo_pregunta_encuesta %>_opcion" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_<%- option.codigo_opcion_encuesta %>" value="<%- option.codigo_opcion_encuesta %>" <%- !opcional_pregunta_encuesta ? 'required' : '' %> data-abide-validator="<%- pregunta_padre ? 'requiredOf' : '' %>" <%- pregunta_padre ? 'data-requiredof=pregunta_'+ pregunta_padre + '_opcion_'+ (codigo_opcion_encuesta ? codigo_opcion_encuesta : '0') : '' %> <%- subpregunta_pregunta ? 'area-has-subquestion' : '' %> <%- respuesta == option.codigo_opcion_encuesta ? 'checked' : '' %> class="with-gap" >
							<label for="pregunta_<%- codigo_pregunta_encuesta %>_opcion_<%- option.codigo_opcion_encuesta %>"><%- option.texto_opcion_encuesta %></label>
						</li>
					<% }) %>
				</ul>
			</div>
		</div>
	<% } %>
</script>
