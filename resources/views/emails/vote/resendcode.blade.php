@extends('emails.layout')

@section('content')
	<table>
        <tr>
            <td align="center" valign="top" style="padding-bottom:10px;">
                <span>Tu código de votación es: <strong> {{ $_code }}</strong></span>
			</td>
		</tr>
		<tr>
            <td align="center" valign="top" style="padding-bottom:10px;">
                <span>Haz clic en el siguiente enlace para verificar el voto por el proyecto: <br> <strong>{{$_name_project}}</strong></span>
            </td>
        </tr>
		<tr>
			<td>
				@include('emails.calltoaction', ['label' => 'Verificar', 'action' => "$_inst_url$_url_confirm", 'color' => $_inst_color])
			</td>
		</tr>

	</table>
@stop
