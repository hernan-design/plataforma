@extends('reports.layout', ['title' => $title, 'type' => 'PDF'])
@section('content')
<table class="rtable" border="0" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
        	<th class="center titleespecial">
        		CARTA DE COMPROMISO SUSCRITA POR {{ strtoupper($data->nombre_representante_legal) }} {{ strtoupper($data->apellidos_representante_legal) }} A FAVOR DE LA FIDUCIARIA COLOMBIANA DE COMERCIO EXTERIOR S.A., FIDUCÓLDEX (INNPULSA COLOMBIA)
        	</th>
        </tr>
    </tbody>
</table>
<br>
<p class="justify">El suscrito {{ strtoupper($data->nombre_representante_legal) }} {{ strtoupper($data->apellidos_representante_legal) }}, identificado con la cédula de ciudadanía número {{$data->identificacion_rep_legal }} expedida en {{$data->ciudad_rep_legal }} y quien, en adelante, y para los efectos de esta CARTA DE COMPROMISO se denominará EL EMPRESARIO, mediante el presente instrumento se obliga de forma unilateral, incondicional e irrevocable a favor de la Fiduciaria Colombiana de Comercio Exterior S.A., FIDUCÓLDEX, quien actúa como vocera de la Unidad de Gestión de Crecimiento Empresarial, de conformidad con lo establecido en el artículo 13 de la Ley 1753 de 2015 y el Contrato de Cesión del Convenio Interadministrativo N° 375 de 2015 y que en adelante se denominará INNPULSA COLOMBIA, en los términos que se indican a continuación, previas las siguientes:</p>
<h3 class="justify">CONSIDERACIONES: </h3>
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
	<li class="justify">Que conforme a lo ordenado en el artículo 13 de la Ley 1753 de 2015, el 15 de julio de 2015 se celebró entre el Ministerio de Comercio, Industria y Turismo y el Banco de Comercio Exterior de Colombia S.A.– Bancóldex, el Convenio Interadministrativo 375 de 2015 para dar cumplimiento al artículo 13 de la Ley 1753 de 2015, estableciendo las directrices para el cumplimiento de dicha administración por parte de BANCÓLDEX. De esta manera, la Unidad de Desarrollo e Innovación se transforma en la Unidad de Gestión de Crecimiento Empresarial, en adelante INNPULSA COLOMBIA por su marca comercial, la cual nace como un esfuerzo del Gobierno Nacional por generar condiciones para apalancar el desarrollo empresarial del País desde la innovación.</li>
	<li class="justify">Que el artículo 126 de la Ley 1815 del 7 de diciembre del año 2016 por medio de la cual “se decreta el Presupuesto de Rentas y Recursos de Capital y Ley de Apropiaciones para la vigencia fiscal del 1o de enero al 31 de diciembre de 2017”, estableció que “Los patrimonios autónomos cuya administración haya sido asignada por ley al Banco de Comercio de Colombia S.A. – Bancóldex, podrán administrarse directamente por este o a través de sus filiales”.</li>
	<li class="justify">Que en razón a la autorización legal impartida y, por definición de Política por parte del Ministerio de Comercio, Industria y Turismo, Bancóldex, Fiduciaria Colombiana de Comercio Exterior S.A., sociedad de servicios financieros de economía mixta indirecta del orden nacional, filial de Bancóldex y el Ministerio de Comercio, Industria y Turismo, suscribieron el 24 de marzo de 2017 contrato de cesión del Convenio 375 de 2012 con efectos a partir del 1º de abril de 2017.</li>
	<li class="justify">Una vez celebrado el contrato de cesión de posición contractual, el Ministerio de Comercio, Industria y Turismo y Fiduciaria Colombiana de Comercio Exterior S.A. FIDUCOLDEX S.A. celebraron el contrato de fiducia mercantil de administración número 006-2017 cuyo objeto es la administración del patrimonio autónomo Unidad de Gestión de Crecimiento Empresarial INNPULSA COLOMBIA por parte de FIDUCOLDEX, quien actúa como vocera del mismo.</li>
	<li class="justify">Que el objetivo principal de INNPULSA COLOMBIA es intervenir sobre los diferentes actores del sector productivo para conseguir que más innovadores y empresarios incursionen en procesos de desarrollo empresarial jalonados por la innovación. INNPULSA COLOMBIA estimula la creación de alianzas entre el sector público, el sector privado y la academia, como eje fundamental del desarrollo empresarial y pilar de la estrategia nacional de innovación y trabaja por generar una cultura del emprendimiento y la innovación en el país.</li>
	<li class="justify">Que el día 07 de noviembre de 2018, INNPULSA COLOMBIA abrió la invitación pública “PROGRAMA EMPODERA” la cual tiene por objeto “poner en marcha el Fondo Empodera a través de la selección de empresas en etapa temprana cuyos equipos de trabajo directivos sean heterogéneos, con el fin de fortalecer las capacidades y habilidades empresariales que permitan el escalamiento de sus negocios.” </li>
	<li class="justify">Que en cumplimiento de sus objetivos, INNPULSA COLOMBIA busca por medio de EMPODERA fortalecer las capacidades y habilidades empresariales que permitan el escalamiento de sus negocios, a través de un proceso que incluye tres Etapas: Etapa 1: Postulación y selección de las empresas en etapa temprana que cumplan con los requisitos definidos en la invitación.; Etapa 2: Realización de diagnóstico de capacidades emprendedoras y desarrollo de Entrenamientos Experienciales Especializados con los representantes de cada una de las empresas seleccionadas; Etapa 3: Realización de misión exploratoria a nivel internacional con un representante de las empresas con mejor desempeño en los Entrenamientos Experienciales Especializados. </li>
	<li class="justify">Que luego de realizada la Etapa 1 definida en los términos de la invitación, El EMPRESARIO ha sido seleccionado para la participación en la Etapa 2: Realización de diagnóstico de capacidades emprendedoras y desarrollo de Entrenamientos Experienciales Especializados. </li>
	<li class="justify">Que INNPULSA COLOMBIA ha dispuesto un COSULTOR quien ejecutará la Etapa 2 y Etapa 3 del programa EMPODERA. </li>
	<li class="justify">Que por la naturaleza y propósitos del programa EMPODERA, resulta crucial la participación activa y comprometida de El EMPRESARIO como un actor clave alrededor del cual se desarrollarán gran parte las actividades del mismo.</li>
	<li class="justify">Que El EMPRESARIO firma la presente carta de compromiso para su vinculación y participación en la Etapa 2 y en caso de ser seleccionado para su participación en la Etapa 3 del programa EMPODERA. </li>
