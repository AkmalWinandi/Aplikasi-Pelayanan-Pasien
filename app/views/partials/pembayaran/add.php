<?php
$comp_model = new SharedController;
$page_element_id = "add-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
$show_header = $this->show_header;
$view_title = $this->view_title;
$redirect_to = $this->redirect_to;
?>
<?php
// Atur zona waktu sesuai dengan zona waktu komputer Anda
date_default_timezone_set('Asia/Jakarta');

// Mengambil tanggal dan waktu saat ini
$currentDateTime = date('Y-m-d H:i:s');

// Gunakan nilai $currentDateTime sesuai kebutuhan, misalnya:
$this->set_field_value('tanggal', $currentDateTime);
?>

<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="add" data-display-type="" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if ($show_header == true) {
    ?>
        <div class="bg-light p-3 mb-3">
            <div class="container">
                <div class="row ">
                    <div class="col ">
                        <h4 class="record-title">Tambah Pembayaran</h4>
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
                <div class="col-md-7 comp-grid">
                    <?php $this::display_page_errors(); ?>
                    <div class="bg-light p-3 animated fadeIn page-content">
                        <form id="pembayaran-add-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("pembayaran/add?csrf_token=$csrf_token") ?>" method="post">
                            <div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="kode_pembayaran">Kode Pembayaran <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input id="ctrl-kode_pembayaran" value="<?php echo $this->set_field_value('kode_pembayaran', ""); ?>" type="text" placeholder="Enter Kode Pembayaran" list="kode_pembayaran_list" required="" name="kode_pembayaran" data-url="api/json/pembayaran_kode_pembayaran_value_exist/" data-loading-msg="Checking availability ..." data-available-msg="Available" data-unavailable-msg="Not available" class="form-control  ctrl-check-duplicate" />
                                                <datalist id="kode_pembayaran_list">
                                                    <?php
                                                    $kode_pembayaran_options = $comp_model->pembayaran_kode_pembayaran_option_list();
                                                    if (!empty($kode_pembayaran_options)) {
                                                        foreach ($kode_pembayaran_options as $option) {
                                                            $value = (!empty($option['value']) ? $option['value'] : null);
                                                            $label = (!empty($option['label']) ? $option['label'] : $value);
                                                    ?>
                                                            <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </datalist>
                                                <div class="check-status"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="tanggal">Tanggal <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input id="ctrl-tanggal" class="form-control datepicker  datepicker" required="" value="<?php echo $this->set_field_value('tanggal', $currentDateTime); ?>" type="datetime" name="tanggal" placeholder="Enter Tanggal" data-enable-time="false" data-min-date="" data-max-date="" data-date-format="Y-m-d" data-alt-format="F j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="icon-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="nama_pasien">Nama Pasien <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input id="ctrl-nama_pasien" value="<?php echo $this->set_field_value('nama_pasien', ""); ?>" type="text" placeholder="Enter Nama Pasien" required="" name="nama_pasien" class="form-control " readonly />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="tindakan">Tindakan <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input id="ctrl-tindakan" value="<?php echo $this->set_field_value('tindakan', ""); ?>" type="text" placeholder="Enter Tindakan" required="" name="tindakan" class="form-control " readonly />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="jenis_rawat">Jenis Rawat <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input id="ctrl-jenis_rawat" value="<?php echo $this->set_field_value('jenis_rawat', ""); ?>" type="text" placeholder="Enter Jenis Rawat" required="" name="jenis_rawat" class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="total">Total <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input id="ctrl-total" value="<?php echo $this->set_field_value('total', ""); ?>" type="number" placeholder="Enter Total" step="1" required="" name="total" class="form-control " readonly />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-submit-btn-holder text-center mt-3">
                                <div class="form-ajax-status"></div>
                                <button class="btn btn-primary" type="submit">
                                    Submit
                                    <i class="icon-paper-plane"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function() {
        $('#ctrl-kode_pembayaran').change(function() {
            var selectedKodePembayaran = $(this).val();

            // Kirim permintaan AJAX
            $.ajax({
                url: 'get_kode_pembayaran/' + selectedKodePembayaran,
                data: {
                    kode_pembayaran: selectedKodePembayaran
                },
                dataType: 'json',
                success: function(response) {
                    // console.log(response.nama_lengkap)
                    $('#ctrl-nama_pasien').val(response.nama_lengkap)
                    $('#ctrl-tindakan').val(response.tindakan)
                    $('#ctrl-total').val(response.total)



                },
                error: function(xhr, status, error) {
                    console.error('Terjadi kesalahan: ', error);
                }
            });
        });
    });
</script>