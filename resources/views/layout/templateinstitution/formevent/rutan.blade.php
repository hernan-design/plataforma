{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-create-calendar-event') ) !!}
    <div class="row 1">
        <div class="small-12 columns input-field">
            <select
                id="codigo_tipo_evento"
                name="codigo_tipo_evento"
                class="choice-filter-events type-event-calendar"
                required data-placeholder="Tipo evento"
                placeholder="Elige un tipo evento"
                readonly>
                <option
                    {{-- value="{{ App\TipoEvento::getTypeEvent('mentoring') }}" --}}
                    value="1"
                    selected> Sesión de mentoría
                </option>
            </select>
            <label>Tipo:</label>
        </div>
    </div>
    <div class="row">
        <div class="small-12 columns input-field">
            <select
                id="codigo_asesoria"
                name="codigo_asesoria"
                class="choice-filter-events type-event-calendar"
                required
                class="validate">
                <option value="" selected> Selecciona </option>
                @foreach (App\Asesoria::getAdvisoryMentor(Auth::user()->identificacion_usuario) as $item)
                    <option value={{ $item->codigo_asesoria }}> {{ $item->nombre_emprendimiento }} </option>
                @endforeach
            </select>
            <label> Emprendimiento </label>
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns">
            <label for="start-event">Fecha Inicio</label>
            <input
                type="text"
                name="fecha_inicio"
                id="start-event"
                value="<%- typeof start !== 'undefined' ? start : '' %>"
                class="datetimepk"
                required>
        </div>
        <div class="small-6 columns">
            <label for="end-event">Fecha Fin</label>
            <input
                type="text"
                name="fecha_fin"
                id="end-event"
                value="<%- typeof end !== 'undefined' ? end : ''%>"
                class="datetimepk"
                required>
        </div>
    </div>
    <div class="row">
        <div class="small-12 columns input-field">
            <select
                name="codigo_ciudad"
                id="codigo_ciudad"
                {{-- class="browser-default choice-select-autocomplete change-choice" --}}
                {{-- data-ajax--url="<%- window.Misc.urlFull( Route.route('ciudades.index') ) %>" --}}
                {{-- data-initial-value="<%- typeof(codigo_ciudad) !== 'undefined' ? codigo_ciudad : '' %>" --}}
                {{-- data-placeholder="Seleccione" --}}
                placeholder="Seleccione"
                required
                readonly>
                <option value="2259" selected>Medellín - Antioquia - COL</option>
            </select>
            <label for="codigo_ciudad">Ciudad</label>
        </div>
    </div>
    <div class="row">
        <div class="small-12 columns input-field">
            <select
                name="codigo_tema_principal_evento"
                id="codigo_tema_principal_evento"
                class="browser-default choice-select-autocomplete change-choice"
                data-ajax--url="<%- window.Misc.urlFull( Route.route('calendario.evento.tema') ) %>"
                data-initial-value="<%- typeof(codigo_tema_principal_evento) !== 'undefined' ? codigo_tema_principal_evento : 0 %>"
                data-placeholder="Seleccione"
                placeholder="Seleccione"
                required>
            </select>
            <label for="codigo_tema_principal_evento">Nombre del Beneficio Otorgado</label>
        </div>
    </div>
    <div class="row">
        <div class="small-12 columns input-field">
            <input type="text"
            name="lugar_evento"
            id="lugar_evento"
            value="<%- typeof lugar_evento !== 'undefined' ? lugar_evento : '' %>"
            required
            class="validate">
            <label for="lugar_evento">Link o lugar de reunión</label>
        </div>
    </div>
    <div class="row can-readonly-field">
        <div class="tablet-12 columns input-field">
            <input
                type="text"
                name="nombre_evento"
                id="nombre_evento"
                area-default="{{ trans('event.mentoring.name.event') }}"
                value="<%- typeof nombre_evento !== 'undefined' ? nombre_evento : '' %>"
                required
                class="validate">
            <label for="nombre_evento">Título del evento</label>
        </div>
    </div>
    <div class="row can-readonly-field">
        <div class="small-12 columns input-field">
            <label>Descripción de la sesión</label>
            <textarea
                name="descripcion_evento"
                {{-- area-default="{{ Lang::get('event.mentoring.description.event') }}" --}}
                rows="2"
                class="materialize-textarea validate"
                required>{{ Lang::get('event.mentoring.description.event') }}</textarea>
        </div>
    </div>
    <div class="row save-section">
        {{--  <% if(!_.isUndefined(typeof(codigo_evento)) && !_.isNull(codigo_evento)) { %>
        <div class="small-12 medium-3 medium-offset-6 columns">
            <a href="#" id="cancel-mentoring" class="button small sky-blue btn-bold radius btn-clean-margin expand">Cancelar </a>
        </div>
        <% } %>  --}}
        <div class="small-12 medium-3 columns">
            {{--  <p><% codigo_evento %></p>  --}}
            {{--  <input class="button small sky-blue btn-bold radius btn-clean-margin expand" value="<%- (_.isUndefined(typeof(codigo_evento)) || _.isNull(codigo_evento)) ? 'Crear': 'Editar' %>" type="submit">  --}}
            <input class="button small sky-blue btn-bold radius btn-clean-margin expand" value="Crear" type="submit">
        </div>
    </div>
{!! Form::close() !!}