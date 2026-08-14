@extends('emails.layout')

@section('content')
	<table>
        <tr>
            <td align="center" valign="top" style="padding-bottom:10px;">
                <span>Haz clic en el siguiente enlace para confirmar el voto por el proyecto: <strong>{{$_name_project}}</strong></span>
            </td>
        </tr>
		<tr>
			<td>
				@include('emails.calltoaction', ['label' => 'Confirmar', 'action' => "$_inst_url$_url_confirm", 'color' => $_inst_color])
			</td>
		</tr>
	</table>
@stop
