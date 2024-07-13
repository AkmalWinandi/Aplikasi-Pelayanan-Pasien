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
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="view" data-display-type="table" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if ($show_header == true) {
    ?>
        <div class="bg-light p-3 mb-3">
            <div class="container">
                <div class="row ">
                    <div class="col ">
                        <h4 class="record-title">View Data Pasien</h4>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    <div class="">
        <div class="container">
            <div class="row ">
                <div class="col-md-12 comp-grid">
                    <?php $this::display_page_errors(); ?>
                    <div class="card animated fadeIn page-content">
                        <?php
                        $counter = 0;
                        if (!empty($data)) {
                            $rec_id = (!empty($data['id']) ? urlencode($data['id']) : null);
                            $counter++;
                        ?>
                            <div id="page-report-body" class="">
                                <table class="table table-hover table-borderless table-striped">
                                    <!-- Table Body Start -->
                                    <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                        <tr class="td-id_pasien">
                                            <th class="we"><i class="icon-key "></i> Id Pasien </th>
                                            <td class="value"> : <?php echo $data['id_pasien']; ?></td>
                                        </tr>
                                        <tr class="td-nama_lengkap">
                                            <th class="title"><i class="icon-user "></i> Nama Lengkap </th>
                                            <td class="value"> : <?php echo $data['nama_lengkap']; ?></td>
                                        </tr>
                                        <tr class="td-nama_lengkap">
                                            <th class="title"><i class="icon-key "></i> Nik </th>
                                            <td class="value"> : <?php echo $data['nik']; ?></td>
                                        </tr>
                                        <tr class="td-tanggal_lahir">
                                            <th class="title"><i class="icon-calendar "></i> Tanggal Lahir </th>
                                            <td class="value"> : <?php echo $data['tanggal_lahir']; ?></td>
                                        </tr>
                                        <tr class="td-jenis_kelamin">
                                            <th class="title"><i class="icon-people "></i> Jenis Kelamin </th>
                                            <td class="value"> : <?php echo $data['jenis_kelamin']; ?></td>
                                        </tr>
                                        <tr class="td-agama">
                                            <th class="title"><i class="icon-star "></i> Agama </th>
                                            <td class="value"> : <?php echo $data['agama']; ?></td>
                                        </tr>
                                        <tr class="td-pekerjaan">
                                            <th class="title"><i class="icon-wrench "></i> Pekerjaan </th>
                                            <td class="value"> : <?php echo $data['pekerjaan']; ?></td>
                                        </tr>
                                        <tr class="td-notelp">
                                            <th class="title"><i class="icon-phone "></i> Notelp </th>
                                            <td class="value"> : <?php echo $data['notelp']; ?></td>
                                        </tr>
                                    </tbody>
                                    <!-- Table Body End -->
                                </table>
                            </div>
                            <div class="p-3 d-flex">
                                <?php $export_print_link = $this->set_current_page_link(array('format' => 'print')); ?>
                                <a class="btn  btn-sm btn-primary export-link-btn" data-format="print" href="<?php print_link($export_print_link); ?>" target="_blank">
                                    <img src="<?php print_link('assets/images/print.png') ?>" class="mr-2" /> PRINT
                                </a>
                            </div>
                        <?php
                        } else {
                        ?>
                            <!-- Empty Record Message -->
                            <div class="text-muted p-3">
                                <i class="icon-ban"></i> No Record Found
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>