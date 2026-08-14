<td style="width:90%"><%- descripcion_entregable %></td>
<% if( (tab.toLowerCase() == 'ventas') && (typeof(entregable_acuerdo_fijo) !== 'undefined') && !entregable_acuerdo_fijo ) { %>
    <td class="text-right" style="width:10%">
        <a href="#" title="Quitar elemento" class="remove-item-agreement close-hover-circle"><i class="mdi mdi-window-close"></i></a>
    </td>
<% } %>