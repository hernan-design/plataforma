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
                    <label for="primer_apellido_persona">Primer Apellido (*)</label>
                    <small class="error">¡El primer apellido es obligatorio!</small>
                </div>
            </div>
            <div class="row">
                <div class="tablet-6 columns input-field">
                    <input type="text" name="segundo_apellido_persona" value="<%- segundo_apellido_persona %>" pattern="[a-zA-Z]+" class="validate">
                    <label for="segundo_apellido_persona">Segundo Apellido</label>
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
                    <label for="codigo_ciudad">Ciudad De Nacimiento (*)</label>
                    <small class="error">¡Debe seleccionar una ciudad!</small>
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
                    <label class="active">Fecha De Nacimiento (*)</label>
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
                        <label for="tipo_identificacion_usuario">Tipo De Identificación (*)</label>
                        <small class="error">¡Debe seleccionar un tipo de identificación!</small>
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
                    <div>
                        <input type="text" name="movil_usuario" id="movil_usuario" value="<%- movil_usuario %>" class="phone-mask-co validate error" required>
                    </div>
                    <label class="active" for="movil_usuario">Celular (*)</label>
                    <small class="error">¡Debe Ingresar un número telefónico!</small>
                </div>
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
                    <label class="active" for="telefono_usuario">Teléfono Fijo</label>
                </div>
            </div>
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
                @if($institution->datos_complementarios)
                    <div class="tablet-6 columns input-field">
                        <select name="codigo_nivel_educacion" id="codigo_nivel_educacion" data-placeholder="Seleccione" placeholder="Seleccione" class="validate" required>
                            <option value="" disabled selected>Seleccione</option>
                            @foreach( App\NivelEducacion::getLevels() as $level)
                                <option value="{{ $level->codigo_nivel_educacion }}" <%- codigo_nivel_educacion == '{{ $level->codigo_nivel_educacion }}' ? 'selected': ''%>>{{ $level->nombre_nivel_educacion }}</option>
                            @endforeach
                        </select>
                        <label for="codigo_nivel_educacion">Nivel de educación</label>
                    </div>
                @endif
            </div>

            <input type="submit" class="registration-next-email-button right button small radius btn-resetc" value="SIGUIENTE">
            <small class="alert-text">(*) campos obligatorios</small>
        </div>
    </div>
</div>