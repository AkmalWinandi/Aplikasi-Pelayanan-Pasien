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
  <title>Struk Pembayaran </title>
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
      text-transform: uppercase;
      width: 60%;
      margin-left: 2rem;
      font-size: smaller;

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
      padding: 5px;
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
          <h4 style="font-weight: lighter;">PEMERINTAH KABUPATEN BARITO SELATAN</h4>
          <h3>UPTD PUSKESMAS TABAK KANILAN</h3>
          <h3>KECAMATAN GUNUNG BINTANG AWAI</h3>
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
    <h4><u>STRUK PEMBAYARAN</u></h4>
  </div>
  <div id="report-body">
    <?php
    $this->render_body();
    ?>
  </div>
  <div class="ttd">
    <table style="padding:0; margin-top:0; ">
      <tr>
        <th align="right" valign="middle" width="60">
          <p style="margin-right:2.5rem; margin-top:0; margin-bottom:3rem;">Admin</p>
          <p style="font-weight: lighter; font-size:24px;">(..................)</p>
        </th>
        </th>
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