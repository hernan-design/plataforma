<table>
    <thead>
        <tr>
            <th colspan="2" class="bg-blue" style="text-align: center">PRODUCTO O SERVICIO</th>
        </tr>
        <tr>
            <th>Variable</th>
            <th>Respuesta</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($answers_eval as $answer => $value)
            @if ($value['codigo_grupo_item_eval'] == 65)
                <tr>
                    <td class="description-table"> @php echo $value['nombre_grup_opc_eval_pregunta'] @endphp </td>
                    <td class="description-answer"> @php echo $value['respuesta'] @endphp </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>