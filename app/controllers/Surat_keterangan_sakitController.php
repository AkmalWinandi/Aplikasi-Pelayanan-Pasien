<?php

/**
 * Surat_keterangan_sakit Page Controller
 * @category  Controller
 */
class Surat_keterangan_sakitController extends SecureController
{
	function __construct()
	{
		parent::__construct();
		$this->tablename = "surat_keterangan_sakit";
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
			"jabatan",
			"alamat_dokter",
			"nama_pasien",
			"nik",
			"umur",
			"jenis_kelamin",
			"pekerjaan",
			"alamat_pasien",
			"keterangan"
		);
		$pagination = $this->get_pagination(12); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if (!empty($request->search)) {
			$text = trim($request->search);
			$search_condition = "(
				surat_keterangan_sakit.id LIKE ? OR 
				surat_keterangan_sakit.nomor_surat LIKE ? OR 
				surat_keterangan_sakit.tanggal LIKE ? OR 
				surat_keterangan_sakit.nama_dokter LIKE ? OR 
				surat_keterangan_sakit.nip LIKE ? OR 
				surat_keterangan_sakit.jabatan LIKE ? OR 
				surat_keterangan_sakit.alamat_dokter LIKE ? OR 
				surat_keterangan_sakit.nama_pasien LIKE ? OR 
				surat_keterangan_sakit.nik LIKE ? OR 
				surat_keterangan_sakit.umur LIKE ? OR 
				surat_keterangan_sakit.jenis_kelamin LIKE ? OR 
				surat_keterangan_sakit.pekerjaan LIKE ? OR 
				surat_keterangan_sakit.alamat_pasien LIKE ? OR 
				surat_keterangan_sakit.keterangan LIKE ?
			)";
			$search_params = array(
				"%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%", "%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			//template to use when ajax search
			$this->view->search_template = "surat_keterangan_sakit/search.php";
		}
		if (!empty($request->orderby)) {
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		} else {
			$db->orderBy("surat_keterangan_sakit.id", ORDER_TYPE);
		}
		if ($fieldname) {
			$db->where($fieldname, $fieldvalue); //filter by a single field name
		}
		if (!empty($request->surat_keterangan_sakit_tanggal)) {
			$vals = explode("-to-", str_replace(" ", "", $request->surat_keterangan_sakit_tanggal));
			$startdate = $vals[0];
			$enddate = $vals[1];
			$db->where("surat_keterangan_sakit.tanggal BETWEEN '$startdate' AND '$enddate'");
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
		$page_title = $this->view->page_title = "Surat Keterangan Sakit";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("surat_keterangan_sakit/list.php", $data); //render the full page
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
			"jabatan",
			"alamat_dokter",
			"nama_pasien",
			"nik",
			"umur",
			"jenis_kelamin",
			"pekerjaan",
			"alamat_pasien",
			"keterangan"
		);
		if ($value) {
			$db->where($rec_id, urldecode($value)); //select record based on field name
		} else {
			$db->where("surat_keterangan_sakit.id", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields);
		if ($record) {
			$record['tanggal'] = format_date($record['tanggal'], 'd-m-Y ');
			$page_title = $this->view->page_title = "View  Surat Keterangan Sakit";
			$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
			$this->view->report_title = $page_title;
			$this->view->report_layout = "sk_sakit.php";
			$this->view->report_paper_size = "A4";
			$this->view->report_orientation = "portrait";
			$this->view->report_hidden_fields = array('id', 'nomor_surat', 'tanggal', 'nama_pasien', 'nik', 'umur', 'jenis_kelamin', 'pekerjaan', 'keterangan', 'alamat_pasien');
		} else {
			if ($db->getLastError()) {
				$this->set_page_error();
			} else {
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("surat_keterangan_sakit/view.php", $record);
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
			$fields = $this->fields = array("nomor_surat", "tanggal", "nama_dokter", "nip", "jabatan", "alamat_dokter", "nama_pasien", "nik", "umur", "jenis_kelamin", "pekerjaan", "keterangan", "alamat_pasien");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nomor_surat' => 'required',
				'tanggal' => 'required',
				'nama_dokter' => 'required',
				'nip' => 'required',
				'jabatan' => 'required',
				'alamat_dokter' => 'required',
				'nama_pasien' => 'required',
				'nik' => 'required',
				'umur' => 'required|numeric',
				'jenis_kelamin' => 'required',
				'pekerjaan' => 'required',
				'keterangan' => 'required',
				'alamat_pasien' => 'required',
			);
			$this->sanitize_array = array(
				'nomor_surat' => 'sanitize_string',
				'tanggal' => 'sanitize_string',
				'nama_dokter' => 'sanitize_string',
				'nip' => 'sanitize_string',
				'jabatan' => 'sanitize_string',
				'alamat_dokter' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'nik' => 'sanitize_string',
				'umur' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'pekerjaan' => 'sanitize_string',
				'keterangan' => 'sanitize_string',
				'alamat_pasien' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if ($this->validated()) {
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if ($rec_id) {
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("surat_keterangan_sakit");
				} else {
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Surat Keterangan Sakit";
		$this->render_view("surat_keterangan_sakit/add.php");
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
		$fields = $this->fields = array("id", "nomor_surat", "tanggal", "nama_dokter", "nip", "jabatan", "alamat_dokter", "nama_pasien", "nik", "umur", "jenis_kelamin", "pekerjaan", "keterangan", "alamat_pasien");
		if ($formdata) {
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nomor_surat' => 'required',
				'tanggal' => 'required',
				'nama_dokter' => 'required',
				'nip' => 'required',
				'jabatan' => 'required',
				'alamat_dokter' => 'required',
				'nama_pasien' => 'required',
				'nik' => 'required',
				'umur' => 'required|numeric',
				'jenis_kelamin' => 'required',
				'pekerjaan' => 'required',
				'keterangan' => 'required',
				'alamat_pasien' => 'required',
			);
			$this->sanitize_array = array(
				'nomor_surat' => 'sanitize_string',
				'tanggal' => 'sanitize_string',
				'nama_dokter' => 'sanitize_string',
				'nip' => 'sanitize_string',
				'jabatan' => 'sanitize_string',
				'alamat_dokter' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'nik' => 'sanitize_string',
				'umur' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'pekerjaan' => 'sanitize_string',
				'keterangan' => 'sanitize_string',
				'alamat_pasien' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if ($this->validated()) {
				$db->where("surat_keterangan_sakit.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if ($bool && $numRows) {
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("surat_keterangan_sakit");
				} else {
					if ($db->getLastError()) {
						$this->set_page_error();
					} elseif (!$numRows) {
						//not an error, but no record was updated
						$page_error = "No record updated";
						$this->set_page_error($page_error);
						$this->set_flash_msg($page_error, "warning");
						return	$this->redirect("surat_keterangan_sakit");
					}
				}
			}
		}
		$db->where("surat_keterangan_sakit.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Surat Keterangan Sakit";
		if (!$data) {
			$this->set_page_error();
		}
		return $this->render_view("surat_keterangan_sakit/edit.php", $data);
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
		$db->where("surat_keterangan_sakit.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if ($bool) {
			$this->set_flash_msg("Record deleted successfully", "success");
		} elseif ($db->getLastError()) {
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("surat_keterangan_sakit");
	}
}
