<?php

/**
 * Pendaftaran Page Controller
 * @category  Controller
 */
class PendaftaranController extends SecureController
{
	function __construct()
	{
		parent::__construct();
		$this->tablename = "pendaftaran";
	}
	/**
	 * List page records
	 * @param $fieldname (filter record by a field) 
	 * @param $fieldvalue (filter field value)
	 * @return BaseView
	 */
	function index($fieldname = null, $fieldvalue = null)
	{
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array(
			"id",
			"tanggal",
			"id_pasien",
			"nama_lengkap",
			"kode_pembayaran",
			"kunjungan",
			"umum_bpjs",
			"poli",
			"tindakan",
			"total",
			"riwayat"
		);
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if (!empty($request->search)) {
			$text = trim($request->search);
			$search_condition = "(
				pendaftaran.id LIKE ? OR 
				pendaftaran.tanggal LIKE ? OR 
				pendaftaran.id_pasien LIKE ? OR 
				pendaftaran.nama_lengkap LIKE ? OR 
				pendaftaran.kode_pembayaran LIKE ? OR 
				pendaftaran.kunjungan LIKE ? OR 
				pendaftaran.umum_bpjs LIKE ? OR 
				pendaftaran.poli LIKE ? OR 
				pendaftaran.tindakan LIKE ? OR 
				pendaftaran.total LIKE ? OR 
				pendaftaran.riwayat LIKE ?
			)";
			$search_params = array(
				"%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			//template to use when ajax search
			$this->view->search_template = "pendaftaran/search.php";
		}
		if (!empty($request->orderby)) {
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		} else {
			$db->orderBy("pendaftaran.id", ORDER_TYPE);
		}
		if ($fieldname) {
			$db->where($fieldname, $fieldvalue); //filter by a single field name
		}
		if (!empty($request->pendaftaran_tanggal)) {
			$vals = explode("-to-", str_replace(" ", "", $request->pendaftaran_tanggal));
			$startdate = $vals[0];
			$enddate = $vals[1];
			$db->where("pendaftaran.tanggal BETWEEN '$startdate' AND '$enddate'");
		}
		$tc = $db->withTotalCount();
		$records = $db->get($tablename, $pagination, $fields);
		$records_count = count($records);
		$total_records = intval($tc->totalCount);
		$page_limit = $pagination[1];
		$total_pages = ceil($total_records / $page_limit);
		if (!empty($records)) {
			foreach ($records as &$record) {
				$record['tanggal'] = format_date($record['tanggal'], 'd-m-Y ');
			}
		}
		$data = new stdClass;
		$data->records = $records;
		$data->record_count = $records_count;
		$data->total_records = $total_records;
		$data->total_page = $total_pages;
		if ($db->getLastError()) {
			$this->set_page_error();
		}
		$page_title = $this->view->page_title = "Pelayanan";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "laporan_pendaftaran.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("pendaftaran/list.php", $data); //render the full page
	}
	/**
	 * View record detail 
	 * @param $rec_id (select record by table primary key) 
	 * @param $value value (select record by value of field name(rec_id))
	 * @return BaseView
	 */
	function view($rec_id = null, $value = null)
	{
		$request = $this->request;
		$db = $this->GetModel();
		$rec_id = $this->rec_id = urldecode($rec_id);
		$tablename = $this->tablename;
		$fields = array(
			"id",
			"id_pasien",
			"nama_lengkap",
			"kunjungan",
			"umum_bpjs",
			"poli",
			"tindakan",
			"riwayat",
			"kode_pembayaran"
		);
		if ($value) {
			$db->where($rec_id, urldecode($value)); //select record based on field name
		} else {
			$db->where("pendaftaran.id", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields);
		if ($record) {
			$page_title = $this->view->page_title = "View  Pendaftaran";
			$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
			$this->view->report_title = $page_title;
			$this->view->report_layout = "laporan_pendaftaran.php";
			$this->view->report_paper_size = "A4";
			$this->view->report_orientation = "portrait";
		} else {
			if ($db->getLastError()) {
				$this->set_page_error();
			} else {
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("pendaftaran/view.php", $record);
	}
	/**
	 * Insert new record to the database table
	 * @param $formdata array() from $_POST
	 * @return BaseView
	 */
	function add($formdata = null)
	{
		if ($formdata) {
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("tanggal", "id_pasien", "nama_lengkap", "kode_pembayaran", "kunjungan", "umum_bpjs", "poli", "tindakan", "total", "riwayat");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
				'id_pasien' => 'required',
				'nama_lengkap' => 'required',
				'kode_pembayaran' => 'required',
				'kunjungan' => 'required',
				'umum_bpjs' => 'required',
				'poli' => 'required',
				'tindakan' => 'required',
				'total' => 'required|numeric',
				'riwayat' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
				'id_pasien' => 'sanitize_string',
				'nama_lengkap' => 'sanitize_string',
				'kode_pembayaran' => 'sanitize_string',
				'kunjungan' => 'sanitize_string',
				'umum_bpjs' => 'sanitize_string',
				'poli' => 'sanitize_string',
				'tindakan' => 'sanitize_string',
				'total' => 'sanitize_string',
				'riwayat' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if ($this->validated()) {
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if ($rec_id) {
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("pendaftaran");
				} else {
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Pendaftaran";
		$this->render_view("pendaftaran/add.php");
	}
	/**
	 * Update table record with formdata
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
	 * @return array
	 */
	function edit($rec_id = null, $formdata = null)
	{
		$request = $this->request;
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$tablename = $this->tablename;
		//editable fields
		$fields = $this->fields = array("id", "tanggal", "id_pasien", "nama_lengkap", "kode_pembayaran", "kunjungan", "umum_bpjs", "poli", "tindakan", "total", "riwayat");
		if ($formdata) {
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
				'id_pasien' => 'required',
				'nama_lengkap' => 'required',
				'kode_pembayaran' => 'required',
				'kunjungan' => 'required',
				'umum_bpjs' => 'required',
				'poli' => 'required',
				'tindakan' => 'required',
				'total' => 'required|numeric',
				'riwayat' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
				'id_pasien' => 'sanitize_string',
				'nama_lengkap' => 'sanitize_string',
				'kode_pembayaran' => 'sanitize_string',
				'kunjungan' => 'sanitize_string',
				'umum_bpjs' => 'sanitize_string',
				'poli' => 'sanitize_string',
				'tindakan' => 'sanitize_string',
				'total' => 'sanitize_string',
				'riwayat' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if ($this->validated()) {
				$db->where("pendaftaran.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if ($bool && $numRows) {
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("pendaftaran");
				} else {
					if ($db->getLastError()) {
						$this->set_page_error();
					} elseif (!$numRows) {
						//not an error, but no record was updated
						$page_error = "No record updated";
						$this->set_page_error($page_error);
						$this->set_flash_msg($page_error, "warning");
						return	$this->redirect("pendaftaran");
					}
				}
			}
		}
		$db->where("pendaftaran.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Pendaftaran";
		if (!$data) {
			$this->set_page_error();
		}
		return $this->render_view("pendaftaran/edit.php", $data);
	}
	/**
	 * Delete record from the database
	 * Support multi delete by separating record id by comma.
	 * @return BaseView
	 */
	function delete($rec_id = null)
	{
		Csrf::cross_check();
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$this->rec_id = $rec_id;
		//form multiple delete, split record id separated by comma into array
		$arr_rec_id = array_map('trim', explode(",", $rec_id));
		$db->where("pendaftaran.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if ($bool) {
			$this->set_flash_msg("Record deleted successfully", "success");
		} elseif ($db->getLastError()) {
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("pendaftaran");
	}
	function getkode()
	{
		$db = $this->Getmodel();

		$data = $db->rawQueryOne("SELECT max(kode_pembayaran) as maxID FROM pendaftaran");

		$idMax = $data["maxID"];

		$noUrut = 0;

		if (!empty($idMax)) {
			$noUrut = (int)substr($idMax, 3, 5);
		}

		$noUrut++;
		$newID = "BYR" . sprintf("%05s", $noUrut);

		return $newID;
	}



	//autofill add
	public function get_nama_lengkap($id_pasien)
	{
		$db = $this->GetModel();
		$fields = $this->fields = array("id", "id_pasien", "nama_lengkap", "tanggal_lahir", "jenis_kelamin", "agama", "pekerjaan", "notelp");
		$db->where("data_pasien.id_pasien", $id_pasien);;
		$data = $db->getOne('data_pasien', $fields);

		header('Content-Type: application/json');
		echo json_encode($data);
		exit;
	}


	//harga

	public function get_harga($tindakan)
	{
		$db = $this->GetModel();
		$fields = array("id", "tindakan", "harga");

		// Pisahkan multiple values jika ada
		$tindakan_arr = explode(',', $tindakan);

		// Buat array untuk menyimpan harga untuk setiap tindakan
		$harga_arr = array();

		// Lakukan query untuk setiap tindakan yang dipilih
		foreach ($tindakan_arr as $tindakan) {
			$db->where("berobat.tindakan", $tindakan);
			$result = $db->getOne('berobat', $fields);
			if ($result) {
				$harga_arr[] = $result;
			}
		}

		header('Content-Type: application/json');
		echo json_encode($harga_arr);
	}
}
