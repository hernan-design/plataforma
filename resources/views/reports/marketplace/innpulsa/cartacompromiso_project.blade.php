@extends('reports.layout', ['title' => $title, 'type' => 'PDF'])
@section('content')
<table class="rtable" border="0" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
        	<th class="center titleespecial">
        		CARTA DE COMPROMISO SUSCRITA POR {{ strtoupper($data->nombre_representante_legal) }} {{ strtoupper($data->apellidos_representante_legal) }} A FAVOR DE LA FIDUCIARIA COLOMBIANA DE COMERCIO EXTERIOR S.A., FIDUCÓLDEX, QUIEN ACTÚA COMO VOCERA DE LA UNIDAD DE GESTIÓN DE CRECIMIENTO EMPRESARIAL DE CONFORMIDAD CON LO ESTABLECIDO EN EL ARTÍCULO 13 DE LA LEY 1753 DE 2015 Y EL CONTRATO DE CESIÓN DEL CONVENIO INTERADMINISTRATIVO N° 375  DE 2015 (INNPULSA COLOMBIA)
        	</th>
        </tr>
    </tbody>
</table>
<br>
<p>El suscrito {{ strtoupper($data->nombre_representante_legal) }} {{ strtoupper($data->apellidos_representante_legal) }}, identificado con la cédula de ciudadanía número {{$data->identificacion_rep_legal }} expedida en {{$data->ciudad_rep_legal }} y quien, en adelante, y para los efectos de esta CARTA DE COMPROMISO se denominará EL EMPRESARIO, mediante el presente instrumento se obliga de forma unilateral, incondicional e irrevocable a favor de la Fiduciaria Colombiana de Comercio Exterior S.A., FIDUCÓLDEX, quien actúa como vocera de la Unidad de Gestión de Crecimiento Empresarial, de conformidad con lo establecido en el artículo 13 de la Ley 1753 de 2015 y el Contrato de Cesión del Convenio Interadministrativo N° 375 de 2015 y que en adelante se denominará INNPULSA COLOMBIA, en los términos que se indican a continuación, previas las siguientes:</p>
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
	<li class="justify">Que el día 03 de octubre de 2016, INNPULSA COLOMBIA abrió la invitación pública “ALDEA Emprendamos juntos una aventura que nos conecta” la cual tiene por objeto “Apoyar a empresarios y emprendedores innovadores en Colombia a superar sus obstáculos y encontrar financiación, dinamizando sus entornos regionales de innovación y emprendimiento, para que alcancen el máximo potencial de sus empresas, a través de una comunidad en la que pueden encontrar conexiones claves.”</li>
	<li class="justify">Que en cumplimiento de sus objetivos, INNPULSA COLOMBIA busca por medio de ALDEA construir una comunidad donde empresarios y emprendedores innovadores tienen la oportunidad de superar las barreras más difíciles, a través de un proceso que incluye cuatro retos: Primer Reto: ¡Conozcámonos!, Segundo Reto: ¡Conversa con Expertos!, Tercer Reto: ¡Conéctate con tus asesores!, y Cuarto Reto: ¡Levantemos Capital!.</li>

	<li class="justify">Que luego de realizados el primer y segundo reto definido en los términos de la invitación ALDEA, identificadas y priorizadas las necesidades empresariales respectivas, EL EMPRESARIO ha sido acreedor de la(s)llave(s) de acceso por valor de {{ $valor_llave_acceso_letras }} (${{ number_format($valor_llave_acceso,0,',','.') }}) para redimir en servicios ofrecidos por asesores de servicios especializados (En adelante ASESOR) habilitados previamente por iNNpulsa Colombia.</li>
	<li class="justify">Que la(s) llave(s) de acceso solo podrá(n) utilizarse para redimir servicios en las siguientes temáticas :
	@foreach($categories as $category)
	<ul>
		<li>{{ $category->nombre_categoria_producto }}</li>
	</ul>
	@endforeach</li>
	<li class="justify">Que INNPULSA COLOMBIA suministrará a EL EMPRESARIO información de los asesores y servicios especializados que se encuentran en cada una de las temáticas mencionadas anteriormente, la descripción del servicio, alcance, precio, equipo de trabajo, entre otra información para facilitar la selección del ASESOR por parte de EL EMPRESARIO.</li>
	<li class="justify">Que EL EMPRESARIO deberá escoger, contactar y negociar a partir de las temáticas de servicio mencionadas y valor de la llave de acceso correspondiente aquellos asesores que le resulten más atractivos a partir de la información enviada previamente por INNPULSA COLOMBIA para la prestación del servicio.</li>
	<li class="justify">Que por la naturaleza y propósitos del programa ALDEA, resulta crucial la participación activa y comprometida de LA EMPRESA como un actor clave alrededor del cual se desarrollarán gran parte las actividades del mismo.</li>
	<li class="justify">Que EL EMPRESARIO firma la presente carta de compromiso para su vinculación y participación en el tercer reto del programa ALDEA.</li>
