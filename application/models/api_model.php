<?php
class api_model extends CI_Model{
	
	public $table_contacts = 'contacts';
	public $table_company = 'company';
	public $table_api_users = 'api_users';
	
	function __construct() { 
		parent::__construct();
	}
	
	public function getAccountInfo($loginID){
		$query = $this->db->select('id,name')->from($this->table_api_users)->where('user_login',$loginID)->where('status',1)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();  
        }
		return $data;
	}
	
	public function checkClient($loginID,$hashKey){
		$query = $this->db->select('count(id) as apiUser')->from($this->table_api_users)->where('user_login',$loginID)->where('secret_key',$hashKey)->where('status',1)->get();
		$data = false;
		if ($query->num_rows() > 0) {
            $row = $query->first_row();         
			if($row->apiUser>0){
				$data = true;
			}
        }
		return $data;
	}
	
	public function getAPIContactList($noOfRecords=500,$Offset=0){
		$totalRecords = 0;
		$queryTotal = $this->db->select('count(c.id) as totalRecords')->from($this->table_contacts.' as c')->join($this->table_company.' as co', 'co.id = c.company_id')->get();		
		if ($queryTotal->num_rows() > 0) {
			$row  = $queryTotal->first_row();
			$totalRecords = $row->totalRecords;
		}
		$data = array('totalRecords'=>$totalRecords,'contacts'=>array(),'headings'=>array(array('name'=>'id','code'=>'id'),array('name'=>'Name','code'=>'name'),array('name'=>'Company Name','code'=>'company_name'),array('name'=>'Title','code'=>'job_title'),array('name'=>'Email','code'=>'email'),array('name'=>'Work Phone','code'=>'phone'),array('name'=>'Cell Phone','code'=>'telephone'),array('name'=>'Linkedin Url','code'=>'linkedin_url')));				
		$this->db->limit($noOfRecords,$Offset);
		$query = $this->db->select("c.id,CONCAT((c.first_name),(' '),(c.last_name)) as name,co.company_name as company_name,c.job_title,c.email,c.phone,c.telephone,c.linkedin_url")->from($this->table_contacts.' as c')->join($this->table_company.' as co', 'co.id = c.company_id')->get();	
		/*echo $this->db->last_query();*/
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$data['contacts'][] = $row;
			}
		}		
		return $data;
	}
}
?>