@extends('emails.layout')

@section('content')

	<p align="justify">
		<span style="color:#FF2424"></b>¡Bienvenido(a) al RETO DE EMPRENDEDORES!</b></span>
	</p>

	<p align="justify">
		<span>
			Has quedado inscrito(a) en la categoría {{ $_program }} {{ $_project }}. Una vez finalice el proceso de evaluación, nos pondremos en contacto contigo por este medio para notificarte si pasaste a la siguiente fase del programa: capacitaciones.
		</span>
	</p>

	<p align="justify">
		<span>
			Te invitamos a que mientras tanto te capacites a través de nuestra plataforma en el módulo <a href="http://redemprendedoresbavaria.net/aprende" title="Aprende">Aprende</a> donde encontrarás charlas y cursos con un gran valor para tu proceso emprendedor.
		</span>
	</p>

	<p align="justify">
		<span>
			Nuestras recomendaciones para ti son:
		</span>
	</p>

	<ul>
		<li>
			<a href="http://redemprendedoresbavaria.net/aprende/cursos/emprendimiento/investigacion-mercados-emprendedores" title="Investigación de mercados para emprendedores">Investigación de mercados para emprendedores</a>
		</li>
		<li>
			<a href="http://redemprendedoresbavaria.net/aprende/cursos/emprendimiento/marca-personal" title="Marca personal">Marca personal</a>
		</li>
		<li>
			<a href="http://redemprendedoresbavaria.net/aprende/cursos/finanzas/financiacion-de-empresas-de-alto-potencial" title="Financiación de empresas de alto potencial">Financiación de empresas de alto potencial</a>
		</li>
	</ul>

@stop
