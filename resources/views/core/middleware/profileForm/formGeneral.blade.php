<div class="row col-equal-height">
    <div class="small-12 tablet-4 columns">
        <div class="registration-process-border">
            <div class="reg-process-info-box">
                <small class="reg-process-info-steps">PASO 2 DE {{ App\RegistroSesion::institution()->pasos_complementarios_registro ? '4' : '2' }}</small>
                <h5 class="reg-process-info-title">Datos generales</h5>
                <p class="reg-process-info-text">Completa los siguientes datos para continuar con el proceso de registro.</p>
                <div id="step-profile-main-image" class="upload-profile-img-main">
                    {{-- Render image template--}}
                </div>
                <span class="text-sm">Sube una imagen de perfil</span>
            </div>
        </div>
    </div>

    <div class="small-12 tablet-8 columns">
        <div class="reg-content-box">
            <div class="row">
                <div class="tablet-6 columns input-field">
                    <input type="text" name="nombre_usuario" value="<%- nombre_usuario %>" pattern="[a-zA-Z]+" class="validate"  required>
                    <label for="nombre_usuario">Nombre (*)</label>
                    <small class="error">¡El nombre es obligatorio!</small>
                </div>

                <div class="tablet-6 columns input-field">
                    <input type="text" name="primer_apellido_persona" value="<%- primer_apellido_persona %>" class="validate" pattern="[a-zA-Z]+" required>
                    <label for="primer_apellido_persona">Primer apellido (*)</label>
                    <small class="error">¡El primer apellido es obligatorio!</small>
                </div>
            </div>
            <div class="row">
                <div class="tablet-6 columns input-field">
                    <input type="text" name="segundo_apellido_persona" value="<%- segundo_apellido_persona %>" pattern="[a-zA-Z]+" class="validate">
                    <label for="segundo_apellido_persona">Segundo apellido</label>
                </div>

                <div class="tablet-6 columns input-field">
                    <select name="genero_persona" data-placeholder="Seleccione" placeholder="Seleccione" class="validate" required>
                        <option value="" disabled selected>Seleccione</option>
                        @foreach( App\Usuario::getArrayGender() as $key => $value)
                            <option value="{{ $key }}" <%- genero_persona == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
                        @endforeach
                    </select>
                    <label for="genero_persona">Sexo (*)</label>
                </div>
            </div>
            <div class="row">
                <div class="tablet-6 columns input-field">
                    <select name="codigo_ciudad" id="codigo_ciudad" class="browser-default choice-select-autocomplete change-choice" data-ajax--url="<%= window.Misc.urlFull( Route.route('ciudades.index') ) %>" data-initial-value="<%- typeof(codigo_ciudad) !== 'undefined' ? codigo_ciudad : '' %>" data-placeholder="Seleccione" placeholder="Seleccione" required>
                    </select>
                    <label for="codigo_ciudad">{{ transtp('perfil.city') }}  (*)</label>
                    <small class="error">Debe seleccionar una ciudad</small>
                </div>

                <div class="tablet-6 columns input-field">
                    <div class="mobile-4 tablet-4 columns">
                        <select name="year" id="year" data-placeholder="{{ Lang::choice('app.year', 1) }}" placeholder="{{ Lang::choice('app.year', 1) }}" required>
                            <option value="" disabled selected>{{ Lang::choice('app.year', 1) }}</option>
                            @foreach( TuProyecto::getPastYears() as $key => $value)
                                <option value="{{ $key }}" <%- window.moment(fecha_nacimiento_usuario).format('YYYY') == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mobile-4 tablet-4 columns">
                        <select name="month" id="month" data-placeholder="{{ Lang::choice('app.month', 1) }}" placeholder="{{ Lang::choice('app.month', 1) }}" required>
                            <option value="" disabled selected>{{ Lang::choice('app.month', 1) }}</option>
                            @foreach( TuProyecto::getMonths() as $key => $value)
                                <option value="{{ $key }}" <%- window.moment(fecha_nacimiento_usuario).format('M') == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mobile-4 tablet-4 end columns">
                        <select name="day" id="day" data-placeholder="{{ Lang::choice('app.day', 1) }}" placeholder="{{ Lang::choice('app.day', 1) }}" required>
                            <option value="" disabled selected>{{ Lang::choice('app.day', 1) }}</option>
                            @for($i = 1; $i <= 31; $i++)
                                <option value="{{ $i  }}" <%- window.moment(fecha_nacimiento_usuario).format('D') == '{{ $i }}' ? 'selected': ''%>>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <label class="active">Fecha de nacimiento (*)</label>
                </div>
            </div>
            @if($institution->identificacion_registro)
                <div class="row">
                    <div class="tablet-6 columns input-field">
                        <select 
                            name="tipo_identificacion_usuario" 
                            id="tipo_identificacion_usuario" 
                            class="browser-default choice-select-autocomplete change-choice" 
                            data-ajax--url="<%= window.Misc.urlFull( Route.route('usuario.identificacion.index') ) %>" 
                            data-initial-value="<%- typeof(tipo_identificacion_usuario) !== 'undefined' ? tipo_identificacion_usuario : '' %>" 
                            data-placeholder="Seleccione" 
                            placeholder="Seleccione" 
                            required>
                        </select>
                        <label for="tipo_identificacion_usuario">Tipo de identificación (*)</label>
                        <small class="error">Debe seleccionar un tipo de identificación</small>
                    </div>

                    <div class="tablet-6 columns input-field">
                        <div id="identification-user">
                            {{-- Render template id=identification-user-tpl --}}
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="tablet-6 columns input-field">
                    <input
                        type="text"
                        name="nickname_usuario"
                        id="nickname_usuario"
                        value="<%- nickname_usuario
                            ? nickname_usuario
                            : '{{ $userNicknameProvisional }}' %>"
                        pattern="nickname"
                        class="validate change-nickname-profile"
                        data-abide-validator="usernameAvailable"
                        maxlength="15"
                        required
                    >
                    <label for="nickname_usuario">Nickname (*)</label>
                    <span class="nickname-field-message success-text hidesoft"></span>
                    <span class="nickname-field-path success-text"><%- window.Misc.urlFull(Route.route('usuario.nickname', {'nickname': !_.isNull(nickname_usuario) ? nickname_usuario : '' })) %></span>
                </div>
                <div class="tablet-6 columns input-field">
                    <div>
                        <input type="text" name="movil_usuario" id="movil_usuario" value="<%- movil_usuario %>" class="phone-mask-co validate error" required>
                    </div>
                    <label class="active" for="movil_usuario">Celular (*)</label>
                    <small class="error">Debe Ingresar un número telefónico</small>
                </div>
            </div>
            <div class="row">
                <div class="tablet-6 columns input-field">
                    <div>
                        <input
                            type="text"
                            name="telefono_usuario"
                            id="telefono_usuario"
                            value="<%- telefono_usuario %>"
                            class="phone-mask-co validate error"
                        >
                    </div>
                    <label class="active" for="telefono_usuario">Teléfono fijo</label>
                </div>
            </div>

            @if($institution->datos_complementarios)
                <div class="row">
                    <div class="small-12 columns input-field">
                        <select name="codigo_nivel_educacion" id="codigo_nivel_educacion" data-placeholder="Seleccione" placeholder="Seleccione" class="validate" required>
                            <option value="" disabled selected>Seleccione</option>
                            @foreach( App\NivelEducacion::getLevels() as $level)
                                <option value="{{ $level->codigo_nivel_educacion }}" <%- codigo_nivel_educacion == '{{ $level->codigo_nivel_educacion }}' ? 'selected': ''%>>{{ $level->nombre_nivel_educacion }}</option>
                            @endforeach
                        </select>
                        <label for="codigo_nivel_educacion">Nivel educación</label>
                    </div>
                </div>

                <div id="step-profile-professions">
                    {{-- Render template id="professions-profile-tpl" --}}
                </div>
                @if ($institution->codigo_institucion == 51)
                    <div class="row">
                        <div class="tablet-12 columns input-field">
                            <select name="codigo_ocupacion_persona" id="codigo_ocupacion_persona" style="max-width:100%;" class="browser-default choice-select-autocomplete change-choice" data-ajax--url="<%= window.Misc.urlFull( Route.route('ocupaciones.index') ) %>" data-initial-value="<%- typeof(codigo_ocupacion_persona) !== 'undefined' ? codigo_ocupacion_persona : '' %>" data-placeholder="Seleccione" placeholder="Seleccione" required>
                            </select>
                            <label for="codigo_ocupacion_persona">Ocupación</label>
                        </div>
                    </div>
                @endif
            @endif

            {{-- validation only for Dinamiza --}}
            @if($institution->datos_socio_economicos)
                <div class="row">
                    <div class="tablet-6 columns input-field">
                            <select name="cor_codigo_ciudad" id="cor_codigo_ciudad" class="browser-default choice-select-autocomplete change-choice" data-ajax--url="<%= window.Misc.urlFull( Route.route('ciudades.index') ) %>" data-initial-value="<%- typeof(cor_codigo_ciudad) !== 'undefined' ? cor_codigo_ciudad : '' %>" data-placeholder="Seleccione..." placeholder="Seleccione...">
                            </select>
                        <label for="cor_codigo_ciudad">Ciudad de residencia</label>
                    </div>
                    <div class="tablet-6 columns input-field">
                        <select name="estado_civil_persona" id="estado_civil_persona" class="" data-placeholder="Seleccione estado civil" placeholder="Seleccione estado civil">
                            <option value="" disabled selected>Seleccione estado civil</option>
                            @foreach( $maritalStatus as $key => $value)
                                <option value="{{ $key }}" <%- estado_civil_persona == {{ $key }} ? 'selected' : '' %>>{{ $value }}</option>
                            @endforeach
                        </select>
                        <label for="estado_civil_persona">Estado civil</label>
                    </div>
                </div>
                <div class="row">
                    <div class="tablet-6 columns input-field">
                        <select type="text" name="codigo_barrio_localidad" id="codigo_barrio_localidad" class="form-control">
                            <option value="">Seleccione...</option>
                            @foreach ($zone as $value)
                                <option value="{{ $value->id }}" <%- codigo_barrio_localidad == {{ $value->id }} ? 'selected' : '' %>>{{ $value->text }}</option>
                            @endforeach
                        </select>
                        <label for="codigo_barrio_localidad">Barrio</label>
                    </div>
                    <div class="tablet-6 columns input-field">
                        <select type="text" name="codigo_localidad_ciudad" id="codigo_localidad_ciudad" class="form-control">
                            <option value="">Seleccione...</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location->id }}" <%- codigo_localidad_ciudad == {{ $location->id }} ? 'selected' : '' %>>{{ $location->text }}</option>
                            @endforeach
                        </select>
                        <label for="codigo_localidad_ciudad">Comuna/Corregimiento</label>
                    </div>
                </div>
                <div class="row">
                    <div class="tablet-6 columns input-field">
                        <select type="text" name="codigo_tipo_vivienda" id="codigo_tipo_vivienda" class="form-control">
                            <option value="">Seleccione...</option>
                            @foreach ($housingType as $value)
                                <option value="{{ $value->codigo_tipo_vivienda }}" <%- codigo_tipo_vivienda == {{ $value->codigo_tipo_vivienda }} ? 'selected' : '' %>>{{ $value->nombre_tipo_vivienda }}</option>
                            @endforeach
                        </select>
                        <label for="codigo_tipo_vivienda">Tipo de vivienda</label>
                    </div>
                    <div class="tablet-6 columns input-field">
                        <select type="text" name="codigo_estrato" id="codigo_estrato" class="form-control">
                            <option value="">Seleccione...</option>
                            @foreach ($stratum as $value)
                                <option value="{{ $value->codigo_estrato }}" <%- codigo_estrato == {{ $value->codigo_estrato }} ? 'selected' : '' %>>{{ $value->nombre_estrato }}</option>
                            @endforeach
                        </select>
                        <label for="codigo_estrato">Estrato</label>
                    </div>
                </div>
                <div class="row">
                    <div class="tablet-6 columns input-field">
                        <select type="text" name="jefe_hogar" id="jefe_hogar" class="form-control">
                            <option value="">Seleccione...</option>
                            @foreach ($homeboss as $key => $value)
                                <option value="{{ $key }}" <%- jefe_hogar == {{ $key }} ? 'selected' : '' %>>{{ $value }}</option>
                            @endforeach
                        </select>
                        <label for="jefe_hogar">Cabeza de familia o jefe de hogar</label>
                    </div>
                    <div class="tablet-6 columns input-field">
                        <select type="text" name="codigo_autodenominacion" id="codigo_autodenominacion" class="form-control">
                            <option value="">Seleccione...</option>
                            @foreach ($selfDomination as $value)
                                <option value="{{ $value->codigo_autodenominacion }}" <%- codigo_autodenominacion == {{ $value->codigo_autodenominacion }} ? 'selected' : '' %>>{{ $value->nombre_autodenominacion }}</option>
                            @endforeach
                        </select>
                        <label for="codigo_autodenominacion">Autodenominación</label>
                    </div>
                </div>
                <div class="row">
                    <div class="tablet-6 columns input-field">
                        <select type="text" name="codigo_nivel_idioma" id="codigo_nivel_idioma" class="form-control">
                            <option value="">Seleccione...</option>
                            @foreach ($languageLevel as $value)
                                <option value="{{ $value->codigo_nivel_idioma }}" <%- codigo_nivel_idioma == {{ $value->codigo_nivel_idioma }} ? 'selected' : '' %>>{{ $value->nombre_nivel_idioma }}</option>
                            @endforeach
                        </select>
                        <label for="codigo_nivel_idioma">Nivel de inglés</label>
                    </div>
                    <div class="tablet-6 columns input-field">
                        <select type="text" name="codigo_grupo_comunitario" id="codigo_grupo_comunitario" class="form-control">
                            <option value="">Seleccione...</option>
                            @foreach ($communityGroup as $value)
                                <option value="{{ $value->codigo_grupo_comunitario }}" <%- codigo_grupo_comunitario == {{ $value->codigo_grupo_comunitario }} ? 'selected' : '' %>>{{ $value->nombre_grupo_comunitario }}</option>
                            @endforeach
                        </select>
                        <label for="codigo_grupo_comunitario">Grupo comunitario</label>
                    </div>
                </div>
                <div class="row">
                    <div class="tablet-6 columns input-field">
                        <select type="text" name="codigo_grupo_poblacional" id="codigo_grupo_poblacional" class="form-control">
                            <option value="">Seleccione...</option>
                            @foreach ($populationGroup as $value)
                                <option value="{{ $value->codigo_grupo_poblacional }}" <%- codigo_grupo_poblacional == {{ $value->codigo_grupo_poblacional }} ? 'selected' : '' %>>{{ $value->nombre_grupo_poblacional }}</option>
                            @endforeach
                        </select>
                        <label for="codigo_grupo_poblacional">Grupo problacional</label>
                    </div>
                    <div class="tablet-6 columns input-field">
                        <select type="text" name="discapacidad" id="discapacidad" class="form-control">
                            <option value="">Seleccione...</option>
                            @foreach ($disability as $key => $value)
                                <option value="{{ $key }}" <%- discapacidad == {{ $key }} ? 'selected' : '' %>>{{ $value }}</option>
                            @endforeach
                        </select>
                        <label for="discapacidad">Discapacidad</label>
                    </div>
                </div>
                <div class="row">
                    <div class="tablet-6 columns input-field">
                        <select type="text" name="codigo_grupo_social" id="codigo_grupo_social" class="form-control">
                            <option value="">Seleccione...</option>
                            @foreach ($socialGroup as $value)
                                <option value="{{ $value->codigo_grupo_social }}" <%- codigo_grupo_social == {{ $value->codigo_grupo_social }} ? 'selected' : '' %>>{{ $value->nombre_grupo_social }}</option>
                            @endforeach
                        </select>
                        <label for="codigo_grupo_social">Grupo social</label>
                    </div>
                </div>
            @endif

            <input type="submit" class="registration-next-email-button right button small radius btn-resetc" value="SIGUIENTE">
            <small class="alert-text">(*) campos obligatorios</small>
        </div>
    </div>
</div>