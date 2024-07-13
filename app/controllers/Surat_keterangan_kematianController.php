<?php 
/**
 * Surat_keterangan_kematian Page Controller
 * @category  Controller
 */
class Surat_keterangan_kematianController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "surat_keterangan_kematian";
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function index($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("id", 
			"nomor_surat", 
			"tanggal", 
			"nama_dokter", 
			"nip", 
			"jabatan", 
			"alamat_dokter", 
			"nama_pasien", 
			"jenis_kelamin", 
			"desa", 
			"keterangan");
		$pagination = $this->get_pagination(12); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				surat_keterangan_kematian.id LIKE ? OR 
				surat_keterangan_kematian.nomor_surat LIKE ? OR 
				surat_keterangan_kematian.tanggal LIKE ? OR 
				surat_keterangan_kematian.nama_dokter LIKE ? OR 
				surat_keterangan_kematian.nip LIKE ? OR 
				surat_keterangan_kematian.jabatan LIKE ? OR 
				surat_keterangan_kematian.alamat_dokter LIKE ? OR 
				surat_keterangan_kematian.nama_pasien LIKE ? OR 
				surat_keterangan_kematian.jenis_kelamin LIKE ? OR 
				surat_keterangan_kematian.desa LIKE ? OR 
				surat_keterangan_kematian.keterangan LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "surat_keterangan_kematian/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("surat_keterangan_kematian.id", ORDER_TYPE);
		}
		if($fieldname){
			$db->where($fieldname , $fieldvalue); //filter by a single field name
		}
		if(!empty($request->surat_keterangan_kematian_tanggal)){
			$vals = explode("-to-", str_replace(" ", "", $request->surat_keterangan_kematian_tanggal));
			$startdate = $vals[0];
			$enddate = $vals[1];
			$db->where("surat_keterangan_kematian.tanggal BETWEEN '$startdate' AND '$enddate'");
		}
		$tc = $db->withTotalCount();
		$records = $db->get($tablename, $pagination, $fields);
		$records_count = count($records);
		$total_records = intval($tc->totalCount);
		$page_limit = $pagination[1];
		$total_pages = ceil($total_records / $page_limit);
		if(	!empty($records)){
			foreach($records as &$record){
				$record['tanggal'] = format_date($record['tanggal'],'d-m-Y ');
			}
		}
		$data = new stdClass;
		$data->records = $records;
		$data->record_count = $records_count;
		$data->total_records = $total_records;
		$data->total_page = $total_pages;
		if($db->getLastError()){
			$this->set_page_error();
		}
		$page_title = $this->view->page_title = "Surat Keterangan Kematian";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("surat_keterangan_kematian/list.php", $data); //render the full page
	}
	/**
     * View record detail 
	 * @param $rec_id (select record by table primary key) 
     * @param $value value (select record by value of field name(rec_id))
     * @return BaseView
     */
	function view($rec_id = null, $value = null){
		$request = $this->request;
		$db = $this->GetModel();
		$rec_id = $this->rec_id = urldecode($rec_id);
		$tablename = $this->tablename;
		$fields = array("id", 
			"nomor_surat", 
			"tanggal", 
			"nama_dokter", 
			"nip", 
			"jabatan", 
			"alamat_dokter", 
			"nama_pasien", 
			"jenis_kelamin", 
			"desa", 
			"keterangan");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("surat_keterangan_kematian.id", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$record['tanggal'] = format_date($record['tanggal'],'d-m-Y ');
			$page_title = $this->view->page_title = "View  Surat Keterangan Kematian";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "sk_kematian.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->view->report_hidden_fields = array('nomor_surat', 'tanggal', 'nama_pasien', 'jenis_kelamin', 'desa', 'keterangan');
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("surat_keterangan_kematian/view.php", $record);
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function add($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("nomor_surat","tanggal","nama_dokter","nip","jabatan","alamat_dokter","nama_pasien","jenis_kelamin","desa","keterangan");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nomor_surat' => 'required',
				'tanggal' => 'required',
				'nama_dokter' => 'required',
				'nip' => 'required',
				'jabatan' => 'required',
				'alamat_dokter' => 'required',
				'nama_pasien' => 'required',
				'jenis_kelamin' => 'required',
				'desa' => 'required',
				'keterangan' => 'required',
			);
			$this->sanitize_array = array(
				'nomor_surat' => 'sanitize_string',
				'tanggal' => 'sanitize_string',
				'nama_dokter' => 'sanitize_string',
				'nip' => 'sanitize_string',
				'jabatan' => 'sanitize_string',
				'alamat_dokter' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'desa' => 'sanitize_string',
				'keterangan' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("surat_keterangan_kematian");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Surat Keterangan Kematian";
		$this->render_view("surat_keterangan_kematian/add.php");
	}
	/**
     * Update table record with formdata
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
     * @return array
     */
	function edit($rec_id = null, $formdata = null){
		$request = $this->request;
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$tablename = $this->tablename;
		 //editable fields
		$fields = $this->fields = array("id","nomor_surat","tanggal","nama_dokter","nip","jabatan","alamat_dokter","nama_pasien","jenis_kelamin","desa","keterangan");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nomor_surat' => 'required',
				'tanggal' => 'required',
				'nama_dokter' => 'required',
				'nip' => 'required',
				'jabatan' => 'required',
				'alamat_dokter' => 'required',
				'nama_pasien' => 'required',
				'jenis_kelamin' => 'required',
				'desa' => 'required',
				'keterangan' => 'required',
			);
			$this->sanitize_array = array(
				'nomor_surat' => 'sanitize_string',
				'tanggal' => 'sanitize_string',
				'nama_dokter' => 'sanitize_string',
				'nip' => 'sanitize_string',
				'jabatan' => 'sanitize_string',
				'alamat_dokter' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'desa' => 'sanitize_string',
				'keterangan' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("surat_keterangan_kematian.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("surat_keterangan_kematian");
				}
				else{
					if($db->getLastError()){
						$this->set_page_error();
					}
					elseif(!$numRows){
						//not an error, but no record was updated
						$page_error = "No record updated";
						$this->set_page_error($page_error);
						$this->set_flash_msg($page_error, "warning");
						return	$this->redirect("surat_keterangan_kematian");
					}
				}
			}
		}
		$db->where("surat_keterangan_kematian.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Surat Keterangan Kematian";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("surat_keterangan_kematian/edit.php", $data);
	}
	/**
     * Delete record from the database
	 * Support multi delete by separating record id by comma.
     * @return BaseView
     */
	function delete($rec_id = null){
		Csrf::cross_check();
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$this->rec_id = $rec_id;
		//form multiple delete, split record id separated by comma into array
		$arr_rec_id = array_map('trim', explode(",", $rec_id));
		$db->where("surat_keterangan_kematian.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("surat_keterangan_kematian");
	}
}