</ol>
<p class="justify">Previas las anteriores consideraciones la presente carta de compromiso se regirá por las siguientes:</p>
<h3 class="justify">CLÁUSULAS: </h3>
<p class="justify">
	PRIMERA. - En virtud de la presente CARTA DE COMPROMISO y de conformidad con lo establecido en la Invitación publicada el 07 de noviembre de 2018 con sus respectivas adendas, EL EMPRESARIO se obliga de forma unilateral, incondicional e irrevocable a favor de INNPULSA COLOMBIA a:
</p>
<ol>
	<li class="justify">Informar a INNPULSA COLOMBIA el equipo de trabajo de El EMPRESARIO que participará en la ejecución del programa EMPODERA. </li>
	<li class="justify">Suministrar la información requerida por EL OPERADOR METODOLÓGICO que INNPULSA COLOMBIA disponga para la ejecución del diagnóstico empresarial comprendido en la etapa 2 del programa. </li>
	<li class="justify">A asistir, participar o delegar como mínimo a una mujer que tenga rol directivo en LA EMPRESA quien asistirá a la realización de Entrenamientos Experienciales Especializados de la Etapa 2 del programa.</li>
	<li class="justify">Asumir los gastos adicionales de la (s) persona (s) que participen en nombre de LA EMPRESA en los Entrenamientos Experienciales Especializados que no son asumidos por INNPULSA COLOMBIA tales como transporte terrestre y otros.</li>
	<li class="justify">Asumir los gastos correspondientes a tiquetes, hospedajes u otros que la empresa identifique para la participación de la segunda persona del equipo propuesto por LA EMPRESA. </li>
	<li class="justify">A asistir, participar o delegar como mínimo a una mujer que tenga rol directivo en LA EMPRESA quien asistirá a la Misión Exploratoria Internacional en caso de que LA EMPRESA sea seleccionada para la participación en la Etapa 3 del programa EMPODERA, cuyo participante debe ser mujer y haber participado en su totalidad en los Entrenamientos Experienciales Especializados contemplados en la Etapa 2.</li>
	<li class="justify">Asumir todos los gastos asociados a los tramites de visa u otros relacionados con la entrada al país de destino (Seguros de viajes, impuestos de entrada y otros que apliquen) de la Misión Exploratoria Internacional contemplada en la Etapa 3 del programa, sólo si LA EMPRESA es seleccionada para participar de ésta. </li>
	<li class="justify">Suministrar a INNPULSA COLOMBIA la información que ésta le solicite para adelantar la supervisión del contrato de prestación de servicios celebrado entre ésta y EL ASESOR, así como aquella información que le permita a INNPULSA COLOMBIA conocer la evolución de EL EMPRESARIO a partir del recibo del servicio prestado por el ASESOR.</li>
	<li class="justify">Mantener en forma permanente a disposición de INNPULSA COLOMBIA, los soportes documentales relacionados con la ejecución del acuerdo de negociación (control de asistencia de las sesiones de trabajo, correos electrónicos, conceptos, entre otros)</li>
	<li class="justify">Informar a INNPULSA COLOMBIA sobre el desempeño, disposición y compromiso del ASESOR prestador del servicio.</li>
	<li class="justify">A la finalización del Acuerdo de Negociación deberá presentar a INNPULSA COLOMBIA una evaluación integral del servicio prestado por EL ASESOR en el formato que para estos efectos se establezca.</li>
	<li class="justify">Si el precio del servicio negociado supera el valor del servicio habilitado por INNPULSA COLOMBIA, bien sea porque se haya pactado un alcance del servicio superior al habilitado o por un aumento en la tasa de cambio (en el caso de servicios ofertados por asesores extranjeros en monedas diferentes a pesos colombianos - COP), este valor adicional deberá ser asumido por EL EMPRESARIO en un primer pago que realizará ésta al ASESOR; INNPULSA COLOMBIA no tendrá ninguna responsabilidad sobre el valor que supere el monto del servicio habilitado.</li>
	<li class="justify">EL EMPRESARIO se compromete a asumir cualquier valor adicional al valor otorgado en la Llave de Acceso cuando la sumatoria del valor de los servicios correspondientes supere el monto de la misma; INNPULSA COLOMBIA no tendrá ninguna responsabilidad sobre el valor que supere el monto de la Llave de Acceso.</li>
