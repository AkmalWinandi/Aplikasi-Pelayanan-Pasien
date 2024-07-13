<?php
$comp_model = new SharedController;
$page_element_id = "list-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
//Page Data From Controller
$view_data = $this->view_data;
$records = $view_data->records;
$record_count = $view_data->record_count;
$total_records = $view_data->total_records;
$field_name = $this->route->field_name;
$field_value = $this->route->field_value;
$view_title = $this->view_title;
$show_header = $this->show_header;
$show_footer = $this->show_footer;
$show_pagination = $this->show_pagination;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="list" data-display-type="table" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if ($show_header == true) {
    ?>
        <div class="bg-light p-3 mb-3">
            <div class="container-fluid">
                <div class="row ">
                    <div class="col ">
                        <form method="get" action="<?php print_link($current_page) ?>" class="form filter-form">
                            <div class="card mb-3">
                                <div class="card-header h4 h4">Filter Berdasarkan Tanggal</div>
                                <div class="p-2">
                                    <input class="form-control datepicker" value="<?php echo $this->set_field_value('surat_keterangan_sehat_tanggal') ?>" type="datetime" name="surat_keterangan_sehat_tanggal" placeholder="" data-enable-time="" data-date-format="Y-m-d" data-alt-format="M j, Y" data-inline="false" data-no-calendar="false" data-mode="range" />
                                </div>
                            </div>
                            <hr />
                            <div class="form-group text-center">
                                <button class="btn btn-primary">Filter</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-3 ">
                        <a class="btn btn btn-primary my-1" href="<?php print_link("surat_keterangan_sehat/add") ?>">
                            <i class="icon-plus"></i>
                            Tambah Surat Sehat
                        </a>
                    </div>
                    <div class="col-sm-4 ">
                        <form class="search" action="<?php print_link('surat_keterangan_sehat'); ?>" method="get">
                            <div class="input-group">
                                <input value="<?php echo get_value('search'); ?>" class="form-control" type="text" name="search" placeholder="Search" />
                                <div class="input-group-append">
                                    <button class="btn btn-primary"><i class="icon-magnifier"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12 comp-grid">
                        <div class="">
                            <!-- Page bread crumbs components-->
                            <?php
                            if (!empty($field_name) || !empty($_GET['search'])) {
                            ?>
                                <hr class="sm d-block d-sm-none" />
                                <nav class="page-header-breadcrumbs mt-2" aria-label="breadcrumb">
                                    <ul class="breadcrumb m-0 p-1">
                                        <?php
                                        if (!empty($field_name)) {
                                        ?>
                                            <li class="breadcrumb-item">
                                                <a class="text-decoration-none" href="<?php print_link('surat_keterangan_sehat'); ?>">
                                                    <i class="icon-arrow-left"></i>
                                                </a>
                                            </li>
                                            <li class="breadcrumb-item">
                                                <?php echo (get_value("tag") ? get_value("tag")  :  make_readable($field_name)); ?>
                                            </li>
                                            <li class="breadcrumb-item active text-capitalize font-weight-bold">
                                                <?php echo (get_value("label") ? get_value("label")  :  make_readable(urldecode($field_value))); ?>
                                            </li>
                                        <?php
                                        }
                                        ?>
                                        <?php
                                        if (get_value("search")) {
                                        ?>
                                            <li class="breadcrumb-item">
                                                <a class="text-decoration-none" href="<?php print_link('surat_keterangan_sehat'); ?>">
                                                    <i class="icon-arrow-left"></i>
                                                </a>
                                            </li>
                                            <li class="breadcrumb-item text-capitalize">
                                                Search
                                            </li>
                                            <li class="breadcrumb-item active text-capitalize font-weight-bold"><?php echo get_value("search"); ?></li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </nav>
                                <!--End of Page bread crumbs components-->
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    <div class="">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-md-12 comp-grid">
                    <?php $this::display_page_errors(); ?>
                    <div class="filter-tags mb-2">
                        <?php
                        if (!empty($_GET['surat_keterangan_sehat_tanggal'])) {
                        ?>
                            <div class="filter-chip card bg-light">
                                <b>Surat Keterangan Sehat Tanggal :</b>
                                <?php
                                $date_val = get_value('surat_keterangan_sehat_tanggal');
                                $formated_date = "";
                                if (str_contains('-to-', $date_val)) {
                                    //if value is a range date
                                    $vals = explode('-to-', str_replace(' ', '', $date_val));
                                    $startdate = $vals[0];
                                    $enddate = $vals[1];
                                    $formated_date = format_date($startdate, 'jS F, Y') . ' <span class="text-muted">&#10148;</span> ' . format_date($enddate, 'jS F, Y');
                                } elseif (str_contains(',', $date_val)) {
                                    //multi date values
                                    $vals = explode(',', str_replace(' ', '', $date_val));
                                    $formated_arrs = array_map(function ($date) {
                                        return format_date($date, 'jS F, Y');
                                    }, $vals);
                                    $formated_date = implode(' <span class="text-info">&#11161;</span> ', $formated_arrs);
                                } else {
                                    $formated_date = format_date($date_val, 'jS F, Y');
                                }
                                echo  $formated_date;
                                $remove_link = unset_get_value('surat_keterangan_sehat_tanggal', $this->route->page_url);
                                ?>
                                <a href="<?php print_link($remove_link); ?>" class="close-btn">
                                    &times;
                                </a>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class=" animated fadeIn page-content">
                        <div id="surat_keterangan_sehat-list-records">
                            <div id="page-report-body" class="table-responsive">
                                <table class="table  table-striped table-sm text-left">
                                    <thead class="table-header bg-light">
                                        <tr>
                                            <th class="td-checkbox">
                                                <label class="custom-control custom-checkbox custom-control-inline">
                                                    <input class="toggle-check-all custom-control-input" type="checkbox" />
                                                    <span class="custom-control-label"></span>
                                                </label>
                                            </th>
                                            <th class="td-sno">#</th>
                                            <th class="td-nomor_surat"><i class="icon-pin "></i> Nomor Surat</th>
                                            <th class="td-tanggal"><i class="icon-calendar "></i> Tanggal</th>
                                            <th class="td-nama_dokter"><i class="icon-user "></i> Nama Dokter</th>
                                            <th class="td-nip"><i class="icon-key "></i> Nip</th>
                                            <th class="td-pangkat_gol"><i class="icon-graduation "></i> Pangkat/Gol</th>
                                            <th class="td-jabatan"><i class="icon-trophy "></i> Jabatan</th>
                                            <th class="td-alamat_dokter"><i class="icon-map "></i> Alamat Dokter</th>
                                            <th class="td-nama_pasien"><i class="icon-user "></i> Nama Pasien</th>
                                            <th class="td-nik"><i class="icon-key "></i> Nik</th>
                                            <th class="td-umur"><i class="icon-hourglass "></i> Umur</th>
                                            <th class="td-jenis_kelamin"><i class="icon-people "></i> Jenis Kelamin</th>
                                            <th class="td-agama"><i class="icon-star "></i> Agama</th>
                                            <th class="td-alamat_pasien"><i class="icon-location-pin "></i> Alamat Pasien</th>
                                            <th class="td-keperluan"><i class="icon-speech "></i> Keperluan</th>
                                            <th class="td-tinggi_badan"><i class="icon-calculator "></i> Tinggi Badan</th>
                                            <th class="td-berat_badan"><i class="icon-calculator "></i> Berat Badan</th>
                                            <th class="td-tekanan_darah"><i class="icon-chemistry "></i> Tekanan Darah</th>
                                            <th class="td-golongan_darah"><i class="icon-heart "></i> Golongan Darah</th>
                                            <th class="td-btn"><i class="icon-rocket "></i>Aksi</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    if (!empty($records)) {
                                    ?>
                                        <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                            <!--record-->
                                            <?php
                                            $counter = 0;
                                            foreach ($records as $data) {
                                                $rec_id = (!empty($data['id']) ? urlencode($data['id']) : null);
                                                $counter++;
                                            ?>
                                                <tr>
                                                    <th class=" td-checkbox">
                                                        <label class="custom-control custom-checkbox custom-control-inline">
                                                            <input class="optioncheck custom-control-input" name="optioncheck[]" value="<?php echo $data['id'] ?>" type="checkbox" />
                                                            <span class="custom-control-label"></span>
                                                        </label>
                                                    </th>
                                                    <th class="td-sno"><?php echo $counter; ?></th>
                                                    <td class="td-nomor_surat"> <?php echo $data['nomor_surat']; ?></td>
                                                    <td class="td-tanggal"> <?php echo $data['tanggal']; ?></td>
                                                    <td class="td-nama_dokter"> <?php echo $data['nama_dokter']; ?></td>
                                                    <td class="td-nip"> <?php echo $data['nip']; ?></td>
                                                    <td class="td-pangkat_gol"> <?php echo $data['pangkat_gol']; ?></td>
                                                    <td class="td-jabatan"> <?php echo $data['jabatan']; ?></td>
                                                    <td class="td-alamat_dokter"> <?php echo $data['alamat_dokter']; ?></td>
                                                    <td class="td-nama_pasien"> <?php echo $data['nama_pasien']; ?></td>
                                                    <td class="td-nik"> <?php echo $data['nik']; ?></td>
                                                    <td class="td-umur"> <?php echo $data['umur']; ?></td>
                                                    <td class="td-jenis_kelamin"> <?php echo $data['jenis_kelamin']; ?></td>
                                                    <td class="td-agama"> <?php echo $data['agama']; ?></td>
                                                    <td class="td-alamat_pasien"> <?php echo $data['alamat_pasien']; ?></td>
                                                    <td class="td-keperluan"> <?php echo $data['keperluan']; ?></td>
                                                    <td class="td-tinggi_badan"> <?php echo $data['tinggi_badan']; ?></td>
                                                    <td class="td-berat_badan"> <?php echo $data['berat_badan']; ?></td>
                                                    <td class="td-tekanan_darah"> <?php echo $data['tekanan_darah']; ?></td>
                                                    <td class="td-golongan_darah"> <?php echo $data['golongan_darah']; ?></td>
                                                    <th class="td-btn">
                                                        <a class="btn btn-sm btn-success has-tooltip" title="View Record" href="<?php print_link("surat_keterangan_sehat/view/$rec_id"); ?>">
                                                            <i class="icon-eye"></i>
                                                        </a>
                                                        <a class="btn btn-sm btn-info has-tooltip" title="Edit This Record" href="<?php print_link("surat_keterangan_sehat/edit/$rec_id"); ?>">
                                                            <i class="icon-pencil"></i>
                                                        </a>
                                                        <a class="btn btn-sm btn-danger has-tooltip record-delete-btn" title="Delete this record" href="<?php print_link("surat_keterangan_sehat/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
                                                            <i class="icon-trash"></i>
                                                        </a>
                                                    </th>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                            <!--endrecord-->
                                        </tbody>
                                        <tbody class="search-data" id="search-data-<?php echo $page_element_id; ?>"></tbody>
                                    <?php
                                    }
                                    ?>
                                </table>
                                <?php
                                if (empty($records)) {
                                ?>
                                    <h4 class="bg-light text-center border-top text-muted animated bounce  p-3">
                                        <i class="icon-ban"></i> No record found
                                    </h4>
                                <?php
                                }
                                ?>
                            </div>
                            <?php
                            if ($show_footer && !empty($records)) {
                            ?>
                                <div class=" border-top mt-2">
                                    <div class="row justify-content-center">
                                        <div class="col-md-auto justify-content-center">
                                            <div class="p-3 d-flex justify-content-between">
                                                <button data-prompt-msg="Are you sure you want to delete these records?" data-display-style="modal" data-url="<?php print_link("surat_keterangan_sehat/delete/{sel_ids}/?csrf_token=$csrf_token&redirect=$current_page"); ?>" class="btn btn-sm btn-danger btn-delete-selected d-none">
                                                    <i class="icon-close"></i> Delete Selected
                                                </button>
                                                <?php $export_excel_link = $this->set_current_page_link(array('format' => 'excel')); ?>
                                                <a class="btn  btn-sm btn-primary export-link-btn" data-format="excel" href="<?php print_link($export_excel_link); ?>" target="_blank">
                                                    <img src="<?php print_link('assets/images/xsl.png') ?>" class="mr-2" /> EXCEL
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <?php
                                            if ($show_pagination == true) {
                                                $pager = new Pagination($total_records, $record_count);
                                                $pager->route = $this->route;
                                                $pager->show_page_count = true;
                                                $pager->show_record_count = true;
                                                $pager->show_page_limit = true;
                                                $pager->limit_count = $this->limit_count;
                                                $pager->show_page_number_list = true;
                                                $pager->pager_link_range = 5;
                                                $pager->render();
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>