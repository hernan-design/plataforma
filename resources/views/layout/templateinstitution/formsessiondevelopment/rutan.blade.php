<div class="rows">
    <div class="row">
        <div class="large-10 columns">
            <strong>Descripción de la intervención</strong>
            <div class="input-field">
                <textarea
                    id="mentoring-description"
                    class="materialize-textarea"
                    <%- finished || estado === window._tp.getState['closed'] || estado === window._tp.getState['pending_accept']  ? 'readonly' : null %>
                    ><%- typeof description != 'undefined' ?  description : ''%></textarea>
                <label for="mentorign-description"></label>
            </div>
        </div>
        <div class="large-2 columns">
            <button
                class="btn radius add-mentoring-description-session"
                <%- finished || estado === window._tp.getState['closed'] || estado === window._tp.getState['pending_accept'] ? 'disabled' : null %>>
                <i class="mdi mdi-plus text-center" ></i>
            </button>
        </div>
    </div>
    <% if(typeof objetivos !== 'undefined' && objetivos) { %>
        <strong>Nombre del Beneficio otorgado</strong><br><br>
        <% _.each(objetivos, function (objetivo, num) { %>
            <p class="gray-dark-text text-md"> <%- num %>. <%- typeof objetivo.descripcion_objetivo_mentoria != 'undefined' ?  objetivo.descripcion_objetivo_mentoria : ''%></p>
            <hr class="gray-dark">
        <% }); %>
    <% } %>
    <strong>Acuerdos/Plan de acción</strong><br><br>
    <div class="row">
        <div class="large-10 columns">
            <input
                type="text"
                id="mentoring-task-session"
                placeholder="Agrega un acuerdo aqui"
                <%- finished || estado === window._tp.getState['closed'] || estado === window._tp.getState['pending_accept'] ? 'disabled' : null %>> &nbsp;
        </div>
        <div class="large-2 columns">
            <button
                class="btn radius add-mentoring-task-session"
                <%- finished || estado === window._tp.getState['closed'] || estado === window._tp.getState['pending_accept'] ? 'disabled' : null %>>
                <i class="mdi mdi-plus text-center" ></i>
            </button>
        </div>
    </div>
    <div class="row">
        <ul id="mentoring-task-session-list">
        </ul>
    </div>

    <strong>Informacion del emprendimiento</strong><br>
    <label
        id="helpBlock"
        class="help-block"
        for="mentoring-tags-title">
        Indique mínimo el número de empleados y ventas promedio mensuales para<br> cada sesión.
    </label>
    <div class="row">
        <div class="large-5 columns">
            <input
                type="text"
                id="mentoring-tags-title"
                placeholder="Agrega un titulo aqui"
                <%- finished || estado === window._tp.getState['closed'] || estado === window._tp.getState['pending_accept'] ? 'disabled' : null %>> &nbsp;
        </div>
        <div class="large-5 columns">
            <input
                type="number"
                id="mentoring-tags-value"
                placeholder="Agrega un valor aqui"
                <%- finished || estado === window._tp.getState['closed'] || estado === window._tp.getState['pending_accept'] ? 'disabled' : null %>> &nbsp;
        </div>
        <div class="large-2 columns">
            <button
                class="btn radius add-mentoring-tags-session"
                <%- finished || estado === window._tp.getState['closed'] || estado === window._tp.getState['pending_accept'] ? 'disabled' : null %>>
                <i class="mdi mdi-plus text-center" ></i>
            </button>
        </div>
    </div>
    <div class="row">
        <ul id="mentoring-tags-session-list">
        </ul>
    </div>
    <strong>Observaciones</strong><br><br>
    <div class="row">
        <div class="large-10 columns">
            <textarea
                id="mentoring-objetive-general"
                placeholder="Agrega tus observaciones aquí"
                rows="2" class="materialize-textarea validate"
                <%- finished || estado === window._tp.getState['closed'] || estado === window._tp.getState['pending_accept'] ? 'readonly' : null %>><%- !_.isEmpty(general_objetive) ? general_objetive : '' %></textarea> &nbsp;
        </div>
        <div class="large-2 columns">
            <button
                class="btn radius add-mentoring-objetive-general-session"
                <%- finished || estado === window._tp.getState['closed'] || estado === window._tp.getState['pending_accept'] ? 'disabled' : null %>>
                <i class="mdi mdi-plus text-center" ></i>
            </button>
        </div>
    </div>

    <strong>Duración de la sesión</strong><br><br>
    <div class="row">
        <div class="large-5 columns">
            <label for="mentoring-duration-minutes-value">Horas</label>
            <input
                value="<%- !_.isEmpty(duration_mentoring_hour) ? duration_mentoring_hour : '' %>"
                min="0"
                max="99"
                type="number"
                id="mentoring-duration-hour-value"
                placeholder="Horas"
                <%- finished || estado === window._tp.getState['closed']
                    || estado === window._tp.getState['pending_accept']
                    ? 'disabled' : null 

                %>

                <%- (typeof mentor !== 'undefined' && mentor && !owner ) ?  null : 'disabled'
                %>
        
            > &nbsp;
        </div>
        <div class="large-5 columns">
            <label for="mentoring-duration-minutes-value">Minutos</label>
            <input
                value="<%- !_.isEmpty(duration_mentoring_minutes) ? duration_mentoring_minutes : '' %>"
                min="0"
                max="59"
                type="number"
                id="mentoring-duration-minutes-value"
                placeholder="Minutos"
                <%- finished || estado === window._tp.getState['closed']
                    || estado === window._tp.getState['pending_accept']
                    ? 'disabled' : null
                %>
                <%- (typeof mentor !== 'undefined' && mentor && !owner ) ?  null : 'disabled'
                %>
            > &nbsp;
        </div>
        <div class="large-2 columns">
            <button
                class="btn radius add-mentoring-duration-session"
                <%- finished || estado === window._tp.getState['closed']
                    || estado === window._tp.getState['pending_accept']
                    ? 'disabled' : null
                %>
                <%- (typeof mentor !== 'undefined' && mentor && !owner ) ?  null : 'disabled'
                %>
            >
                <i class="mdi mdi-plus text-center" ></i>
            </button>
        </div>
    </div>

    <div class="row">
        <div class="large-10 columns">
            <strong>Fase del Proceso</strong>
            <div class="input-field">
                <select
                    id="mentoring-phase"
                    class="validate"
                    <%- finished || estado === window._tp.getState['closed'] || estado === window._tp.getState['pending_accept']  ? 'readonly' : null %>
                    >
                    <option value="" <%- phase.length ? '' : 'selected' %>> Selecciona</option>
                    <option value="promoción" <%- (phase.length && phase === 'promoción') ? 'selected' : '' %>>Promoción</option>
                    <option
                        value="orientación"
                        <%- (phase.length && phase === 'orientación') ? 'selected' : '' %>>Orientación
                    </option>
                    <option
                        value="diagnóstico"
                        <%- (phase.length && phase === 'diagnóstico') ? 'selected' : '' %>>Diagnóstico
                    </option>
                    <option
                        value="seguimiento"
                        <%- (phase.length && phase === 'seguimiento') ? 'selected' : '' %>>Seguimiento
                    </option>
                    <option
                        value="prestación de servicio"
                        <%- (phase.length && phase === 'prestación de servicio') ? 'selected' : '' %>>Prestación de servicio
                    </option>
                </select>
            <label for="mentoring-phase"></label>
            </div>
        </div>
        <div class="large-2 columns">
            <button
                class="btn radius add-mentoring-phase-session"
                <%- finished || estado === window._tp.getState['closed'] || estado === window._tp.getState['pending_accept'] ? 'disabled' : null %>>
                <i class="mdi mdi-plus text-center" ></i>
            </button>
        </div>
    </div>
    <div class="row" id="field-diagnosis" style="display:  <%- (phase.length && phase === 'diagnóstico') ? 'block' : 'none' %>" >
        <div class="large-10 columns">
            <strong>Diagnóstico</strong>
            <div class="input-field">
                <select
                    id="mentoring-diagnosis"
                    class="validate"
                    <%- finished || estado === window._tp.getState['closed'] || estado === window._tp.getState['pending_accept']  ? 'readonly' : null %>
                    >
                    <option value="" <%- diagnosis.length ? '' : 'selected' %>> Selecciona</option>
                    <option
                        value="Contexto del emprendimiento"
                        <%- (diagnosis.length && diagnosis === 'Contexto del emprendimiento') ? 'selected' : '' %>>Contexto del emprendimiento
                    </option>
                    <option
                        value="Brechas identifica"
                        <%- (diagnosis.length && diagnosis === 'Brechas identifica') ? 'selected' : '' %>>Brechas identificadas
                    </option>
                    <option
                        value="Brechas priorizadas"
                        <%- (diagnosis.length && diagnosis === 'Brechas priorizadas') ? 'selected' : '' %>>Brechas priorizadas
                    </option>
                    <option
                        value="Aspectos adicionales"
                        <%- (diagnosis.length && diagnosis === 'Aspectos adicionales') ? 'selected' : '' %>>Aspectos adicionales
                    </option>
                </select>
            <label for="mentoring-diagnosis"></label>
            </div>
        </div>
        <div class="large-2 columns">
            <button
                class="btn radius add-mentoring-diagnosis-session"
                <%- finished || estado === window._tp.getState['closed'] || estado === window._tp.getState['pending_accept'] ? 'disabled' : null %>>
                <i class="mdi mdi-plus text-center" ></i>
            </button>
        </div>
    </div>

    <div class="row">
        <div class="large-10 columns">
            <strong>¿Se recomienda para la siguiente etapa?</strong>
            <div class="input-field">
                <select
                    id="mentoring-recommends"
                    class="validate"
                    <%- finished || estado === window._tp.getState['closed'] || estado === window._tp.getState['pending_accept']  ? 'readonly' : null %>
                    >
                    <option value="" <%- recommends.length ? '' : 'selected' %>> Selecciona</option>
                    <option
                        value="Finalizó y se propone siguiente etapa"
                        <%- (recommends.length && recommends === 'Finalizó y se propone siguiente etapa') ? 'selected' : '' %>>Finalizó y se propone siguiente etapa
                    </option>
                    <option
                        value="Finalizó, pero no continua"
                        <%- (recommends.length && recommends === 'Finalizó, pero no continua') ? 'selected' : '' %>>Finalizó, pero no continua
                    </option>
                    <option
                        value="No finalizó"
                        <%- (recommends.length && recommends === 'No finalizó') ? 'selected' : '' %>>No finalizó
                    </option>
                    <option
                        value="Redireccionado"
                        <%- (recommends.length && recommends === 'Redireccionado') ? 'selected' : '' %>>Redireccionado
                    </option>
                    <option
                        value="Otro"
                        <%- (recommends.length && recommends === 'Otro') ? 'selected' : '' %>>Otro
                    </option>
                    <option
                        value="En acompañamiento"
                        <%- (recommends.length && recommends === 'En acompañamiento') ? 'selected' : '' %>>En acompañamiento
                    </option>
                </select>
            <label for="mentoring-recommends"></label>
            </div>
        </div>
        <div class="large-2 columns">
            <button
                class="btn radius add-mentoring-recommends-session"
                <%- finished || estado === window._tp.getState['closed'] || estado === window._tp.getState['pending_accept'] ? 'disabled' : null %>>
                <i class="mdi mdi-plus text-center" ></i>
            </button>
        </div>
    </div>

    <div class="row">
        <div class="large-10 columns">
            <strong>Seguimiento</strong>
            <div class="input-field">
                <textarea
                    id="mentoring-tracing"
                    class="materialize-textarea"
                    maxlength="255"
                    <%- finished || estado === window._tp.getState['closed'] || estado === window._tp.getState['pending_accept']  ? 'readonly' : null %>
                    max="255"
                    ><%- typeof tracing != 'undefined' ?  tracing : '' %></textarea>
                <label for="mentorign-tracing"></label>
            </div>
        </div>
        <div class="large-2 columns">
            <button
                class="btn radius add-mentoring-tracing-session"
                <%- finished || estado === window._tp.getState['closed'] || estado === window._tp.getState['pending_accept'] ? 'disabled' : null %>>
                <i class="mdi mdi-plus text-center" ></i>
            </button>
        </div>
    </div>

    <br>
    <strong>Asignación de VOUCHER</strong><br><br>
    <div class="row">
        <form method="post" id="add-mentoring-assigvoucher-session">
            <div class="large-10 columns"
                style="
                height: 200px;
                overflow-y: scroll;"    
            >
                <?php //listado de opciones para sugerir voucher, solo disponible para rutan
                    $text =  [
                                '01-IN-001 Consultoría en Transformación digital.',
                                '02-IN-001 Ajuste y validación del modelo de negocio.',
                                '02-IN-002 Asesoría en Identidad de marca.',
                                '03-IN-001 Estructura de costos, presupuesto y fijación de precios.',
                                '03-IN-002 Formalización empresarial y laboral.',
                                '04-IN-001 Mapeo de capacidades, competencias y brechas del equipo emprendedor.',
                                '04-IN-002 Desarrollo de habilidades propias del perfil del emprendedor.',
                                'IN - Landing (1 puesto).',
                                'IN - Landing (2 puestos).',
                                '01-AC-001 Análisis de entorno competitivo para detectar oportunidades de mejora o desarrollo de nuevos productos.',
                                '01-AC-002 Sofisticación de productos y servicios.',
                                '02-AC-001 Afinación del modelo de negocio y preparación del pitch comercial.',
                                '02-AC-002 Diseño y ejecución de estructura y estrategias comerciales.',
                                '02-AC-003 Desarrollo de estrategias de mercadeo y marketing.',
                                '02-AC-004 Análisis y validación para acceso a mercados internacionales.',
                                '03-AC-001 Alistamiento financiero y tributario (Estado de resultados integral, Flujo de caja).',
                                '03-AC-002 Consultoría jurídica y legal para temas de operación (contratos, políticas de TD, confidencialidad, regulaciones específicas)..',
                                '03-AC-003 Alistamiento para la estructuración de rondas de inversión.',
                                '03-AC-004 Proyecciones financieras (Definición de mega y KPIs).',
                                '04-AC-001 Desarrollo de habilidades gerenciales/liderazgo para afrontar el crecimiento exponencial.',
                                '04-AC-002 Consultoría para la definición de gobierno corporativo.',
                                '02-CN-001 Gestión comercial para acceso a nuevos mercados (softlanding e internacionalización).',
                                '03-CN-001 Proyecciones financieras (Definición de mega y KPIs).',
                                '04-CN-001 Direccionamiento estratégico y operativo de las empresas.',
                                '04-CN-002 Consultoría en definición y desarrollo de modelos de acuerdos societarios y juntas directivas.',
                                'Potencializador AP.',
                                'POT - Landing (1 puesto).',
                                'POT - Landing (2 puestos).',
                                'Softlanding.',
                                'UDEMY - 200 LicenciasCursos.',
                                'ADDECO - 10% servicios de transformación, auditorias y estrategias.',
                                'ADDECO - 20% servicios outsourcing.',
                                'HUBSPOT - Precio especial en plataforma.',
                                'HUBSPOT - Bono de USD 500 en google adds.',
                                'ELEMPLEO - 3 publicaciones gratuitas.',
                                'ELEMPLEO - 60 descargas de CV.',
                                'ELEMPLEO - 16% en planes limintados e ilimitados.',
                                'DEEL - 10% contrataciones de talento.',
                                "WHALE y JAGUAR - 1 mes gratis de membresía.",
                                'PEAKU - Paga 2 y lleva 4 en mensualidades.',
                                'PEAKU - 50% en plan completo.',
                                'PEAKU - 1 mes gratis en plan payroll remoto.',
                                'PMI - curso de kickoff en conceptos básicos.',
                                'PMI - curso de disciplined agile básico.',
                                'ALEGRA - 35% por 1 año en planes completos y solo facturación.',
                                'EXPERIS - 2% busqueda de talento TI.',
                                'EXPERIS - acompañamiento en viabilidades salariales.',
                                'EXPERIS - acompañamiento en conocimiento en mercadeo TI.',
                                'ZEMSANIA - 5% subcontratación recursos humano de tecnología.',
                                'ZEMSANIA - 10% hunting en recursos humano de tecnología.',
                                'INFOTREE - 15% procesos permanent y placement.',
                                'MATH - 20% calculos actuariales.',
                                'PACIFICA - 15% contrataciones y garantía extendida hasta 6 meses.',
                                'NILO - Nómina electronica 1 año gratis (10 empleados).',
                                'NILO - 20% planes de nómina.',
                                'NILO - 20% planes de facturación electrónica y tiendas virtuales.',
                                'ORACLE - USD 2500 créditos para uso de la nube (referidos RutaN).',
                                'ORACLE - 70% por 2 años en programa de Startups.',
                                'ORACLE - sesiones de entrenamiento.',
                                "MR.CLARK - 20% servicios básicos para PCs y portatiles.",
                                'MR.CLARK - 20% servicios de infraestructura.',
                                'SURA - asesoría y diagnóstico empresarial gratuito e ilimitado.',
                                'Amazon Web Services.',
                            ];
                ?>
                <fieldset
                    style="border: none;"
                    <%- finished || estado === window._tp.getState['closed'] || estado === window._tp.getState['pending_accept'] ? 'disabled' : null %>>
                    <legend>¿Sugerir Voucher?</legend>
                    @foreach ($text as $item)
                        <div>
                            <input
                                id="checkbox{{ $loop->index }}"
                                name="checkbox{{ $loop->index }}"
                                type="checkbox"
                                value="{{ $item }}"
                                <%- assigvoucher.checkbox{{ $loop->index }} === '{{ $item }}' ? 'checked' : '' %>
                                <%- (typeof mentor !== 'undefined' && mentor && !owner ) ?  null : 'disabled'%>
                            >
                            <label style="font-size: 13px;" for="checkbox{{ $loop->index }}">
                                {{ $item }}
                            </label>
                        </div>
                    @endforeach
                </fieldset>
            </div>
            <div class="large-2 columns">
                <button
                    class="btn radius"
                    type="submit"
                    <%- finished || estado === window._tp.getState['closed'] || estado === window._tp.getState['pending_accept'] ? 'disabled' : null %>
                    <%- (typeof mentor !== 'undefined' && mentor && !owner ) ?  null : 'disabled'
                    %>
                >
                    <i class="mdi mdi-plus text-center" ></i>
                </button>
            </div>
        </form>
    </div>
</div>