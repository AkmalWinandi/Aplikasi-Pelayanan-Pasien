<?php

/**
 * Surat_keterangan_sehat Page Controller
 * @category  Controller
 */
class Surat_keterangan_sehatController extends SecureController
{
	function __construct()
	{
		parent::__construct();
		$this->tablename = "surat_keterangan_sehat";
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
			"nomor_surat",
			"tanggal",
			"nama_dokter",
			"nip",
			"pangkat_gol",
			"jabatan",
			"alamat_dokter",
			"nama_pasien",
			"nik",
			"umur",
			"jenis_kelamin",
			"agama",
			"alamat_pasien",
			"keperluan",
			"tinggi_badan",
			"berat_badan",
			"tekanan_darah",
			"golongan_darah"
		);
		$pagination = $this->get_pagination(12); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if (!empty($request->search)) {
			$text = trim($request->search);
			$search_condition = "(
				surat_keterangan_sehat.id LIKE ? OR 
				surat_keterangan_sehat.nomor_surat LIKE ? OR 
				surat_keterangan_sehat.tanggal LIKE ? OR 
				surat_keterangan_sehat.nama_dokter LIKE ? OR 
				surat_keterangan_sehat.nip LIKE ? OR 
				surat_keterangan_sehat.pangkat_gol LIKE ? OR 
				surat_keterangan_sehat.jabatan LIKE ? OR 
				surat_keterangan_sehat.alamat_dokter LIKE ? OR 
				surat_keterangan_sehat.nama_pasien LIKE ? OR 
				surat_keterangan_sehat.nik LIKE ? OR 
				surat_keterangan_sehat.umur LIKE ? OR 
				surat_keterangan_sehat.jenis_kelamin LIKE ? OR 
				surat_keterangan_sehat.agama LIKE ? OR 
				surat_keterangan_sehat.alamat_pasien LIKE ? OR 
				surat_keterangan_sehat.keperluan LIKE ? OR 
				surat_keterangan_sehat.tinggi_badan LIKE ? OR 
				surat_keterangan_sehat.berat_badan LIKE ? OR 
				surat_keterangan_sehat.tekanan_darah LIKE ? OR 
				surat_keterangan_sehat.golongan_darah LIKE ?
			)";
			$search_params = array(
				"%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			//template to use when ajax search
			$this->view->search_template = "surat_keterangan_sehat/search.php";
		}
		if (!empty($request->orderby)) {
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		} else {
			$db->orderBy("surat_keterangan_sehat.id", ORDER_TYPE);
		}
		if ($fieldname) {
			$db->where($fieldname, $fieldvalue); //filter by a single field name
		}
		if (!empty($request->surat_keterangan_sehat_tanggal)) {
			$vals = explode("-to-", str_replace(" ", "", $request->surat_keterangan_sehat_tanggal));
			$startdate = $vals[0];
			$enddate = $vals[1];
			$db->where("surat_keterangan_sehat.tanggal BETWEEN '$startdate' AND '$enddate'");
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
		$page_title = $this->view->page_title = "Surat Keterangan Sehat";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->view->report_hidden_fields = array('id');
		$this->render_view("surat_keterangan_sehat/list.php", $data); //render the full page
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
			"nomor_surat",
			"tanggal",
			"nama_dokter",
			"nip",
			"pangkat_gol",
			"jabatan",
			"alamat_dokter",
			"nama_pasien",
			"nik",
			"umur",
			"jenis_kelamin",
			"agama",
			"alamat_pasien",
			"keperluan",
			"tinggi_badan",
			"berat_badan",
			"tekanan_darah",
			"golongan_darah"
		);
		if ($value) {
			$db->where($rec_id, urldecode($value)); //select record based on field name
		} else {
			$db->where("surat_keterangan_sehat.id", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields);
		if ($record) {
			$record['tanggal'] = format_date($record['tanggal'], 'd-m-Y ');
			$page_title = $this->view->page_title = "View  Surat Keterangan Sehat";
			$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
			$this->view->report_title = $page_title;
			$this->view->report_layout = "sk_sehat.php";
			$this->view->report_paper_size = "A4";
			$this->view->report_orientation = "portrait";
			$this->view->report_hidden_fields = array('id', 'nomor_surat', 'tanggal', 'jenis_surat', 'nama_pasien', 'nik', 'umur', 'jenis_kelamin', 'agama', 'alamat_pasien', 'keperluan', 'tinggi_badan', 'berat_badan', 'tekanan_darah', 'golongan_darah');
		} else {
			if ($db->getLastError()) {
				$this->set_page_error();
			} else {
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("surat_keterangan_sehat/view.php", $record);
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
			$fields = $this->fields = array("nomor_surat", "tanggal", "nama_dokter", "nip", "pangkat_gol", "jabatan", "alamat_dokter", "nama_pasien", "nik", "umur", "jenis_kelamin", "agama", "alamat_pasien", "keperluan", "tinggi_badan", "berat_badan", "tekanan_darah", "golongan_darah");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nomor_surat' => 'required',
				'tanggal' => 'required',
				'nama_dokter' => 'required',
				'nip' => 'required',
				'pangkat_gol' => 'required',
				'jabatan' => 'required',
				'alamat_dokter' => 'required',
				'nama_pasien' => 'required',
				'nik' => 'required',
				'umur' => 'required|numeric',
				'jenis_kelamin' => 'required',
				'agama' => 'required',
				'alamat_pasien' => 'required',
				'keperluan' => 'required',
				'tinggi_badan' => 'required',
				'berat_badan' => 'required',
				'tekanan_darah' => 'required',
				'golongan_darah' => 'required',
			);
			$this->sanitize_array = array(
				'nomor_surat' => 'sanitize_string',
				'tanggal' => 'sanitize_string',
				'nama_dokter' => 'sanitize_string',
				'nip' => 'sanitize_string',
				'pangkat_gol' => 'sanitize_string',
				'jabatan' => 'sanitize_string',
				'alamat_dokter' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'nik' => 'sanitize_string',
				'umur' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'agama' => 'sanitize_string',
				'alamat_pasien' => 'sanitize_string',
				'keperluan' => 'sanitize_string',
				'tinggi_badan' => 'sanitize_string',
				'berat_badan' => 'sanitize_string',
				'tekanan_darah' => 'sanitize_string',
				'golongan_darah' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if ($this->validated()) {
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if ($rec_id) {
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("surat_keterangan_sehat");
				} else {
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Surat Keterangan Sehat";
		$this->render_view("surat_keterangan_sehat/add.php");
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
		$fields = $this->fields = array("id", "nomor_surat", "tanggal", "nama_dokter", "nip", "pangkat_gol", "jabatan", "alamat_dokter", "nama_pasien", "nik", "umur", "jenis_kelamin", "agama", "alamat_pasien", "keperluan", "tinggi_badan", "berat_badan", "tekanan_darah", "golongan_darah");
		if ($formdata) {
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nomor_surat' => 'required',
				'tanggal' => 'required',
				'nama_dokter' => 'required',
				'nip' => 'required',
				'pangkat_gol' => 'required',
				'jabatan' => 'required',
				'alamat_dokter' => 'required',
				'nama_pasien' => 'required',
				'nik' => 'required',
				'umur' => 'required|numeric',
				'jenis_kelamin' => 'required',
				'agama' => 'required',
				'alamat_pasien' => 'required',
				'keperluan' => 'required',
				'tinggi_badan' => 'required',
				'berat_badan' => 'required',
				'tekanan_darah' => 'required',
				'golongan_darah' => 'required',
			);
			$this->sanitize_array = array(
				'nomor_surat' => 'sanitize_string',
				'tanggal' => 'sanitize_string',
				'nama_dokter' => 'sanitize_string',
				'nip' => 'sanitize_string',
				'pangkat_gol' => 'sanitize_string',
				'jabatan' => 'sanitize_string',
				'alamat_dokter' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'nik' => 'sanitize_string',
				'umur' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'agama' => 'sanitize_string',
				'alamat_pasien' => 'sanitize_string',
				'keperluan' => 'sanitize_string',
				'tinggi_badan' => 'sanitize_string',
				'berat_badan' => 'sanitize_string',
				'tekanan_darah' => 'sanitize_string',
				'golongan_darah' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if ($this->validated()) {
				$db->where("surat_keterangan_sehat.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if ($bool && $numRows) {
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("surat_keterangan_sehat");
				} else {
					if ($db->getLastError()) {
						$this->set_page_error();
					} elseif (!$numRows) {
						//not an error, but no record was updated
						$page_error = "No record updated";
						$this->set_page_error($page_error);
						$this->set_flash_msg($page_error, "warning");
						return	$this->redirect("surat_keterangan_sehat");
					}
				}
			}
		}
		$db->where("surat_keterangan_sehat.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Surat Keterangan Sehat";
		if (!$data) {
			$this->set_page_error();
		}
		return $this->render_view("surat_keterangan_sehat/edit.php", $data);
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
		$db->where("surat_keterangan_sehat.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if ($bool) {
			$this->set_flash_msg("Record deleted successfully", "success");
		} elseif ($db->getLastError()) {
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("surat_keterangan_sehat");
	}
}
