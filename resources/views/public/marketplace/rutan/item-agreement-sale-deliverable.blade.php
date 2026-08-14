<td style="width:80%"><%- descripcion_entregable %></td>
<td class="text-right" style="width:20%">
    <% if(!_.isNull(url_adjunto)) { %>
        <a
            href="<%- url_adjunto %>"
            title="Ver adjunto"
            target="_blank"
            ><i class="mdi mdi-file-document"></i>
            Ver adjunto
        </a>
    <% } else { %>
        <span><i class="mdi mdi-file-document"></i>
        No hay adjunto
        </span>
    <% }  %>
</td>