</ol>
<p class="justify">Previas las anteriores consideraciones la presente carta de compromiso se regirá por las siguientes:</p>
<h3 class="justify">CLÁUSULAS: </h3>
<p class="justify">
	PRIMERA. - En virtud de la presente CARTA DE COMPROMISO y de conformidad con lo establecido en la Invitación publicada el 3 de octubre de 2016 con sus respectivas adendas, EL EMPRESARIO se obliga de forma unilateral, incondicional e irrevocable a favor de INNPULSA COLOMBIA a:
</p>
<ol>
	<li class="justify">A participar de forma activa y comprometida en todas las actividades propuestas en el marco del programa ALDEA.</li>
	<li class="justify">Seleccionar en un plazo prudente, que en todo caso no podrá ser superior a veinte (20) días siguientes a la entrega de la información relacionada con el listado de asesores por parte de INNPULSA COLOMBIA, al ASESOR que prestará el/los servicios que permitirán solucionar las problemáticas previamente identificadas y priorizadas y para las cuales fue otorgada la llave de acceso correspondiente. Si pasado este plazo, EL EMPRESARIO no ha surtido el proceso de selección correspondiente, iNNpulsa Colombia entenderá que no es de su interés recibir el beneficio otorgado y por tanto desiste de recibir el mismo.</li>
	<li class="justify">Realizar el proceso de negociación de manera directa con el/los ASESORES habilitados por INNPULSA COLOMBIA en cuanto al objeto, alcance y valor de los servicios, así como demás aspectos que considere indispensables para la adecuada ejecución del objeto y la protección de sus intereses. Serán de exclusiva responsabilidad de EL EMPRESARIO las condiciones pactadas en el correspondiente “Acuerdo de negociación” que resultare de lo acordado entre las Partes del mismo y en tal sentido INNPULSA COLOMBIA no será responsable por cualquier perjuicio ocasionado por lo pactado u omitido en dicho acuerdo.</li>
	<li class="justify">Firmar el “Acuerdo de Negociación” pactado con el ASESOR, en el cual se describirá el alcance, actividades, número de sesiones de trabajo, entregables, resultados y demás condiciones pactadas del/los servicio(s) correspondiente(s) que se definan de común acuerdo con EL ASESOR, para asegurar la prestación del servicio en el plazo, precio y calidad esperada. Al respecto, se precisa que dicho acuerdo deberá ser aprobado por INNPULSA COLOMBIA de forma previa a la firma del mismo, para lo cual su labor de revisión se circunscribirá, por una parte, a verificar que el acuerdo contemple los servicios recomendados como resultado de las actividades desarrolladas en el segundo reto del programa ALDEA y por otra, a que el servicio se defina a partir de las condiciones habilitadas por INNPULSA COLOMBIA en relación con los servicios que deberán ser prestados por los asesores, las demás condiciones que se pacten en el acuerdo, se reitera, serán de exclusiva responsabilidad de EL EMPRESARIO.</li>
	<li class="justify">Recibir el/los servicio(s) conforme al alcance, actividades, número de sesiones de trabajo, entregables, resultados y condiciones pactadas y consignadas en el documento denominado “Acuerdo de negociación” firmado entre el ASESOR y EL EMPRESARIO.</li>
	<li class="justify">Disponer el equipo de trabajo necesario para el desarrollo de las actividades que permitan la prestación del servicio por el ASESOR e informar a INNPULSA COLOMBIA quien será el interlocutor encargado de coordinar tales actividades (agendas, reuniones, participación de los actores requeridos, lugares de reunión, logística, etc.)</li>
	<li class="justify">Recibir y aplicar los conocimientos y herramientas transferidos por EL ASESOR conforme a los servicios prestados y consignados en el acuerdo de negociación firmado entre el ASESOR y EL EMPRESARIO.</li>
	<li class="justify">Suministrar a INNPULSA COLOMBIA la información que ésta le solicite para adelantar la supervisión del contrato de prestación de servicios celebrado entre ésta y EL ASESOR, así como aquella información que le permita a INNPULSA COLOMBIA conocer la evolución de EL EMPRESARIO a partir del recibo del servicio prestado por el ASESOR.</li>
	<li class="justify">Mantener en forma permanente a disposición de INNPULSA COLOMBIA, los soportes documentales relacionados con la ejecución del acuerdo de negociación (control de asistencia de las sesiones de trabajo, correos electrónicos, conceptos, entre otros)</li>
	<li class="justify">Informar a INNPULSA COLOMBIA sobre el desempeño, disposición y compromiso del ASESOR prestador del servicio.</li>
	<li class="justify">A la finalización del Acuerdo de Negociación deberá presentar a INNPULSA COLOMBIA una evaluación integral del servicio prestado por EL ASESOR en el formato que para estos efectos se establezca.</li>
	<li class="justify">Si el precio del servicio negociado supera el valor del servicio habilitado por INNPULSA COLOMBIA, bien sea porque se haya pactado un alcance del servicio superior al habilitado o por un aumento en la tasa de cambio (en el caso de servicios ofertados por asesores extranjeros en monedas diferentes a pesos colombianos - COP), este valor adicional deberá ser asumido por EL EMPRESARIO en un primer pago que realizará ésta al ASESOR; INNPULSA COLOMBIA no tendrá ninguna responsabilidad sobre el valor que supere el monto del servicio habilitado.</li>
	<li class="justify">EL EMPRESARIO se compromete a asumir cualquier valor adicional al valor otorgado en la Llave de Acceso cuando la sumatoria del valor de los servicios correspondientes supere el monto de la misma; INNPULSA COLOMBIA no tendrá ninguna responsabilidad sobre el valor que supere el monto de la Llave de Acceso.</li>
	<li class="justify">EL EMPRESARIO se obliga a reconocer y pagar a EL ASESOR la remuneración que le corresponda conforme a la diferencia que llegare a existir entre el valor total del servicio seleccionado y el valor del servicio habilitado por INNPULSA COLOMBIA, de conformidad con lo que haya sido pactado en el acuerdo de negociación.</li>
	<li class="justify">Autorizar expresa e irrevocablemente a INNPULSA COLOMBIA para reproducir, distribuir, comunicar públicamente en cualquier forma y por cualquier medio la información relacionada con su experiencia en el programa ALDEA de INNPULSA COLOMBIA.</li>
