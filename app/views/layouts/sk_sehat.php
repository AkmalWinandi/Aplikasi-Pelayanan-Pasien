<?php
$comp_model = new SharedController;
$page_element_id = "view-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
//Page Data Information from Controller
$data = $this->view_data;
//$rec_id = $data['__tableprimarykey'];
$page_id = $this->route->page_id; //Page id from url
$view_title = $this->view_title;
$show_header = $this->show_header;
$show_edit_btn = $this->show_edit_btn;
$show_delete_btn = $this->show_delete_btn;
$show_export_btn = $this->show_export_btn;
?>
<!DOCTYPE html>
<html>

<head>
	<title>Surat Keterangan Kesehatan </title>
	<style>
		@page {

			margin-top: 0;
			margin-bottom: 0;
			font-family: 'Times New Roman', Times, serif;
		}

		body,
		h1,
		h2,
		h3,
		h4,
		h5,
		h6 {
			margin: 0px;
			padding: 0px;
			font-family: 'Times New Roman', Times, serif;

		}

		.p {
			margin: 0;
			font-weight: lighter;
			text-transform: none;
		}

		.p1 {
			margin: 0;
			font-weight: lighter;
			text-transform: none;
			font-weight: bold;
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

		}

		#report-header table {

			margin-bottom: 0;
			margin-top: 50px;
		}

		#report-header .sub-title {
			font-size: small;
			color: #888;
		}

		#report-header img {
			height: 100px;
			width: 100px;
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
			margin-left: 4rem;
			margin-bottom: 0;

		}

		.mrd {
			padding: 20px;
			text-align: left;
			margin-left: 4rem;
			margin-bottom: 0;
			font-weight: lighter;
		}

		.we {
			width: 19%;
		}

		.mrd2 {
			padding: 20px;
			text-align: left;
			width: 50%;
			margin-left: 4rem;
			margin-bottom: 0;
			font-weight: lighter;
		}

		.mrd4 {
			padding: 20px;
			text-align: left;
			width: 40%;
			margin-left: 25rem;
			margin-bottom: 0;
			font-weight: lighter;
		}

		.mrd3 {
			padding: 20px;
			text-align: right;
			margin-bottom: 0;
			font-weight: lighter;
			width: 50%;
		}


		.pp {
			padding: 0px;
			text-align: left;

			margin-bottom: 0;
			margin-left: 2rem;
		}

		.pp1 {
			padding: 0px;
			text-align: left;

			margin-bottom: 0;
			margin-left: 2rem;
			margin-top: 0;
			margin-right: 4rem;
		}

		.pp2 {
			padding: 0px;
			text-align: center;

			margin-bottom: 0;

			margin-top: 0;
			margin-right: 100px;
			font-style: italic;
		}

		.ppp {
			padding: 20px;
			text-align: left;

			width: 60%;
			margin-left: 10rem;
		}

		.ttd {
			padding: 0px;
			text-align: right;
			width: 80%;
			margin-left: 2rem;
			margin-top: 0;
			margin-bottom: 0;
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
			padding: 0px;
			vertical-align: top;
			font-weight: lighter;



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
			padding: 0.3rem;
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
	<div id="report-header">
		<table class="table table-sm">
			<tr>
				<th align="left" valign="middle" width="60">
					<img width="50" height="50" src="<?php print_link("assets/images/logo_barito.png") ?>" />
				</th>
				<th style="text-align: center;">
					<h3 style="font-weight: lighter;">PEMERINTAH KABUPATEN BARITO SELATAN</h3>
					<h2>UPTD PUSKESMAS TABAK KANILAN</h2>
					<h2>KECAMATAN GUNUNG BINTANG AWAI</h2>
					<p class="p">Jln PP Dinan Gg.Pelajar RT III No:28, Desa Tabak Kanilan Kode Pos 73753</p>
					<p class="p">Email: uptdpuskesmastabak@gmail.com</p>
				</th>
				<th align="right" valign="middle" width="60">
					<img width="50" height="50" src="<?php print_link("assets/images/logopus.jpg") ?>" />
				</th>
				</th>
			</tr>
		</table>
	</div>

	<div id="report-title">
		<h2><u>SURAT KETERANGAN KESEHATAN</u></h2>
		<p class="p1">Nomor : <?php echo $data['nomor_surat']; ?></p>
	</div>
	<p class="pp">Yang Bertanda Tangan Dibawah ini :</p>
	<div id="report-body">
		<?php
		$this->render_body();
		?>
	</div>
	<p class="pp1">Menerangkan dengan sesungguhnya bahwa :</p>
	<div class="mrd">
		<table class="table table-hover table-borderless table-striped">
			<!-- Table Body Start -->
			<tr>
				<th class="we">Nama Pasien </th>
				<td> : <?php echo $data['nama_pasien']; ?></td>
			</tr>
			<tr>
				<th> Umur </th>
				<td> : <?php echo $data['umur']; ?> Tahun</td>
			</tr>
			<tr>
				<th> Nik </th>
				<td> : <?php echo $data['nik']; ?></td>
			</tr>
			<tr>
				<th>Jenis Kelamin </th>
				<td> : <?php echo $data['jenis_kelamin']; ?></td>
			</tr>
			<tr>
				<th> Agama </th>
				<td> : <?php echo $data['agama']; ?></td>
			</tr>
			<tr>
				<th> Alamat Pasien </th>
				<td> : <?php echo $data['alamat_pasien']; ?></td>
			</tr>
			<tr>
				<th>Keperluan </th>
				<td> : <?php echo $data['keperluan']; ?></td>
			</tr>
			<!-- Table Body End -->
		</table>
	</div>
	</div>

	<p class="pp1">Dengan Hasil Pemeriksaan :</p>
	<div class="mrd">
		<table class="table table-hover table-borderless table-striped">
			<!-- Table Body Start -->
			<tr>
				<th class="we">Tinggi Badan </th>
				<td> : <?php echo $data['tinggi_badan']; ?></td>
			</tr>
			<tr>
				<th> Berat Badan </th>
				<td> : <?php echo $data['berat_badan']; ?></td>
			</tr>
			<tr>
				<th>Tekanan Darah </th>
				<td> : <?php echo $data['tekanan_darah']; ?></td>
			</tr>
			<tr>
				<th> Golongan Darah </th>
				<td> : <b>=<?php echo $data['golongan_darah']; ?>=</b></td>
			</tr>
			<!-- Table Body End -->
		</table>
	</div>
	<p class="pp1">Telah diperiksa di Puskesmas Tabak Kanilan Kecamatan Gunung Bintang Awai dengan hasil</p>
	<h1 class="pp2">"SEHAT"</h1><br>
	<p class="pp1">Demikian surat keterangan ini diberikan kepada yang bersangkutan untuk dapat dipergunakan sebagaimana mestinya.</p>
	<div class="mrd4">
		<table class="table table-hover table-borderless table-striped">
			<tr>
				<th>DIKELUARKAN DI</th>
				<td>: TABAK KANILAN</td>
			</tr>
			<tr style="margin-bottom:0;">
				<th>PADA TANGGAL</th>
				<td>: <?php echo $data['tanggal']; ?></td>
			</tr>
		</table>
		<table class="table table-hover table-borderless table-striped" style="width: auto;">
			<tr style="text-align: center;  border-top:1px solid #000;">
				<th>Dokter UPT Puskesmas Tabak Kanilan</th>
			</tr>
			<tr style="text-align: center;">
				<th>Kecamatan Gunung Bintang Awai,</th>
			</tr>
		</table>
	</div><br><br>
	<div class="mrd4">
		<table class="table table-hover table-borderless table-striped">
			<tr style="text-align: center;">
				<th><u><B><?php echo $data['nama_dokter']; ?></B></u></th>
			</tr>
			<tr style="text-align: center; ">
				<th>NIP. <?php echo $data['nip']; ?></th>
			</tr>
		</table>

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