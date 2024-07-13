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
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="view"  data-display-type="table" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-light p-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">View  Pembayaran</h4>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
    <div  class="">
        <div class="container">
            <div class="row ">
                <div class="col-md-12 comp-grid">
                    <?php $this :: display_page_errors(); ?>
                    <div  class="card animated fadeIn page-content">
                        <?php
                        $counter = 0;
                        if(!empty($data)){
                        $rec_id = (!empty($data['id']) ? urlencode($data['id']) : null);
                        $counter++;
                        ?>
                        <div id="page-report-body" class="">
                            <table class="table table-hover table-borderless table-striped">
                                <!-- Table Body Start -->
                                <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                    <tr  class="td-kode_pembayaran">
                                        <th class="title"><i class="icon-key "></i> Kode Pembayaran </th>
                                        <td class="value"> <?php echo $data['kode_pembayaran']; ?></td>
                                    </tr>
                                    <tr  class="td-tanggal">
                                        <th class="title"><i class="icon-calendar "></i> Tanggal </th>
                                        <td class="value"> <?php echo $data['tanggal']; ?></td>
                                    </tr>
                                    <tr  class="td-nama_pasien">
                                        <th class="title"><i class="icon-people "></i> Nama Pasien </th>
                                        <td class="value"> <?php echo $data['nama_pasien']; ?></td>
                                    </tr>
                                    <tr  class="td-tindakan">
                                        <th class="title"><i class="icon-heart "></i> Tindakan </th>
                                        <td class="value"> <?php echo $data['tindakan']; ?></td>
                                    </tr>
                                    <tr  class="td-jenis_rawat">
                                        <th class="title"><i class="icon-notebook "></i> Jenis Rawat </th>
                                        <td class="value"> <?php echo $data['jenis_rawat']; ?></td>
                                    </tr>
                                    <tr  class="td-total">
                                        <th class="title"><i class="icon-wallet "></i> Total: </th>
                                        <td class="value"><?php echo "Rp. " .number_format($data['total']); ?></td>
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
                            }
                            else{
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
