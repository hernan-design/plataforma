<html>
	<head>
		<style>
			/** Define the margins of your page **/
			@page {
				margin: 100px 50px 100px 50px;
			}
			header {
				position: fixed;
				top: -60px;
				left: 0px;
				right: 0px;
				height: 50px;

				/** Extra personal styles **/
				background-color: #ffffff;
				color: white;
				text-align: center;
				line-height: 35px;
			}
			footer {
				position: fixed;
				bottom: -60px;
				left: 0px;
				right: 0px;
				height: 50px;

				/** Extra personal styles **/
				font-family: Arial, Helvetica, sans-serif;
				font-size: 9px;
				background-color: #ffffff;
				color: black;
				text-align: right;
				line-height: 35px;
			}
			table, th, td {
				border: 0.5px solid rgb(163, 157, 157);
				border-collapse: collapse;
				font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				width: 100%;
			}
			th {
				text-align: left;
				padding: 2.5px;
			}
			td ~ .bg-1 {
				background = "#C14242"
				text-align: center;
				padding: 2.5px;
				font-size: 10px;
			}
			td ~ .bg-2 {
				background = "#BFBF3F"
				text-align: center;
				padding: 2.5px;
				font-size: 10px;
			}
			td ~ .bg-3 {
				background = "#3FBF7F"
				text-align: center;
				padding: 2.5px;
				font-size: 10px;
			}
			td {
				background-color: #d9d9d9;
				color: black;
				padding: 2.5px;
				font-size: 10px;
			}

			h5 {
				font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
			}
			.title {
				/*margin-top: 27px;*/
				text-align: center;
			}
			h6 {
				font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				margin: 10px 0 0 0;
			}
			.padding h6 {
				padding: 3px;
			}
			ul {
				list-style: none;
				padding: 0;
				margin: 0;
			}
			li {
				padding-left: 16px;
				color: black;
				font-family: Arial, Helvetica, sans-serif;
				font-size: 11px;
			}
			li::before {
				content: "•";
				padding-right: 8px;
				color: black;
			}
			li .justify{
				text-align: justify;
			}
			.content-info {
				padding: 0 5px 0 27px;
				/*position: relative;*/
			}
			.bg-heads {
				background: #412b8a;
				color: white;
			}
			.bg-blue {
				background: rgb(20, 51, 95);
				color: white;
			}
			
			.bg-red {
				background: rgb(100, 30, 30);
				color: white;
			}
			.bg-green {
				background: rgb(29, 83, 76);
				color: white;
			}
			.bg-yellow {
				background: rgb(99, 95, 35);
				color: white;
			}
			.sub-title {
				text-align: center;
				/*border: 1px solid rgb(184, 178, 178);*/
			}
			.scoring-1 {
				margin: 0;
				padding: 0;
				height: 230px;
				width: 320px;
				box-sizing: border-box;
				text-align: center;
			}
			.scoring-2 {
				margin: 0;
				padding: 0;
				height: 230px;
				width: 320px;
				box-sizing: border-box;
				text-align: center;
			}
			.scoring-3 {
				margin: 0;
				padding: 0;
				height: 230px;
				width: 320px;
				box-sizing: border-box;
				text-align: center;
			}
			.scoring-4 {
				margin: 0;
				padding: 0;
				height: 220px;
				width: 320px;
				box-sizing: border-box;
				text-align: center;
			}
			.id-table {
				background: white;
				text-align: center;
			}
			.description-table {
				background: white;
			}
			.scoring-table {
				text-align: center;
			}
			.description-answer {
				text-align: justify;
			}
			.container-product {
				display: flex;
				justify-content: center;
				margin-top: 200px;
				border: 1px solid rgb(184, 178, 178);
			}
			.container-service {
				display: flex;
				justify-content: center;
				margin-top: 600px;
				border: 1px solid rgb(184, 178, 178);
			}
			.item {
				margin: 0;
				padding: 0;
				text-align: center;
				/*align-self: center;*/
				box-sizing: border-box;
			}
			.average {
				background: white;
				text-align: center;
			}
			.average-total {
				background: rgb(99, 111, 161);
				color: white;
			}
			.margin-top-product {
				margin-top: 200px
			}
			.margin-top-service {
				margin-top: 500px
			}
			.margin-botton-section {
				margin-bottom: 30px;
				background: white
			}
		</style>
	</head>

	<body>
		<header>
			<div class="margin-botton-section">
				<img src="@php echo $_logo @endphp"
				alt="Encabezado"  width="176px" height="83px">
			</div>
		</header>
		<footer>
			Copyright © @php echo date("Y-m-d") . " Ruta N" @endphp
		</footer>
		<main>
			<br>
			<h5 class="title">
				@php echo $_title_diagnosis @endphp
			</h5>
			<table>
				<tr>
					<th>Fecha de emisión </th>
					<td> @php echo date("d-m-Y") @endphp </td>
				</tr>
			</table>
			<h5>I. DATOS BÁSICOS DEL PROYECTO</h5>
			<div>
				@include('emails.diagnosis.rutanpdf.datosbasicos')
			</div>
			<h5>II. DATOS DEL EVALUADOR</h5>
			<div>
				@include('emails.diagnosis.rutanpdf.datosevaluador')
			</div>
			<h5>III. DETALLADO VARIABLES DEL DIAGNÓSTICO</h5>
			<div>
				@include('emails.diagnosis.rutanpdf.answers_1' , ['answers_eval' => $_answers_eval])
			</div>
			<br>
			<div>
				@include('emails.diagnosis.rutanpdf.answers_2' , ['answers_eval' => $_answers_eval, 'description_257' => $_description_257])
			</div>
			<br>
			<div>
				@include('emails.diagnosis.rutanpdf.answers_3' , ['answers_eval' => $_answers_eval, 'description_263' => $_description_263])
			</div>
			<br>
			<div>
				@include('emails.diagnosis.rutanpdf.answers_4' , ['answers_eval' => $_answers_eval])
			</div>
			<br>
			<div>
				@include('emails.diagnosis.rutanpdf.radar', ['calculate' => $_calculate])
			</div>
			<br>
			<div>
				@include('emails.diagnosis.rutanpdf.resumen', ['calculate' => $_calculate])
			</div>
			<div>
				<h5>IV. OBSERVACIONES</h5>
				<p style="text-align: justy">
					@php
						echo $_answers_eval[0]['observacion']
					@endphp
				</p>
			</div>
		</main>
	</body>
</html>