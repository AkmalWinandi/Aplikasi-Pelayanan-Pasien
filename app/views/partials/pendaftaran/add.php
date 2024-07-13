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
                        <h4 class="record-title">Tambah Pelayanan</h4>
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
                        <form id="pendaftaran-add-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("pendaftaran/add?csrf_token=$csrf_token") ?>" method="post">
                            <div>


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
                                            <label class="control-label" for="id_pasien">Id Pasien <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input id="ctrl-id_pasien" value="<?php echo $this->set_field_value('id_pasien', ""); ?>" type="text" placeholder="Enter Id Pasien" list="id_pasien_list" required="" name="id_pasien" class="form-control " />
                                                <datalist id="id_pasien_list">
                                                    <?php
                                                    $id_pasien_options = $comp_model->pendaftaran_id_pasien_option_list();
                                                    if (!empty($id_pasien_options)) {
                                                        foreach ($id_pasien_options as $option) {
                                                            $value = (!empty($option['value']) ? $option['value'] : null);
                                                            $label = (!empty($option['label']) ? $option['label'] : $value);
                                                    ?>
                                                            <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </datalist>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="nama_lengkap">Nama Lengkap <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input id="ctrl-nama_lengkap" value="<?php echo $this->set_field_value('nama_lengkap', ""); ?>" type="text" placeholder="Enter Nama Lengkap" required="" name="nama_lengkap" class="form-control " readonly />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $kode_controller = new PendaftaranController;
                                $kode = $kode_controller->getKode();
                                ?>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="kode_pembayaran">Kode Pembayaran <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input id="ctrl-kode_pembayaran" value="<?php echo $this->set_field_value('kode_pembayaran', $kode); ?>" type="text" placeholder="Enter Kode Pembayaran" required="" name="kode_pembayaran" class="form-control " readonly />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="kunjungan">Kunjungan <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <?php
                                                $kunjungan_options = Menu::$kunjungan;
                                                if (!empty($kunjungan_options)) {
                                                    foreach ($kunjungan_options as $option) {
                                                        $value = $option['value'];
                                                        $label = $option['label'];
                                                        //check if current option is checked option
                                                        $checked = $this->set_field_checked('kunjungan', $value, "");
                                                ?>
                                                        <label class="custom-control custom-radio custom-control-inline">
                                                            <input id="ctrl-kunjungan" class="custom-control-input" <?php echo $checked ?> value="<?php echo $value ?>" type="radio" required="" name="kunjungan" />
                                                            <span class="custom-control-label"><?php echo $label ?></span>
                                                        </label>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="umum_bpjs">Umum Bpjs <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <select required="" id="ctrl-umum_bpjs" name="umum_bpjs" value="<?php echo $this->set_field_value('umum_bpjs', ""); ?>" placeholder="Select a value ..." class="custom-select">
                                                    <option value="">Select a value ...</option>
                                                    <option value="umum">UMUM</option>
                                                    <option value="bpjs">BPJS</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="poli">Poli <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <select required="" id="ctrl-poli" name="poli" placeholder="Select a value ..." class="custom-select">
                                                    <option value="">Select a value ...</option>
                                                    <?php
                                                    $poli_options = Menu::$poli;
                                                    if (!empty($poli_options)) {
                                                        foreach ($poli_options as $option) {
                                                            $value = $option['value'];
                                                            $label = $option['label'];
                                                            $selected = $this->set_field_selected('poli', $value, "");
                                                    ?>
                                                            <option <?php echo $selected ?> value="<?php echo $value ?>">
                                                                <?php echo $label ?>
                                                            </option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
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
                                                <select required="" id="ctrl-tindakan" name="tindakan[]" placeholder="Select a value ..." multiple class="selectize">
                                                    <option value="">Select a value ...</option>
                                                    <?php
                                                    $tindakan_options = $comp_model->pendaftaran_tindakan_option_list();
                                                    if (!empty($tindakan_options)) {
                                                        foreach ($tindakan_options as $option) {
                                                            $value = (!empty($option['value']) ? $option['value'] : null);
                                                            $label = (!empty($option['label']) ? $option['label'] : $value);
                                                            $selected = $this->set_field_selected('tindakan', $value, "");
                                                    ?>
                                                            <option <?php echo $selected; ?> value="<?php echo $value; ?>">
                                                                <?php echo $label; ?>
                                                            </option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
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
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="riwayat">Riwayat <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <textarea placeholder="Enter Riwayat" id="ctrl-riwayat" required="" rows="5" name="riwayat" class=" form-control"><?php echo $this->set_field_value('riwayat', ""); ?></textarea>
                                                <!--<div class="invalid-feedback animated bounceIn text-center">Please enter text</div>-->
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
        $('#ctrl-id_pasien').change(function() {
            var selectedIdPasien = $(this).val();

            // Kirim permintaan AJAX
            $.ajax({
                url: 'get_nama_lengkap/' + selectedIdPasien,
                data: {
                    id_pasien: selectedIdPasien
                },
                dataType: 'json',
                success: function(response) {
                    // console.log(response.nama_lengkap)
                    $('#ctrl-nama_lengkap').val(response.nama_lengkap)

                },
                error: function(xhr, status, error) {
                    console.error('Terjadi kesalahan: ', error);
                }
            });
        });
    });

    $(document).ready(function() {
        // Fungsi untuk menghitung total harga berdasarkan tindakan yang dipilih
        function hitungTotalHarga() {
            var selectedTindakan = $('#ctrl-tindakan').val();

            // Mendapatkan nilai umum_bpjs yang dipilih
            var selectedUmumBpjs = $('#ctrl-umum_bpjs').val();

            // Jika opsi BPJS dipilih, set total menjadi 0
            if (selectedUmumBpjs === 'bpjs') {
                $('#ctrl-total').val('0');
                return; // Keluar dari fungsi
            }

            // Jika tidak ada tindakan yang dipilih, kosongkan total
            if (!selectedTindakan || selectedTindakan.length === 0) {
                $('#ctrl-total').val('');
                return; // Keluar dari fungsi
            }

            // Kirim permintaan AJAX untuk mendapatkan harga tindakan yang dipilih
            $.ajax({
                url: 'get_harga/' + selectedTindakan,
                data: {
                    tindakan: selectedTindakan
                },
                dataType: 'json',
                success: function(response) {
                    // Inisialisasi variabel untuk menyimpan total harga
                    var totalPrice = 0;

                    // Loop melalui setiap harga dalam respons dan tambahkan ke total
                    for (var i = 0; i < response.length; i++) {
                        totalPrice += parseFloat(response[i].harga);
                    }

                    // Atur nilai input teks total dengan total harga
                    $('#ctrl-total').val(totalPrice);
                },
                error: function(xhr, status, error) {
                    console.error('Terjadi kesalahan: ', error);
                }
            });
        }

        // Panggil fungsi hitungTotalHarga saat halaman dimuat
        hitungTotalHarga();

        // Panggil fungsi hitungTotalHarga ketika input tindakan diubah
        $('#ctrl-tindakan').change(hitungTotalHarga);
    });
</script>