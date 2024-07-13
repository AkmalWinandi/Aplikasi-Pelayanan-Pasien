<?php 

/**
 * SharedController Controller
 * @category  Controller / Model
 */
class SharedController extends BaseController{
	
	/**
     * user_username_value_exist Model Action
     * @return array
     */
	function user_username_value_exist($val){
		$db = $this->GetModel();
		$db->where("username", $val);
		$exist = $db->has("user");
		return $exist;
	}

	/**
     * user_password_value_exist Model Action
     * @return array
     */
	function user_password_value_exist($val){
		$db = $this->GetModel();
		$db->where("password", $val);
		$exist = $db->has("user");
		return $exist;
	}

	/**
     * user_email_value_exist Model Action
     * @return array
     */
	function user_email_value_exist($val){
		$db = $this->GetModel();
		$db->where("email", $val);
		$exist = $db->has("user");
		return $exist;
	}

	/**
     * pembayaran_kode_pembayaran_value_exist Model Action
     * @return array
     */
	function pembayaran_kode_pembayaran_value_exist($val){
		$db = $this->GetModel();
		$db->where("kode_pembayaran", $val);
		$exist = $db->has("pembayaran");
		return $exist;
	}

	/**
     * pembayaran_kode_pembayaran_option_list Model Action
     * @return array
     */
	function pembayaran_kode_pembayaran_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT kode_pembayaran AS value,kode_pembayaran AS label FROM pendaftaran";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * pembayaran_tindakan_option_list Model Action
     * @return array
     */
	function pembayaran_tindakan_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT tindakan AS value,tindakan AS label FROM berobat";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * pendaftaran_id_pasien_option_list Model Action
     * @return array
     */
	function pendaftaran_id_pasien_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id_pasien AS value,id_pasien AS label FROM data_pasien";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * pendaftaran_tindakan_option_list Model Action
     * @return array
     */
	function pendaftaran_tindakan_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT tindakan AS value,tindakan AS label FROM berobat";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
	* barchart_jumlahkunjunganpasien Model Action
	* @return array
	*/
	function barchart_jumlahkunjunganpasien(){
		
		$db = $this->GetModel();
		$chart_data = array(
			"labels"=> array(),
			"datasets"=> array(),
		);
		
		//set query result for dataset 1
		$sqltext = "SELECT  COUNT(p.poli) AS count_of_poli, MONTHNAME(p.tanggal) AS monthname_of_tanggal FROM pendaftaran AS p GROUP BY monthname_of_tanggal";
		$queryparams = null;
		$dataset1 = $db->rawQuery($sqltext, $queryparams);
		$dataset_data =  array_column($dataset1, 'count_of_poli');
		$dataset_labels =  array_column($dataset1, 'monthname_of_tanggal');
		$chart_data["labels"] = array_unique(array_merge($chart_data["labels"], $dataset_labels));
		$chart_data["datasets"][] = $dataset_data;

		return $chart_data;
	}

}
