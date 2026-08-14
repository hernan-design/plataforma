<table>
    <thead>
        <tr>
            <th colspan="2" class="bg-green" style="text-align: center">FINANCIERO</th>
        </tr>
        <tr>
            <th>Variable</th>
            <th>Respuesta</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($answers_eval as $answer => $value)
            @if ($value['codigo_grupo_item_eval'] == 67)
                <tr>
                    <td class="description-table"> @php echo $value['nombre_grup_opc_eval_pregunta'] @endphp </td>


                        {{--  ¿Cómo se encuentra la estructura financiera de la empresa/emprendimiento?.  --}}
                        @if ($value['codigo_item_evaluacion'] == 367 || $value['codigo_item_evaluacion'] == 402 ||
                        $value['codigo_item_evaluacion'] == 437 || $value['codigo_item_evaluacion']== 472)
                        <td class="description-answer"> @php echo $_description_263 @endphp </td>
                        @else
                        <td class="description-answer"> @php echo $value['respuesta'] @endphp </td>
                        @endif

                </tr>
            @endif
        @endforeach
    </tbody>
</table>