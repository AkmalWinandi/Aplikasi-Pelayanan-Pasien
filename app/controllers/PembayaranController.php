<?php 
/**
 * Pembayaran Page Controller
 * @category  Controller
 */
class PembayaranController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "pembayaran";
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
			"kode_pembayaran", 
			"tanggal", 
			"nama_pasien", 
			"tindakan", 
			"jenis_rawat", 
			"total");
		$pagination = $this->get_pagination(10); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				pembayaran.id LIKE ? OR 
				pembayaran.kode_pembayaran LIKE ? OR 
				pembayaran.tanggal LIKE ? OR 
				pembayaran.nama_pasien LIKE ? OR 
				pembayaran.tindakan LIKE ? OR 
				pembayaran.jenis_rawat LIKE ? OR 
				pembayaran.total LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "pembayaran/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("pembayaran.id", ORDER_TYPE);
		}
		if($fieldname){
			$db->where($fieldname , $fieldvalue); //filter by a single field name
		}
		if(!empty($request->pembayaran_tanggal)){
			$vals = explode("-to-", str_replace(" ", "", $request->pembayaran_tanggal));
			$startdate = $vals[0];
			$enddate = $vals[1];
			$db->where("pembayaran.tanggal BETWEEN '$startdate' AND '$enddate'");
		}
		$tc = $db->withTotalCount();
		$records = $db->get($tablename, $pagination, $fields);
		$records_count = count($records);
		$total_records = intval($tc->totalCount);
		$page_limit = $pagination[1];
		$total_pages = ceil($total_records / $page_limit);
		if(	!empty($records)){
			foreach($records as &$record){
				$record['tanggal'] = format_date($record['tanggal'],'d-m-Y');
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
		$page_title = $this->view->page_title = "Pembayaran";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->view->report_hidden_fields = array('id');
		$this->render_view("pembayaran/list.php", $data); //render the full page
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
			"kode_pembayaran", 
			"tanggal", 
			"nama_pasien", 
			"tindakan", 
			"jenis_rawat", 
			"total");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("pembayaran.id", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$record['tanggal'] = format_date($record['tanggal'],'d-m-Y');
			$page_title = $this->view->page_title = "View  Pembayaran";
		$this->view->report_layout = "struk_pembayaran.php";
		$this->view->report_paper_size = "A6";
		$this->view->report_orientation = "portrait";
		$this->view->report_hidden_fields = array('tanggal');
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("pembayaran/view.php", $record);
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
			$fields = $this->fields = array("kode_pembayaran","tanggal","nama_pasien","tindakan","jenis_rawat","total");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'kode_pembayaran' => 'required',
				'tanggal' => 'required',
				'nama_pasien' => 'required',
				'tindakan' => 'required',
				'jenis_rawat' => 'required',
				'total' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'kode_pembayaran' => 'sanitize_string',
				'tanggal' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'tindakan' => 'sanitize_string',
				'jenis_rawat' => 'sanitize_string',
				'total' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			//Check if Duplicate Record Already Exit In The Database
			$db->where("kode_pembayaran", $modeldata['kode_pembayaran']);
			if($db->has($tablename)){
				$this->view->page_error[] = $modeldata['kode_pembayaran']." Already exist!";
			} 
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("pembayaran");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Pembayaran";
		$this->render_view("pembayaran/add.php");
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
		$fields = $this->fields = array("id","kode_pembayaran","tanggal","nama_pasien","tindakan","jenis_rawat","total");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'kode_pembayaran' => 'required',
				'tanggal' => 'required',
				'nama_pasien' => 'required',
				'tindakan' => 'required',
				'jenis_rawat' => 'required',
				'total' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'kode_pembayaran' => 'sanitize_string',
				'tanggal' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'tindakan' => 'sanitize_string',
				'jenis_rawat' => 'sanitize_string',
				'total' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			//Check if Duplicate Record Already Exit In The Database
			if(isset($modeldata['kode_pembayaran'])){
				$db->where("kode_pembayaran", $modeldata['kode_pembayaran'])->where("id", $rec_id, "!=");
				if($db->has($tablename)){
					$this->view->page_error[] = $modeldata['kode_pembayaran']." Already exist!";
				}
			} 
			if($this->validated()){
				$db->where("pembayaran.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("pembayaran");
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
						return	$this->redirect("pembayaran");
					}
				}
			}
		}
		$db->where("pembayaran.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Pembayaran";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("pembayaran/edit.php", $data);
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
		$db->where("pembayaran.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("pembayaran");
	}
	public function get_kode_pembayaran($kode_pembayaran)
	{
		$db = $this->GetModel();
		$fields = $this->fields = array("tanggal","id_pasien","nama_lengkap","kode_pembayaran","kunjungan","umum_bpjs","poli","tindakan","total","riwayat");
		$db->where("pendaftaran.kode_pembayaran", $kode_pembayaran);;
		$data = $db->getOne('pendaftaran', $fields);

		header('Content-Type: application/json');
		echo json_encode($data);
		exit;
	}
}
