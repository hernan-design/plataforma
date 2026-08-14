@extends('emails.layout')

@section('content')
	<p align="justify">Recibe un afectuoso saludo de iNNpulsa Colombia, la agencia del Gobierno Nacional que trabaja para forjar las empresas del futuro, empresas preparadas para asumir el reto de crecer colaborando y conectándose.</p>
    <p align="justify"> De antemano queremos agradecerte por permitirnos conocer tu emprendimiento <b> {{ $_emprendimiento }}  </b>.  </p>
    <p aling="justify"> En esta ocasión, la Vicepresidencia de Aceleración y Emprendimiento de iNNpulsa Colombia, te informa que no has sido seleccionado(a) para participar en el segundo reto "Conversa con expertos”. </p>
    <p aling="justify"> Sin embargo, te recomendamos validar los componentes de innovación dentro de tu modelo de negocio, debido a que </p>
    <b><ul>
        <li>
            La información disponible sobre el emprendimiento, no es suficiente para identificar con claridad, cuál es la oportunidad y/o problema que resuelve en el mercado.
        </li>
        <li>
            El emprendimiento plantea una solución existente con pocas barreras de entrada, por lo cual, no es claro el diferencial de su modelo de negocio.
        </li>
    </ul></b>
    <p align="justify"> Desde iNNpulsa Colombia, te recomendamos implementar acciones de mejora, para una próxima postulación. </p>
    <p align="justify"> Gracias por mostrar interés en ser parte de ALDEA. ¡Recuerda que eres el motor de nuestra organización! </p>
    <p align="justify"> Cordialmente, </p>
    <p align="justify"> Equipo ALDEA </p>
    <p align="justify"> iNNpulsa Colombia </p>
    <br>
    <p align="justify"> Solo podrás volver a aplicar a esta convocatoria desde el  <b>{{ date("Y-m-d", strtotime($_fecha_aplicacion)) }}</b> </p>
    <p align="justify"> Para volver a aplicar a esta convocatoria <a href="https://aldeainnpulsa.com/convocatoria/reto1-aldea-innpulsa/aplicar/terminos">haz clic aquí</a></p>
@stop





