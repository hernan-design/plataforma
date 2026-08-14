@extends('reports.layout', ['title' => $title, 'type' => 'PDF'])
@section('content')
	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<tbody>
		<tr>
			<th class="center titleespecial">
				CARTA DE COMPROMISO SUSCRITA POR {{ strtoupper($data->nombre_empresa) }} A FAVOR DE LA FIDUCIARIA COLOMBIANA DE COMERCIO EXTERIOR S.A., FIDUCÓLDEX, QUIEN ACTÚA COMO VOCERA DEL PATRIMONIO AUTÓNOMO INNPULSA COLOMBIA DE CONFORMIDAD CON LO ESTABLECIDO EN EL ARTÍCULO 13 DE LA LEY 1753 DE 2015 Y EL CONTRATO DE CESIÓN DEL CONVENIO INTERADMINISTRATIVO N° 375  DE 2015
			</th>
		</tr>
		</tbody>
	</table>
	<br>
	<p class="justify">El suscrito {{ $data->nombre_representante_legal }} {{ $data->apellidos_representante_legal }}, identificado con la cédula de ciudadanía número {{$data->identificacion_rep_legal }} expedida en {{$data->ciudad_rep_legal }}, quien actúa en nombre y representación legal de {{ strtoupper($data->nombre_empresa) }}. sociedad domiciliada en la ciudad de {{ $data->ciudad_empresa }}, identificada con NIT. {{ $data->nit_empresa }}, debidamente facultado para la suscripción del presente documento y quien, en adelante, y para los efectos de esta <b>CARTA DE COMPROMISO</b> se denominará <b>LA EMPRESA</b>, mediante el presente instrumento se obliga de forma unilateral, incondicional e irrevocable a favor de la Fiduciaria Colombiana de Comercio Exterior S.A., FIDUCÓLDEX, quien actúa como vocera del Patrimonio Autónomo <b>INNPULSA COLOMBIA</b>, de conformidad con lo establecido en el artículo 13 de la Ley 1753 de 2015 y el Contrato de Cesión del Convenio Interadministrativo N° 375 de 2015 y que en adelante se denominará <b>INNPULSA COLOMBIA</b>, en los términos que se indican a continuación, previas las siguientes: </p>
	<h3 class="justify">CONSIDERACIONES: </h3><br>
	<ol>
	<li class="justify">Que la Ley 1753 de 2015 (Plan Nacional de Desarrollo 2014-2018) en su artículo 13 ordenó la unificación del Fondo de Modernización e Innovación para las Micro, Pequeñas y Medianas Empresas y de la Unidad de Desarrollo e Innovación en los siguientes términos:
		<p class="justify">Artículo 13º. Fondo de Modernización e Innovación para las Micro, Pequeñas y Medianas Empresas y Unidad de Desarrollo e Innovación: Unifíquese en un sólo patrimonio autónomo el Fondo de Modernización e Innovación para las Micro, Pequeñas y Medianas Empresas y Unidad de Desarrollo e Innovación, creados por la Ley 590 de 2000 y 1450 de 2011. Este patrimonio autónomo, se regirá por normas de derecho privado, y será administrado por el Banco de Comercio Exterior S.A. (Bancóldex), de acuerdo con los lineamientos que fije el Gobierno Nacional a través de la Política pública que para el efecto defina el Ministerio de Comercio, Industria y Turismo.</p>
		Los recursos que integrarán el patrimonio autónomo son los siguientes:
		<ul>
			<li>Recursos provenientes del Presupuesto General de la Nación.</li>
			<li>Recursos aportados por las entidades nacionales, territoriales o por particulares a través de convenios o trasferencias.</li>
			<li>Donaciones.</li>
			<li>Recursos de cooperación nacional o internacional.</li>
			<li>Rendimientos financieros generados por los recursos entregados, los cuales se reinvertirán de pleno derecho en el vehículo.</li>
			<li>Las utilidades del Banco de Comercio Exterior (Bancóldex) previa aprobación del CONPES.</li>
			<li>Los demás recursos que obtenga o se le asignen a cualquier título.</li>
			<p>Los gastos de funcionamiento y administración en que incurra por la operación de este patrimonio se reintegrarán a Bancóldex.</p>
		</ul>
	</li>
	<li class="justify">Que conforme a lo ordenado en el artículo 13 de la Ley 1753 de 2015, el 15 de julio de 2015 se celebró entre el Ministerio de Comercio, Industria y Turismo y el Banco de Comercio Exterior de Colombia S.A.– Bancóldex, el Convenio Interadministrativo 375 de 2015 para dar cumplimiento al artículo 13 de la Ley 1753 de 2015, estableciendo las directrices para el cumplimiento de dicha administración por parte de BANCÓLDEX. De esta manera, la Unidad de Desarrollo e Innovación se transforma en <b>INNPULSA COLOMBIA</b> la cual nace como un esfuerzo del Gobierno Nacional por generar condiciones para apalancar el desarrollo empresarial del País desde la innovación.</li>
	<li class="justify">Que el artículo 126 de la Ley 1815 del 7 de diciembre del año 2016 por medio de la cual “se decreta el Presupuesto de Rentas y Recursos de Capital y Ley de Apropiaciones para la vigencia fiscal del 1o de enero al 31 de diciembre de 2017”, estableció que “Los patrimonios autónomos cuya administración haya sido asignada por ley al Banco de Comercio de Colombia S.A. – Bancóldex, podrán administrarse directamente por este o a través de sus filiales”.</li>
	<li class="justify">Que en razón a la autorización legal impartida y, por definición de Política por parte del Ministerio de Comercio, Industria y Turismo, Bancóldex, Fiduciaria Colombiana de Comercio Exterior S.A., sociedad de servicios financieros de economía mixta indirecta del orden nacional, filial de Bancóldex y el Ministerio de Comercio, Industria y Turismo, suscribieron el 24 de marzo de 2017 contrato de cesión del Convenio 375 de 2012 con efectos a partir del 1º de abril de 2017.</li>
	<li class="justify">Una vez celebrado el contrato de cesión de posición contractual, el Ministerio de Comercio, Industria y Turismo y Fiduciaria Colombiana de Comercio Exterior S.A. FIDUCOLDEX S.A. celebraron el contrato de fiducia mercantil de administración número 006-2017 cuyo objeto es la administración del patrimonio autónomo Unidad de Gestión de Crecimiento Empresarial <b>INNPULSA COLOMBIA</b> por parte de FIDUCOLDEX, quien actúa como vocera del mismo.</li>
	<li class="justify">Que el objetivo principal de <b>INNPULSA COLOMBIA</b> es intervenir sobre los diferentes actores del sector productivo para conseguir que más innovadores y empresarios incursionen en procesos de desarrollo empresarial jalonados por la innovación. <b>INNPULSA COLOMBIA </b> estimula la creación de alianzas entre el sector público, el sector privado y la academia, como eje fundamental del desarrollo empresarial y pilar de la estrategia nacional de innovación y trabaja por generar una cultura del emprendimiento y la innovación en el país.</li>
	<li class="justify">Que el día 17 de junio de 2020, <b>INNPULSA COLOMBIA</b> abrió la invitación pública “EMPODERA-20” la cual tiene por objeto “seleccionar empresas en etapa temprana cuyos equipos de trabajo directivos sean heterogéneos para que hagan parte del Programa <b>INNPULSA</b> – Empodera, con el fin de fortalecer las capacidades y habilidades empresariales que permitan la aceleración de sus negocios.”</li>
	<li class="justify">Que en cumplimiento de sus objetivos, <b>INNPULSA COLOMBIA</b> busca por medio del programa <b>INNPULSA</b> - Empodera fortalecer las capacidades y habilidades empresariales que permitan la aceleración de sus negocios, a través de un proceso que incluye cuatro Etapas: Etapa 1: Postulación y selección de las empresas en etapa temprana que cumplan con los requisitos definidos en la invitación.; Etapa 2: Realización de diagnóstico de capacidades emprendedoras Etapa 3:Fortalecimiento empresarial y de Habilidades Blandas; Etapa 4: Realización de misión exploratoria a nivel internacional con un representante de las empresas con mejor desempeño en la Etapa 3 del programa <b>INNPULSA</b> - Empodera.</li>
	<li class="justify">Que luego de realizada la Etapa 1 definida en los términos de la invitación, LA EMPRESA ha sido seleccionada para la participación en la Etapa 2: Realización de diagnóstico de capacidades emprendedoras y Etapa 3: Etapa de Fortalecimiento Empresarial y de Habilidades Blandas.</li>
	<li class="justify">Que INNPULSA COLOMBIA ha dispuesto un COSULTOR quien ejecutará la Etapa 2 y Etapa 3 del programa EMPODERA. </li>
	<li class="justify">Que por la naturaleza y propósitos del programa EMPODERA, resulta crucial la participación activa y comprometida de LA EMPRESA como un actor clave alrededor del cual se desarrollarán gran parte las actividades del mismo.</li>
	<li class="justify">Que LA EMPRESA firma la presente carta de compromiso para su vinculación y participación en la Etapa 2 y 3 del programa. Y en caso de ser seleccionada para su participación en la Etapa 4 del programa INNPULSA - Empodera.</li>
