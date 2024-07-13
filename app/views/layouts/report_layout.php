<!DOCTYPE html>
<html>

<head>
	<title>Formulir Pendaftaran </title>
	<style>
		@page {

			margin-top: 0;
			margin-bottom: 0;
			font-family: 'Times New Roman', Times, serif;

		}

		body {
			font-family: Arial, sans-serif;
			margin: 0;
			padding: 0;
			display: flex;
			justify-content: center;
			align-items: center;
			min-height: 100vh;
			background-color: #f0f0f0;
		}

		.card hr {
			border-color: black;
			padding: 0;
			margin-top: 0;
			margin-bottom: 2px;
		}

		.we {
			width: 30%;
		}

		.card {
			width: 390px;
			background-color: white;
			border-radius: 8px;
			border: 1px solid black;
			/* Menambahkan border */
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			padding: 20px;
			text-align: center;
		}


		.card img {
			width: 40px;

		}

		.card h2 {
			margin-bottom: 5px;
		}

		.card h4,
		h3,
		h5,
		h6 {
			margin-bottom: 0;
			margin-top: 0;
			margin-left: 0;
			margin-right: 0;
		}


		.card p {
			margin: 0px 0;
			padding: 0;
		}

		.p {
			margin: 0;
			padding: 0;
			font-weight: lighter;
			font-size: 8px;

		}

		.card th {
			padding-bottom: 0px;
		}


		small {
			font-size: 12px;
			color: #888;
		}

		.ajax-page-load-indicator {
			display: none;
			visibility: hidden;
		}

		#report-header {
			position: relative;
			border-bottom: 5px double #000;
			background: #fff;
			width: auto;

		}

		#report-header table {

			margin-bottom: 0;
			margin-top: 20rem;
		}

		#report-header .sub-title {
			font-size: small;
			color: #888;
		}

		#report-header img {
			height: 50px;
			width: 50px;
			margin-left: 4rem;
			margin-right: 4rem;
		}

		#report-title {
			background: #fff;
			margin-top: 20px;
			margin-bottom: 20px;
			padding: 10px 20px;

			text-align: center;
			font-family: 'Times New Roman', Times, serif;
			text-transform: uppercase;

		}

		#report-body {
			padding: 20px;
			text-align: left;
			text-transform: uppercase;
			width: 100%;
			margin-left: 2rem;
			font-size: 12px;


		}

		.ttd {
			padding: 10px;
			text-align: left;
			width: 80%;
			margin-left: 2rem;
		}

		#report-footer {
			padding: 10px;
			background: #fafafa;
			border-top: 2px solid #0066cc;
			position: absolute;
			bottom: 0;
			left: 0;
			width: 98%;
			overflow: hidden;
			margin: 0 auto;
		}

		#report-footer table {
			margin: 0;
			overflow: hidden;
		}



		table,
		.table {
			width: 100%;
			max-width: 100%;
			margin-bottom: 0;
			border-collapse: collapse;
		}

		.table th,
		.table td {
			padding: 0.5px;
			vertical-align: top;
			font-weight: lighter;
			font-size: 10px;


		}

		.table thead th {
			vertical-align: bottom;
			border-bottom: 2px solid #eceeef;
		}

		.table tbody+tbody {
			border-top: 2px solid #eceeef;
		}

		.table .table {
			background-color: #fff;
		}

		.table-sm th,
		.table-sm td {
			padding: ;
		}

		.table-bordered {
			border: 1px solid #eceeef;
		}

		.table-bordered th,
		.table-bordered td {
			border: 1px solid #eceeef;
		}

		.table-bordered thead th,
		.table-bordered thead td {
			border-bottom-width: 2px;
		}

		.table-hover .table-success:hover {
			background-color: #d0e9c6;
		}

		.table-hover .table-success:hover>td,
		.table-hover .table-success:hover>th {
			background-color: #d0e9c6;
		}

		.table-info,
		.table-info>th,
		.table-info>td {
			background-color: #d9edf7;
		}

		.table-hover .table-info:hover {
			background-color: #c4e3f3;
		}

		.table-hover .table-info:hover>td,
		.table-hover .table-info:hover>th {
			background-color: #c4e3f3;
		}

		.table-warning,
		.table-warning>th,
		.table-warning>td {
			background-color: #fcf8e3;
		}

		.table-hover .table-warning:hover {
			background-color: #faf2cc;
		}

		.table-hover .table-warning:hover>td,
		.table-hover .table-warning:hover>th {
			background-color: #faf2cc;
		}

		.table-danger,
		.table-danger>th,
		.table-danger>td {
			background-color: #f2dede;
		}

		.table-hover .table-danger:hover {
			background-color: #ebcccc;
		}

		.table-hover .table-danger:hover>td,
		.table-hover .table-danger:hover>th {
			background-color: #ebcccc;
		}

		.thead-inverse th {
			color: #fff;
			background-color: #292b2c;
		}

		.thead-default th {
			color: #464a4c;
			background-color: #eceeef;
		}

		.table-inverse {
			color: #fff;
			background-color: #292b2c;
		}

		.table-inverse th,
		.table-inverse td,
		.table-inverse thead th {
			border-color: #fff;
		}

		.table-inverse.table-bordered {
			border: 0;
		}

		.table-responsive {
			display: block;
			width: 100%;
			overflow-x: auto;
			-ms-overflow-style: -ms-autohiding-scrollbar;
		}

		.table-responsive.table-bordered {
			border: 0;
		}
	</style>
</head>

<body>
	<div class="card">
		<table>
			<th align="left" valign="middle" width="10" style=" ">
				<img width="50" height="80" src="<?php print_link("assets/images/logo_barito.png") ?>" />
			</th>
			<th align="center" valign="middle" width="10" style=" width:auto;">
				<h6 style=" font-weight: lighter;">PEMERINTAH KABUPATEN BARITO SELATAN</h6>
				<h5>UPTD PUSKESMAS TABAK KANILAN</h5>
				<h5>KECAMATAN GUNUNG BINTANG AWAI</h5>
				<p class="p">Jln PP Dinan Gg.Pelajar RT III No:28, Desa Tabak Kanilan Kode Pos 73753</p>
				<p class="p">Email: uptdpuskesmastabak@gmail.com</p>
			</th>
			<th align="right" valign="middle" width="10">
				<img width="50" height="80" src="<?php print_link("assets/images/logopus.jpg") ?>" />
			</th>
		</table>
		<hr>
		<h4><u>Kartu Pasien</u></h4>
		<div id="report-body">
			<?php
			$this->render_body();
			?>
		</div>
		<h6>*Kartu Harap Dibawa Ketika Berobat</h6>
	</div>

	</div>
	<?php
	if ($this->force_print) {
	?>
		<script>
			window.print();
		</script>
	<?php
	}
	?>
</body>

</html>