</ol>
<p class="justify">
	SEGUNDA. - El presente compromiso será irrevocable y su plazo dependerá de la duración del servicio pactado en el acuerdo de negociación entre EL EMPRESARIO y INNPULSA COLOMBIA y tres (3) meses más.
</p><p class="justify">
	TERCERA. -EL EMPRESARIO acepta que INNPULSA COLOMBIA no se hace responsable bajo ningún concepto de la calidad del servicio prestado por EL ASESOR de Servicios Especializados, por lo que El EMPRESARIO deberá prever en el Acuerdo de negociación que celebre con EL ASESOR, lo que considere necesario para recibir el servicio a satisfacción.
</p>



<p class="justify">
	QUINTA. - EL EMPRESARIO certifica a FIDUCOLDEX, COMO VOCERA Y ADMINISTRADORA DE INNPULSA COLOMBIA DE GESTION DE CRECIMIENTO EMPRESARIAL que sus recursos no provienen ni se destinan al ejercicio de ninguna actividad ilícita o de actividades de lavado de dinero proveniente de éstas o de actividades relacionadas con la financiación del terrorismo.

	EL EMPRESARIO se obliga a realizar todas las actividades encaminadas a asegurar que todos sus socios, administradores, clientes, proveedores, empleados, etc., y los recursos de estos, no se encuentren relacionados o provengan, de actividades ilícitas, particularmente de lavado de activos o financiación del terrorismo.

	En todo caso, si durante el plazo de vigencia del presente compromiso EL EMPRESARIO, algunos de sus administradores o socios llegaren a resultar inmiscuidos en una investigación de cualquier tipo (penal, administrativa, etc.) relacionada con actividades ilícitas, lavado de dinero o financiamiento del terrorismo, o fuese incluido en listas de control como las de la ONU, OFAC, etc., FIDUCOLDEX COMO ADMINISTRADOR DE LA UNIDAD DE GESTION DE CRECIMIENTO EMPRESARIAL informará a EL EMPRESARIO y al respectivo asesor, su exclusión inmediata del Programa ALDEA y a exigirá inmediatamente el pago de la suma establecida en la Cláusula Cuarta de este instrumento sin que por este hecho esté obligado a indemnizar ningún tipo de perjuicio a El EMPRESARIO.
</p>

<p class="justify">
	SEXTA.- MERITO EJECUTIVO: Para todos los efectos legales el presente instrumento presta merito ejecutivo.
</p>

<p class="justify">
	Para constancia se acepta por EL EMPRESARIO a los {{ $dia }} días del mes de {{ trans("app.".strtolower(jdmonthname(gregoriantojd($mes, 1, 1), CAL_MONTH_GREGORIAN_LONG))) }} de {{ $ano }}.
</p>

<p class="justify">{{ strtoupper($data->nombre_representante_legal) }} {{ strtoupper($data->apellidos_representante_legal) }}</p>
<br>
<br>
<p class="justify">	C.C {{$data->identificacion_rep_legal }}</p>
@stop
