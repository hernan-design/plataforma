@extends('emails.layout')

@section('content')
	<div>
		<p style="text-align:center;color:#487F4A;font-size:22px;">Bienvenido a la red de profesionales, emprendedores y empresarios Coomeva</p>
		<p style="text-align:center;">Haz click en el siguiente enlace para <b style="color:#487F4A;">confirmar</b> tu registro.</p>
		<p align="justify"><span></span></p>



		@include('emails.calltoaction', ['label' => trans('app.confirm.mail.confirm'), 'action' => $_inst_url.$_url_action, 'color' => $_inst_color])
	</div>
	<table style="width:520px;">
		<tr>
			<td style="height:40px;text-align:center;">Y accede a todos los beneficios que te ofrece esta gran comunidad:</td>
		</tr>
	</table>
	<table>
		<tr style="height:100px;">
			<td style="width:90px;">
				<img src="http://static.tuproyecto.com/images/institutions/coomeva/mailing/coomeva-mail-icon-social.png" alt="coomeva establece conexiones y alianzas ícono">
			</td>
			<td><p><b style="color:#487F4A;">Establecer conexiones y alianzas</b> con otros profesionales y empresarios.</p></td>
		</tr>
		<tr style="height:100px;">
			<td style="width:90px;">
				<img src="http://static.tuproyecto.com/images/institutions/coomeva/mailing/coomeva-mail-icon-light.png" alt="coomeva establece conexiones y alianzas ícono">
			</td>
			<td><p><b style="color:#487F4A;">Desarrollar tu idea de negocio</b> o <b style="color:#487F4A;">fortalecer tu empresa</b> con asesoría, capacitación, acompañamiento y opciones de financiación.</p></td>
		</tr>

		<tr style="height:100px;">
			<td style="width:90px;">
				<img src="http://static.tuproyecto.com/images/institutions/coomeva/mailing/coomeva-mail-icon-work.png" alt="coomeva establece conexiones y alianzas ícono">
			</td>
			<td><p><b style="color:#487F4A;">Acceder a productos especializados</b> acordes con tu ocupación.</p></td>
		</tr>

		<tr style="height:100px;">
			<td style="width:90px;">
				<img src="http://static.tuproyecto.com/images/institutions/coomeva/mailing/coomeva-mail-icon-shopcart.png" alt="coomeva establece conexiones y alianzas ícono">
			</td>
			<td><p><b style="color:#487F4A;">Ofrecer tus productos y servicios</b> a los miembros de esta Red.</p></td>
		</tr>

		<tr style="height:100px;">
			<td style="width:90px;">
				<img src="http://static.tuproyecto.com/images/institutions/coomeva/mailing/coomeva-mail-icon-book.png" alt="coomeva establece conexiones y alianzas ícono">
			</td>
			<td><p>Disfrutar de una <b style="color:#487F4A;">biblioteca virtual </b>con libros, revistas especializadas, artículos y conferencias de actualización profesional.</p></td>
		</tr>
	</table>
	<table width="520px">
		<tr style="height:60px;background-color:#487F4A;">
			<td style=""><p style="color:#FFFFFF;text-align:center;">¡Participa activamente con tus contenidos e interacción!</p></td>
		</tr>
	</table>
@stop
