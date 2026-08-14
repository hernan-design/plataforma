<table>
    <thead>
        <tr>
            <th colspan="2" class="bg-red" style="text-align: center">COMERCIAL Y DE MERCADO</th>
        </tr>
        <tr>
            <th>Variable</th>
            <th>Respuesta</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($answers_eval as $answer => $value)
            @if ($value['codigo_grupo_item_eval'] == 66)
                <tr>
                    <td class="description-table"> @php echo $value['nombre_grup_opc_eval_pregunta'] @endphp </td>

                    {{--  Barreras de mercado.  --}}
                    @if ($value['codigo_item_evaluacion'] == 361 || $value['codigo_item_evaluacion'] == 396 ||
					    $value['codigo_item_evaluacion'] == 431 || $value['codigo_item_evaluacion']== 466)
                        <td class="description-answer"> @php echo $_description_257 @endphp </td>
                    @else
                        <td class="description-answer"> @php echo $value['respuesta'] @endphp </td>
                    @endif

                </tr>
            @endif
        @endforeach
    </tbody>
</table>