</ol>
<p class="justify">
	SEGUNDA. - El presente compromiso será irrevocable y su plazo dependerá de la duración del servicio pactado en el acuerdo de negociación entre EL EMPRESARIO y INNPULSA COLOMBIA y tres (3) meses más.
</p><p class="justify">
	TERCERA. -EL EMPRESARIO acepta que INNPULSA COLOMBIA no se hace responsable bajo ningún concepto de la calidad del servicio prestado por EL ASESOR de Servicios Especializados, por lo que LA EMPRESA deberá prever en el Acuerdo de negociación que celebre con EL ASESOR, lo que considere necesario para recibir el servicio a satisfacción.
</p>


<p class="justify">
	CUARTA. - EL EMPRESARIO se compromete a pagar incondicionalmente a la orden de INNPULSA COLOMBIA, en caso del incumplimiento total o parcial, o aún por el simple retardo en el cumplimiento, de cualquiera de las obligaciones señaladas en el presente instrumento la suma de {{ $valor_llave_acceso_letras }} (${{ number_format($valor_llave_acceso,0,',','.') }}), correspondiente al valor de la llave de acceso otorgada, suma que podrá ser exigida ejecutivamente por INNPULSA COLOMBIA, sin necesidad de requerimiento judicial o privado alguno ni constitución en mora a LA EMPRESA.  Lo anterior, sin perjuicio de que INNPULSA COLOMBIA pueda exigir adicionalmente las prestaciones e indemnizaciones derivadas del incumplimiento de esta CARTA DE COMPROMISO, y sin que se extinga por ello la obligación principal.
</p>

<p class="justify">
	QUINTA. - EL EMPRESARIO certifica a FIDUCOLDEX, COMO VOCERA Y ADMINISTRADORA DE INNPULSA COLOMBIA DE GESTION DE CRECIMIENTO EMPRESARIAL que sus recursos no provienen ni se destinan al ejercicio de ninguna actividad ilícita o de actividades de lavado de dinero proveniente de éstas o de actividades relacionadas con la financiación del terrorismo.

	EL EMPRESARIO se obliga a realizar todas las actividades encaminadas a asegurar que todos sus socios, administradores, clientes, proveedores, empleados, etc., y los recursos de estos, no se encuentren relacionados o provengan, de actividades ilícitas, particularmente de lavado de activos o financiación del terrorismo.

	En todo caso, si durante el plazo de vigencia del presente compromiso EL EMPRESARIO, algunos de sus administradores o socios llegaren a resultar inmiscuidos en una investigación de cualquier tipo (penal, administrativa, etc.) relacionada con actividades ilícitas, lavado de dinero o financiamiento del terrorismo, o fuese incluido en listas de control como las de la ONU, OFAC, etc., FIDUCOLDEX COMO ADMINISTRADOR DE LA UNIDAD DE GESTION DE CRECIMIENTO EMPRESARIAL informará a EL EMPRESARIO y al respectivo asesor, su exclusión inmediata del Programa ALDEA y a exigirá inmediatamente el pago de la suma establecida en la Cláusula Cuarta de este instrumento sin que por este hecho esté obligado a indemnizar ningún tipo de perjuicio a LA EMPRESA.
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