</ol>
	<p class="justify">Previas las anteriores consideraciones la presente carta de compromiso se regirá por las siguientes:</p><br>
	<h3 class="text-center">CLÁUSULAS: </h3><br>
	<p class="justify"><b> PRIMERA - </b> En virtud de la presente <b>CARTA DE COMPROMISO</b> y de conformidad con lo establecido en la Invitación publicada el 17 de junio de 2020 con sus respectivas adendas, <b>LA EMPRESA</b> se obliga de forma unilateral, incondicional e irrevocable a favor de <b>INNPULSA COLOMBIA</b> a: </p>
	<ol>
		<li class="justify">Informar a <b>INNPULSA COLOMBIA</b> el equipo de trabajo con rol directivo de <b>LA EMPRESA</b> que participará en la ejecución del programa <b>INNPULSA</b> - Empodera </li>
		<li class="justify">Suministrar la información requerida por <b>EL OPERADOR METODOLÓGICO</b> que <b>INNPULSA COLOMBIA</b> disponga para la ejecución del diagnóstico empresarial comprendido en la etapa 2 del programa. </li>
		<li class="justify">A asistir, participar o delegar como mínimo a una mujer que tenga rol directivo en <b>LA EMPRESA</b> quien asistirá a la realización de Entrenamientos Experienciales Especializados de la Etapa 3 del programa.</li>
		<li class="justify">En caso de llevarse a cabo actividades presenciales, asumir los gastos adicionales de la (s) persona (s) que participen en nombre de <b>LA EMPRESA</b> en la Etapa 3 del programa que no son asumidos por <b>INNPULSA COLOMBIA</b> tales como transporte terrestre y otros.</li>
		<li class="justify">En caso de llevarse a cabo actividades presenciales, asumir los gastos correspondientes a tiquetes, hospedajes u otros que la empresa identifique para la participación de la segunda persona del equipo propuesto por <b>LA EMPRESA</b>.</li>
		<li class="justify">A asistir, participar o delegar como mínimo a una mujer que tenga rol directivo en <b>LA EMPRESA</b> quien asistirá a la Misión Exploratoria Internacional en caso de que <b>LA EMPRESA</b> sea seleccionada para la participación en la Etapa 4 del programa <b>INNPULSA</b> - Empodera, cuyo participante debe haber participado en su totalidad en  las etapas del programa <b>INNPULSA</b> - Empodera.</li>
		<li class="justify">Asumir todos los gastos asociados a los tramites de visa u otros relacionados con la entrada al país de destino (Seguros de viajes, impuestos de entrada y otros que apliquen) de la Misión Exploratoria Internacional contemplada en la Etapa 3 del programa, sólo si <b>LA EMPRESA</b> es seleccionada para participar de ésta.</li>
		<li class="justify">Participar de forma activa y comprometida en todas las actividades propuestas en el marco del Programa <b>INNPULSA</b> - Empodera. En ese sentido, se precisa adelantar todas las actividades solicitadas por <b>EL OPERADOR METODOLÓGICO</b> que designe <b>INNPULSA COLOMBIA</b>, así como suministrar toda la información requerida por éste para conseguir los objetivos del programa.</li>
		<li class="justify">Disponer del equipo de trabajo necesario conforme a los lineamientos establecidos en la invitación a participar en cada una de las Fases que supere <b>LA EMPRESA</b> en el programa <b>INNPULSA</b> - Empodera para el desarrollo de las actividades que permitan la prestación del servicio por <b>EL OPERADOR METODOLÓGICO</b>.</li>
		<li class="justify">Recibir y aplicar los conocimientos y herramientas transferidos por <b>EL OPERADOR METODOLÓGICO</b> conforme al proceso de fortalecimiento empresarial que se adelante en marco del programa <b>INNPULSA</b> - Empodera en cada una de las Etapas que participe <b>LA EMPRESA</b>.</li>
		<li class="justify">Suministrar a <b>INNPULSA COLOMBIA</b> y/o <b>EL OPERADOR METODOLÓGICO</b> la información que se le solicite para adelantar la supervisión del contrato de prestación de servicios celebrado entre ésta y <b>EL OPERADOR METODOLÓGICO</b>, así como aquella información que le permita a <b>INNPULSA COLOMBIA</b> conocer la evolución de <b>LA EMPRESA</b> a partir de las actividades desarrolladas en marco del programa <b>INNPULSA</b> - Empodera.</li>
		<li class="justify">Informar a <b>INNPULSA COLOMBIA</b> sobre el desempeño, disposición y compromiso del <b>OPERADOR METODOLÓGICO</b> que ejecutará el programa  <b>INNPULSA</b> - Empodera. </li>
		<li class="justify">Autorizar expresa e irrevocablemente a <b>INNPULSA COLOMBIA</b> para reproducir, distribuir, comunicar públicamente en cualquier forma y por cualquier medio la información relacionada con su experiencia en el programa <b>INNPULSA</b> - Empodera de <b>INNPULSA COLOMBIA.</b></li>
	</ol>
	<p class="justify">
		<b> SEGUNDA - </b> El presente compromiso será irrevocable y su plazo dependerá de la duración de las Etapas que supere <b>LA EMPRESA</b> comprendidas en el programa <b>INNPULSA</b> - Empodera y seis (6) meses más.
	</p>
	<p class="justify">
		<b> TERCERA - </b>  <b>LA EMPRESA</b> se compromete a pagar incondicionalmente a la orden de <b>INNPULSA COLOMBIA</b>, en caso del incumplimiento total o parcial, o aún por el simple retardo en el cumplimiento, de cualquiera de las obligaciones señaladas en el presente instrumento comprendidas en la Etapa 1, 2 y 3 del programa <b>INNPULSA</b> - Empodera  la suma de $2.877.000, y en caso que <b>LA EMPRESA</b> supere la Etapa 4 del programa la suma de $14.920.000, cuya suma podrá ser exigida ejecutivamente por <b>INNPULSA COLOMBIA</b>, sin necesidad de requerimiento judicial o privado alguno ni constitución en mora a <b>LA EMPRESA</b>.  Lo anterior, sin perjuicio de que <b>INNPULSA COLOMBIA</b> pueda exigir adicionalmente las prestaciones e indemnizaciones derivadas del incumplimiento de esta <b>CARTA DE COMPROMISO</b>, y sin que se extinga por ello la obligación principal.
	</p><br>
	<p class="justify">
		<b> CUARTA - </b> <b>LA EMPRESA</b> certifica a FIDUCOLDEX, como vocera y administradora de <b>INNPULSA COLOMBIA</b> que sus recursos no provienen ni se destinan al ejercicio de ninguna actividad ilícita o de actividades de lavado de dinero proveniente de éstas o de actividades relacionadas con la financiación del terrorismo.
	</p>
	<p class="justify">
		<b>LA EMPRESA</b> se obliga a realizar todas las actividades encaminadas a asegurar que todos sus socios, administradores, clientes, proveedores, empleados, etc., y los recursos de estos, no se encuentren relacionados o provengan, de actividades ilícitas, particularmente de lavado de activos o financiación del terrorismo.
	</p>
	<p class="justify">
		En todo caso, si durante el plazo de vigencia del presente compromiso <b>LA EMPRESA</b>, algunos de sus administradores o socios llegaren a resultar inmiscuidos en una investigación de cualquier tipo (penal, administrativa, etc.) relacionada con actividades ilícitas, lavado de dinero o financiamiento del terrorismo, o fuese incluido en listas de control como las de la ONU, OFAC, etc., FIDUCOLDEX como administrador de <b>INNPULSA COLOMBIA</b> informará a LA EMPRESA su exclusión inmediata del Programa <b>INNPULSA</b> - Empodera y se exigirá inmediatamente el pago de la suma establecida en la Cláusula tercera de este instrumento sin que por este hecho esté obligado a indemnizar ningún tipo de perjuicio a <b>LA EMPRESA</b>.
	</p><br>

	<p class="justify">
		<b> QUINTA. - MERITO EJECUTIVO: </b> Para todos los efectos legales el presente instrumento presta merito ejecutivo.
	</p>
	<p class="justify"> Para constancia se acepta por parte de LA EMPRESA a los {{ $dia }} días del mes de {{ trans("app.".strtolower(jdmonthname(gregoriantojd($mes, 1, 1), CAL_MONTH_GREGORIAN_LONG))) }} de {{ $ano }}. </p>
	<br>
	<p>{{ strtoupper($data->nombre_empresa) }}</p>
	<br>
	<br>
	<p>	{{ $data->nombre_representante_legal }} {{ $data->apellidos_representante_legal }} </p>
	<p>	C.C {{ $data->identificacion_rep_legal }}</p><br>
@stop
