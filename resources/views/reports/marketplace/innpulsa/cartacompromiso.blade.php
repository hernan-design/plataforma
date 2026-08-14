@extends('reports.layout', ['title' => $title, 'type' => 'PDF'])
@section('content')
	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<tbody>
		<tr>
			<th class="center titleespecial">
				CARTA DE COMPROMISO SUSCRITA POR {{ strtoupper($data->nombre_empresa) }} A FAVOR DE LA FIDUCIARIA COLOMBIANA DE COMERCIO EXTERIOR S.A., FIDUCÓLDEX, QUIEN ACTÚA COMO VOCERA DE INNPULSA COLOMBIA
			</th>
		</tr>
		</tbody>
	</table>
	<br><br>
	<p class="justify">El suscrito {{ $data->nombre_representante_legal }} {{ $data->apellidos_representante_legal }}, identificado con la cédula de ciudadanía número {{ $data->identificacion_rep_legal }} expedida en {{ $data->ciudad_rep_legal }}, quien actúa en nombre y representación legal de {{ strtoupper($data->nombre_empresa) }}, sociedad domiciliada en la ciudad de {{ $data->ciudad_empresa }}, identificada con NIT {{ $data->nit_empresa }}, debidamente facultado para la suscripción del presente documento y quien, en adelante, y para los efectos de esta CARTA DE COMPROMISO se denominará EL EMPRENDEDOR, mediante el presente instrumento se obliga de forma unilateral, incondicional e irrevocable a favor de la Fiduciaria Colombiana de Comercio Exterior S.A., FIDUCÓLDEX, quien actúa como vocera de INNPULSA COLOMBIA, en los términos que se indican a continuación, previas las siguientes:</p>
	<br>
	<h3 class="justify">CONSIDERACIONES: </h3><br>
	<p class="justify"> <b> PRIMERA: </b> Que la Ley 1753 de 2015 (Plan Nacional de Desarrollo 2014-2018) en su artículo 13 ordenó la unificación del Fondo de Modernización e Innovación para las Micro, Pequeñas y Medianas Empresas y de la Unidad de Desarrollo e Innovación en los siguientes términos: </p>
	<p class="justify"> “Artículo 13º. Fondo de Modernización e Innovación para las Micro, Pequeñas y Medianas Empresas y Unidad de Desarrollo e Innovación: Unifíquese en un sólo patrimonio autónomo el Fondo de Modernización e Innovación para las Micro, Pequeñas y Medianas Empresas y Unidad de Desarrollo e Innovación, creados por la Ley 590 de 2000 y 1450 de 2011. Este patrimonio autónomo, se regirá por normas de derecho privado, y será administrado por el Banco de Comercio Exterior S.A. (Bancóldex), de acuerdo con los lineamientos que fije el Gobierno Nacional a través de la Política pública que para el efecto defina el Ministerio de Comercio, Industria y Turismo”. </p><br>
	<p class="justify"> <b> SEGUNDA: </b>  Que conforme a lo ordenado en el artículo 13 de la Ley 1753 de 2015, el 15 de julio de 2015 se celebró entre el Ministerio de Comercio, Industria y Turismo y el Banco de Comercio Exterior de Colombia S.A. – Bancóldex, el Convenio Interadministrativo 375, estableciendo las directrices para el cumplimiento de dicha administración por parte de BANCÓLDEX. </p><br>
	<p class="justify"> <b> TERCERA:</b> Que el artículo 126 de la Ley 1815 del 7 de diciembre del año 2016 por medio de la cual “se decreta el Presupuesto de Rentas y Recursos de Capital y Ley de Apropiaciones para la vigencia fiscal del 1o de enero al 31 de diciembre de 2017”, estableció que “Los patrimonios autónomos cuya administración haya sido asignada por ley al Banco de Comercio de Colombia S.A. – Bancóldex, podrán administrarse directamente por este o a través de sus filiales”. </p><br>
	<p class="justify"> <b> CUARTA: </b> Que en razón a la autorización legal impartida y por definición de Política por parte del Ministerio de Comercio, Industria y Turismo, Bancóldex, Fiduciaria Colombiana de Comercio Exterior S.A., sociedad de servicios financieros de economía mixta indirecta del orden nacional, filial de Bancóldex y el Ministerio de Comercio, Industria y Turismo, suscribieron el 24 de marzo de 2017 contrato de cesión del Convenio 375 de 2015 con efectos a partir del 1º de abril de 2017. </p><br>
	<p class="justify"> <b> QUINTA: </b> Una vez celebrado el contrato de cesión de posición contractual, el Ministerio de Comercio, Industria y Turismo y Fiduciaria Colombiana de Comercio Exterior S.A. Fiducóldex S.A. celebraron el contrato de fiducia mercantil de administración número 006-2017 cuyo objeto es la administración del patrimonio Innpulsa Colombia, por parte de Fiducóldex, quien actúa como vocera del mismo. </p><br>
	<p class="justify"> <b> SEXTA: </b> Que uno de los objetivos principales de INNPULSA COLOMBIA es acompañar y propiciar las condiciones necesarias para que los emprendedores innovadores y el ecosistema de emprendimiento se consoliden y potencialicen, generando sostenidamente empresas innovadoras de alto crecimiento que impacten positivamente el país. </p>
	<p class="justify"> INNPULSA COLOMBIA estimula la creación de alianzas entre el sector público, el sector privado y la academia, como eje fundamental del desarrollo empresarial y pilar de la estrategia nacional de innovación y trabaja por generar una cultura del emprendimiento y la innovación en el país. </p><br>
	<p class="justify"> <b> SÉPTIMA: </b> Que el día a 22 de julio de 2020, INNPULSA COLOMBIA abrió la invitación pública <b>“PROGRAMA ALDEA”</b> la cual tiene por objeto ““Promover la consolidación, el crecimiento y sostenibilidad de emprendedores innovadores (alto impacto) para que se conviertan en los próximos grandes empresarios de Colombia y el mundo, dinamizando los entornos regionales, los actores que intervienen en ellos y fortaleciendo de esta manera los ecosistemas de emprendimiento regionales.”</p><br>
	<p class="justify"> <b> OCTAVA: </b> Qué en cumplimiento de sus objetivos, INNPULSA COLOMBIA busca por medio de ALDEA fortalecer el emprendimiento innovador (también denominado de alto impacto) en Colombia. En su proceso, los emprendedores participantes encuentran feedback personalizado, apoyo de expertos, asesores, consultores de servicios especializados, y, también, tienen la posibilidad de acceder a la comunidad de emprendedores innovadores (denominada ATÍPICOS) donde pueden acceder a conexiones de crecimiento (capital social) y colaboración con otros emprendedores para que alcancen el máximo potencial de sus empresas, aprovechando oportunidades y superando sus obstáculos para crecer</p>
	<p class="justify"> <b> NOVENA: </b> Que luego de realizados y superados el primer y segundo reto del programa ALDEA definidos en los términos de invitación, EL EMPRENDEDOR ha pasado a desarrollar el tercer reto ¡Conéctate con tus asesores!, de acuerdo con la identificación y priorización de sus necesidades empresariales, por lo anterior, ha sido acreedor(a) de la(s) llave(s) de acceso por valor de {{ strtoupper($valor_llave_acceso_letras) }} ( ${{ $valor_llave_acceso }} ) para redimir en servicios ofrecidos por asesores de servicios especializados (En adelante ASESOR) habilitados previamente por INNPULSA COLOMBIA.</p>
	<p class="justify">Que la(s) llave(s) de acceso solo podrá(n) utilizarse para redimir servicios en las siguientes temáticas de acuerdo con el resultado del reto 2 ¡Conversa con Expertos!: </p>
	<ol>
		@foreach($categories as $category)
			<li>{{ $category->nombre_cat_padre_producto }}</li>
		@endforeach
	</ol>
	<br>
	<p class="justify"> <b> DÉCIMA:  INNPULSA COLOMBIA</b> a través de convocatoria pública ha seleccionado al grupo de asesores que se encuentran habilitados para prestar los servicios especializados en cada una de las temáticas mencionadas anteriormente.  </p><br>
	<p class="justify"> <b> DÉCIMA PRIMERA: INNPULSA COLOMBIA </b> suministrará a EL EMPRENDEDOR toda la información de los asesores que se encuentran habilitados para la prestación de los servicios especializados en cada una de las temáticas en las que EL EMPRENDEDOR deba redimir sus llaves de acceso, eso se hará a través del Marketplace del programa ALDEA o en el medio que INNPULSA COLOMBIA disponga para ello, así mismo, entregará la información de la descripción del servicio, alcance, precio máximo, equipo de trabajo, entre otra información presentada previamente por el ASESOR, para facilitar la selección del ASESOR por parte de EL EMPRENDEDOR. </p><br>
	<p class="justify"> <b> DÉCIMA SEGUNDA: </b>  EL EMPRENDEDOR a partir de las temáticas de servicio en las que debe redimir su llave de acceso y el valor de la misma, deberá escoger, contactar y negociar con aquellos asesores que le resulten más atractivos a partir de la información publicada en el Marketplace del programa ALDEA o en el medio que INNPULSA COLOMBIA disponga para ello. </p><br>
	<p class="justify"> <b> DÉCIMA TERCERA: </b> Que por la naturaleza y propósitos del programa ALDEA,  EL EMPRENDEDOR se compromete a participar de forma activa en el programa como un actor clave alrededor del cual se desarrollarán gran parte las actividades de este. </p><br>
	<p class="justify"> <b> DÉCIMA CUARTA: </b> De acuerdo con lo anterior,  EL EMPRENDEDOR suscribe la presente carta de compromiso para su vinculación y participación en el tercer reto ¡Conéctate con tus Asesores! del programa ALDEA. </p>
	<p class="justify">Previas las anteriores consideraciones la presente carta de compromiso se regirá por las siguientes:</p><br>
	<h3 class="text-center">CLÁUSULAS: </h3><br>
	<p class="justify"> <b> PRIMERA: </b> En virtud de la presente CARTA DE COMPROMISO y de conformidad con lo establecido en la Invitación publicada el 22 de julio de 2020 con sus respectivas adendas, EL EMPRENDEDOR se obliga de forma unilateral, incondicional e irrevocable a favor de INNPULSA COLOMBIA a: </p>
	<ol>
		<li class="justify">Participar de forma activa y comprometida en todas las actividades que se deban desarrollar en el marco del programa ALDEA.</li>
		<li class="justify">Si existe alguna inconformidad deberá reportarlo oportuna y efectivamente a INNPULSA COLOMBIA, al equipo de Aldea designado para acompañar el proceso.</li>
		<li class="justify">EL EMPRENDEDOR no podrá trasladar o trasferir la llave de acceso a otras empresas o emprendimientos. EL EMPRENDEDOR solo podrá utilizar la llave de acceso para prestaciones de servicios de asesores sobre su
			emprendimiento, quien fue la que surtió los retos anteriores del programa ALDEA. En ningún caso EL EMPRENDEDOR podrá hacer uso de los servicios especializados para fortalecer otras personas diferente a ella misma o a su emprendimiento</li>
		<li class="justify">INNPULSA COLOMBIA podrá solicitarle al ASESOR información de la evolución de EL EMPRENDEDOR en cualquier
			momento, así como información necesaria para conocer los resultados y el impacto de cara a los servicios recibidos.</li>
		<li class="justify">Una vez tenga acceso al Marketplace, deberá seleccionar del listado de Asesores de Servicios Especializados habilitados por INNPULSA COLOMBIA, el/los que considere más adecuado(s) para resolver sus necesidades y detonar el crecimiento de su negocio, de acuerdo con las categorías priorizadas por los Expertos en el Segundo Reto</li>
		<li class="justify">EL EMPRENDEDOR contará con <b>treinta (30) días calendario </b>, desde la habilitación del acceso al Marketplace o en el medio que INNPULSA COLOMBIA disponga para ello, para surtir el proceso de selección de servicios, negociación y cierre de acuerdos correspondientes con los asesores, por tanto, INNPULSA COLOMBIA solo reconocerá los acuerdos de negociación suscritos en este plazo. <b> En caso de que el empresario no haya seleccionado servicios en el plazo establecido, INNPULSA COLOMBIA no reconocerá la totalidad del valor de la llave de acceso otorgada al emprendedor y éste perderá su beneficio y/o remanente de la llave de acceso ALDEA.</b></li>

		<li class="justify">
			EL EMPRENDEDOR desde la habilitación del acceso al Marketplace y en el 
			tiempo que INNPULSA COLOMBIA disponga para ello, deberá surtir el proceso 
			de selección de servicios, negociación y cierre de acuerdos correspondientes 
			con los asesores, por tanto, INNPULSA COLOMBIA solo reconocerá los acuerdos 
			de negociación suscritos en este plazo. <b> En caso de que el empresario no 
			haya seleccionado servicios en el plazo establecido, INNPULSA COLOMBIA no 
			reconocerá la totalidad del valor de la llave de acceso otorgada al emprendedor 
			y éste perderá su beneficio y/o remanente de la llave de acceso ALDEA.</b>
		</li>

		<li class="justify">EL EMPRENDEDOR deberá seleccionar el/los asesores que más se ajuste a su necesidad, a partir de la información contenida en el Marketplace o en el medio que INNPULSA COLOMBIA disponga para ello, por lo tanto, deberá tener en cuenta:
		<p class="justify">
			<ol>
				<li class="justify">No debe seleccionar servicios similares o con el mismo alcance. </li>
				<li class="justify">Es responsabilidad de EL EMPRENDEDOR elegir el asesor y el servicio que se ajuste a sus necesidades. En este proceso puede: aumentar los beneficios ofrecidos, definir las fechas oportunas para la ejecución, disminuir el valor del servicio sin perder el alcance</li>
			</ol></li>
		</p>
		<p class="justify"><b>Nota:</b> En ningún caso podrá superar el monto establecido en la oferta publicada. </p>
		<li class="justify">EL EMPRENDEDOR una vez decida adquirir un servicio a través de la opción de compra u oferta (sí es aceptada), el asesor generará un acuerdo de negociación, el cual deberá contener como mínimo, el alcance, las actividades, equipo de trabajo, responsabilidades de las partes, es decir de EL EMPRENDEDOR y del asesor, número de sesiones de trabajo, número de horas de trabajo por sesión, modalidad del servicio, es decir presencial o semipresencial, entregable, resultados, duración fecha de inicio y fin del acompañamiento, precio y forma de pago. </li>
		<li class="justify">Cuando el ASESOR del servicio cree el acuerdo de negociación, será enviada una notificación al correo electrónico de EL EMPRENDEDOR para que acceda a la información descrita. EL EMPRENDEDOR debe verificar que dicho acuerdo contenga como mínimo todos los apartes descritos en el numeral anterior, y que corresponda a lo negociado.</li>
		<p class="justify">Sí EL EMPRENDEDOR está de acuerdo con lo contenido en el ACUERDO DE NEGOCIACIÓN y corresponde a lopactado, debe aprobar el Acuerdo, de lo contrario lo puede devolver al asesor indicando los comentarios y observaciones en la ventana habilitada para ello en el Marketplace o en el medio que INNPULSA COLOMBIA disponga para ello.</p>
		<p class="justify"><b>Nota: INNPULSA COLOMBIA</b> revisará el acuerdo de negociación y deberá aprobarlo, <span style="text-decoration: underline;">en ningún caso será posible iniciar actividades si el acuerdo no está aprobado por INNPULSA COLOMBIA.</span></p>
		<li class="justify">En el caso que INNPULSA COLOMBIA solicite un ajuste, EL ASESOR y EL EMPRENDEDOR deberán iniciar nuevamente el proceso.</li>
		<li class="justify">Una vez INNPULSA COLOMBIA apruebe el acuerdo de negociación el Asesor y EL EMPRENDEDOR recibirán una notificación indicando el inicio de las actividades correspondientes, así como la opción de descargar la versión final del documento. </li>
		<li class="justify">Solo puede suscribir acuerdos de negociación con los Asesores que se encuentren en el Marketplace o en el medio que INNPULSA COLOMBIA disponga para ello y conforme a los servicios habilitados por INNPULSA COLOMBIA.</li>
		<li class="justify">EL EMPRENDEDOR debe disponer del equipo de trabajo necesario para el desarrollo de las actividades que permitan la prestación del servicio por parte del ASESOR.</li>
		<li class="justify">EL EMPRENDEDOR debe recibir y aplicar los conocimientos y herramientas transferidos por EL ASESOR conforme a los servicios prestados y consignados en el acuerdo de negociación firmado.</li>
		<li class="justify">EL EMPRENDEDOR debe informar de manera permanente a INNPULSA COLOMBIA sobre el desempeño, disposición y compromiso del ASESOR prestador del servicio.</li>
		<li class="justify">EL EMPRENDEDOR deberá informar a INNPULSA COLOMBIA, cualquier situación que afecte la prestación normal del servicio y/o que altere la ejecución del acuerdo de negociación suscrito, con el fin de identificar soluciones y tomar las medidas correspondientes.</li>
		<li class="justify">EL EMPRENDEDOR dentro de los treinta (30) días siguientes de finalizado la prestación del servicio por parte del ASESOR deberá presentar a INNPULSA COLOMBIA <b>una evaluación integral del servicio prestado por EL ASESOR por medio de la plataforma de ALDEA</b> o en el medio que INNPULSA COLOMBIA disponga para ello.</li>
		<li class="justify">El precio del servicio a negociar entre EL EMPRENDEDOR y asesor no podrá superar en ningún caso el valor del servicio presentado por el asesor y publicado en el Marketplace o en el medio que INNPULSA COLOMBIA disponga para ello.</li>
		<li class="justify">INNPULSA COLOMBIA no tendrá ninguna responsabilidad si EL EMPRENDEDOR decide contratar servicios por un valor superior al monto de la Llave de Acceso otorgada. Por lo anterior, es obligación de EL EMPRENDEDOR reconocer y pagar a EL ASESOR la remuneración que le corresponda, conforme a la diferencia que llegare a existir entre el valor total del servicio seleccionado y el valor del servicio habilitado por INNPULSA COLOMBIA.</li>
		<li class="justify">EL EMPRENDEDOR autoriza expresa e irrevocablemente a INNPULSA COLOMBIA para reproducir, distribuir, comunicar públicamente en cualquier forma y por cualquier medio la información relacionada con su experiencia en el programa ALDEA de INNPULSA COLOMBIA.</li>
		<li class="justify">EL EMPRENDEDOR debe hacer uso de el/los servicios contratados en el tiempo estimado en el acuerdo de negociación.</li>
		<li class="justify">En caso de requerirse un plazo adicional para la culminación de las actividades definidas en el acuerdo, <b>el ASESOR y EL EMPRENDEDOR deberán informar a INNPULSA COLOMBIA para su aprobación con treinta (30) días calendario de anterioridad al vencimiento del servicio, la justificación y el tiempo adicional requerido para la culminación de las actividades, el cual en ningún caso podrá ser superior a sesenta (60) días calendario adicionales al plazo inicialmente establecido.</b></li>
	</ol><br>
	<p class="justify">
		<b> SEGUNDA: </b> EL EMPRENDEDOR conoce y acepta las siguientes condiciones generales del tercer reto ¡Conéctate con tus Asesores! del programa ALDEA:
	</p>
	<ol>
		<li class="justify">El uso de la <i>Llave de Acceso</i> estará sujeto a la disponibilidad de recursos de INNPULSA COLOMBIA.</li>
		<li class="justify">En ningún caso INNPULSA COLOMBIA podrá pagar AL ASESOR un valor superior al previamente habilitado.</li>
		<li class="justify">No es posible contratar la prestación de un servicio diferente al ofertado en el MarketPlace o en el medio que INNPULSA COLOMBIA disponga para ello.</li>
		<li class="justify">Por la naturaleza pública de los recursos que se manejan en el programa ALDEA, cualquier irregularidad en la que incurra EL EMPRENDEDOR durante el proceso de negociación y/o durante la prestación del servicio, generará para EL EMPRENDEDOR la pérdida de beneficio obtenido en el programa Aldea. Para estos casos, INNPULSA COLOMBIA implementará las acciones que considere pertinentes.</li>
		<li class="justify">EL EMPRENDEDOR debe cumplir con todas y cada una de las condiciones que se pacten en el acuerdo de negociación. </li>
		<li class="justify">EL EMPRENDEDOR debe participar en cada parte del proceso a que se refiere este reto; si decide abandonarlo, perderá el beneficio otorgado y no podrá postularse al programa ALDEA hasta un año después de la notificación de pérdida de beneficio enviada por parte de INNPULSA COLOMBIA.</li>
		<li class="justify">Si existe alguna inconformidad deberá reportarlo oportunamente a INNPULSA COLOMBIA. </li>
		<li class="justify">Deberá evaluar al <i>Asesor de Servicios Especializados</i> cuando la prestación del servicio haya finalizado.</li>
		<li class="justify">INNPULSA COLOMBIA podrá solicitarle información de la evolución de EL EMPRENDEDOR en cualquier momento, así como información necesaria para conocer el impacto de cara a los servicios recibidos. </li>
		<li class="justify">EL EMPRENDEDOR no podrá trasladar o trasferir la llave de acceso a otras empresas. EL EMPRENDEDOR solo podrá utilizar las llaves de acceso para prestaciones de servicios de asesores sobre ella, quien fue la que surtió los retos anteriores del programa ALDEA, en ningún caso EL EMPRENDEDOR podrá hacer uso de los servicios especializados para fortalecer otras personas diferente a ella misma. </li>
		<li class="justify"><b><span style="text-decoration: underline;">Las demás obligaciones indicadas en los términos de invitación del programa ALDEA y sus respectivas adendas.</span></b></li>
	</ol><br>
	<p class="justify">
		<b> TERCERO: EL EMPRENDEDOR </b> acepta que INNPULSA COLOMBIA no se hace responsable bajo ningún concepto de la calidad del servicio prestado por EL ASESOR de Servicios Especializados, por lo que EL EMPRENDEDOR deberá prever en el Acuerdo de negociación que celebre con EL ASESOR, lo que considere necesario para recibir el servicio a satisfacción.
	</p><br>
	<p class="justify">
		<b> CUARTA: EL EMPRENDEDOR </b> se compromete a pagar incondicionalmente a la orden de INNPULSA COLOMBIA, en caso del incumplimiento total o parcial, o aún por el simple retardo en el cumplimiento, de cualquiera de las obligaciones señaladas en el presente instrumento la suma correspondiente al valor de la llave de acceso otorgada, suma que podrá ser exigida ejecutivamente por INNPULSA COLOMBIA, sin necesidad de requerimiento judicial o privado alguno ni constitución en mora a EL EMPRENDEDOR. Lo anterior, sin perjuicio de que INNPULSA COLOMBIA pueda exigir adicionalmente las prestaciones e indemnizaciones derivadas del incumplimiento de esta CARTA DE COMPROMISO, y sin que se extinga por ello la obligación principal.
	</p><br>
	<p class="justify">
		<b> QUINTA: EL EMPRENDEDOR </b> certifica a FIDUCOLDEX, COMO VOCERA Y ADMINISTRADORA DE INNPULSA COLOMBIA que sus recursos no provienen ni se destinan al ejercicio de ninguna actividad ilícita o de actividades de lavado de dinero proveniente de éstas o de actividades relacionadas con la financiación del terrorismo.
	</p><br>
	<p class="justify">
		EL EMPRENDEDOR se obliga a realizar todas las actividades encaminadas a asegurar que todos sus socios, administradores, clientes, proveedores, empleados, etc., y los recursos de estos, no se encuentren relacionados o provengan, de actividades ilícitas, particularmente de lavado de activos o financiación del terrorismo.
	</p>
	<p class="justify">
		En todo caso, si durante el plazo de vigencia del presente compromiso EL EMPRENDEDOR, algunos de sus administradores o socios llegaren a resultar inmersos en una investigación de cualquier tipo (penal, administrativa, etc.) relacionada con actividades ilícitas, lavado de dinero o financiamiento del terrorismo, o fuese incluido en listas de control como las de la ONU, OFAC, etc., FIDUCOLDEX COMO ADMINISTRADOR DE INNPULSA COLOMBIA informará a EL EMPRENDEDOR y al respectivo asesor, su exclusión inmediata del Programa ALDEA y a exigirá inmediatamente el pago de la suma establecida en la Cláusula cuarta de este instrumento sin que por este hecho esté obligado a indemnizar ningún tipo de perjuicio a EL EMPRENDEDOR.
	</p><br>

	<p class="justify">
		<b> SEXTA - MERITO EJECUTIVO: </b> Con la suscripción del/los acuerdo(s) de negociación, EL EMPRENDEDOR reconoce expresamente el mérito ejecutivo, con todos los efectos legales que este reconocimiento conlleva. Por esta razón, en caso de incumplimiento de cualquiera de las obligaciones contenidas en el presente, EL EMPRENDEDOR deberá pagar a INNPULSA el valor de la suma correspondiente a la llave de acceso dentro de los treinta (30) días calendario después de notificado el valor a cancelar y las condiciones del pago. De no ser canceladas las sumas de dinero adeudadas dentro del plazo pactado, la obligación tendrá el carácter de expresa, clara y exigible y por ello iNNpulsa Colombia quedará facultado para adelantar las acciones judiciales y extrajudiciales que considere procedentes, en orden a obtener el pago de tales obligaciones.
	</p>

	<p class="justify"> Para todos los efectos legales el presente instrumento presta mérito ejecutivo. Para constancia se acepta por parte de EL EMPRENDEDOR a los {{ $dia }} días del mes de {{ trans("app.".strtolower(jdmonthname(gregoriantojd($mes, 1, 1), CAL_MONTH_GREGORIAN_LONG))) }} de {{ $ano }}. </p>
	<br>
	<p>{{ strtoupper($data->nombre_empresa) }}</p>
	<br>
	<br>
	<p>	{{ $data->nombre_representante_legal }} {{ $data->apellidos_representante_legal }} </p>
	<p>	C.C {{ $data->identificacion_rep_legal }}</p>
@stop
