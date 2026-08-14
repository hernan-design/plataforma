<div class="rows">
    <div class="row">
        <div class="large-10 columns">
            <strong>Descripción de sesión</strong>
            <div class="input-field">
                <textarea id="mentoring-description" class="materialize-textarea"
                    <%- finished || estado === window._tp.getState['closed'] || estado === window._tp.getState['pending_accept']  ? 'readonly' : null %>>
                    <%- typeof description != 'undefined' ?  description : ''%>
                </textarea>
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
        <strong>Tema</strong><br><br>
        <% _.each(objetivos, function (objetivo, num) { %>
            <p class="gray-dark-text text-md"> <%- num %>. <%- typeof objetivo.descripcion_objetivo_mentoria != 'undefined' ?  objetivo.descripcion_objetivo_mentoria : ''%></p>
            <hr class="gray-dark">
        <% }); %>
    <% } %>
    <strong>Acuerdos/Plan de acción</strong><br><br>
    <div class="row">
        <div class="large-10 columns">
            <input type="text"  id="mentoring-task-session" placeholder="Agrega un acuerdo aqui" <%- finished || estado === window._tp.getState['closed'] || estado === window._tp.getState['pending_accept'] ? 'disabled' : null %>> &nbsp;
        </div>
        <div class="large-2 columns">
            <button class="btn radius add-mentoring-task-session" <%- finished || estado === window._tp.getState['closed'] || estado === window._tp.getState['pending_accept'] ? 'disabled' : null %>><i class="mdi mdi-plus text-center" ></i></button>
        </div>
    </div>
    <div class="row">
        <ul id="mentoring-task-session-list">
        </ul>
    </div>
    <strong>Informacion del emprendimiento</strong><br>
    <label id="helpBlock" class="help-block">Indique mínimo el número de empleados y ventas promedio mensuales para<br> cada sesión.</label>
    <div class="row">
        <div class="large-5 columns">
            <input type="text"  id="mentoring-tags-title" placeholder="Agrega un titulo aqui" <%- finished || estado === window._tp.getState['closed'] || estado === window._tp.getState['pending_accept'] ? 'disabled' : null %>> &nbsp;
        </div>
        <div class="large-5 columns">
            <input type="number"  id="mentoring-tags-value" placeholder="Agrega un valor aqui" <%- finished || estado === window._tp.getState['closed'] || estado === window._tp.getState['pending_accept'] ? 'disabled' : null %>> &nbsp;
        </div>
        <div class="large-2 columns">
            <button class="btn radius add-mentoring-tags-session" <%- finished || estado === window._tp.getState['closed'] || estado === window._tp.getState['pending_accept'] ? 'disabled' : null %>><i class="mdi mdi-plus text-center" ></i></button>
        </div>
    </div>
    <div class="row">
        <ul id="mentoring-tags-session-list">
        </ul>
    </div>
    <strong>Observaciones</strong><br><br>
    <div class="row">
        <div class="large-10 columns">
            <textarea id="mentoring-objetive-general" placeholder="Agrega tus observaciones aquí" rows="2" class="materialize-textarea validate" <%- finished || estado === window._tp.getState['closed'] || estado === window._tp.getState['pending_accept'] ? 'readonly' : null %>><%- !_.isEmpty(general_objetive) ? general_objetive : '' %></textarea> &nbsp;
        </div>
        <div class="large-2 columns">
            <button class="btn radius add-mentoring-objetive-general-session" <%- finished || estado === window._tp.getState['closed'] || estado === window._tp.getState['pending_accept'] ? 'disabled' : null %>><i class="mdi mdi-plus text-center" ></i></button>
        </div>
    </div>


    <b>Duración de la sesión</b><br><br>
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
</div>