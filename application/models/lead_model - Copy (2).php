<?php
class lead_model extends CI_Model{
	
	public $table_lead = 'litigations';
	public $table_comment = 'other_comments';
	public $table_box = 'box_list';
    public $table_history = 'history';
    public $table = 'users'; 
   	public $table_assign_lead = 'assign_leads';	
	public $table_assign_lead_type = 'assign_lead_type';
	public $table_gmail = "messages_gmail";
	public $table_requests = 'approval_requests';
	public $table_chart = "lead_chart";
	public $table_acquisition = "acquisition";
	public $table_stage = 'lead_stages';
	public $table_level = 'lead_levels';
	public $table_report = 'lead_reports';
	public $table_lead_open_project = 'lead_open_project';
	public $table_buttons = 'buttons';
	public $table_lead_buttons = 'lead_buttons';
	public $table_lead_event = 'lead_event';
	public $table_docket_buttons = 'docket_buttons';
	public $table_contacts_access = 'contacts_access';
	public $table_task_conversation = 'task_conversation';
	public $table_task_flag = 'task_message_flag';
	public $table_contacts = 'contacts';
	public $table_company = 'company';
	public $table_invitees = 'backyard_invitees';
	public $table_sales_activity = 'sales_activity_log_detail';
	public $table_presale_broker = 'presale_broker';
	public $table_presales_activity = 'presale_activity_log_detail';
	public $table_acquisition_company = 'acquisition_company';
	public $table_acquisition_activity = 'acquisition_activity_log_detail';
	public $table_lead_template = 'lead_template_files';
	public $table_precontacts = 'pre_contacts';
	public $table_precompanies = 'pre_companies';
	public $table_free_precontacts = 'free_precontacts';
	public $table_litigation_scrap = 'litigation_scrap';
	public $table_campaign = 'campaigns';
	public $table_campaign_list = 'campaign_sender_lists';
	public $table_sector = "sectors";
	public $table_company_sector = 'company_sector';
	public $table_campaign_process = 'campaign_process';
	public $table_sales_broker_lead_company = 'sales_broker_lead_company';
	public $table_activity_log = 'activity_log_detail';
	public $table_linkedin_query = 'linkedin_query';
	public $table_category = 'category';
	public $table_preference = 'preferences';
	public $table_temp_contacts = 'temp_contacts';
	public $table_map_sectors_departments = 'map_sectors_departments';
	public $table_user_logtime = 'user_logtime';
	public $table_email_raw = 'email_raw';
	public $table_lead_patent = 'lead_patent';
	public $table_lead_patent_family = 'lead_patent_family';
	public $table_lead_patent_scrap_data = 'lead_patent_scrap_data';
	public $table_lead_patent_family_diagram = 'lead_patent_family_diagram';
	public $table_due_dilligence_illustrations = 'due_dilligence_illustrations';
	public $table_due_dilligence_inventions = 'due_dilligence_inventions';
	public $table_due_dilligence_legal = 'due_dilligence_legal';
	public $table_due_dilligence_pdf = 'due_dilligence_pdf';
	public $table_licenses = 'licenses';
	public $table_comparables = 'comparables';
	public $table_invitees_due = 'invitees';
	public $table_chart_lefts = 'chart_lefts';
	public $table_due_dilligences = 'due_dilligences';
	public $table_job_queue = 'job_queue';
	public $table_damages = 'damages';
	public $table_request_to_participate = 'request_to_participates';
	public $table_potential_participates = 'potential_participates';
	public $table_customer_request = 'customer_request';
	public $table_commitments = 'commitments';
	public $table_revised_documents = 'revised_documents';
	public $table_patent_family_illustration = 'patent_family_illustration';
	public $table_lead_patent_family_parent_child = 'lead_patent_family_parent_child';
	public $table_patent_illustration_detail = 'patent_illustration_detail';
	public $table_family_patent_relation = 'lead_patent_family_relation';
	public $table_patent_family_member = 'lead_patent_family_member';
	public $sOpen = array();
	public $myAllRelationList = array();
	public $myAllRelationDataList = array();
	public $myAllDetailList = array();
	public function __construct() {
		parent::__construct();			
	}
	
	function getMergePreContactsAndContact(){
		/*truncate table temp*/
		$this->db->query("TRUNCATE ".$this->table_temp_contacts);
		/*INSERT DATA FROM  CONTACTS*/
		$this->db->query("INSERT INTO ".$this->table_temp_contacts."(`first_name`,`last_name`,`company_name`,`job_title`,`email`,`telephone`,`cellphone`,`linkedin_url`,`img_card`,`contact_type`,`contact_id`) SELECT c.first_name,c.last_name,co.company_name,c.job_title,c.email,c.telephone,c.phone,c.linkedin_url,c.img_card,1,c.id FROM ".$this->table_contacts." as c INNER JOIN ".$this->table_company." as co ON co.id = c.company_id");
		/*INSERT DATA FROM  PRECONTACTS*/
		$this->db->query("INSERT INTO ".$this->table_temp_contacts."(`first_name`,`last_name`,`company_name`,`job_title`,`email`,`telephone`,`cellphone`,`linkedin_url`,`img_card`,`contact_type`,`contact_id`) SELECT c.first_name,c.last_name,c.company_name,c.job_title,c.email,c.telephone,c.cellphone,c.profile_url,c.img_card,0,c.id FROM ".$this->table_precontacts." as c");		
		/*$query = $this->db->query("SELECT i.id, i.first_name,i.last_name,i.job_title,i.company_name,i.contact_id,i.contact_type FROM ".$this->table_temp_contacts." i
INNER JOIN (
 SELECT last_name
    FROM ".$this->table_temp_contacts."
    GROUP BY last_name,first_name
    HAVING COUNT( id ) > 1
) j ON i.last_name=j.last_name order by i.last_name");*/
		/*$query = $this->db->query("SELECT distinct(i.contact_id),i.id, i.first_name,i.last_name,i.job_title,i.email,i.telephone,i.cellphone,i.linkedin_url,i.company_name,i.img_card,i.contact_type FROM ".$this->table_temp_contacts." i
INNER JOIN (
 SELECT last_name
    FROM ".$this->table_temp_contacts."
    GROUP BY last_name,first_name
    HAVING COUNT( id ) > 1
) j ON i.last_name=j.last_name  INNER JOIN (SELECT first_name  FROM ".$this->table_temp_contacts."   GROUP BY first_name,last_name    HAVING  COUNT( id ) > 1) j1 
	ON i.first_name=j1.first_name   order by i.first_name ASC , i.last_name ASC");*/
		$preQuery = $this->db->query('SELECT id, first_name, last_name    FROM '.$this->table_temp_contacts.'    GROUP BY last_name,first_name HAVING  COUNT( id ) > 1');		
		$data = array();
		if ($preQuery->num_rows() > 0) {			
			foreach($preQuery->result() as $row){ 
				$postQuery = $this->db->query('SELECT distinct(i.contact_id),i.id, i.first_name,i.last_name,i.job_title,i.email,i.telephone,i.cellphone,i.linkedin_url,i.company_name,i.img_card,i.contact_type    FROM '.$this->table_temp_contacts.'  as i WHERE trim(i.first_name) = "'.trim($row->first_name).'" AND trim(i.last_name) = "'.trim($row->last_name).'"');		
				if ($postQuery->num_rows() > 1) {
					foreach($postQuery->result() as $postRow){ 
						$data[] = $postRow;
					}
				}				
			}
		}
		return $data;
	}
	
	public function findPatentChildFamily($patent){
		$data = array('links'=>array(),'details'=>array(),'main'=>array());
		$lengthString = strlen($patent);
		$first2Digit = "";
		switch($lengthString){
			case 9:
				$patentData =substr($patent,2);
				$first2Digit = substr($patent,0,2);
			break;
			case 11:
			case 13:
				$first2Digit = substr($patent,0,2);
				$patentData =substr($patent,2);
				$patentData =substr($patentData,0,-2);
			break;
			default:
				$patentData = $patent;
			break;
		}
		if(isset($patentData) && !empty($patentData) && strlen($patentData)==7 && ($first2Digit=="" || strtolower($first2Digit)=="us")){
			$queryPatent = $this->db->select('*')->from($this->table_patent_illustration_detail)->where('patent_app_number',$patentData)->get();
			if ($queryPatent->num_rows() > 0) {	
				$mainPatentDetail = $queryPatent->first_row();
				$data['main'] = $mainPatentDetail;
				/*Find patent child*/	
				$parentList = array();
				$childList = array();
			}
		}
	}
	
	public function findPatentFamilyChild($patent){
		$data = array('links'=>array(),'details'=>array(),'main'=>array(),'all_datas'=>array());
		$lengthString = strlen($patent);
		$first2Digit = "";
		switch($lengthString){
			case 9:
				$patentData =substr($patent,2);
				$first2Digit = substr($patent,0,2);
			break;
			case 11:
			case 13:
				$first2Digit = substr($patent,0,2);
				$patentData =substr($patent,2);
				$patentData =substr($patentData,0,-2);
			break;
			default:
				$patentData = $patent;
			break;
		}
		if(isset($patentData) && !empty($patentData) && strlen($patentData)==7 && ($first2Digit=="" || strtolower($first2Digit)=="us")){				
			$queryPatent = $this->db->select('*')->from($this->table_patent_illustration_detail)->where('patent_app_number',$patentData)->get();
			
			if ($queryPatent->num_rows() > 0) {	
				/*$data['details'] = $queryPatent->first_row();*/				
				$mainPatentDetail = $queryPatent->first_row();
				
				$data['main'] = $mainPatentDetail;
				/*Find patent child*/	
				$parentList = array();
				$childList = array();
				$patentParentList = $this->db->select('*')->from($this->table_lead_patent_family_parent_child)->where('patent_app_number',$mainPatentDetail->application_number)->where('parent',1)->order_by('id','ASC')->get();
				array_push($this->myAllRelationDataList,array('id'=>(int)$this->filterInt($mainPatentDetail->application_number),'description'=> $mainPatentDetail->application_number, 'email'=> "", 'groupTitleColor'=> "#4169e1", 'image'=>"", 'itemTitleColor'=> "#4169e1", 'phone'=> "",'relation_number'=>$mainPatentDetail->application_number , 'title'=> $mainPatentDetail->patent_app_number, 'label'=> $mainPatentDetail->patent_app_number));
				if ($patentParentList->num_rows() > 0) {	
					$myParents = array();
					foreach($patentParentList->result() as $row){
						$parentList[] = $row;
						array_push($this->sOpen,$row->patent_app_number);
						/*array_push($this->sOpen,$row->relation_number);*/
						array_push($this->myAllRelationList,$row);
						$myParents[] = (int)$this->filterInt($row->relation_number);
					}
					array_push($this->myAllRelationDataList,array('id'=>(int)$this->filterInt($mainPatentDetail->application_number), 'parent'=>$myParents,'description'=> $mainPatentDetail->application_number, 'email'=> "", 'groupTitleColor'=> "#4169e1", 'image'=>"", 'itemTitleColor'=> "#4169e1", 'phone'=> "",'relation_number'=>$mainPatentDetail->application_number , 'title'=> $mainPatentDetail->patent_app_number, 'label'=> $mainPatentDetail->patent_app_number));
				}
				$patentChildList = $this->db->select('*')->from($this->table_lead_patent_family_parent_child)->where('patent_app_number',$mainPatentDetail->application_number)->where('child',1)->order_by('id','ASC')->get();
				if ($patentChildList->num_rows() > 0) {	
					foreach($patentChildList->result() as $row){
						$childList[] = $row;
						/*array_push($this->sOpen,$row->relation_number);*/
						array_push($this->myAllRelationList,$row);
						/*array_push($this->myAllRelationDataList,array('id'=>$this->filterInt($row->relation_number), 'parent'=>array($this->filterInt($mainPatentDetail->application_number)),'description'=> $row->relation_number, 'email'=> "", 'groupTitleColor'=> "#4169e1", 'image'=>"", 'itemTitleColor'=> "#4169e1", 'phone'=> "",'relation_number'=>$row->relation_number , 'title'=> $row->relation_number, 'label'=> $row->relation_number));*/
					}
				}
				
				if(count($childList)>0){
					$this->findMyParentChildRelation($childList);
				}
				if(count($parentList)>0){
					$this->findMyParentChildRelation($childList);
				}
				
				$allDetails = array();
				if(count($this->myAllRelationList)>0){
					$detailsListNumber = array();
					foreach($this->myAllRelationList as $relationList){
						$detailsListNumber[] = $relationList->patent_app_number;
						$detailsListNumber[] = $relationList->relation_number;
					}
					$childDetails = $this->db->select('distinct(application_number) as appNumber, d.*')->from($this->table_patent_illustration_detail.' as d')->where_in('application_number',$detailsListNumber)->get();
					if ($childDetails->num_rows() > 0) {	
						foreach($childDetails->result() as $row){
							$allDetails[] = $row;
						}
					}
				}
				$data['links'] = $this->myAllRelationList;
				$data['all_datas'] = $this->myAllRelationDataList;
				$data['details'] = $allDetails;			
			}
		}
		return $data;
	}
	
	function checkSopen($number){
		$enter = false;
		if(count($this->sOpen)>0){
			foreach($this->sOpen as $open){
				if($this->filterInt($open)==$this->filterInt($number)){
					$enter = true;
				}
			}
		}
		return $enter;
	}
	
	function filterInt($number){
		return filter_var($number, FILTER_SANITIZE_NUMBER_INT);
		/*return preg_replace("/[^0-9]/","",$number);*/
	}
	
	function findMyParentChildRelation($dataArray){
		if(count($dataArray)>0){
			foreach($dataArray as $dA){
				$parentList = array();
				$childList = array();
				$checkEntryLevel = $this->checkSopen($dA->relation_number);
				if($checkEntryLevel==false){
					$patentParentList = $this->db->select('id,patent_app_number,relation_number,parent,child,relation_type')->from($this->table_lead_patent_family_parent_child)->where('patent_app_number',$dA->relation_number)->where('parent',1)->order_by('id','ASC')->get();
					array_push($this->sOpen,$dA->relation_number);
					if ($patentParentList->num_rows() > 0) {
						$myParents = array();
						foreach($patentParentList->result() as $row){
							$pNumber = $this->filterInt($row->patent_app_number);
							$rNumber = $this->filterInt($row->relation_number);
							$enter = false;
							if($pNumber!=$rNumber){
								if(count($this->myAllRelationList)>0){
									foreach($this->myAllRelationList as $mR){
										if(($this->filterInt($mR->patent_app_number)==$rNumber && $this->filterInt($mR->relation_number)==$pNumber) && ((int)$mR->parent==(int)$row->child) && ((int)$mR->child==(int)$row->parent)){
											$enter = true;break;
										}
									}
								}
							} else {
								$enter = true;
							}
							if($enter == false){
								$parentList[] = $row;	
								$myParents[] = (int) $this->filterInt($row->relation_number);
								array_push($this->myAllRelationList,$row);							
							}						
						}
						if(count($myParents)>0){
							array_push($this->myAllRelationDataList,array('id'=>(int)$this->filterInt($dA->relation_number), 'parent'=>$myParents,'description'=> $dA->relation_number, 'email'=> "", 'groupTitleColor'=> "#4169e1", 'image'=>"", 'itemTitleColor'=> "#4169e1", 'phone'=> "", 'title'=> $dA->relation_number, 'relation_number'=>$dA->relation_number ,'label'=> $dA->relation_number));
						}
						
					}
					$patentChildList = $this->db->select('id,patent_app_number,relation_number,parent,child,relation_type')->from($this->table_lead_patent_family_parent_child)->where('patent_app_number',$dA->relation_number)->where('child',1)->order_by('id','ASC')->get();
					if ($patentChildList->num_rows() > 0) {	
						foreach($patentChildList->result() as $row){
							$pNumber = $this->filterInt($row->patent_app_number);
							$rNumber = $this->filterInt($row->relation_number);
							$enter = false;
							if($pNumber!=$rNumber){
								if(count($this->myAllRelationList)>0){
									foreach($this->myAllRelationList as $mR){
										if(($this->filterInt($mR->patent_app_number)==$rNumber && $this->filterInt($mR->relation_number)==$pNumber) && ((int)$mR->parent==(int)$row->child) && ((int)$mR->child==(int)$row->parent)){
											$enter = true;break;
										}
									}
								}
							} else {
								$enter = true;
							}						
							if($enter == false){
								$childList[] = $row;
								array_push($this->myAllRelationList,$row);
								/*array_push($this->myAllRelationDataList,array('id'=>$this->filterInt($row->relation_number), 'parent'=>array($this->filterInt($dA->relation_number)),'description'=> $row->relation_number, 'email'=> "", 'groupTitleColor'=> "#4169e1", 'image'=>"", 'itemTitleColor'=> "#4169e1", 'phone'=> "",'relation_number'=>$row->relation_number ,'title'=> $row->relation_number, 'label'=> $row->relation_number));*/
							}
						}
					}
					if(count($parentList)>0){					
						$this->findMyParentChildRelation($parentList);
					}
					if(count($childList)>0){					
						$this->findMyParentChildRelation($childList);
					}
				}
			}
		}
	}
	
	public function findMyParentDetails($dataArray){
		if(count($dataArray)>0){
			for($i=0;$i<count($dataArray);$i++){
				$findChild = $this->db->select("relation_number,relation_type")->from($this->table_lead_patent_family_parent_child)->where('patent_app_number',$dataArray[$i]['number_id'])->where('child',1)->order_by('id','ASC')->get();
				echo $this->db->last_query()."<br/>";
				if($findChild->num_rows()>0){
					foreach($findChild->result() as $rowChild){
						$arrayChild = array('number_id'=>$rowChild->relation_number,'details'=>array(),'parent_relation'=>$rowChild->relation_type,'message'=>'','child'=>array(),'parent'=>array());						
						$childDetails = $this->db->select('*')->from($this->table_patent_illustration_detail)->where('patent_app_number',$rowChild->relation_number)->get();
						echo $this->db->last_query()."<br/>";
						if ($childDetails->num_rows() > 0) {
							$arrayChild['details'] = $childDetails->first_row();
						}
						array_push($dataArray[$i]['child'],$arrayChild);
					}
				}
				$findParent = $this->db->select("relation_number,relation_type")->from($this->table_lead_patent_family_parent_child)->where('patent_app_number',$dataArray[$i]['number_id'])->where('parent',1)->order_by('id','ASC')->get();
				echo $this->db->last_query()."<br/>";
				if($findParent->num_rows()>0){
					foreach($findParent->result() as $rowParent){
						$arrayParent = array('number_id'=>$rowParent->relation_number,'details'=>array(),'parent_relation'=>$rowParent->relation_type,'message'=>'','child'=>array(),'parent'=>array());
						$parentDetails = $this->db->select('*')->from($this->table_patent_illustration_detail)->where('patent_app_number',$rowParent->relation_number)->get();
						echo $this->db->last_query()."<br/>";
						if ($parentDetails->num_rows() > 0) {
							$arrayParent['details'] = $childDetails->first_row();
						}
						array_push($dataArray[$i]['parent'],$arrayParent);
					}
				}
				if(count($dataArray[$i]['parent'])>0){
					$dataArray[$i]['parent'] = $this->findMyParentDetails($dataArray[$i]['parent']);
				}
				if(count($dataArray[$i]['child'])>0){
					$dataArray[$i]['child'] = $this->findMyParentDetails($dataArray[$i]['child']);
				}
			}
		}
		return $dataArray;
	}

	public function getLeadPatentFamilyData($leadID){
		$data = array('child_count'=>0,'child_detail'=>0,'child_total'=>0);
		$leadOldPatentList = $this->db->select('patent_number,id')->from($this->table_lead_patent)->where('lead_id',$leadID)->get();
		if ($leadOldPatentList->num_rows() > 0) {	
			$childPatent = [];
			$parentPatent = [];
			$childTotal = 0;
			foreach($leadOldPatentList->result() as $row){				
				$getMyChild = $this->db->select('distinct(child_number) as child_number ,id,scrap_status')->from($this->table_lead_patent_family)->where('parent_number',$row->patent_number)->get();
				if ($getMyChild->num_rows() > 0) {	
					$data['child_total'] = $data['child_total'] + $getMyChild->num_rows();
					foreach($getMyChild->result() as $rowChild){ 
						if((int)$rowChild->scrap_status==1){
							$childPatent[] = $rowChild->child_number;
						}
					}
				}
				$parentPatent[] = $row->patent_number;				
			}
			$allPatent = array_merge($childPatent,$parentPatent);
			if(count($childPatent)>0){
				$data['child_count'] = count($childPatent);
			}
			if(count($allPatent)>0){
				$allPatentQuery = $this->db->select('distinct(patent_number) as patent_number,b_citations,f_citations,expired,application,title,current_assignee,original_assignee,priority,status')->from($this->table_lead_patent_scrap_data)->where_in('patent_number',$allPatent)->get();
				$childArray = array();
				foreach($allPatentQuery->result() as $rowChild){ 
					$childArray[] = $rowChild;
				}
				$data['child_detail'] = $childArray;
			}
		}
		return $data;
	}
	
	function getAllEPOFamilies($leadID){
		$data = array('family'=>array(),'publications'=>array());
		$queryPatent = $this->db->select('distinct(lp.patent_number) as patent_number')->from($this->table_lead_patent.' as lp')->where('lp.lead_id',$leadID)->get();
		if ($queryPatent->num_rows() > 0) {	
			$family = array();
			foreach($queryPatent->result() as $rowParent){
				$patent = $rowParent->patent_number;
				if(strlen($patent)==11 || strlen($patent)==13){
					$patent = substr($patent,0,-2);
				}
				$allPatentQuery = $this->db->select('distinct(fpr.family_id) as familyID')->from($this->table_family_patent_relation.' as fpr')->where('fpr.patent_id',$patent)->order_by('fpr.id','DESC')->get();
				/*echo $this->db->last_query();*/
				if ($allPatentQuery->num_rows() > 0) {
					foreach($allPatentQuery->result() as $rowChild){ 
						$data['family'][] = $rowChild;
						$family[] = $rowChild->familyID;
					}		
				}
			}
			if(count($family)>0){
				$allPatentQuery = $this->db->select('fm.publication_country,fm.publication_number as publication_number, fm.application_number as application_number,fm.application_country')->from($this->table_patent_family_member.' as fm')->where_in('fm.family_id',$family)->order_by('fm.id','DESC')->get();
				/*echo $this->db->last_query();*/
				if ($allPatentQuery->num_rows() > 0) {
					foreach($allPatentQuery->result() as $rowChild){ 
						$data['publications'][] = $rowChild;
					}		
				}
			}
		}
		return $data;
	}
	
	function getAllEPOFamiliesByPatent($patent){
		$data = array('family'=>array(),'publications'=>array());
		if(strlen($patent)==11 || strlen($patent)==13){
			$patent = substr($patent,0,-2);
		}
		$family = array();
		$allPatentQuery = $this->db->select('distinct(fpr.family_id) as familyID')->from($this->table_family_patent_relation.' as fpr')->where('fpr.patent_id',$patent)->order_by('fpr.id','DESC')->get();
		/*echo $this->db->last_query();*/
		if ($allPatentQuery->num_rows() > 0) {
			foreach($allPatentQuery->result() as $rowChild){ 
				$data['family'][] = $rowChild;
				$family[] = $rowChild->familyID;
			}		
		}
		if(count($family)>0){
			$allPatentQuery = $this->db->select('fm.publication_country,fm.publication_number as publication_number, fm.application_number as application_number,fm.application_country')->from($this->table_patent_family_member.' as fm')->where_in('fm.family_id',$family)->order_by('fm.id','DESC')->get();
			/*echo $this->db->last_query();*/
			if ($allPatentQuery->num_rows() > 0) {
				foreach($allPatentQuery->result() as $rowChild){ 
					$data['publications'][] = $rowChild;
				}		
			}
		}
		return $data;
	}
	
	public function getLeadPatentParentData($leadID){
		/*$data = array('child_count'=>0,'child_detail'=>0);*/
		$data = array();
		$queryPatent = $this->db->select('distinct(lp.patent_number) as patent_number')->from($this->table_lead_patent.' as lp')->where('lp.lead_id',$leadID)->get();
		if ($queryPatent->num_rows() > 0) {	
			foreach($queryPatent->result() as $rowParent){
				$allPatentQuery = $this->db->select('distinct(sd.patent_number) as patent_number,b_citations,f_citations,expired,application,title,current_assignee,original_assignee,priority,status')->from($this->table_lead_patent_scrap_data.' as sd')->where('sd.patent_number',$rowParent->patent_number)->order_by('sd.id','DESC')->limit(1)->get();
				/*echo $this->db->last_query();*/
				if ($allPatentQuery->num_rows() > 0) {	
					$data[] = $allPatentQuery->first_row();			
				}
			}
		}
		return $data;
	}
	
	
	public function leadOldPatentListWithFamily($leadID){
		$leadOldPatentList = $this->db->select('patent_number,id')->from($this->table_lead_patent)->where('lead_id',$leadID)->get();
		if ($leadOldPatentList->num_rows() > 0) {			
			foreach($leadOldPatentList->result() as $row){ 
				/*Find Child*/
				$allPatent = [];
				$allId = [];
				$getMyChild = $this->db->select('child_number,id')->from($this->table_lead_patent_family)->where('parent_number',$row->patent_number)->get();
				if ($getMyChild->num_rows() > 0) {			
					foreach($getMyChild->result() as $rowChild){ 
						$allPatent[] = $rowChild->child_number;
						$allId[] = $rowChild->id;
					}
				}
				$allPatent[] = $row->patent_number;
				if(count($allPatent)>0){
					$this->db->where_in('patent_number',$allPatent);
					$this->db->delete($this->table_lead_patent_scrap_data);					
				}
				if(count($allId)>0){
					$this->db->where_in('parent_number',$row->patent_number);
					$this->db->delete($this->table_lead_patent_family);
					$this->db->where_in('id',$allId);
					$this->db->delete($this->table_lead_patent_family_diagram);
				}
				
				$this->db->where('id',$row->id);
				$this->db->delete($this->table_lead_patent);	
			}			
		}
	}
	
	public function insertLeadPatentBulk($allAssets,$leadID){
		/*allAssets in array*/
		if(count($allAssets)>0){
			$insertArrayBulk = array();
			foreach($allAssets as $patent){
				$asset = "";
				if(isset($patent['patents'])){
					$asset = $patent['patents'];
				} else if(isset($patent['patent'])){
					$asset = $patent['patent'];
				} else if(isset($patent['assets'])){
					$asset = $patent['assets'];
				}
				if(!empty($asset)){
					$insertArrayBulk[] = array('patent_number'=>$asset,'lead_id'=>$leadID);
				}				
			}
			if(count($insertArrayBulk)>0){
				$this->db->insert_batch($this->table_lead_patent,$insertArrayBulk);
			}
		}		
	}
	
	public function findJobDetails($jobID,$select){
		$data = array();
		$jobData = $this->db->select($select)->from($this->table_job_queue)->where('id',$jobID)->get();
		if ($jobData->num_rows() > 0) {	
			$data = $jobData->first_row();
		}
		return $data;
	}
	
	public function checkPendingJobByLead($leadID){
		$data = array();
		$jobData = $this->db->select($select)->from($this->table_job_queue)->where('account',$leadID)->where('status',0)->where('type','Patent_Family')->where('module_name','Patent_Family')->order_by('id','desc')->get();
		if ($jobData->num_rows() > 0) {	
			$data = $jobData->first_row();
		}
		return $data;
	}
	
	public function findJobDetailsByLead($jobID,$select){
		$data = array();
		$jobData = $this->db->select($select)->from($this->table_job_queue)->where('id',$jobID)->order_by('id','DESC')->limit(1)->get();
		if ($jobData->num_rows() > 0) {	
			$data = $jobData->first_row();
		}
		return $data;
	}
	
	public function getLeadPatentList($leadID){
		$leadPatentList = $this->db->select('patent_number as patent,id')->from($this->table_lead_patent)->where('lead_id',$leadID)->get();
		$data =  array();
		if ($leadPatentList->num_rows() > 0) {	
			foreach($leadPatentList->result() as $leadPatent){ 
				$data[] = $leadPatent;
			}
		}
		return $data;
	}
	
	public function getLeadPatentDataList($leadID){
		$data =  array('count'=>0,'data'=>array());
		$leadPatentCount = $this->db->select("count(id) as patentCount")->from($this->table_lead_patent)->where('lead_id',$leadID)->get();
		if ($leadPatentCount->num_rows() > 0) {	
			$rowData = $leadPatentCount->first_row();
			$data['count'] =  $rowData->patentCount;
		}
		$leadPatentDetails = $this->db->select('*')->from($this->table_lead_patent_scrap_data.' as sd')->join($this->table_lead_patent.' as lp', 'lp.patent_number=sd.patent_number')->where('lp.scrap_status',1)->where('lp.lead_id',$leadID)->get();
		if ($leadPatentDetails->num_rows() > 0) {	
			foreach($leadPatentDetails->result() as $leadPatent){ 
				$data['data'][] = $leadPatent;
			}
		}
		return $data;
	}
	
	public function insertLeadPatentFamilyBulk($data){
		if(count($data)>0){
			$this->db->insert_batch($this->table_lead_patent_family,$data);
		}
		return $this->db->affected_rows();
	}
	
	public function updatePotentialInBatch($data){
		if(count($data)>0){
			$this->db->update_batch($this->table_potential_participates,$data,'id');
		}
		return $this->db->affected_rows();
	}
	
	
	
	public function insertLeadPatentScrapData($data){
		$this->db->insert($this->table_lead_patent_scrap_data, $data);
		return $this->db->insert_id();
	}
	
	public function insertFamilyDiagram($data){
		$this->db->insert($this->table_lead_patent_family_diagram, $data);
		return $this->db->insert_id();
	}
	
	public function insertJobQueue($data){
		$this->db->insert($this->table_job_queue, $data);
		return $this->db->insert_id();
	}
	
	public function updateLeadPatentByPatentNumber($data,$patentNumber){
		$this->db->where("patent_number",$patentNumber);
		$this->db->update($this->table_lead_patent,$data);
		return $this->db->affected_rows();
	}
	
	public function insertLinkedInQuery($data){
		$this->db->insert($this->table_linkedin_query, $data);
		return $this->db->insert_id();
	}
	
	public function updateLinkedInQuery($data,$id){
		$this->db->where("id",$id);
		$this->db->update($this->table_linkedin_query,$data);
		return $this->db->affected_rows();
	}
	
	public function insertOpenProjectData($data){
		$this->db->insert($this->table_lead_open_project, $data);
		return $this->db->insert_id();
	}
	
	public function addEmailRawData($data){
		$this->db->insert($this->table_email_raw, $data);
		return $this->db->insert_id();
	}
	
	public function insertActivityLog($data){
		$this->db->insert($this->table_activity_log, $data);
		return $this->db->insert_id();
	}
	
	public function insertPreSalesBrokerLeadCompany($data){
		$this->db->insert($this->table_presale_broker, $data);
		return $this->db->insert_id();
	}
	
	public function insertSalesBrokerLeadCompany($data){
		$this->db->insert($this->table_sales_broker_lead_company, $data);
		return $this->db->insert_id();
	}
	
	public function deleteSalesBrokerLeadCompany($data){
		$this->db->where('lead_id',$data['lead_id']);
		$this->db->where('sales_company_id',$data['sales_company_id']);
		$this->db->delete($this->table_sales_broker_lead_company);
		return $this->db->affected_rows();
	}
	
	public function insertCampaignProcess($data){
		$this->db->insert($this->table_campaign_process, $data);
		return $this->db->insert_id();
	}
	
	function deleteCampaignProcess($id){
		$query = $this->db->select('count(cl.id) as countID')->from($this->table_campaign_process.' as cp')->join($this->table_campaign_list.' as cl','cl.campaign_id = cp.campaign_id')->where('cp.id',$id)->where('send','0')->get();
		if($query->num_rows()>0){
			$count = $query->first_row();
			if($count->countID==0){
				$this->db->where('id',$id);
				$this->db->delete($this->table_campaign_process);
				return $this->db->affected_rows();
			} else {
				return 1;
			}
		} else {
			return 1;
		}
	}
	
	
	public function insertFreePreContacts($data){
		$this->db->insert($this->table_free_precontacts, $data);
		return $this->db->insert_id();
	}
	
	
	public function findEmailDate($id){
		$result = $this->db->select('date_received')->from($this->table_box)->where('id',$id)->get();
		if($result->num_rows()>0){
			$data = $result->first_row();
			return $data->date_received;
		} else {
			return date('Y-m-d H:i:s');
		}
	}
	
	public function insertLitigationScrap($data){
		$this->db->insert($this->table_litigation_scrap, $data);
		return $this->db->insert_id();
	}
	
	function deleteLitigationScrap($id){
		$this->db->where('id',$id);
		$this->db->delete($this->table_litigation_scrap);
		return $this->db->affected_rows();
	}
	
	function deleteFreePreContact($id){
		$this->db->where('id',$id);
		$this->db->delete($this->table_free_precontacts);
		return $this->db->affected_rows();
	}
	
	public function updateSalesCompanyStage($leadID,$contactID,$data){
		$this->db->where("lead_id",$leadID);
		$this->db->where("contact_id",$contactID);
		$this->db->update($this->table_invitees,$data);
		return $this->db->affected_rows();
	}
	
	public function updateAcquisitionCompanyStage($leadID,$contactID,$data){
		$this->db->where("lead_id",$leadID);
		$this->db->where("contact_id",$contactID);
		$this->db->update($this->table_acquisition_company,$data);
		return $this->db->affected_rows();
	}
	
	public function updateOpenProjectData($data,$id){
		$this->db->where("id",$id);
		$this->db->update($this->table_lead_open_project,$data);
		return $this->db->affected_rows();
	}
	
	public function updateOpenProjectDataByLeadType($leadID,$type,$data=array()){
		$this->db->where("lead_id",$leadID);
		$this->db->where("type",$type);
		$updata = array();
		if(count($data)>0){
			$updata = $data;
		} else {
			$updata = array('status'=>1);
		}
		$this->db->update($this->table_lead_open_project,$updata);
		/*echo $this->db->last_query()."<br/>";*/
		return $this->db->affected_rows();
	}
	
	public function deleteOpenProjectData($id){
		$this->db->where("id",$id);
		$this->db->delete($this->table_lead_open_project);
		return $this->db->affected_rows();
	}
	
	public function insertCampaign($data){
		$this->db->insert($this->table_campaign, $data);
		return $this->db->insert_id();
	}
	
	public function insertCampaignList($data){
		$this->db->insert($this->table_campaign_list, $data);
		return $this->db->insert_id();
	}
	
	public function updateCampaignList($campainID,$email,$data){
		$this->db->where("campaign_id",$campainID);
		$this->db->where("address",$email);
		$this->db->update($this->table_campaign_list,$data);
	}
	
	public function delete_address_from_campaign($campaignID,$email){
		$this->db->where("campaign_id",$campaignID);
		$this->db->where("address",$email);
		$this->db->delete($this->table_campaign_list);
		return $this->db->affected_rows();
	}
	
	public function checkCampaignProcess($campaignID){
		$data = $this->db->select('count(cp.id) as countID')->from($this->table_campaign_process.' as cp')->where('campaign_id',$campaignID)->get()->row->countID;
		return $data;
	}
	
	public function findLeadIdFromProcess($processID){
		$data = $this->db->select('cp.lead_id')->from($this->table_campaign_process.' as cp')->where('id',$processID)->get()->row->lead_id;
		return $data;
	}
	
	public function findLastOpenProject($leadID,$projectType,$status){
		$query = $this->db->select('c.email,c.secondary_email')->from($this->table_lead_open_project.' as cp')->join($this->table_contacts.' as c','c.id = cp.contact_id')->where('lead_id',$leadID)->where('type',$projectType)->where('status',$status)->limit(1)->order_by('cp.id','desc')->get();
		$data = array();
		if($query->num_rows()>0){
			$data = $query->first_row();
		}
		return $data;
	}
	
	public function getLinkedinQueryData(){
		$query = $this->db->select('id,title,keyword')->from($this->table_linkedin_query.' as cp')->get();
		$data = array();
		if($query->num_rows()>0){
			$data = $query->first_row();
		}
		return $data;
	}
	
	public function getCampaignListByEmailInProccess($email,$campaignID){
		$data = array();
		$query = $this->db->select('distinct(cp.campaign_id) as campaign_id, cp.id as campaignProcessID,cl.address,cp.subject,cp.type,cp.user_id,cp.main_activity,cp.campaign_date,cp.lead_id,cl.id as campaignListID')->from($this->table_campaign_process.' as cp')->join($this->table_campaign_list.' as cl','cl.campaign_id = cp.campaign_id')->where('(cl.send="1") AND (cl.proccessed = 0 OR cl.proccessed IS null)')->where('address',$email)->where('cl.campaign_id',$campaignID)->order_by("cp.id","DESC")->get();
		/*echo $this->db->last_query();*/
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row){ 
				$data[] = $row;
			}
		}
		return $data;
	}
	
	public function getRecentCampaignProcess(){
		$data = array();
		$query = $this->db->select('distinct(cp.campaign_id) as campaign_id, cp.id as campaignProcessID,cl.address,cp.subject,cp.type,cp.user_id,cp.main_activity,cp.campaign_date,cp.lead_id,cl.id as campaignListID')->from($this->table_campaign_process.' as cp')->join($this->table_campaign_list.' as cl','cl.campaign_id = cp.campaign_id')->where('(cl.send="1") AND (cl.proccessed = 0 OR cl.proccessed IS null)')->order_by("cp.id","DESC")->get();
		/*echo $this->db->last_query();*/
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row){ 
				$data[] = $row;
			}
		}
		return $data;
	}
	
	public function getCampaign($id=0,$campaignType=0){
		$data= array();
		if($id==0 && $campaignType>0){
			$query = $this->db->select("*")->from($this->table_campaign)->where('id IN (SELECT distinct(campaign_id) FROM '.$this->table_campaign_list.' WHERE send=0)')->where("campaign_type",$campaignType)->order_by("start_date","DESC")->get();
			if ($query->num_rows() > 0) {
				foreach($query->result() as $row){ 
					$data[] = $row;
				}
			}
		} else if($id>0){
			$query = $this->db->select("*")->from($this->table_campaign)->where("id",$id)->get();
			if ($query->num_rows() > 0) {
				$campaign = $query->first_row();
				$list = array();
				$query = $this->db->select("*")->from($this->table_campaign_list)->where("campaign_id",$campaign->id)->where('send',0)->get();
				if ($query->num_rows() > 0) {
					foreach($query->result() as $row){
						$list[] = $row;
					}
				}
				$data = array("campaign"=>$campaign,"list"=>$list);
			}
		}
		return $data;
	}
	
	public function saveTaskConversation($data){
		$this->db->insert($this->table_task_conversation, $data);
		return $this->db->insert_id();
	}
	
	public function saveLeadEvent($data){
		$this->db->insert($this->table_lead_event, $data);
		return $this->db->insert_id();
	}
	
	public function saveTaskConversationFlag($data){
		/*$this->deleteTaskConversation($data['task_id']);*/
		$this->db->insert($this->table_task_flag, $data);
		return $this->db->insert_id();
	}
	
	public function saveLeadTemplate($data){
		$this->db->insert($this->table_lead_template, $data);
		return $this->db->insert_id();
	}
	
	public function deleteTaskConversation($taskID){
		$this->db->where('task_id',$taskID);
		$this->db->delete($this->table_task_flag);
	}
	
	function deleteLeadTemplate($id){
		$this->db->where('id',$id);
		$this->db->delete($this->table_lead_template);
		return $this->db->affected_rows();
	}
	
	function getLeadTemplates($leadID,$type=0){
		$boxQuery = $this->db->select("*")->from($this->table_lead_template)->where('lead_id',$leadID)->where('type',$type)->get();
		$boxData =array();
		if(count($boxQuery->num_rows())>0){
			foreach($boxQuery->result() as $box){
				$boxData[] = $box;
			}
		}
		return $boxData;
	}
	
	public function emailSearch($from,$to='',$subject='',$has='',$doesntHave=''){
		$searchString = "";
		$stringInc = false;		
		if(!empty($from)){
			$explodeFrom = explode(',',$from);
			for($i=0;$i<count($explodeFrom);$i++){
				$fromSearch = trim($explodeFrom[$i]);
				if(!empty($fromSearch)){
					$searchString .= "content LIKE '%".$explodeFrom[$i]."%' OR ";
				}				
			}
			$searchString = substr($searchString,0,-3);
			$stringInc = true;
		}
		if(!empty($to)){
			if($stringInc == true){
				$searchString .= "OR ";
			}
			$explodeTo = explode(',',$to);
			for($i=0;$i<count($explodeTo)-1;$i++){
				$toSearch = trim($explodeTo[$i]);
				if(!empty($toSearch)){
					$searchString .= "content LIKE '%".$toSearch."%' OR ";
				}
			}
			$searchString = substr($searchString,0,-3);
			$stringInc = true;
		}
		if(!empty($subject)){
			if($stringInc == true){
				$searchString .= "AND ";
			}
			$searchString .= "content LIKE '%".$subject."%' ";
			$stringInc = true;
		}
		if(!empty($has)){
			if($stringInc == true){
				$searchString .= "AND ";
			}
			$searchString .= "content LIKE '%".$has."%' ";
			$stringInc = true;
		}
		if(!empty($doesntHave)){
			if($stringInc == true){
				$searchString .= "AND ";
			}
			$searchString .= "content NOT LIKE '%".$doesntHave."%' ";
			$stringInc = true;
		}
		$data = array();
		$searchString = trim($searchString);
		if(!empty($searchString)){
			/*if(!empty($from)){
				$searchString .=" AND b.user_id = (SELECT id FROM ".$this->table_contacts." as c WHERE c.email='".$from."')";
			}*/
			$data = array();
			$query = $this->db->select('b.*, a.company_id as aCompanyID, a.type as aType, s.company_id as sCompanyID,s.type as sType, p.company_id as pCompanyID,p.type as pType,l.lead_name,a.id as aID, s.id as sID, p.id as pID')->from($this->table_box.' as b')->join($this->table_acquisition_activity.' as a','b.id = a.email_id','left')->join($this->table_sales_activity.' as s','b.id = s.email_id','left')->join($this->table_presales_activity.' as p','b.id = p.email_id','left')->join($this->table_lead.' as l','l.id = b.lead_id')->where($searchString)->where("l.status IN ('0','1','2')")->order_by('b.id','desc')->get();
			/*echo $this->db->last_query();*/
			if(count($query->num_rows())>0){
				foreach($query->result() as $row){
					$activityType = $this->lead_model->getPersonCompanyDetailFromAcquisitionActivityLogByEmailID($row->id);
					$activity = 0;
					if(count($activityType)==0){
						$activityType = $this->lead_model->getPersonCompanyDetailFromSalesActivityLogByEmailID($row->id);
						if(count($activityType)>0){
							$activity = 1;
						} else {
							$activityType = $this->lead_model->getPersonCompanyDetailFromPreSalesActivityLogByEmailID($row->id);
							if(count($activityType)>0){
								$activity = 3;
							}
						}
					} else {
						$activity = 2;
					}
					$row->from_activity = $activity;
					$data[] = $row;
				}
			}			
		}
		return $data;
	}
	
	public function fincImapEmailWithMessageID($messageID){
		$data = array();
			$query = $this->db->select('DISTINCT(b.id),b.*, a.company_id as aCompanyID, a.type as aType, s.company_id as sCompanyID,s.type as sType, p.company_id as pCompanyID,p.type as pType,l.lead_name,a.id as aID, s.id as sID, p.id as pID')->from($this->table_box.' as b')->join($this->table_acquisition_activity.' as a','b.id = a.email_id','left')->join($this->table_sales_activity.' as s','b.id = s.email_id','left')->join($this->table_presales_activity.' as p','b.id = p.email_id','left')->join($this->table_lead.' as l','l.id = b.lead_id')->where('b.content LIKE "%'.$messageID.'%"')->where("l.status IN ('0','1','2')")->where('b.sent_from','1')->order_by('b.id','ASC')->get();
			/*echo $this->db->last_query();*/
			if(count($query->num_rows())>0){
				$row = $query->first_row();
				foreach($query->result() as $row){
					$activityType = $this->lead_model->getPersonCompanyDetailFromAcquisitionActivityLogByEmailID($row->id);
					$activity = 0;
					if(count($activityType)==0){
						$activityType = $this->lead_model->getPersonCompanyDetailFromSalesActivityLogByEmailID($row->id);
						if(count($activityType)>0){
							$activity = 1;
						} else {
							$activityType = $this->lead_model->getPersonCompanyDetailFromPreSalesActivityLogByEmailID($row->id);
							if(count($activityType)>0){
								$activity  = 3;
							}
						}
					} else {
						$activity = 2;
					}
					$row->from_activity = $activity;
					$data[] = $row;
				}
			}
			return $data;
	}
	
	public function findEmailFromWhichActivity($ID){
		$activityType = $this->getPersonCompanyDetailFromAcquisitionActivityLogByEmailID($ID);
		if(count($activityType)==0){
			$activityType = $this->getPersonCompanyDetailFromSalesActivityLogByEmailID($ID);
			if(count($activityType)==0){
				$activityType = $this->getPersonCompanyDetailFromPreSalesActivityLogByEmailID($ID);
			}
		}	
		$email = "";
		if(count($activityType)>0){
			$getContactDetail = $this->findBrokerDetails($activityType->contact_id);
			if(count($getContactDetail)>0){
				$email = $getContactDetail->email;
			}
		}
		return $email;
	}
	
	public function getEmailList($limit){
		$data = array();
		$query = $this->db->select('b.*, a.company_id as aCompanyID, a.type as aType, s.company_id as sCompanyID,s.type as sType,l.lead_name')->from($this->table_box.' as b')->join($this->table_acquisition_activity.' as a','b.id = a.email_id','left')->join($this->table_sales_activity.' as s','b.id = s.email_id','left')->join($this->table_lead.' as l','l.id = b.lead_id')->where("l.status IN ('0','1','2')")->order_by('b.id','desc')->limit($limit,0)->get();
		if(count($query->num_rows())>0){
			foreach($query->result() as $row){
				$activityType = $this->lead_model->getPersonCompanyDetailFromAcquisitionActivityLogByEmailID($row->id);
				$activity = 0;
				if(count($activityType)==0){
					$activityType = $this->lead_model->getPersonCompanyDetailFromSalesActivityLogByEmailID($row->id);
					if(count($activityType)>0){
						$activity = 1;
					} else {
						$activityType = $this->lead_model->getPersonCompanyDetailFromPreSalesActivityLogByEmailID($row->id);
						if(count($activityType)>0){
							$activity = 3;
						}
					}
				} else {
					$activity = 2;
				}
				$row->from_activity = $activity;
				$data[] = $row;
			}
		}
		return $data;
	}
	
	public function getMessageTaskList($userID,$leadID=0,$messageType=0){
		$counter=0;
		$list = array();
		if($messageType==0){
			if($leadID==0){
				$queryMySend = $this->db->select("DISTINCT(task_id) as taskID")->from($this->table_task_conversation.' as c')->where('c.from_u',$userID)->order_by('c.id','DESC')->get();
			} else {
				$queryMySend = $this->db->select("DISTINCT(task_id) as taskID")->from($this->table_task_conversation.' as c')->join($this->table_requests.' as r','r.id = c.task_id')->where('c.from_u',$userID)->where('r.lead_id',$leadID)->order_by('c.id','DESC')->get();
			}
			if(count($queryMySend->num_rows())>0){
				foreach($queryMySend->result() as $task){
					$queryTask = $this->db->select('c.from_u as sentUser,c.task_id as taskID,c.create_c,r.*,l.type as leadType,l.lead_name,u.name as fromUserName,u1.name as userName,u1.profile_pic,c.message as userMessage')->from($this->table_task_conversation.' as c')->join($this->table_requests.' as r','r.id = c.task_id')->join($this->table_lead.' as l','l.id = r.lead_id')->join('users as u','u.id=c.from_u')->join('users as u1','u1.id=r.user_id')->where('c.task_id',$task->taskID)->limit(1,0)->order_by('c.id','DESC')->get();
					/*echo $this->db->last_query()."<br/>";*/
					if ($queryTask->num_rows() > 0) {
						$data = $queryTask->first_row();
						if($data->sentUser==$userID){
							$list[] = $data;
							$counter++;
						}
					}
				}
			}
		} else if($messageType==1){
			if($leadID==0){
				$queryMyReceive = $this->db->select("DISTINCT(task_id) as taskID,f.message_id as messageID")->from($this->table_task_flag.' as f')->where('f.user_id',$userID)->where('f.status <> 2')->order_by('f.message_id','DESC')->get();
			} else {
				$queryMyReceive = $this->db->select("DISTINCT(task_id) as taskID,f.message_id as messageID")->from($this->table_task_flag.' as f')->join($this->table_requests.' as r','r.id = f.task_id')->where('f.user_id',$userID)->where('f.status <> 2')->where('r.lead_id',$leadID)->order_by('f.message_id','DESC')->get();
			}
			if(count($queryMyReceive->num_rows())>0){
				foreach($queryMyReceive->result() as $task){
					$currentMessage = $this->db->select("c.id as messageID")->from($this->table_task_conversation.' as c')->where('c.task_id',$task->taskID)->order_by('c.id','DESC')->get()->row();
					if(count($currentMessage)>0){
						$queryTask = $this->db->select('f.user_id as receiveUser,f.task_id as taskID,c.create_c,f.status as unRead,r.*,l.type as leadType,l.lead_name,u.name as fromUserName,u1.name as userName,u1.profile_pic,c.message as userMessage')->from($this->table_task_flag.' as f')->join($this->table_task_conversation.' as c', 'f.message_id= c.id')->join($this->table_requests.' as r','r.id = f.task_id')->join($this->table_lead.' as l','l.id = r.lead_id')->join('users as u','u.id=c.from_u')->join('users as u1','u1.id=r.user_id')->where('f.message_id',$currentMessage->messageID)->order_by('f.flag_id','DESC')->get();
						/*echo $this->db->last_query()."<br/>";*/
						if ($queryTask->num_rows() > 0) {
							foreach($queryTask->result() as $data){
								if($data->receiveUser==$userID){
									$list[] = $data;
									if($data->unRead=="1"){
										$counter++;
									}
								}
							}					
						}
					}
				}
			}
		}
		return array("count"=>$counter,"list"=>$list);		
	}
	
	
	public function getFlagConversations($userID,$flag=true,$leadID = 0){		
		$taskCount = (object) array("countNotify"=>0);
		$taskICount = (object) array("countNotify"=>0);
		if($flag==true && $leadID==0){
			/*$taskList = $this->waitingCalApproval($userID);*/
			$taskCount = $this->waitingApprovalCount($userID);
			/*$taskIList = $this->waitingICalApproval($userID);*/
			$taskICount = $this->waitingIApprovalCount($userID);
		} else {			
			/*$taskList = $this->getAllTaskMeFromLead($leadID);*/
			$taskCount = $this->getAllTaskFromLeadCount($leadID);
			/*$taskIList = $this->myTaskApproval($leadID);*/
			$taskICount = $this->myTaskApprovalCount($leadID);
		}		
		if($leadID==0){
			$queryMySend = $this->db->select("DISTINCT(task_id) as taskID")->from($this->table_task_conversation.' as c')->where('c.from_u',$userID)->order_by('c.id','DESC')->get();
		} else {
			$queryMySend = $this->db->select("DISTINCT(task_id) as taskID")->from($this->table_task_conversation.' as c')->join($this->table_requests.' as r','r.id = c.task_id')->where('c.from_u',$userID)->where('r.lead_id',$leadID)->order_by('c.id','DESC')->get();
		}
		$countSendUnread = 0;
		$countReceieveUnread = 0;
		if(count($queryMySend->num_rows())>0){
			foreach($queryMySend->result() as $task){
				$queryTask = $this->db->select('c.from_u as sentUser,c.task_id as taskID,c.create_c,r.*,l.type as leadType,l.lead_name,u.name as fromUserName,u1.name as userName,u1.profile_pic,c.message as userMessage')->from($this->table_task_conversation.' as c')->join($this->table_requests.' as r','r.id = c.task_id')->join($this->table_lead.' as l','l.id = r.lead_id')->join('users as u','u.id=c.from_u')->join('users as u1','u1.id=r.user_id')->where('c.task_id',$task->taskID)->limit(1,0)->order_by('c.id','DESC')->get();
				if ($queryTask->num_rows() > 0) {
					$data = $queryTask->first_row();
					if($data->sentUser==$userID){
						$countSendUnread++;
					}
				}
			}
		}
		if($leadID==0){
			$queryMyReceive = $this->db->select("DISTINCT(task_id) as taskID,f.message_id as messageID")->from($this->table_task_flag.' as f')->where('f.user_id',$userID)->where('f.status <> 2')->order_by('f.message_id','DESC')->get();
		} else {
			$queryMyReceive = $this->db->select("DISTINCT(task_id) as taskID,f.message_id as messageID")->from($this->table_task_flag.' as f')->join($this->table_requests.' as r','r.id = f.task_id')->where('f.user_id',$userID)->where('f.status <> 2')->where('r.lead_id',$leadID)->order_by('f.message_id','DESC')->get();
		}
		
		if(count($queryMyReceive->num_rows())>0){
			foreach($queryMyReceive->result() as $task){
				$currentMessage = $this->db->select("c.id as messageID")->from($this->table_task_conversation.' as c')->where('c.task_id',$task->taskID)->order_by('c.id','DESC')->get()->row();
				if(count($currentMessage)>0){
					$queryTask = $this->db->select('f.user_id as receiveUser,f.task_id as taskID,c.create_c,f.status as unRead,r.*,l.type as leadType,l.lead_name,u.name as fromUserName,u1.name as userName,u1.profile_pic,c.message as userMessage')->from($this->table_task_flag.' as f')->join($this->table_task_conversation.' as c', 'f.message_id= c.id')->join($this->table_requests.' as r','r.id = f.task_id')->join($this->table_lead.' as l','l.id = r.lead_id')->join('users as u','u.id=c.from_u')->join('users as u1','u1.id=r.user_id')->where('f.message_id',$currentMessage->messageID)->order_by('f.flag_id','DESC')->get();
					if ($queryTask->num_rows() > 0) {
						foreach($queryTask->result() as $data){
							if($data->receiveUser==$userID){
								if($data->unRead=="1"){
									$countReceieveUnread++;
								}
							}
						}					
					}
				}
			}
		}
		$returnArray['countSend'] = $countSendUnread;
		$returnArray['countReceieve'] = $countReceieveUnread;
		$returnArray['taskCount'] = $taskCount->countNotify;
		$returnArray['taskICount'] = $taskICount->countNotify;
		/*$returnArray['taskIList'] = $taskIList;*/
        /*$allArray['task_i'] = $this->myTaskApproval($row->id);*/		
		return $returnArray;
	}		
	
	function getAllTaskMeFromLead($leadID){
		$query = $this->db->select('a.doc_url,a.id as approved_id,a.type as approved_type,a.subject, a.user_id as toUserID, a.from_user_id as fromUserID, a.parent_id,a.execution_date,a.completion_date,a.message,a.status as notifyStatus,a.create_date as taskCreateDate,l.id,l.lead_name,l.serial_number,l.type,l.create_date,uu.name as userName, u.name as uuserName, u.type as userType,u.profile_pic')->from($this->table_requests.' as a')->join($this->table_lead.' as l','l.id=a.lead_id')->join($this->table.' as u','u.id=a.user_id')->join($this->table.' as uu','uu.id=a.from_user_id')->where('lead_id',$leadID)->where('a.status',0)->where('date_format(a.execution_date,"%Y-%m-%d")<="'.date("Y-m-d").'"')->where('a.user_id',$this->session->userdata['id'])->where('l.status IN (0,1,2)')->order_by('a.id','DESC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		
		return $data;
	}	
	
	function getAllTaskFromLeadCount($leadID){
		$query = $this->db->select('count(*) as countNotify')->from($this->table_requests.' as a')->join($this->table_lead.' as l','l.id=a.lead_id')->join($this->table.' as u','u.id=a.user_id')->join($this->table.' as uu','uu.id=a.from_user_id')->where('lead_id',$leadID)->where('a.status',0)->where('date_format(a.execution_date,"%Y-%m-%d")<="'.date("Y-m-d").'"')->where('a.user_id',$this->session->userdata['id'])->where('l.status IN (0,1,2)')->order_by('a.id','DESC')->get()->row();
		return $query;
	}
	
	public function myTaskApprovalCount($leadID){
		$data = $this->db->select('count(*) as countNotify')->from($this->table_requests.' as a')->join($this->table_lead.' as l','l.id=a.lead_id','left')->join($this->table.' as u','u.id=a.user_id')->where('a.from_user_id',$this->session->userdata['id'])->where('a.lead_id',$leadID)->where('a.status',0)->where('date_format(a.execution_date,"%Y-%m-%d")<="'.date("Y-m-d").'"')->where('l.status IN (0,1,2)')->order_by('a.id','DESC')->get()->row();		
		return $data;
	}
	
	public function myTaskApproval($leadID){
		$query = $this->db->select('a.doc_url,a.id as approved_id,a.type as approved_type,a.subject, a.user_id as toUserID, a.from_user_id as fromUserID, a.parent_id,a.execution_date,a.completion_date,a.message,a.create_date as taskCreateDate,l.*,l.serial_number,u.name as userName, u.type as userType,u.profile_pic')->from($this->table_requests.' as a')->join($this->table_lead.' as l','l.id=a.lead_id','left')->join($this->table.' as u','u.id=a.user_id')->where('a.from_user_id',$this->session->userdata['id'])->where('a.lead_id',$leadID)->where('a.status',0)->where('date_format(a.execution_date,"%Y-%m-%d")<="'.date("Y-m-d").'"')->where('l.status IN (0,1,2)')->order_by('a.id','DESC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		/*echo $this->db->last_query();*/
		return $data;
	}
	
	function getAllTaskFromLead($leadID){
		$query = $this->db->select('a.doc_url,a.id as approved_id,a.type as approved_type,a.subject, a.user_id as toUserID, a.from_user_id as fromUserID, a.parent_id,a.execution_date,a.completion_date,a.message,a.status as notifyStatus,a.create_date as taskCreateDate,l.id,l.lead_name,l.type,l.create_date,uu.name as userName, u.name as uuserName, u.type as userType,u.profile_pic')->from($this->table_requests.' as a')->join($this->table_lead.' as l','l.id=a.lead_id')->join($this->table.' as u','u.id=a.user_id')->join($this->table.' as uu','uu.id=a.from_user_id')->where('lead_id',$leadID)->where('a.status <> 2')->where('date_format(a.execution_date,"%Y-%m-%d")<="'.date("Y-m-d").'"')->where('l.status IN (0,1,2)')->order_by('a.id','DESC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		
		return $data;
	}
	
	function waitingApprovalCount($userID){
		$query = $this->db->select('count(*) as countNotify')->from($this->table_requests.' as a')->join($this->table_lead.' as l','l.id=a.lead_id','left')->join($this->table.' as u','u.id=a.from_user_id')->where('a.user_id',$userID)->where('a.status',0)->where('date_format(a.execution_date,"%Y-%m-%d")<="'.date("Y-m-d").'"')->where('l.status IN (0,1,2)')->order_by('a.id','DESC')->get()->row();
		return $query;
	}
	
	function waitingIApprovalCount($userID){
		$query = $this->db->select('count(*) as countNotify')->from($this->table_requests.' as a')->join($this->table_lead.' as l','l.id=a.lead_id','left')->join($this->table.' as u','u.id=a.user_id')->where('a.from_user_id',$userID)->where('a.status',0)->where('date_format(a.execution_date,"%Y-%m-%d")<="'.date("Y-m-d").'"')->where('l.status IN (0,1,2)')->order_by('a.id','DESC')->get()->row();
		return $query;
	}
	
	function waitingICalApproval($userID){
		$query = $this->db->select('a.doc_url,a.id as approved_id,a.type as approved_type,a.subject, a.user_id as toUserID, a.from_user_id as fromUserID, a.parent_id,a.execution_date,a.completion_date,a.message,a.status as notifyStatus,a.create_date as taskCreateDate,l.id,l.lead_name,l.serial_number,l.type,l.create_date,uu.name as userName, uu.type as userType,u.name as uuserName,u.profile_pic')->from($this->table_requests.' as a')->join($this->table_lead.' as l','l.id=a.lead_id','left')->join($this->table.' as u','u.id=a.from_user_id')->join($this->table.' as uu','uu.id=a.user_id')->where('a.from_user_id',$userID)->where('a.status <> 2')->where('date_format(a.execution_date,"%Y-%m-%d")<="'.date("Y-m-d").'"')->where('l.status IN (0,1,2)')->order_by('a.id','DESC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		
		return $data;
	}
	
	function waitingCalApproval($userID){
		$query = $this->db->select('a.doc_url,a.id as approved_id,a.type as approved_type,a.subject, a.user_id as toUserID, a.from_user_id as fromUserID, a.parent_id,a.execution_date,a.completion_date,a.message,a.status as notifyStatus,a.create_date as taskCreateDate,l.id,l.lead_name,l.serial_number,l.type,l.create_date,u.name as userName, u.type as userType,uu.name as uuserName,uu.profile_pic')->from($this->table_requests.' as a')->join($this->table_lead.' as l','l.id=a.lead_id','left')->join($this->table.' as u','u.id=a.from_user_id')->join($this->table.' as uu','uu.id=a.user_id')->where('a.user_id',$userID)->where('a.status <> 2')->where('date_format(a.execution_date,"%Y-%m-%d")<="'.date("Y-m-d").'"')->where('l.status IN (0,1,2)')->order_by('a.id','DESC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		
		return $data;
	}
	
	function waitingApproval($userID){
		$query = $this->db->select('a.doc_url,a.id as approved_id,a.type as approved_type,a.subject, a.user_id as toUserID, a.from_user_id as fromUserID, a.parent_id,a.execution_date,a.completion_date,a.message,a.status as notifyStatus,a.create_date as taskCreateDate,l.*,u.name as userName, u.type as userType')->from($this->table_requests.' as a')->join($this->table_lead.' as l','l.id=a.lead_id','left')->join($this->table.' as u','u.id=a.from_user_id')->where('a.user_id',$userID)->where('a.status <> 2')->where('date_format(a.execution_date,"%Y-%m-%d")<="'.date("Y-m-d").'"')->where('l.status IN (0,1,2)')->order_by('a.id','DESC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		
		return $data;
	}
	
	
	
	
	
	function deleteTask($taskID){
		$this->db->where('task_id',$taskID);
		$this->db->delete($this->table_task_flag);
		$this->db->where('task_id',$taskID);
		$this->db->delete($this->table_task_conversation);
		$this->db->where('id',$taskID);
		$this->db->delete($this->table_requests);
	}
	
	
	
	
	
	function countUnreadMessage($userID){
		$query = $this->db->select('count(*) as messageCount')->from($this->table_task_flag.' as f')->where('f.user_id',$userID)->where('f.status','1')->get()->row();
		return $query->messageCount;
	}
	
	public function getTaskConversation($taskID){
		$this->updateTaskFlagConversation($taskID,$this->session->userdata['id'], array('status'=>'0'));
		$listQuery = $this->db->select("c.*,u1.id as fromUser, u1.name as fromUserName, u1.profile_pic,u2.id as toUser, u2.name as toUserName, u2.profile_pic")->from($this->table_task_conversation.' as c')->join($this->table_task_flag.' as tf','tf.message_id = c.id')->join('users as u1','u1.id=c.from_u')->join('users as u2','u2.id=tf.user_id')->where("c.task_id",$taskID)->order_by('c.id', 'ASC')->get();
		$list = array();
		if(count($listQuery->num_rows())>0){
			$count = 0;
			foreach($listQuery->result() as $box){
				$list[] = $box;				
			}
		}
		return $list;
	}
	
	public function getTaskConversationList($taskID){
		$listQuery = $this->db->select("c.*,u1.id as fromUser, u1.name as fromUserName, u1.profile_pic")->from($this->table_task_flag.' as c')->join('users as u1','u1.id=c.user_id')->where("c.task_id",$taskID)->order_by('c.flag_id', 'ASC')->get();
		$list = array();
		if(count($listQuery->num_rows())>0){
			$count = 0;
			foreach($listQuery->result() as $box){
				$list[] = $box;				
			}
		}
		return $list;
	}
	
	public function updateTaskFlagConversation($taskID,$userID,$data){
		$this->db->where('task_id',$taskID);
		$this->db->where('user_id',$userID);
		$this->db->update($this->table_task_flag, $data);
		
	}
	
	public function getContactToken(){
		$listQuery = $this->db->select("*")->from($this->table_contacts_access)->get();
		$data = array();
		if(count($listQuery->num_rows())>0){
			$data = $listQuery->first_row();
		}
		return $data;
	}
	
	public function findCompanyData($companyID){		
		$listQuery = $this->db->select("id,company_name")->from($this->table_company)->where('id',$companyID)->get();
		$data = array();
		if(count($listQuery->num_rows())>0){
			$data = $listQuery->first_row();
		}
		return $data;
	}
	
	public function findLucidData($leadID){
		$listQuery = $this->db->select("*")->from($this->table_chart)->where('lead_id',$leadID)->get();
		$list =array();
		if(count($listQuery->num_rows())>0){
			foreach($listQuery->result() as $box){
				$list[] = $box;
			}
		}
		return $list;
	}
	
	public function insertChart($data){
		// Inserting in Table(Litigation) 
		$this->db->insert($this->table_chart, $data);
		return $this->db->insert_id();
	}
	public function updateChart($id,$data){
		// Inserting in Table(Litigation) 
		$this->db->where('lead_id', $id);
		$this->db->update($this->table_chart, $data);
		return $id;
	}
	
	public function updateChartWithLead($leadID,$patent,$data){
		$this->db->where('lead_id', $leadID);
		$this->db->where('patent', $patent);
		$this->db->update($this->table_chart, $data);
		return $leadID;
	}
	
	public function from_litigation_insert($data){
		// Inserting in Table(Litigation) 
		$this->db->insert($this->table_lead, $data);
		return $this->db->insert_id();
	}
	public function from_litigation_update($id,$data){
		// Inserting in Table(Litigation) 
		/*$this->db->set_charset('utf8');*/
		$this->db->query("SET NAMES 'UTF8'");
		$this->db->query("SET CHARACTER SET 'utf8'");
		$this->db->query("SET COLLATION_CONNECTION = 'utf8_unicode_ci'");
		$this->db->where('id', $id);
		$this->db->update($this->table_lead, $data);
		
		return $id;
	}
	
	public function insertPassLead($data){
		$this->db->insert($this->table_pass,$data);
		return $this->db->insert_id(); 
	}
	
	public function insertBox($data){
		/*$this->db->database();
		$this->db->reconnect();*/
		$this->load->database();
		$this->db->insert($this->table_box,$data);
		return $this->db->insert_id();
	}
	
	public function updateBox($id,$data){
		// Inserting in Table(Litigation) 
		$this->db->where('id', $id);
		$this->db->update($this->table_box, $data);
		
		return $id;
	}
	
	public function insertGmailMessages($data){
		$this->db->insert($this->table_gmail,$data);
		return $this->db->insert_id();
	}
	
	public function getPassLead(){		
		$data = array("message"=>array(),"lead"=>array());		
		return $data;
	}
	
	public function getGmailMessages($userID){
		$query= $this->db->select("*")->from($this->table_gmail)->where("user_id",$userID)->order_by('id','DESC')->get();
		$data = array();
		if($query->num_rows()>0){
			$data = $query->first_row();			
		}
		return $data;
	}
	
	public function removeFromBox($leadID,$threadID){
		$this->db->where('lead_id',$leadID);
		$this->db->where('id',$threadID);
		$this->db->delete($this->table_box);
		return $this->db->affected_rows();
	}
	public function removeFromAcquisition($leadID,$threadID){
		$this->db->where('lead_id',$leadID);
		$this->db->where('email_id',$threadID);
		$this->db->delete($this->table_acquisition_activity);
		return $this->db->affected_rows();
	}
	public function removeFromSales($leadID,$threadID){
		$this->db->where('lead_id',$leadID);
		$this->db->where('email_id',$threadID);
		$this->db->delete($this->table_sales_activity);
		return $this->db->affected_rows();
	}	
	function deleteLead($leadID){
		$this->db->where('id',$leadID);
		$this->db->delete($this->table_lead);
		$this->db->where('lead_id',$leadID);
		$this->db->delete($this->table_box);
		$this->db->where('lead_id',$leadID);
		$this->db->delete($this->table_acquisition_company);
		$this->db->where('lead_id',$leadID);
		$this->db->delete($this->table_presales_activity);
		$this->db->where('lead_id',$leadID);
		$this->db->delete($this->table_acquisition_activity);
		$this->db->where('lead_id',$leadID);
		$this->db->delete($this->table_sales_activity);
		$this->db->where('lead_id',$leadID);
		$this->db->delete($this->table_invitees);
		$this->db->where('lead_id',$leadID);
		$this->db->delete($this->table_acquisition);
		$this->db->where('lead_id',$leadID);
		$this->db->delete($this->table_assign_lead);
		$this->db->where('parent_id',$leadID);
		$this->db->delete('other_comments');
		$queryRequest = $this->db->select('*')->from($this->table_requests)->where('lead_id',$leadID)->get();
		if($queryRequest->num_rows()>0){
			foreach ($queryRequest->result() as $row) {
				$taskID = $row->id;
				$this->db->where('task_id',$taskID);
				$this->db->delete($this->table_task_flag);
				$this->db->where('task_id',$taskID);
				$this->db->delete($this->table_task_conversation);
				$this->db->where('id',$taskID);
				$this->db->delete($this->table_requests);				
				$this->deleteApprovalRequest($leadID);
				$this->deleteHistory($leadID);
				$this->deleteLeadButtons($leadID);
			}	
		}
		return $this->db->affected_rows();
	}	
	public function findIncompleteList($type){
		$query = $this->db->select('*')->from($this->table_lead)->where('complete','0')->where('type',$type)->get();
		$data = array();
		if($query->num_rows()>0){
			foreach ($query->result() as $row) {
				/*Broker Name*/
					if(!empty($row->broker)){
						$brokderData = $this->db->select('c.first_name,c.last_name,cc.company_name')->from($this->table_contacts.' as c')->join($this->table_company.' as cc','cc.id = c.company_id')->where('c.id',$row->broker)->get()->row();
						if(count($brokderData)>0){
							$row->broker_contact = $brokderData->company_name;
							$row->broker_person_contact = $brokderData->first_name.' '.$brokderData->last_name;
						} else {
							$row->broker_contact ='';
							$row->broker_person_contact = '';
							$row->broker = '';
						}
					}
					
					/*End Broker Name*/
					/*Seller Name*/
					if(!empty($row->plantiffs_name)){
						$sellerInfo = $this->db->select('cc.company_name')->from($this->table_company.' as cc')->where('cc.id',$row->plantiffs_name)->get()->row();
						if(count($sellerInfo)>0){
							$row->seller_contact = $sellerInfo->company_name;
						} else {
							$row->seller_contact = '';
							$row->plantiffs_name = '';
						}
					}
					/*End Seller Name*/
				$boxQuery = $this->db->select("*")->from($this->table_box)->where('lead_id',$row->id)->get();
				$boxData =array();
				if(count($boxQuery->num_rows())>0){
					foreach($boxQuery->result() as $box){
						$boxData[] = $box;
					}
				}
				$row->box_list = $boxData;
				$data[] = $row;
			}			
		}
		return $data;
	}
	function getAllEmails(){
		$boxQuery = $this->db->select("*")->from($this->table_box)->where('date_received','0000-00-00 00:00:00')->get();
		$boxData =array();
		if(count($boxQuery->num_rows())>0){
			foreach($boxQuery->result() as $box){
				$boxData[] = $box;
			}
		}
		return $boxData;
	}	
	function searchLeads($searchData){
		$data = array();
		$conditions = "";
		$flag = 0;
		if(!empty($searchData['has_the_words'])){
			/*From whole database*/
			$search_values = array($searchData['has_the_words']);
			$table_fields = array();
			$cumulative_results = array();
			$CI = &get_instance();
			$CI->load->database();
			$db_name = $CI->db->database;
			$tableNames = array('task_conversation','sectors','sec_agreements','sales_broker_lead_company','sales_activity_log_detail','litigations','lead_template_files','email_template','acquisition','acquisition_activity_log_detail','acquisition_company','activity_log_detail','category','map_sectors_departments','box_list','company','company_sector','contacts');
			// Pull all table columns that have character data types
			$result = $this->db->query("
				SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE
				FROM  `INFORMATION_SCHEMA`.`COLUMNS` 
				WHERE  `TABLE_SCHEMA` =  '{$db_name}'
				AND `DATA_TYPE` IN ('varchar', 'char', 'text')
				")->result_array();
			
			// Build table-keyed columns so we know which to query
			foreach ( $result  as $o ) 
			{
				$table_fields[$o['TABLE_NAME']][] = $o['COLUMN_NAME'];			
			}
			
			// Build search query to pull the affected rows
			// Search Each Row for matches
			foreach($table_fields as $table_name => $fields)
			{
				// Clear search array
				if(in_array($table_name,$tableNames)){
					$search_array = array();				
					// Add a search for each search match
					foreach($fields as $field)
					{
						foreach($search_values as $value) 
						{
							$search_array[] = " `{$field}` LIKE '%{$value}%' ";
						}
					}
					// Implode $search_array
					$search_string = implode (' OR ', $search_array);
					$query_string = "SELECT * FROM `{$table_name}` WHERE {$search_string}";
					
					$table_results = $this->db->query($query_string)->result_array();
					if(array_key_exists('lead_id',$table_results)){
						if(count($table_results)>0){
							foreach($table_results as $result){
								$cumulative_results[] = $result['lead_id'];
							}
						}						
					} else if($table_name=="litigations"){
						if(count($table_results)>0){
							foreach($table_results as $result){
								$cumulative_results[] = $result['id'];
							}
						}
					} else if (array_key_exists('company_name',$table_results)){
						/*Company Name*/
						if(count($table_results)>0){
							foreach($table_results as $result){
								$query = $this->db->select("distinct(l.id) as lead_id")->from($this->table_lead.' as l')->join($this->table_activity_log.' as a','l.id = a.lead_id')->where('a.company_id',$result['id'])->get()->result_array();
								if(count($query)>0){
									foreach($query as $val){
										$cumulative_results[] = $result['lead_id'];
									}
								}
							}
						}
					} else if (array_key_exists('first_name',$table_results)){
						/*Contacts*/
						if(count($table_results)>0){
							foreach($table_results as $result){
								$query = $this->db->select("distinct(l.id) as lead_id")->from($this->table_lead.' as l')->join($this->table_activity_log.' as a','l.id = a.lead_id')->where('a.contact_id',$result['id'])->get()->result_array();
								if(count($query)>0){
									foreach($query as $val){
										$cumulative_results[] = $result['lead_id'];
									}
								}
							}
						}
					} else if ($table_name=="sectors"){
						/*Sectors*/
						if(count($table_results)>0){
							foreach($table_results as $result){
								$query = $this->db->select("distinct(l.id) as lead_id")->from($this->table_lead.' as l')->join($this->table_activity_log.' as a','l.id = a.lead_id')->join($this->table_company_sector.' as cs','cs.company_id=a.company_id')->join($this->table_sector.' as s','s.id=cs.sector_id')->where('s.id',$result['id'])->get()->result_array();
								if(count($query)>0){
									foreach($query as $val){
										$cumulative_results[] = $result['lead_id'];
									}
								}
							}
						}
					} else if ($table_name=="category"){
						/*Category*/
						if(count($table_results)>0){
							foreach($table_results as $result){
								$query = $this->db->select("distinct(l.id) as lead_id")->from($this->table_lead.' as l')->join($this->table_activity_log.' as a','l.id = a.lead_id')->join($this->table_company_sector.' as cs','cs.company_id=a.company_id')->join($this->table_map_sectors_departments.' as ms','ms.sector_id=cs.sector_id')->join($this->table_category.' as c','c.id=ms.category_id')->where('c.id',$result['id'])->get()->result_array();
								if(count($query)>0){
									foreach($query as $val){
										$cumulative_results[] = $result['lead_id'];
									}
								}
							}
						}
					}
				}				
			}
			if(count($cumulative_results)>0){
				if((int)$this->session->userdata['type']!=9){
					$sql = "SELECT distinct(l.id) as id,l.lead_name,l.type,l.complete,l.seller_info_text,l.seller_like,l.synpat_like,l.ppa_date,l.funding_trnsfr,l.seller_info FROM ".$this->table_lead." as l INNER JOIN ".$this->table_assign_lead." as al ON al.lead_id = l.id WHERE l.id IN (".implode(',',$cumulative_results).") AND al.pd_id= ".$this->session->userdata['id']." AND l.status IN ('0','1','2') AND l.type <> 'INT' ORDER BY l.lead_name ASC";
				} else {
					$sql = "SELECT l.* FROM ".$this->table_lead." as l WHERE l.id IN (".implode(',',$cumulative_results).") AND l.status IN ('0','1','2') ORDER BY l.lead_name ASC";
				}
				$query = $this->db->query($sql);
				if($query->num_rows()>0){
					foreach ($query->result() as $row) {
						$data[] = $row;
					}
				}
			}	
		} else {
			if(!empty($searchData['lead_name'])){
				$flag = 1;
				$conditions = " lead_name LIKE '%".$this->db->escape_like_str($searchData['lead_name'])."%' ";
			}
			if(!empty($searchData['plantiffs_name'])){
				if($flag==1){
					$conditions .= " OR plantiffs_name LIKE '%".$this->db->escape_like_str($searchData['plantiffs_name'])."%'  OR seller_contact  LIKE '%".$this->db->escape_like_str($searchData['plantiffs_name'])."%'";
				} else {
					$flag = 1;
					$conditions = "  plantiffs_name LIKE '%".$this->db->escape_like_str($searchData['plantiffs_name'])."%'  OR seller_contact  LIKE '%".$this->db->escape_like_str($searchData['plantiffs_name'])."%'";
				}			
			}
			if(!empty($searchData['plantiffs_name'])){
				if($flag==1){
					$conditions .= " OR plantiffs_name LIKE '%".$this->db->escape_like_str($searchData['plantiffs_name'])."%'  OR seller_contact  LIKE '%".$this->db->escape_like_str($searchData['plantiffs_name'])."%'";
				} else {
					$flag = 1;
					$conditions = "  plantiffs_name LIKE '%".$this->db->escape_like_str($searchData['plantiffs_name'])."%'  OR seller_contact  LIKE '%".$this->db->escape_like_str($searchData['plantiffs_name'])."%'";
				}			
			}
			if(!empty($searchData['person_name_1'])){
				if($flag==1){
					$conditions .= " OR person_name_1 LIKE '%".$this->db->escape_like_str($searchData['person_name_1'])."%'  ";
				} else {
					$flag = 1;
					$conditions = "  person_name_1 LIKE '%".$this->db->escape_like_str($searchData['person_name_1'])."%' ";
				}			
			}
			if(!empty($searchData['person_name_2'])){
				if($flag==1){
					$conditions .= " OR person_name_2 LIKE '%".$this->db->escape_like_str($searchData['person_name_2'])."%'  ";
				} else {
					$flag = 1;
					$conditions = "  person_name_2 LIKE '%".$this->db->escape_like_str($searchData['person_name_2'])."%' ";
				}			
			}
			if(!empty($searchData['broker'])){
				if($flag==1){
					$conditions .= " OR broker_contact LIKE '%".$this->db->escape_like_str($searchData['broker'])."%'  ";
				} else {
					$flag = 1;
					$conditions = "  broker_contact LIKE '%".$this->db->escape_like_str($searchData['broker'])."%' ";
				}			
			}
			if(!empty($searchData['broker_person'])){
				if($flag==1){
					$conditions .= " OR broker_person_contact LIKE '%".$this->db->escape_like_str($searchData['broker_person'])."%'  ";
				} else {
					$flag = 1;
					$conditions = "  broker_person_contact LIKE '%".$this->db->escape_like_str($searchData['broker_person'])."%' ";
				}			
			}
			if(!empty($searchData['relates_to'])){
				if($flag==1){
					$conditions .= " OR relates_to LIKE '%".$this->db->escape_like_str($searchData['relates_to'])."%'  ";
				} else {
					$flag = 1;
					$conditions = "  relates_to LIKE '%".$this->db->escape_like_str($searchData['relates_to'])."%' ";
				}			
			}
			if(!empty($searchData['serial_number'])){			
				$conditions = "  serial_number ='".$this->db->escape_like_str($searchData['serial_number'])."'";						
			}
			if((int)$this->session->userdata['type']!=9){
				$sql = "SELECT distinct(l.id) as id,l.lead_name,l.type,l.complete,l.seller_info_text,l.seller_like,l.synpat_like,l.ppa_date,l.funding_trnsfr,l.seller_info FROM ".$this->table_lead." as l INNER JOIN ".$this->table_assign_lead." as al ON al.lead_id = l.id WHERE ".$conditions." AND al.pd_id= ".$this->session->userdata['id']." AND l.status IN ('0','1','2') AND l.type <> 'INT' ORDER BY l.lead_name ASC";
			} else {
				$sql = "SELECT distinct(l.id) as id,l.lead_name,l.type,l.complete,l.seller_info_text,l.seller_like,l.synpat_like,l.ppa_date,l.funding_trnsfr,l.seller_info FROM ".$this->table_lead." as l WHERE ".$conditions." AND l.status IN ('0','1','2') ORDER BY l.lead_name ASC";
			}
			$query = $this->db->query($sql);
			if($query->num_rows()>0){
				foreach ($query->result() as $row) {
					$data[] = $row;
				}
			}
		}
		
		return $data;
	}	
	public function getAllLeads(){
		$query = $this->db->select('*')->from($this->table_lead)->where("status IN ('0','1','2')")->order_by('lead_name','ASC')->get();
		$data = array();
		if($query->num_rows()>0){
			foreach ($query->result() as $row) {
				$data[] = $row;
			}			
		}
		return $data;
	}	
	public function findEOULeadMaterial($serialNumber){
		$query = $this->db->select('other_field')->from('wp_popup_data')->where('serial_number',$serialNumber)->get();
		$data = array();
		if($query->num_rows()>0){
			$data = $query->first_row();
		}
		return $data;
	}
	public function findIncompleteANDCompleteList($type=''){
		//$query = $this->db->select('*')->from($this->table_lead)->where('type',$type)->get();
        $data = array();
		if($this->session->userdata['type']==9){
			$select = 'l.id,l.serial_number,l.lead_name,l.type ,l.create_date ,l.seller_info ,l.seller_info_text ,l.seller_like ,l.funding_trnsfr ,l.complete ,l.status ,l.synpat_like ,l.ppa_id ,l.ppa_text_date ,l.execute_ppa ,l.ppa_execute ,l.ppa_date ,l.plantiffs_name ,l.technologies ,l.no_of_us_patents ,l.no_of_non_us_patents ,l.send_proposal_letter ,l.market_data ,l.seller_contact ,l.broker_contact,l.broker ,l.broker_person_contact ,l.person_name_1 ,l.person_title_1 ,l.person_name_2 ,l.person_title_2 ,l.address ,l.relates_to ,l.expected_price ,l.update_date';
			$query = $this->db->select($select)->from($this->table_lead.' as l')->where("l.status IN ('0','1','2')")->order_by('l.lead_name','ASC')->get();
			if($query->num_rows()>0){
				foreach ($query->result() as $row) {
					/*Broker Name*/
					if(!empty($row->broker)){
						$brokderData = $this->db->select('c.first_name,c.last_name,cc.company_name')->from($this->table_contacts.' as c')->join($this->table_company.' as cc','cc.id = c.company_id')->where('c.id',$row->broker)->get()->row();
						if(count($brokderData)>0){
							$row->broker_contact = $brokderData->company_name;
							$row->broker_person_contact = $brokderData->first_name.' '.$brokderData->last_name;
						} else {
							$row->broker_contact ='';
							$row->broker_person_contact = '';
							$row->broker = '';
						}
					}
					
					/*End Broker Name*/
					/*Seller Name*/
					if(!empty($row->plantiffs_name)){
						$sellerInfo = $this->db->select('cc.company_name')->from($this->table_company.' as cc')->where('cc.id',$row->plantiffs_name)->get()->row();
						if(count($sellerInfo)>0){
							$row->seller_contact = $sellerInfo->company_name;
						} else {
							$row->seller_contact = '';
							$row->plantiffs_name = '';
						}
					}
					/*End Seller Name*/
					/*Person 1*/
					if(!empty($row->person_title_1)){
						$personOneData = $this->db->select('c.first_name,c.last_name,c.job_title')->from($this->table_contacts.' as c')->where('c.id',$row->person_title_1)->get()->row();
						if(count($personOneData)>0){
							$row->person_name_1 = $personOneData->first_name.' '.$personOneData->last_name.', '.$personOneData->job_title;
						} else {
							$row->person_name_1 ='';
							$row->person_title_1 = '';
						}
					}
					/*End Person 1*/
					/*Person 2*/
					if(!empty($row->person_title_2)){
						$personSecondData = $this->db->select('c.first_name,c.last_name,c.job_title')->from($this->table_contacts.' as c')->where('c.id',$row->person_title_2)->get()->row();
						if(count($personSecondData)>0){
							$row->person_name_2 = $personSecondData->first_name.' '.$personSecondData->last_name.', '.$personSecondData->job_title;
						} else {
							$row->person_name_2 ='';
							$row->person_title_2 = '';
						}
					}
					/*End Person 2*/
					/*Lead Last seen*/
					$row->lead_last_seen = "0000-00-00";
					$queryLastSeen = $this->db->select('create_date as login_date')->from($this->table_history)->where('lead_id',$row->id)->order_by('id','desc')->limit(1,0)->get();						
					if($queryLastSeen->num_rows()>0){
						$dataLastSeen = $queryLastSeen->first_row();
						$row->lead_last_seen = $dataLastSeen->login_date;
					}
					/*End Lead Last seen*/
					/*Calculation Attractive*/
					$row->attractive = 0;
					$queryAttractive = $this->db->select('sum(attractive) as attractive,count(id) as counter')->from($this->table_comment)->where('parent_id',$row->id)->get();
					if($queryAttractive->num_rows()>0){
						$attractiveData = $queryAttractive->first_row();
						if($attractiveData->counter>0 && $attractiveData->attractive>0){
							$row->attractive = $attractiveData->attractive/$attractiveData->counter;
						}
					}
					$getEouData = $this->findEOULeadMaterial($row->serial_number);
					$evidence = 0;
					if(count($getEouData)>0){
						$eouData = $getEouData->other_field;
						if(is_string($eouData)){
							$jsonDecodeEou = json_decode($eouData);							
							if(isset($jsonDecodeEou->another_license) && $jsonDecodeEou->another_license!='' && count($jsonDecodeEou->another_license)>0){
								foreach($jsonDecodeEou->another_license as $licenseEvidence){									
									if($licenseEvidence->evidence=="Yes"){										
										$evidence = $evidence+1;
									}
								}
							}
						}
					}
					$row->eou = $evidence;
					$data[] = $row;
				}			
			}
		} else {
			$checkUserAssignLead = $this->checkUserLeads($this->session->userdata['id']);
			$checkUserAssignLeadType = $this->checkUserAssignLeadType($this->session->userdata['id']);
			$data = array();
			/*$query = $this->db->select('l.*')->from($this->table_lead.' as l')->where("l.status IN ('0','1','2')")->where('l.type <> "INT"')->order_by('l.lead_name ASC')->get();
			*/
			$query = "";
			if(count($checkUserAssignLead)>0 && count($checkUserAssignLeadType)>0){
				$leadType = implode('","', $checkUserAssignLeadType);
				$leadAssigned = implode(',', $checkUserAssignLead);
				$query = $this->db->select('l.*')->from($this->table_lead.' as l')->where("l.type IN (".$leadType.")")->or_where("l.id IN (".$leadAssigned.")")->where("l.status IN ('0','1','2')")->where('l.type <> "INT"')->order_by('l.lead_name ASC')->get();
			} else if(count($checkUserAssignLead)>0){
				$leadAssigned = implode(',', $checkUserAssignLead);
				$query = $this->db->select('l.*')->from($this->table_lead.' as l')->where("l.id IN (".$leadAssigned.")")->where("l.status IN ('0','1','2')")->where('l.type <> "INT"')->order_by('l.lead_name ASC')->get();
			} else if(count($checkUserAssignLeadType)>0){
				$leadType = implode('","', $checkUserAssignLeadType);
				$query = $this->db->select('l.*')->from($this->table_lead.' as l')->where("l.type IN (".$leadType.")")->where("l.status IN ('0','1','2')")->where('l.type <> "INT"')->order_by('l.lead_name ASC')->get();
			}
			if(is_object($query) && $query->num_rows()>0){
				foreach ($query->result() as $row) {
					/*Broker Name*/
					if(!empty($row->broker)){
						$brokderData = $this->db->select('c.first_name,c.last_name,cc.company_name')->from($this->table_contacts.' as c')->join($this->table_company.' as cc','cc.id = c.company_id')->where('c.id',$row->broker)->get()->row();
						if(count($brokderData)>0){
							$row->broker_contact = $brokderData->company_name;
							$row->broker_person_contact = $brokderData->first_name.' '.$brokderData->last_name;
						} else {
							$row->broker_contact ='';
							$row->broker_person_contact = '';
							$row->broker = '';
						}
					}
					
					/*End Broker Name*/
					/*Seller Name*/
					if(!empty($row->plantiffs_name)){
						$sellerInfo = $this->db->select('cc.company_name')->from($this->table_company.' as cc')->where('cc.id',$row->plantiffs_name)->get()->row();
						if(count($sellerInfo)>0){
							$row->seller_contact = $sellerInfo->company_name;
						} else {
							$row->seller_contact = '';
							$row->plantiffs_name = '';
						}
					}
					/*End Seller Name*/
					/*Calculation Attractive*/
					$row->attractive = 0;
					$queryAttractive = $this->db->select('sum(attractive) as attractive,count(id) as counter')->from($this->table_comment)->where('parent_id',$row->id)->get();
					if($queryAttractive->num_rows()>0){
						$attractiveData = $queryAttractive->first_row();
						if($attractiveData->counter>0 && $attractiveData->attractive>0){
							$row->attractive = $attractiveData->attractive/$attractiveData->counter;
						}
					}
					$row->lead_last_seen = "0000-00-00";
					$queryLastSeen = $this->db->select('create_date as login_date')->from($this->table_history)->where('lead_id',$row->id)->order_by('id','desc')->limit(1,0)->get();				
					if($queryLastSeen->num_rows()>0){
						$dataLastSeen = $queryLastSeen->first_row();
						$row->lead_last_seen = $dataLastSeen->login_date;
					}
					/*Person 1*/
					if(!empty($row->person_title_1)){
						$personOneData = $this->db->select('c.first_name,c.last_name,c.job_title')->from($this->table_contacts.' as c')->where('c.id',$row->person_title_1)->get()->row();
						if(count($personOneData)>0){
							$row->person_name_1 = $personOneData->first_name.' '.$personOneData->last_name.', '.$personOneData->job_title;
						} else {
							$row->person_name_1 ='';
							$row->person_title_1 = '';
						}
					}
					/*End Person 1*/
					/*Person 2*/
					if(!empty($row->person_title_2)){
						$personSecondData = $this->db->select('c.first_name,c.last_name,c.job_title')->from($this->table_contacts.' as c')->where('c.id',$row->person_title_2)->get()->row();
						if(count($personSecondData)>0){
							$row->person_name_2 = $personSecondData->first_name.' '.$personSecondData->last_name.', '.$personSecondData->job_title;
						} else {
							$row->person_name_2 ='';
							$row->person_title_2 = '';
						}
					}
					/*End Person 2*/
					$getEouData = $this->findEOULeadMaterial($row->serial_number);
					$evidence = 0;
					if(count($getEouData)>0){
						$eouData = $getEouData->other_field;
						if(is_string($eouData)){
							$jsonDecodeEou = json_decode($eouData);							
							if(isset($jsonDecodeEou->another_license) && $jsonDecodeEou->another_license!='' && count($jsonDecodeEou->another_license)>0){
								foreach($jsonDecodeEou->another_license as $licenseEvidence){									
									if($licenseEvidence->evidence=="Yes"){										
										$evidence = $evidence+1;
									}
								}
							}
						}
					}
					$row->eou = $evidence;
					$data[] = $row;
				}
			}
		}
		
		return $data;
	}	
	public function getSalesActivityCompaniesByLead($leadID){
		$data = array();
		$getInviteesCompanies = $this->db->select("c.id,c.company_name")->from($this->table_invitees.' as i')->join($this->table_company.' as c','c.id=i.contact_id')->where("i.lead_id",$leadID)->order_by('i.last_activity DESC')->get();
		if ($getInviteesCompanies->num_rows() > 0) {
			foreach ($getInviteesCompanies->result() as $company) {
				$data[] = $company;
			}
		}
		return $data;
	}
	public function getAcquisitionActivityCompaniesByLead($leadID){
		$data = array();
		$getInviteesCompanies = $this->db->select("c.id,c.company_name")->from($this->table_acquisition_company.' as i')->join($this->table_company.' as c','c.id=i.contact_id')->where("i.lead_id",$leadID)->order_by('i.last_activity DESC')->get();
		if ($getInviteesCompanies->num_rows() > 0) {
			foreach ($getInviteesCompanies->result() as $company) {
				$data[] = $company;
			}
		}
		return $data;
	}
	public function getPreSaleActivityCompaniesByLead($leadID){
		$data = array();
		$getInviteesCompanies = $this->db->select("c.id,c.company_name")->from($this->table_invitees.' as i')->join($this->table_company.' as c','c.id=i.contact_id')->where("i.lead_id",$leadID)->order_by('i.pre_sale_activity DESC')->get();
		if ($getInviteesCompanies->num_rows() > 0) {
			foreach ($getInviteesCompanies->result() as $company) {
				$data[] = $company;
			}
		}
		return $data;
	}
	function findCallData($activityID,$t){
		$data = array();
		$query = "";
		if($t==1){
			$query = $this->db->select("s.*,CONCAT((p.first_name),(' '),(p.last_name)) as personName")->from($this->table_sales_activity.' as s')->join($this->table_contacts.' as p','p.id = s.contact_id')->where('s.id',$activityID)->get();
		} else if($t==2){
			$query = $this->db->select("s.*,CONCAT((p.first_name),(' '),(p.last_name)) as personName")->from($this->table_acquisition_activity.' as s')->join($this->table_contacts.' as p','p.id = s.contact_id')->where('s.id',$activityID)->get();
		}
		if(is_object($query)){
			if($query->num_rows()>0){
				$data = $query->first_row();
			}
		}
		return $data;
	}	
	function findPersonLastActivty($leadID,$companyID,$personID,$activity){
		$data = array();
		switch((int)$activity){
			case 2:
				$query = $this->db->select("*")->from($this->table_acquisition_activity)->where('lead_id',$leadID)->where('contact_id',$personID)->where('company_id',$companyID)->where('email_id',0)->order_by('id desc')->limit(1,0)->get();
				if($query->num_rows()>0){
					$data = $query->first_row();
				}
			break;
			case 1:
			default:
				$query = $this->db->select("*")->from($this->table_sales_activity)->where('lead_id',$leadID)->where('contact_id',$personID)->where('company_id',$companyID)->where('email_id',0)->order_by('id desc')->limit(1,0)->get();
				if($query->num_rows()>0){
					$data = $query->first_row();
				}
			break;
		}
		return $data;
	}
	function getSalesContatcsByLead($leadID){
		$persons = array();
		$getInviteesCompanies = $this->db->select("c.id,c.company_name,s.id as sectorID, s.name as sectorName")->from($this->table_invitees.' as i')->join($this->table_company.' as c','c.id=i.contact_id')->join($this->table_company_sector.' as cs', 'c.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where("i.lead_id",$leadID)->order_by('i.last_activity DESC')->get();
		if ($getInviteesCompanies->num_rows() > 0) {
			foreach ($getInviteesCompanies->result() as $company) {
				$getPersons = $this->db->select("*")->from($this->table_contacts)->where("company_id",$company->id)->order_by("first_name DESC")->get();
				if($getPersons->num_rows()>0){
					foreach ($getPersons->result() as $p) {
						$p->company_name = $company->company_name;
						$p->sectorName = $company->sectorName;
						$p->departments =  $this->departments($company->id);
						$persons[] = $p;
					}
				}
			}
		}
		return $persons;
	}	
	
	function departments($customerID){
		$query = $this->db->select("c.*")->from($this->table_preference.' as p')->join($this->table_category.' as c','c.id = p.preference_id')->where("p.customer_id",$customerID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data;
	}
	public function allLeadsWithActivity($activity){
		/*2=>Acquisition,1=>Sales Activity*/
		$query = $this->db->select('id,lead_name')->from($this->table_lead)->where("status IN ('0','1','2')")->order_by('lead_name ASC')->get();
		$data = array();		
		if($query->num_rows()>0){
			foreach ($query->result() as $row) {
				$companyData = array();	
				if($activity==2){
					$getInviteesCompanies = $this->db->select("c.id,c.company_name")->from($this->table_acquisition_company.' as i')->join($this->table_company.' as c','c.id=i.contact_id')->where("i.lead_id",$row->id)->order_by('i.last_activity DESC')->get();
					if ($getInviteesCompanies->num_rows() > 0) {
						foreach ($getInviteesCompanies->result() as $company) {
							$getPersons = $this->db->select("*")->from($this->table_contacts)->where("company_id",$company->id)->order_by("first_name DESC")->get();
							$persons =array();
							if($getPersons->num_rows()>0){
								foreach ($getPersons->result() as $p) {
									$persons[] = $p;
								}
							}				
							$companyData[]=array("company"=>$company,"people"=>$persons);
						}
					}
				} else if($activity==3){
					$getInviteesCompanies = $this->db->select("c.id,c.company_name")->from($this->table_invitees.' as i')->join($this->table_company.' as c','c.id=i.contact_id')->where("i.lead_id",$row->id)->order_by('i.pre_sale_activity DESC')->get();
					if ($getInviteesCompanies->num_rows() > 0) {
						foreach ($getInviteesCompanies->result() as $company) {
							$getPersons = $this->db->select("*")->from($this->table_contacts)->where("company_id",$company->id)->order_by("first_name DESC")->get();
							$persons =array();
							if($getPersons->num_rows()>0){
								foreach ($getPersons->result() as $p) {
									$persons[] = $p;
								}
							}				
							$companyData[]=array("company"=>$company,"people"=>$persons);
						}
					}
				} else {
					$getInviteesCompanies = $this->db->select("c.id,c.company_name")->from($this->table_invitees.' as i')->join($this->table_company.' as c','c.id=i.contact_id')->where("i.lead_id",$row->id)->order_by('i.last_activity DESC')->get();
					if ($getInviteesCompanies->num_rows() > 0) {
						foreach ($getInviteesCompanies->result() as $company) {
							$getPersons = $this->db->select("*")->from($this->table_contacts)->where("company_id",$company->id)->order_by("first_name DESC")->get();
							$persons =array();
							if($getPersons->num_rows()>0){
								foreach ($getPersons->result() as $p) {
									$persons[] = $p;
								}
							}				
							$companyData[]=array("company"=>$company,"people"=>$persons);
						}
					}
				}				
				$row->box_list = $companyData;
				$data[] = $row;
			}			
		}
		return $data;
	}
	function checkUserLeads($userID){
		$data = array();
		$query = $this->db->select('l.lead_id as id')->from($this->table_assign_lead.' as l')->where('l.pd_id',$userID)->get();
		if($query->num_rows()>0){
			foreach ($query->result() as $row) {
				$data[] =  $row->id;
			}
		}/*
		$findUserEmail = $this->db->select('u.email')->from($this->table.' as u')->where('u.id',$userID)->get()->row()->email;
		if(!empty($findUserEmail) && $findUserEmail!=null){
			$getContactDetails = $this->db->select('c.*')->from($this->table_contacts.' as c')->where('trim(c.email)',$findUserEmail)->get();
			if($getContactDetails->num_rows()>0){
				$contact = $getContactDetails->first_row();
				<!--Leads from sales-->
				$findAllContactsBelongsToContactCompany = $this->db->select("c.id")->from($this->table_contacts.' as c')->where("c.company_id",$contact->company_id)->get();
				$allContacts = array();
				if($findAllContactsBelongsToContactCompany->num_rows()>0){
					foreach($findAllContactsBelongsToContactCompany->result() as $row){
						$allContacts[] = $row->id;
					}
					if(count($allContacts)>0){
						$findCompanyAssociateToThisContacts = $this->findCompaniesAssociate($allContacts);
						$findCompanyAssociateToThisContacts[] = $contact->company_id;
						if(count($findCompanyAssociateToThisContacts)>0){
							$companies = implode(',',$findCompanyAssociateToThisContacts);
							$getLeadsFromSales = $this->db->select('DISTINCT(i.lead_id) as lead_id')->from($this->table_invitees.' as i')->where('i.contact_id IN ('.$companies.')')->get();
							if($getLeadsFromSales->num_rows()>0){
								foreach($getLeadsFromSales->result() as $row){
									$data[] = $row->lead_id;
								}
							}
						}
					}
				}
			}
		}*/
		return $data;
	}	
	function checkUserAssignLeadType($userID){
		$data = array();
		$query = $this->db->select('l.lead_type as type')->from($this->table_assign_lead_type.' as l')->where('l.user_id',$userID)->get();
		if($query->num_rows()>0){
			foreach ($query->result() as $row) {
				$data[] =  '"'.$row->type.'"';
			}
		}
		return $data;
	}	
	public function findIncompleteANDCompleteListAccUser($userID){
		//$query = $this->db->select('*')->from($this->table_lead)->where('type',$type)->get();
        /*$query = $this->db->select('l.*')->from($this->table_lead.' as l')->join($this->table_assign_lead .' as al','al.lead_id = l.id')->where('al.pd_id',$userID)->where("l.status IN ('0','1','2')")->where('l.type <> "INT"')->get();*/
		$checkUserAssignLead = $this->checkUserLeads($userID);
		$checkUserAssignLeadType = $this->checkUserAssignLeadType($userID);
		$data = array();
        /*$query = $this->db->select('l.*')->from($this->table_lead.' as l')->where("l.status IN ('0','1','2')")->where('l.type <> "INT"')->order_by('l.lead_name ASC')->get();
		*/
		$query = "";
		$select = 'l.id,l.serial_number,l.lead_name,l.type ,l.create_date ,l.seller_info ,l.seller_info_text ,l.seller_like ,l.funding_trnsfr ,l.complete ,l.status ,l.synpat_like ,l.ppa_id ,l.ppa_text_date ,l.execute_ppa ,l.ppa_execute ,l.ppa_date ,l.plantiffs_name ,l.technologies ,l.no_of_us_patents ,l.no_of_non_us_patents ,l.send_proposal_letter ,l.market_data ,l.seller_contact ,l.broker_contact,l.broker ,l.broker_person_contact ,l.person_name_1 ,l.person_title_1 ,l.person_name_2 ,l.person_title_2 ,l.address ,l.relates_to ,l.expected_price ,l.update_date';
		if(count($checkUserAssignLead)>0 && count($checkUserAssignLeadType)>0){
			$leadType = implode('","', $checkUserAssignLeadType);
			$leadAssigned = implode(',', $checkUserAssignLead);
			$query = $this->db->select($select)->from($this->table_lead.' as l')->where("l.type IN (".$leadType.")")->or_where("l.id IN (".$leadAssigned.")")->where("l.status IN ('0','1','2')")->where('l.type <> "INT"')->order_by('l.lead_name ASC')->get();
		} else if(count($checkUserAssignLead)>0){
			$leadAssigned = implode(',', $checkUserAssignLead);
			$query = $this->db->select($select)->from($this->table_lead.' as l')->where("l.id IN (".$leadAssigned.")")->where("l.status IN ('0','1','2')")->where('l.type <> "INT"')->order_by('l.lead_name ASC')->get();
		} else if(count($checkUserAssignLeadType)>0){
			$leadType = implode('","', $checkUserAssignLeadType);
			$query = $this->db->select($select)->from($this->table_lead.' as l')->where("l.type IN (".$leadType.")")->where("l.status IN ('0','1','2')")->where('l.type <> "INT"')->order_by('l.lead_name ASC')->get();
		}
		if(is_object($query) && $query->num_rows()>0){
			foreach ($query->result() as $row) {
				/*Broker Name*/
					if(!empty($row->broker)){
						$brokderData = $this->db->select('c.first_name,c.last_name,cc.company_name')->from($this->table_contacts.' as c')->join($this->table_company.' as cc','cc.id = c.company_id')->where('c.id',$row->broker)->get()->row();
						if(count($brokderData)>0){
							$row->broker_contact = $brokderData->company_name;
							$row->broker_person_contact = $brokderData->first_name.' '.$brokderData->last_name;
						} else {
							$row->broker_contact ='';
							$row->broker_person_contact = '';
							$row->broker = '';
						}
					}
					
					/*End Broker Name*/
					/*Seller Name*/
					if(!empty($row->plantiffs_name)){
						$sellerInfo = $this->db->select('cc.company_name')->from($this->table_company.' as cc')->where('cc.id',$row->plantiffs_name)->get()->row();
						if(count($sellerInfo)>0){
							$row->seller_contact = $sellerInfo->company_name;
						} else {
							$row->seller_contact = '';
							$row->plantiffs_name = '';
						}
					}
					/*End Seller Name*/
					/*Lead Last seen*/
					$row->lead_last_seen = "0000-00-00";
					$queryLastSeen = $this->db->select('create_date as login_date')->from($this->table_history)->where('lead_id',$row->id)->order_by('id','desc')->limit(1,0)->get();					
					if($queryLastSeen->num_rows()>0){
						$dataLastSeen = $queryLastSeen->first_row();
						$row->lead_last_seen = $dataLastSeen->login_date;
					}
					/*End Lead Last seen*/
					/*Person 1*/
					if(!empty($row->person_title_1)){
						$personOneData = $this->db->select('c.first_name,c.last_name,c.job_title')->from($this->table_contacts.' as c')->where('c.id',$row->person_title_1)->get()->row();
						if(count($personOneData)>0){
							$row->person_name_1 = $personOneData->first_name.' '.$personOneData->last_name.', '.$personOneData->job_title;
						} else {
							$row->person_name_1 ='';
							$row->person_title_1 = '';
						}
					}
					/*End Person 1*/
					/*Person 2*/
					if(!empty($row->person_title_2)){
						$personSecondData = $this->db->select('c.first_name,c.last_name,c.job_title')->from($this->table_contacts.' as c')->where('c.id',$row->person_title_2)->get()->row();
						if(count($personSecondData)>0){
							$row->person_name_2 = $personSecondData->first_name.' '.$personSecondData->last_name.', '.$personSecondData->job_title;
						} else {
							$row->person_name_2 ='';
							$row->person_title_2 = '';
						}
					}
					/*End Person 2*/
					/*Calculation Attractive*/
					$row->attractive = 0;
					$queryAttractive = $this->db->select('sum(attractive) as attractive,count(id) as counter')->from($this->table_comment)->where('parent_id',$row->id)->get();
					if($queryAttractive->num_rows()>0){
						$attractiveData = $queryAttractive->first_row();
						if($attractiveData->counter>0 && $attractiveData->attractive>0){
							$row->attractive = $attractiveData->attractive/$attractiveData->counter;
						}
					}
					/**/
				/*$boxQuery = $this->db->select("*")->from($this->table_box)->where('lead_id',$row->id)->order_by('lead_id','DESC')->get();
				$boxData =array();
				if(count($boxQuery->num_rows())>0){
					foreach($boxQuery->result() as $box){
						$boxData[] = $box;
					}
				}
				$row->box_list = $boxData;*/
				$data[] = $row;
			}			
		}
		return $data;
	}
	
	public function from_count_incomplete_litigation($type,$complete){
		$query = $this->db->select('count(*) as leadCount')->from($this->table_lead)->where('complete',$complete)->where('type',$type)->where('status','0')->get();
		$data = array();
		if($query->num_rows()>0){
			$data =$query->first_row();
		}
		return $data;
	}
	
	public function record_count($type,$complete=1) {
		$this->db->where('type',$type);
		$this->db->where('status','0');
		$this->db->where('complete',$complete);
        return $this->db->count_all_results($this->table_lead);
    }
	
	function findBoxList($leadID,$type=0){
		$boxQuery = $this->db->select("*")->from($this->table_box)->where('lead_id',$leadID)->where('type',$type)->order_by('date_received','DESC')->get();
		$boxList =array();
		if(count($boxQuery->num_rows())>0){
			foreach($boxQuery->result() as $box){
				$boxList[] = $box;
			}
		}
		return $boxList;
	}
	
	function findBoxByThread($threadID){
		$boxQuery = $this->db->select("*")->from($this->table_box)->where('thread_id',$threadID)->get();
		$boxList =array();
		if(count($boxQuery->num_rows())>0){
			foreach($boxQuery->result() as $box){
				$boxList[] = $box;
			}
		}
		return $boxList;
	}
	
	function findBoxByMessageID($messsageID){
		$boxQuery = $this->db->select("*")->from($this->table_box)->where('message_id',$messsageID)->get();
		$boxList =array();
		if(count($boxQuery->num_rows())>0){
			foreach($boxQuery->result() as $box){
				$boxList[] = $box;
			}
		}
		return $boxList;
	}
	
	function findBoxNewById($threadID){
		$boxQuery = $this->db->select("*")->from($this->table_box)->where('id',$threadID)->get();
		$boxList =array();
		if(count($boxQuery->num_rows())>0){
			$boxList[] = $boxQuery->first_row();			
		}
		return $boxList;
	}
	
	function findAllBoxList(){
		$boxQuery = $this->db->select("*")->from($this->table_box)->get();
		$boxList =array();
		if(count($boxQuery->num_rows())>0){
			foreach($boxQuery->result() as $box){
				$boxList[] = $box;
			}
		}
		
		return $boxList;
	}
	function findAllBoxThreadList(){
		$boxQuery = $this->db->select("thread_id")->from($this->table_box)->get();
		$boxList =array();
		if(count($boxQuery->num_rows())>0){
			foreach($boxQuery->result() as $box){
				$boxList[] = $box;
			}
		}
		
		return $boxList;
	}
	
	
	public function checkUserCreatedLeadFromLitigation(){
		$userID = $this->session->userdata['id'];
		$start = (date('D') != 'Mon') ? date('Y-m-d', strtotime('last Monday')) : date('Y-m-d');
		$finish = (date('D') != 'Sat') ? date('Y-m-d', strtotime('next Saturday')) : date('Y-m-d');
		$query = $this->db->select('count(*) as leads')->from($this->table_lead)->where('type','Litigation')->where('date_format(create_date,"%Y-%m-%d")>=',$start)->where('date_format(create_date,"%Y-%m-%d")<=',$finish)->where('user_id',$userID)->get();
		return $query->row();
		
	}
	public function findAllLitigationWithPaging($type,$limit,$start,$complete=1){
		$this->db->limit($limit, $start);
		$this->db->order_by('id','DESC');		
		$query = $this->db->select('l.*,u.name as userName')->from($this->table_lead.' as l')->join('users as u','u.id=l.user_id','left outer')->where('l.type',$type)->where('l.status','0')->where('complete',$complete)->order_by('l.id','DESC')->get();

	
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $allArray = array();
				$allArray['litigation'] = $row;
				$allArray['comment'] = $this->getLitigationComments($row->id,$type);
				$data[] = $allArray;
            }            
        }
		
		return $data;
	}
    public function findOneLitigationWithPaging($lead_id,$type){
		$query = $this->db->select('l.*,u.name as userName')->from($this->table_lead.' as l')->join('users as u','u.id=l.user_id','left outer')->where('l.type',$type)->where('l.status','0')->where('l.id',$lead_id)->order_by('l.id','DESC')->get();
       
		
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $allArray = array();
				$allArray['litigation'] = $row;
				$allArray['comment'] = $this->getLitigationComments($row->id,$type);
				$data[] = $allArray;
            }            
        }
		
		return $data;
	}
		
	public function getSalesActivityLead($lead_id){
		$data = array();
		$data['sales_activity'] = $this->getSalesActivity($lead_id);
		$data['presales_activity'] = $this->getPreSalesActivity($lead_id);
		$data['broker_as_companies'] = $this->findLeadCompanyBrokerDetails($lead_id);
		$data['pre_broker_as_companies'] = $this->findLeadCompanyBrokerDetails($lead_id);
		return $data;
	}
	
	function getLeadSerialNumber($leadID){
		return $this->db->select('l.serial_number')->from($this->table_lead.' as l')->where('l.id',$leadID)->get()->row()->serial_number;
	}
	
	function getCompanyList($search,$select){
		$data = array();
		if(trim($search)!=""){
			$query = $this->db->select($select)->from($this->table_company.' as c')->where('c.company_name LIKE "%'.$search.'%"')->order_by('c.company_name','ASC')->get();
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					$data[] = $row;
				}
			}
		}		
		return $data;
	}
	
	function getOpenProjectList($leadID){
		$query = $this->db->select("op.*, CONCAT((c.first_name),(' '),(c.last_name)) as personName,co.company_name")->from($this->table_lead_open_project.' as op')->join($this->table_contacts.' as c','c.id = op.contact_id','INNER')->join($this->table_company.' as co','co.id = c.company_id','INNER')->where('op.lead_id',$leadID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
        }
		return $data;
	}
	
	public function getAllLeadWithoutSellerID(){
		$query = $this->db->select('id,folder_id')->from($this->table_lead.' as l')->where_in('l.status',array(0,1,2))->where('seller_material_folder_id','')->order_by('l.id','DESC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$data[] = $row;
			}
		}
		return $data;
	}
	
	function findLeadTableData($lead_id){
		$select = 'l.id,l.serial_number,l.lead_name ,l.type ,l.create_date ,l.seller_info ,l.seller_info_text ,l.seller_like ,l.funding_trnsfr ,l.complete ,l.status ,l.synpat_like ,l.ppa_text_date ,l.execute_ppa ,l.ppa_execute ,l.ppa_date ,l.plantiffs_name ,l.seller_contact ,l.broker_contact ,l.broker ,l.broker_person_contact ,l.person_name_1 ,l.person_title_1 ,l.person_name_2 ,l.person_title_2 ,l.relates_to ,l.update_date';
		$query = $this->db->select($select)->from($this->table_lead.' as l')->where('l.id',$lead_id)->order_by('l.id','DESC')->get();		
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $allArray = array();
                /**/
                /*Broker Name*/
					if(!empty($row->broker)){
						$brokderData = $this->db->select('c.first_name,c.last_name,cc.company_name')->from($this->table_contacts.' as c')->join($this->table_company.' as cc','cc.id = c.company_id')->where('c.id',$row->broker)->get()->row();
						if(count($brokderData)>0){
							$row->broker_contact = $brokderData->company_name;
							$row->broker_person_contact = $brokderData->first_name.' '.$brokderData->last_name;
						} else {
							$row->broker_contact ='';
							$row->broker_person_contact = '';
							$row->broker = '';
						}
					}
					
					/*End Broker Name*/
					/*Seller Name*/
					if(!empty($row->plantiffs_name)){
						$sellerInfo = $this->db->select('cc.company_name')->from($this->table_company.' as cc')->where('cc.id',$row->plantiffs_name)->get()->row();
						if(count($sellerInfo)>0){
							$row->seller_contact = $sellerInfo->company_name;
						} else {
							$row->seller_contact = '';
							$row->plantiffs_name = '';
						}
					}
					/*End Seller Name*/

					/*Person 1*/
					if(!empty($row->person_title_1)){
						$personOneData = $this->db->select('c.first_name,c.last_name,c.job_title')->from($this->table_contacts.' as c')->where('c.id',$row->person_title_1)->get()->row();
						if(count($personOneData)>0){
							$row->person_name_1 = $personOneData->first_name.' '.$personOneData->last_name.', '.$personOneData->job_title;
						} else {
							$row->person_name_1 ='';
							$row->person_title_1 = '';
						}
					}
					/*End Person 1*/
					/*Person 2*/
					if(!empty($row->person_title_2)){
						$personSecondData = $this->db->select('c.first_name,c.last_name,c.job_title')->from($this->table_contacts.' as c')->where('c.id',$row->person_title_2)->get()->row();
						if(count($personSecondData)>0){
							$row->person_name_2 = $personSecondData->first_name.' '.$personSecondData->last_name.', '.$personSecondData->job_title;
						} else {
							$row->person_name_2 ='';
							$row->person_title_2 = '';
						}
					}
					/*End Person 2*/
					/*Lead Last seen*/
					$row->lead_last_seen = "0000-00-00";
					$queryLastSeen = $this->db->select('create_date as login_date')->from($this->table_history)->where('lead_id',$row->id)->order_by('id','desc')->limit(1,0)->get();					
					if($queryLastSeen->num_rows()>0){
						$dataLastSeen = $queryLastSeen->first_row();
						$row->lead_last_seen = $dataLastSeen->login_date;
					}
					/*End Lead Last seen*/
					/*Calculation Attractive*/
					$row->attractive = 0;
					$queryAttractive = $this->db->select('sum(attractive) as attractive,count(id) as counter')->from($this->table_comment)->where('parent_id',$row->id)->get();
					if($queryAttractive->num_rows()>0){
						$attractiveData = $queryAttractive->first_row();
						if($attractiveData->counter>0 && $attractiveData->attractive>0){
							$row->attractive = $attractiveData->attractive/$attractiveData->counter;
						}
					}
					/**/
					$getEouData = $this->findEOULeadMaterial($row->serial_number);
					$evidence = 0;
					if(count($getEouData)>0){
						$eouData = $getEouData->other_field;
						if(is_string($eouData)){
							$jsonDecodeEou = json_decode($eouData);							
							if(isset($jsonDecodeEou->another_license) && $jsonDecodeEou->another_license!='' && count($jsonDecodeEou->another_license)>0){
								foreach($jsonDecodeEou->another_license as $licenseEvidence){									
									if($licenseEvidence->evidence=="Yes"){										
										$evidence = $evidence+1;
									}
								}
							}
						}
					}
					$row->eou = $evidence;
                /**/
				$allArray['litigation'] = $row;				             
				$data[] = $allArray;
            }            
        }		
		return $data;
	}
	
	function findFamilyPatents($leadID){
		/*$getDataFromLeadPatent = $this->db->select("patent_number , 'Patent' as type")->from($this->table_lead_patent)->where('lead_id',$leadID)->get();*/
		$getDataFromLeadPatent = $this->db->query("SELECT patent_number , 'Patent' as type FROM ".$this->table_lead_patent." WHERE lead_id=".(int)$leadID);
		$familyPatent = array();
		if ($getDataFromLeadPatent->num_rows() > 0) {
			$patentList = array();
			foreach ($getDataFromLeadPatent->result() as $row) {
				$familyPatent[] = $row;
				$patentList[] = $row->patent_number;
			}
			if(count($familyPatent)){
				$getDataFromLeadPatentFamily = $this->db->select("distinct(child_number) as patent_number , type")->from($this->table_lead_patent_family)->where_in('parent_number',$patentList)->where_not_in('child_number',$patentList)->get();
				foreach ($getDataFromLeadPatentFamily->result() as $rowFamily) {
					$familyPatent[] = $rowFamily;
				}
			}
		}
		return $familyPatent;
	}
	
	public function findOneLitigationWithIncomplete1($lead_id,$type){
		$select = 'l.id,l.serial_number,file_url,l.lead_name ,l.spreadsheet_id  ,l.worksheet_id ,l.worksheet_name ,l.type ,l.patent_data ,l.create_date ,l.seller_info ,l.seller_info_text ,l.seller_like ,l.funding_trnsfr ,l.claim_illus ,l.claim_status_dd ,l.technical_dd ,l.technical_status_dd ,l.legal_dd  ,l.legal_status_dd ,l.create_patent_list  ,l.create_patent_list_text ,l.complete ,l.forward_to_review_text  ,l.nda_term_sheet  ,l.nda_term_sheet_text ,l.status ,l.synpat_like ,l.ppa_id ,l.ppa_text_date ,l.execute_ppa ,l.ppa_execute ,l.ppa_date ,l.plantiffs_name ,l.no_of_prospects ,l.upfront_price ,l.prospects_name ,l.technologies ,l.no_of_us_patents ,l.no_of_non_us_patents ,l.send_proposal_letter ,l.market_data ,l.seller_contact ,l.broker_contact ,l.option_expiration_date ,l.broker ,l.broker_person_contact ,l.person_name_1 ,l.person_title_1 ,l.person_name_2 ,l.person_title_2 ,l.address ,l.relates_to ,l.expected_price ,l.update_date ,l.next_action ,l.case_name ,l.litigation_stage ,l.market_industry ,l.case_type ,l.case_number ,l.cause no_of_patent ,l.filling_date ,l.active_defendants ,l.lead_attorney ,l.scrapper_data ,l.original_defendants ,l.court ,l.link_to_pacer ,l.link_to_rpx ,l.defendants ,l.court_docket_entries,l.folder_id';
		$query = $this->db->select($select)->from($this->table_lead.' as l')->where('l.id',$lead_id)->order_by('l.id','DESC')->get();
		
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $allArray = array();
                /**/
                /*Broker Name*/
					if(!empty($row->broker)){
						$brokderData = $this->db->select('c.first_name,c.last_name,cc.company_name')->from($this->table_contacts.' as c')->join($this->table_company.' as cc','cc.id = c.company_id')->where('c.id',$row->broker)->get()->row();
						if(count($brokderData)>0){
							$row->broker_contact = $brokderData->company_name;
							$row->broker_person_contact = $brokderData->first_name.' '.$brokderData->last_name;
						} else {
							$row->broker_contact ='';
							$row->broker_person_contact = '';
							$row->broker = '';
						}
					}
					
					/*End Broker Name*/
					/*Seller Name*/
					if(!empty($row->plantiffs_name)){
						$sellerInfo = $this->db->select('cc.company_name')->from($this->table_company.' as cc')->where('cc.id',$row->plantiffs_name)->get()->row();
						if(count($sellerInfo)>0){
							$row->seller_contact = $sellerInfo->company_name;
						} else {
							$row->seller_contact = '';
							$row->plantiffs_name = '';
						}
					}
					/*End Seller Name*/

					/*Person 1*/
					if(!empty($row->person_title_1)){
						$personOneData = $this->db->select('c.first_name,c.last_name')->from($this->table_contacts.' as c')->where('c.id',$row->person_title_1)->get()->row();
						if(count($personOneData)>0){
							$row->person_name_1 = $personOneData->first_name.' '.$personOneData->last_name;
						} else {
							$row->person_name_1 ='';
							$row->person_title_1 = '';
						}
					}
					/*End Person 1*/
					/*Person 2*/
					if(!empty($row->person_title_2)){
						$personSecondData = $this->db->select('c.first_name,c.last_name')->from($this->table_contacts.' as c')->where('c.id',$row->person_title_2)->get()->row();
						if(count($personSecondData)>0){
							$row->person_name_2 = $personSecondData->first_name.' '.$personSecondData->last_name;
						} else {
							$row->person_name_2 ='';
							$row->person_title_2 = '';
						}
					}
					/*End Person 2*/
					/*Lead Last seen*/
					$row->lead_last_seen = "0000-00-00";
					$queryLastSeen = $this->db->select('create_date as login_date')->from($this->table_history)->where('lead_id',$row->id)->order_by('id','desc')->limit(1,0)->get();					
					if($queryLastSeen->num_rows()>0){
						$dataLastSeen = $queryLastSeen->first_row();
						$row->lead_last_seen = $dataLastSeen->login_date;
					}
					/*End Lead Last seen*/
					/*Calculation Attractive*/
					$row->attractive = 0;
					$queryAttractive = $this->db->select('sum(attractive) as attractive,count(id) as counter')->from($this->table_comment)->where('parent_id',$row->id)->get();
					if($queryAttractive->num_rows()>0){
						$attractiveData = $queryAttractive->first_row();
						if($attractiveData->counter>0 && $attractiveData->attractive>0){
							$row->attractive = $attractiveData->attractive/$attractiveData->counter;
						}
					}
					/**/
					$getEouData = $this->findEOULeadMaterial($row->serial_number);
					$evidence = 0;
					if(count($getEouData)>0){
						$eouData = $getEouData->other_field;
						if(is_string($eouData)){
							$jsonDecodeEou = json_decode($eouData);							
							if(isset($jsonDecodeEou->another_license) && $jsonDecodeEou->another_license!='' && count($jsonDecodeEou->another_license)>0){
								foreach($jsonDecodeEou->another_license as $licenseEvidence){									
									if($licenseEvidence->evidence=="Yes"){										
										$evidence = $evidence+1;
									}
								}
							}
						}
					}
					$row->eou = $evidence;
                /**/
				$allArray['comment'] = $this->getLitigationComments($row->id,$type);
                /*$allArray['timeLine'] = $this->getAllUserHistory(0,$row->id,0);*/
                $allArray['timeLine'] = array();
                /*$allArray['task'] = $this->getAllTaskFromLead($row->id);
				$allArray['task_i'] = $this->myTaskApproval($row->id);*/
                $allArray['task'] = array();
                $allArray['task_i'] = array();
                $allArray['acquisitions'] = $this->getAcquisitionData($row->id,'a.store_name,a.order_name,a.category,a.regular_license_starts,a.late_license_starts,a.active_button,a.docket_status');
				
				$illustrationComplete = 0;
				$techDDComplete = 0;
				$marketDDComplete = 0;
				$legalDDComplete = 0;
				$pdfDDComplete = 0;
				$comparablesComplete = 0;
				$invitesComplete = 0;
				$imageComplete = 0;
				$family = 0;
				$assets = 0;
				$jurisd = 0;
				$marketCategoriesString = "";
				$marketCategories= array();
				if(count($allArray['acquisitions'])>0){					
					$getLeadPatentList = $this->getLeadPatentList($row->id);
					if(count($getLeadPatentList)>0){
						$patentsList = array();
						foreach($getLeadPatentList as $p){
							$patentsList[] = $p->patent;
						}
						if(count($patentsList)>0){
							/*Number of Illustration Patent Complete*/
							$illustrationComplete = $this->db->select("count(id) as illustrationComplete")->from($this->table_due_dilligence_illustrations)->where_in('patent_id',$patentsList)->where('status',1)->get()->row()->illustrationComplete;							
							/*End*/
							/*Number of TechDD Patent Complete*/
							$techDDComplete = $this->db->select("count(id) as techDDComplete")->from($this->table_due_dilligence_inventions)->where_in('patent_id',$patentsList)->where('tech_status',1)->get()->row()->techDDComplete;	
							echo $this->db->last_query();
							/*End*/
							/*Number of Market Patent Complete*/
							$marketDDComplete = $this->db->select("count(id) as marketDDComplete")->from($this->table_due_dilligence_inventions)->where_in('patent_id',$patentsList)->where('market_status',1)->get()->row()->marketDDComplete;	
							/*End*/
							/*Number of LegalDD Patent Complete*/
							$legalDDComplete = $this->db->select("count(id) as legalDDComplete")->from($this->table_due_dilligence_legal)->where_in('patent_id',$patentsList)->where('status',1)->get()->row()->legalDDComplete;
							/*End*/
							/*Number of PDFs Patent Complete*/
							$pdfDDComplete = $this->db->select("count(id) as pdfDDComplete")->from($this->table_due_dilligence_pdf)->where_in('patent_id',$patentsList)->where('status',1)->get()->row()->pdfDDComplete;
							/*End*/
						}
					}	
					$family = $this->db->select("count(patent_number) as family")->from($this->table_lead_patent)->where('lead_id',$row->id)->get()->row()->family;
					$getLicenseResult = $this->db->select('id as licenseID')->from($this->table_licenses)->where('serial_number',$row->serial_number)->get();
					$allPatentApplication = $this->findFamilyPatents($row->id);
					/*Lead Family, Assets, Jurisdiction*/
					$chartLeftData = array();
					if(count($allPatentApplication)>0){
						foreach($allPatentApplication as $publishedPatent){
							$first2Letter = substr($publishedPatent->patent_number,0,2);
							if(count($chartLeftData)>0){
								$enter = false;
								$l=0;
								foreach($chartLeftData as $left){
									if($left['country']==$first2Letter){
										/*echo "COUNTRY:".$left['country']."MATTER:".$first2Letter."<br/>";*/
										$patentCount = $left['patents'];
										$applicationCount = $left['applications'];
										/*echo '1'.$publishedPatent->type."@@".$publishedPatent->patent_number."LEN".strlen($publishedPatent->patent_number)."<br/>";*/
										if($publishedPatent->type=="Patent"  || $publishedPatent->type=="Grant"){
											if(strlen($publishedPatent->patent_number)>11){
												$applicationCount = (int) $applicationCount + 1;
											} else {
												$patentCount = (int) $patentCount + 1;
												/*echo "PATENT: ".$patentCount."<br/>";*/
											}
										} else if($publishedPatent->type=="Application"){
											$applicationCount = (int) $applicationCount + 1;
										}
										$chartLeftData[$l]['patents'] = $patentCount;
										$chartLeftData[$l]['applications'] = $applicationCount;
										$enter = true;
										break;
									}
									$l++;
								}
								if($enter===false){
									$patentCount = 0;
									$applicationCount = 0;
									if($publishedPatent->type=="Patent" || $publishedPatent->type=="Grant"){
										/*echo '2'.$publishedPatent->type."@@".$publishedPatent->patent_number."LEN".strlen($publishedPatent->patent_number)."<br/>";*/
										if(strlen($publishedPatent->patent_number)>11){
											$applicationCount = (int) $applicationCount + 1;
										} else {
											$patentCount = (int) $patentCount + 1;
											/*echo "PATENT: ".$patentCount."<br/>";*/
										}
									} else if($publishedPatent->type=="Application"){
										$applicationCount = 1;
									}
									$chartLeftData[] = array('license_id'=>$getLicenseData->id,'country'=>$first2Letter,'patents'=>$patentCount,'applications'=>$applicationCount);
								}
							} else {
								$patentCount = 0;
								$applicationCount = 0;
								/*echo '3'.$publishedPatent->type."@@".$publishedPatent->patent_number."LEN".strlen($publishedPatent->patent_number)."<br/>";*/
								if($publishedPatent->type=="Patent" || $publishedPatent->type=="Grant"){
									if(strlen($publishedPatent->patent_number)>11){
										$applicationCount = (int) $applicationCount + 1;
									} else {
										$patentCount = (int) $patentCount + 1;
										/*echo "PATENT: ".$patentCount."<br/>";*/
									}
								} else if($publishedPatent->type=="Application"){
									$applicationCount = 1;
								}
								$chartLeftData[] = array('license_id'=>$getLicenseData->id,'country'=>$first2Letter,'patents'=>$patentCount,'applications'=>$applicationCount);
							}
						}
					}					
					$assets = 0;
					$countCountry = array();
					if(count($chartLeftData)>0){
						foreach($chartLeftData as $chartL){
							$chartL = (object) $chartL;
							if(strtolower(strtoupper($chartL->country))!="wo" && strtolower(strtoupper($chartL->country))!="ep"){
								$assets = $assets + (int)$chartL->applications + (int)$chartL->patents;
								if(!in_array($chartL->country,$countCountry)){
									$countCountry[] = $chartL->country;
								}
							}								
						}
					}
					$jurisd = count($countCountry);
					if($getLicenseResult->num_rows()>0){
						$getLicenseData = $getLicenseResult->first_row();
						/*Number of Comparables Agreement*/
						$comparablesComplete = $this->db->select("count(id) as comparablesComplete")->from($this->table_comparables)->where('license_id',$getLicenseData->licenseID)->get()->row()->comparablesComplete;
						/*End*/
						/*Number of Invitees Patent Complete*/
						$invitesComplete = $this->db->select("count(id) as invitesComplete")->from($this->table_invitees_due)->where('license_id',$getLicenseData->licenseID)->get()->row()->invitesComplete;
						/*End*/
						
						/*Check due dilligence Inventions*/
						$dueInventionsResult = $this->db->select('DISTINCT(di.patent_id), di.related_system_texts')->from($this->table_due_dilligence_inventions.' as di')->join($this->table_due_dilligences.' as d','d.patent_number = di.patent_id','INNER')->join($this->table_licenses.' as l','l.id = d.license_id')->where('d.license_id',$getLicenseData->licenseID)->get();
						if($dueInventionsResult->num_rows()>0){							
							foreach($dueInventionsResult->result() as $dueRows){
								$getInvention = $dueRows->related_system_texts;
								if(!empty($getInvention) && $getInvention!=null){
									try{
										$inventionText = json_decode($getInvention,true);
										if(count($inventionText)>0){
											if(isset($inventionText[0][1]) && $inventionText[0][1]!=null && $inventionText[0][1]!=''){
												foreach($inventionText as $invention){
													if(isset($invention[1]) && $invention[1]!=null && $invention[1]!=''){
														$checkMe = $this->db->select('c.parent')->from($this->table_category.' as c')->where('c.name',$invention[1])->limit(1)->order_by('id','DESC')->get();
														if($checkMe->num_rows()>0){
															$getCategory = $checkMe->first_row();
															if((int)$getCategory->parent == 2){
																$checkParent = $this->db->select('c.name')->from($this->table_category.' as c')->where('c.id',$getCategory->parent)->get();
																if($checkParent->num_rows()>0){
																	$getParentCategory = $checkParent->first_row();
																	if(!in_array($getParentCategory->name,$marketCategories)){
																		$marketCategories[] = $getParentCategory->name;
																	}
																}
															}else {
																if(!in_array($invention[1],$marketCategories)){
																	$marketCategories[] = $invention[1];
																}
															}
														}
													}
												}
											}
										}
									} catch( Exception $e){
										
									}
								}
							}							
						}
						$marketCategoriesString = implode(',',$marketCategories);
						/*End due dilligence Inventions*/
					}
					/*Number of Images*/					
					$imagesResult = $this->getAcquisitionData($row->id,'a.image_left,a.image_middle,a.image_right,a.image_four,a.image_five,a.image_six,a.image_seven,a.image_eight,a.image_nine,a.image_ten,a.image_eleven,a.image_twelve');
					if(!empty($imagesResult->image_left) && $imagesResult->image_left!=null){
						$imageComplete++;
					}
					if(!empty($imagesResult->image_middle) && $imagesResult->image_middle!=null){
						$imageComplete++;
					}
					if(!empty($imagesResult->image_right) && $imagesResult->image_right!=null){
						$imageComplete++;
					}
					if(!empty($imagesResult->image_four) && $imagesResult->image_four!=null){
						$imageComplete++;
					}
					if(!empty($imagesResult->image_five) && $imagesResult->image_five!=null){
						$imageComplete++;
					}
					if(!empty($imagesResult->image_six) && $imagesResult->image_six!=null){
						$imageComplete++;
					}
					if(!empty($imagesResult->image_seven) && $imagesResult->image_seven!=null){
						$imageComplete++;
					}
					if(!empty($imagesResult->image_eight) && $imagesResult->image_eight!=null){
						$imageComplete++;
					}
					if(!empty($imagesResult->image_nine) && $imagesResult->image_nine!=null){
						$imageComplete++;
					}
					if(!empty($imagesResult->image_ten) && $imagesResult->image_ten!=null){
						$imageComplete++;
					}
					if(!empty($imagesResult->image_eleven) && $imagesResult->image_eleven!=null){
						$imageComplete++;
					}
					if(!empty($imagesResult->image_twelve) && $imagesResult->image_twelve!=null){
						$imageComplete++;
					}
					/*End*/
					/*IntroDD complete*/					
					/*End*/					
				}
				$row->family = $family;
				$row->assets = $assets;
				$row->jurisdiction = $jurisd;
				$row->illustrationComplete =$illustrationComplete;
				$row->techDDComplete = $techDDComplete;
				$row->marketDDComplete = $marketDDComplete;
				$row->legalDDComplete = $legalDDComplete;
				$row->pdfDDComplete = $pdfDDComplete;
				$row->comparablesComplete = $comparablesComplete;
				$row->invitesComplete = $invitesComplete;
				$row->imageComplete = $imageComplete;
				$row->marketCategoriesString = $marketCategoriesString;
				$allArray['litigation'] = $row;
                /*$allArray['stage'] = $this->checkStage($row->id);
                $allArray['level'] = $this->checkLevel($row->id);*/
                $allArray['level'] = array();
				$allArray['stage'] = array();
                $allArray['report'] = $this->checkLeadReport($row->id);
                $allArray['open_project'] = $this->getOpenProjectList($row->id);
                $allArray['buttons'] = $this->checkButtonList($row->id);               
				$data[] = $allArray;
            }            
        }
		
		return $data;
	}
	
	
	
	public function findOneLitigationWithIncomplete($lead_id,$type){
		$select = 'l.id,l.serial_number,file_url,l.lead_name ,l.spreadsheet_id  ,l.worksheet_id ,l.worksheet_name ,l.type ,l.patent_data ,l.create_date ,l.seller_info ,l.seller_info_text ,l.seller_like ,l.funding_trnsfr ,l.claim_illus ,l.claim_status_dd ,l.technical_dd ,l.technical_status_dd ,l.legal_dd  ,l.legal_status_dd ,l.create_patent_list  ,l.create_patent_list_text ,l.complete ,l.forward_to_review_text  ,l.nda_term_sheet  ,l.nda_term_sheet_text ,l.status ,l.synpat_like ,l.ppa_id ,l.ppa_text_date ,l.execute_ppa ,l.ppa_execute ,l.ppa_date ,l.plantiffs_name ,l.no_of_prospects ,l.upfront_price ,l.prospects_name ,l.technologies ,l.no_of_us_patents ,l.no_of_non_us_patents ,l.send_proposal_letter ,l.market_data ,l.seller_contact ,l.broker_contact ,l.option_expiration_date ,l.broker ,l.broker_person_contact ,l.person_name_1 ,l.person_title_1 ,l.person_name_2 ,l.person_title_2 ,l.address ,l.relates_to ,l.expected_price ,l.update_date ,l.next_action ,l.case_name ,l.litigation_stage ,l.market_industry ,l.case_type ,l.case_number ,l.cause no_of_patent ,l.filling_date ,l.active_defendants ,l.lead_attorney ,l.scrapper_data ,l.original_defendants ,l.court ,l.link_to_pacer ,l.link_to_rpx ,l.defendants ,l.court_docket_entries,l.folder_id';
		$query = $this->db->select($select)->from($this->table_lead.' as l')->where('l.id',$lead_id)->order_by('l.id','DESC')->get();
		
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $allArray = array();
                /**/
                /*Broker Name*/
					if(!empty($row->broker)){
						$brokderData = $this->db->select('c.first_name,c.last_name,cc.company_name')->from($this->table_contacts.' as c')->join($this->table_company.' as cc','cc.id = c.company_id')->where('c.id',$row->broker)->get()->row();
						if(count($brokderData)>0){
							$row->broker_contact = $brokderData->company_name;
							$row->broker_person_contact = $brokderData->first_name.' '.$brokderData->last_name;
						} else {
							$row->broker_contact ='';
							$row->broker_person_contact = '';
							$row->broker = '';
						}
					}
					
					/*End Broker Name*/
					/*Seller Name*/
					if(!empty($row->plantiffs_name)){
						$sellerInfo = $this->db->select('cc.company_name')->from($this->table_company.' as cc')->where('cc.id',$row->plantiffs_name)->get()->row();
						if(count($sellerInfo)>0){
							$row->seller_contact = $sellerInfo->company_name;
						} else {
							$row->seller_contact = '';
							$row->plantiffs_name = '';
						}
					}
					/*End Seller Name*/

					/*Person 1*/
					if(!empty($row->person_title_1)){
						$personOneData = $this->db->select('c.first_name,c.last_name')->from($this->table_contacts.' as c')->where('c.id',$row->person_title_1)->get()->row();
						if(count($personOneData)>0){
							$row->person_name_1 = $personOneData->first_name.' '.$personOneData->last_name;
						} else {
							$row->person_name_1 ='';
							$row->person_title_1 = '';
						}
					}
					/*End Person 1*/
					/*Person 2*/
					if(!empty($row->person_title_2)){
						$personSecondData = $this->db->select('c.first_name,c.last_name')->from($this->table_contacts.' as c')->where('c.id',$row->person_title_2)->get()->row();
						if(count($personSecondData)>0){
							$row->person_name_2 = $personSecondData->first_name.' '.$personSecondData->last_name;
						} else {
							$row->person_name_2 ='';
							$row->person_title_2 = '';
						}
					}
					/*End Person 2*/
					/*Lead Last seen*/
					$row->lead_last_seen = "0000-00-00";
					$queryLastSeen = $this->db->select('create_date as login_date')->from($this->table_history)->where('lead_id',$row->id)->order_by('id','desc')->limit(1,0)->get();					
					if($queryLastSeen->num_rows()>0){
						$dataLastSeen = $queryLastSeen->first_row();
						$row->lead_last_seen = $dataLastSeen->login_date;
					}
					/*End Lead Last seen*/
					/*Calculation Attractive*/
					$row->attractive = 0;
					$queryAttractive = $this->db->select('sum(attractive) as attractive,count(id) as counter')->from($this->table_comment)->where('parent_id',$row->id)->get();
					if($queryAttractive->num_rows()>0){
						$attractiveData = $queryAttractive->first_row();
						if($attractiveData->counter>0 && $attractiveData->attractive>0){
							$row->attractive = $attractiveData->attractive/$attractiveData->counter;
						}
					}
					/**/
					$getEouData = $this->findEOULeadMaterial($row->serial_number);
					$evidence = 0;
					if(count($getEouData)>0){
						$eouData = $getEouData->other_field;
						if(is_string($eouData)){
							$jsonDecodeEou = json_decode($eouData);							
							if(isset($jsonDecodeEou->another_license) && $jsonDecodeEou->another_license!='' && count($jsonDecodeEou->another_license)>0){
								foreach($jsonDecodeEou->another_license as $licenseEvidence){									
									if($licenseEvidence->evidence=="Yes"){										
										$evidence = $evidence+1;
									}
								}
							}
						}
					}
					$row->eou = $evidence;
                /**/
				$allArray['comment'] = $this->getLitigationComments($row->id,$type);
                /*$allArray['timeLine'] = $this->getAllUserHistory(0,$row->id,0);*/
                $allArray['timeLine'] = array();
                /*$allArray['task'] = $this->getAllTaskFromLead($row->id);
				$allArray['task_i'] = $this->myTaskApproval($row->id);*/
                $allArray['task'] = array();
                $allArray['task_i'] = array();
                 $allArray['acquisitions'] = $this->getAcquisitionData($row->id,'a.store_name,a.order_name,a.category,a.regular_license_starts,a.late_license_starts,a.active_button,a.docket_status,a.cost_price');
				$illustrationComplete = 0;
				$techDDComplete = 0;
				$marketDDComplete = 0;
				$legalDDComplete = 0;
				$pdfDDComplete = 0;
				$comparablesComplete = 0;
				$invitesComplete = 0;
				$imageComplete = 0;
				$royaltyComplete = 0;
				$family = 0;
				$assets = 0;
				$jurisd = 0;
				$marketCategoriesString = "";
				if(count($allArray['acquisitions'])>0){					
					$getLeadPatentList = $this->getLeadPatentList($row->id);
					if(count($getLeadPatentList)>0){
						$patentsList = array();
						foreach($getLeadPatentList as $p){
							$patentsList[] = $p->patent;
						}
						if(count($patentsList)>0){
							/*Number of Illustration Patent Complete*/
							$illustrationComplete = $this->db->select("count(id) as illustrationComplete")->from($this->table_due_dilligence_illustrations)->where_in('patent_id',$patentsList)->where('status',1)->get()->row()->illustrationComplete;							
							/*End*/
							/*Number of TechDD Patent Complete*/
							$techDDComplete = $this->db->select("count(id) as techDDComplete")->from($this->table_due_dilligence_inventions)->where_in('patent_id',$patentsList)->where('tech_status',1)->get()->row()->techDDComplete;	
							/*End*/
							/*Number of Market Patent Complete*/
							$marketDDComplete = $this->db->select("count(id) as marketDDComplete")->from($this->table_due_dilligence_inventions)->where_in('patent_id',$patentsList)->where('market_status',1)->get()->row()->marketDDComplete;	
							/*End*/
							/*Number of LegalDD Patent Complete*/
							$legalDDComplete = $this->db->select("count(id) as legalDDComplete")->from($this->table_due_dilligence_legal)->where_in('patent_id',$patentsList)->where('status',1)->get()->row()->legalDDComplete;
							/*End*/
							/*Number of PDFs Patent Complete*/
							$pdfDDComplete = $this->db->select("count(id) as pdfDDComplete")->from($this->table_due_dilligence_pdf)->where_in('patent_id',$patentsList)->where('status',1)->get()->row()->pdfDDComplete;
							/*End*/							
						}
					}					
					$getLicenseResult = $this->db->select('id as licenseID')->from($this->table_licenses)->where('serial_number',$row->serial_number)->get();
					if($getLicenseResult->num_rows()>0){
						$getLicenseData = $getLicenseResult->first_row();
						/*Royalty*/
						$royaltyComplete = $this->db->select("count(id) as royaltyComplete")->from($this->table_damages)->where('license_id',$getLicenseData->licenseID)->get()->row()->royaltyComplete;
						/*End*/
						/*Number of Comparables Agreement*/
						$comparablesComplete = $this->db->select("count(id) as comparablesComplete")->from($this->table_comparables)->where('license_id',$getLicenseData->licenseID)->get()->row()->comparablesComplete;
						/*End*/
						/*Number of Invitees Patent Complete*/
						$invitesComplete = $this->db->select("count(id) as invitesComplete")->from($this->table_invitees_due)->where('license_id',$getLicenseData->licenseID)->get()->row()->invitesComplete;
						/*End*/
						/*Lead Family, Assets, Jurisdiction*/
						$family = $this->db->select("count(patent_number) as family")->from($this->table_due_dilligences)->where('license_id',$getLicenseData->licenseID)->get()->row()->family;
						$queryChartLeft = $this->db->select("country,patents,applications")->from($this->table_chart_lefts)->where('license_id',$getLicenseData->licenseID)->get();
						if($queryChartLeft->num_rows()>0){
							$getChartLeft = array();
							foreach($queryChartLeft->result() as $rowLeft){
								$getChartLeft[] = $rowLeft;
							}
							$assets = 0;
							$countCountry = array();
							if(count($getChartLeft)>0){
								foreach($getChartLeft as $chartL){
									if(strtolower(strtoupper($chartL->country))!="wo" && strtolower(strtoupper($chartL->country))!="ep"){
										$assets = $assets + (int)$chartL->applications + (int)$chartL->patents;
										if(!in_array($chartL->country,$countCountry)){
											$countCountry[] = $chartL->country;
										}
									}								
								}
							}
							$jurisd = count($countCountry);
						}
						/*Check due dilligence Inventions*/
						$dueInventionsResult = $this->db->select('DISTINCT(di.patent_id), di.related_system_texts')->from($this->table_due_dilligence_inventions.' as di')->join($this->table_due_dilligences.' as d','d.patent_number = di.patent_id','INNER')->join($this->table_licenses.' as l','l.id = d.license_id')->where('d.license_id',$getLicenseData->licenseID)->get();
						$marketCategories= array();
						if($dueInventionsResult->num_rows()>0){							
							foreach($dueInventionsResult->result() as $dueRows){
								$getInvention = $dueRows->related_system_texts;
								if(!empty($getInvention) && $getInvention!=null){
									try{
										$inventionText = json_decode($getInvention,true);
										if(count($inventionText)>0){
											if(isset($inventionText[0][1]) && $inventionText[0][1]!=null && $inventionText[0][1]!=''){
												foreach($inventionText as $invention){
													if(isset($invention[1]) && $invention[1]!=null && $invention[1]!=''){
														$checkMe = $this->db->select('c.parent')->from($this->table_category.' as c')->where('c.name',$invention[1])->limit(1)->order_by('id','DESC')->get();
														if($checkMe->num_rows()>0){
															$getCategory = $checkMe->first_row();
															if((int)$getCategory->parent == 2){
																$checkParent = $this->db->select('c.name')->from($this->table_category.' as c')->where('c.id',$getCategory->parent)->get();
																if($checkParent->num_rows()>0){
																	$getParentCategory = $checkParent->first_row();
																	if(!in_array($getParentCategory->name,$marketCategories)){
																		$marketCategories[] = $getParentCategory->name;
																	}
																}
															}else {
																if(!in_array($invention[1],$marketCategories)){
																	$marketCategories[] = $invention[1];
																}
															}
														}
													}
												}
											}
										}
									} catch( Exception $e){
										
									}
								}
							}							
						}
						$marketCategoriesString = implode(',',$marketCategories);
						/*End due dilligence Inventions*/
					}
					/*Number of Images*/					
					$imagesResult = $this->getAcquisitionData($row->id,'a.image_left,a.image_middle,a.image_right,a.image_four,a.image_five,a.image_six,a.image_seven,a.image_eight,a.image_nine,a.image_ten,a.image_eleven,a.image_twelve');
					if(!empty($imagesResult->image_left) && $imagesResult->image_left!=null){
						$imageComplete++;
					}
					if(!empty($imagesResult->image_middle) && $imagesResult->image_middle!=null){
						$imageComplete++;
					}
					if(!empty($imagesResult->image_right) && $imagesResult->image_right!=null){
						$imageComplete++;
					}
					if(!empty($imagesResult->image_four) && $imagesResult->image_four!=null){
						$imageComplete++;
					}
					if(!empty($imagesResult->image_five) && $imagesResult->image_five!=null){
						$imageComplete++;
					}
					if(!empty($imagesResult->image_six) && $imagesResult->image_six!=null){
						$imageComplete++;
					}
					if(!empty($imagesResult->image_seven) && $imagesResult->image_seven!=null){
						$imageComplete++;
					}
					if(!empty($imagesResult->image_eight) && $imagesResult->image_eight!=null){
						$imageComplete++;
					}
					if(!empty($imagesResult->image_nine) && $imagesResult->image_nine!=null){
						$imageComplete++;
					}
					if(!empty($imagesResult->image_ten) && $imagesResult->image_ten!=null){
						$imageComplete++;
					}
					if(!empty($imagesResult->image_eleven) && $imagesResult->image_eleven!=null){
						$imageComplete++;
					}
					if(!empty($imagesResult->image_twelve) && $imagesResult->image_twelve!=null){
						$imageComplete++;
					}
					/*End*/
					/*IntroDD complete*/					
					/*End*/					
				}
				$row->family = $family;
				$row->assets = $assets;
				$row->jurisdiction = $jurisd;
				$row->illustrationComplete =$illustrationComplete;
				$row->techDDComplete = $techDDComplete;
				$row->marketDDComplete = $marketDDComplete;
				$row->legalDDComplete = $legalDDComplete;
				$row->pdfDDComplete = $pdfDDComplete;
				$row->comparablesComplete = $comparablesComplete;
				$row->invitesComplete = $invitesComplete;
				$row->imageComplete = $imageComplete;
				$row->royaltyComplete = $royaltyComplete;
				$row->marketCategoriesString = $marketCategoriesString;
				$allArray['litigation'] = $row;
                /*$allArray['stage'] = $this->checkStage($row->id);
                $allArray['level'] = $this->checkLevel($row->id);*/
                $allArray['level'] = array();
				$allArray['stage'] = array();
                $allArray['report'] = $this->checkLeadReport($row->id);
                $allArray['open_project'] = $this->getOpenProjectList($row->id);
                $allArray['buttons'] = $this->checkButtonList($row->id);               
				$data[] = $allArray;
            }            
        }
		
		return $data;
	}
	
	function findCallActivityLog($leadID,$personID,$companyID){
		$loglist =array();
		/*$getLogList = $this->db->select('a.*')->from($this->table_activity_log.' as a')->join($this->table_lead.' as b','b.id = a.email_id','left outer')->where("a.company_id",$companyID)->where('a.lead_id',$leadID)->where('a.contact_id',$personID)->order_by('a.id','DESC')->order_by('b.date_received','DESC')->get();*/
		
		$getLogList = $this->db->select('a.*')->from($this->table_activity_log.' as a')->join($this->table_lead.' as b','b.id = a.email_id','left outer')->where("a.company_id",$companyID)->where('a.lead_id',$leadID)->where('a.contact_id',$personID)->order_by('a.id','DESC')->get();
		if($getLogList->num_rows()>0){
			foreach ($getLogList->result() as $p) {
				$loglist[] = $p;
			}
		}
		return $loglist;
	}
	
	function c_my_contact_list($cID,$select){
		$persons =array();
		$getPersons = $this->db->select($select)->from($this->table_contacts.' as c')->where("c.company_id",$cID)->order_by("c.first_name DESC")->get();
		if($getPersons->num_rows()>0){
			foreach ($getPersons->result() as $p) {
				$persons[] = $p;
			}
		}
		return $persons;
	}
	
	function getContactByEmail($email){
		$persons = array();
		$email = trim($email);
		if($email!="" && !empty($email))
		$getPersons = $this->db->select('*')->from($this->table_contacts.' as c')->where("c.email",trim($email))->get();
		if($getPersons->num_rows()>0){
			$persons = $getPersons->first_row();
		}   
		return $persons;
	}
	
	function getContactFullContactID($fullContact){
		$persons = array();
		$fullContact = trim($fullContact);
		if($fullContact!="" && !empty($fullContact))
		$getPersons = $this->db->select('*')->from($this->table_contacts.' as c')->where("c.fullContact",trim($fullContact))->get();
		if($getPersons->num_rows()>0){
			$persons = $getPersons->first_row();
		}   
		return $persons;
	}
	
	function getPreCompanyName($companyName,$select){
		$persons = array();
		if(!empty($companyName)){
			$getPersons = $this->db->select($select)->from($this->table_precompanies.' as c')->where("c.company_name",$companyName)->get();
			if($getPersons->num_rows()>0){
				$persons = $getPersons->first_row();
			} 
		}		  
		return $persons;
	}
	
	function getCompanyName($companyName,$select){
		$getData = array();
		if(!empty($companyName)){
			$getResult = $this->db->select($select)->from($this->table_company.' as c')->where("c.company_name",$companyName)->get();
			if($getResult->num_rows()>0){
				$getData = $getResult->first_row();
			} 
		}		  
		return $getData;
	}
	
	function getPreContactById($ID){
		$persons = array();
		$getPersons = $this->db->select('*')->from($this->table_precontacts.' as c')->where("c.id",$ID)->get();
		if($getPersons->num_rows()>0){
			$persons = $getPersons->first_row();
		}   
		return $persons;
	}
	
	function getContactById($ID){
		$persons = array();
		$getPersons = $this->db->select('*')->from($this->table_contacts.' as c')->where("c.id",$ID)->get();
		if($getPersons->num_rows()>0){
			$persons = $getPersons->first_row();
		}   
		return $persons;
	}
	
	function getPreContactByEmail($email){
		$persons = array();
		$email = trim($email);
		if($email!="" && !empty($email))
		$getPersons = $this->db->select('*')->from($this->table_precontacts.' as c')->where("c.email",trim($email))->get();
		if($getPersons->num_rows()>0){
			$persons = $getPersons->first_row();
		}   
		return $persons;
	}
	
	function getPreContactFullContactID($fullContact){
		$persons = array();
		$fullContact = trim($fullContact);
		if($fullContact!="" && !empty($fullContact))
		$getPersons = $this->db->select('*')->from($this->table_precontacts.' as c')->where("c.fullcontact",trim($fullContact))->get();
		if($getPersons->num_rows()>0){
			$persons = $getPersons->first_row();
		}   
		return $persons;
	}
	
	public function updateSalesActivity($id,$data){
		$this->db->where('id',$id);
		$this->db->update($this->table_sales_activity, $data);
		if($this->db->affected_rows()>0){
			$this->db->where('contact_id',$data['company_id']);
			$this->db->where('lead_id',$data['lead_id']);
			$this->db->update($this->table_invitees,array('last_activity'=>$data['activity_date']));
		}
		return $id;
	}
	
	public function updateSalesActivityByContactID($contactID,$data){
		$this->db->where('contact_id',$contactID);
		$this->db->update($this->table_sales_activity, $data);
		return $this->db->affected_rows();
	}
	
	public function updateAcquisitionActivityByContactID($contactID,$data){
		$this->db->where('contact_id',$contactID);
		$this->db->update($this->table_acquisition_activity, $data);
		return $this->db->affected_rows();
	}
	
	public function updateActivityLogByContactID($contactID,$data){
		$this->db->where('contact_id',$contactID);
		$this->db->update($this->table_activity_log, $data);
		return $this->db->affected_rows();
	}
	
	public function updateSalesActivityByEmailID($id,$data){
		$this->db->where('email_id',$id);
		$this->db->update($this->table_sales_activity, $data);
		if($this->db->affected_rows()>0){
			$this->db->where('contact_id',$data['company_id']);
			$this->db->where('lead_id',$data['lead_id']);
			$this->db->update($this->table_invitees,array('last_activity'=>$data['activity_date']));
		}
		return $id;
	}
	
	public function insetSalesActivity($data){
		$this->db->insert($this->table_sales_activity, $data);
		$id = 0;
		if($this->db->insert_id()>0){
			$id = $this->db->insert_id();
			$this->db->where('contact_id',$data['company_id']);
			$this->db->where('lead_id',$data['lead_id']);
			$this->db->update($this->table_invitees,array('last_activity'=>$data['activity_date']));
			
			
			/*echo $this->db->last_query();*/
		}
		return $id;
	}
	
	public function updatePreSaleActivity($id,$data){
		$this->db->where('id',$id);
		$this->db->update($this->table_presales_activity, $data);
		if($this->db->affected_rows()>0){
			$this->db->where('contact_id',$data['company_id']);
			$this->db->where('lead_id',$data['lead_id']);
			$this->db->update($this->table_invitees,array('pre_sale_activity'=>$data['activity_date']));
		}
		return $id;
	}
	
	public function updatePreSaleActivityByEmailID($id,$data){
		$this->db->where('email_id',$id);
		$this->db->update($this->table_presales_activity, $data);
		if($this->db->affected_rows()>0){
			$this->db->where('contact_id',$data['company_id']);
			$this->db->where('lead_id',$data['lead_id']);
			$this->db->update($this->table_invitees,array('pre_sale_activity'=>$data['activity_date']));
		}
		return $id;
	}
	
	public function updateAcquistionActivity($id,$data){
		$this->db->where('id',$id);
		$this->db->update($this->table_acquisition_activity, $data);
		if($this->db->affected_rows()>0){
			$this->db->where('contact_id',$data['company_id']);
			$this->db->where('lead_id',$data['lead_id']);
			$this->db->update($this->table_acquisition_company,array('last_activity'=>$data['activity_date']));
		}
		return $id;
	}
	
	public function updateAcquistionActivityByEmailID($id,$data){
		$this->db->where('email_id',$id);
		$this->db->update($this->table_acquisition_activity, $data);
		if($this->db->affected_rows()>0){
			$this->db->where('contact_id',$data['company_id']);
			$this->db->where('lead_id',$data['lead_id']);
			$this->db->update($this->table_acquisition_company,array('last_activity'=>$data['activity_date']));
		}
		return $id;
	}
	
	public function insertAcquistionActivity($data){
		if(isset($data['c_id'])){
			unset($data['c_id']);
		}
		if(isset($data['p_id'])){
			unset($data['p_id']);
		}
		$this->db->insert($this->table_acquisition_activity, $data);
		$id = 0;
		if($this->db->insert_id()>0){
			$id = $this->db->insert_id();
			$this->db->where('contact_id',$data['company_id']);
			$this->db->where('lead_id',$data['lead_id']);
			$this->db->update($this->table_acquisition_company,array('last_activity'=>$data['activity_date']));
		}
		return $id;
	}
	
	public function insertPreSaleActivity($data){
		$this->db->insert($this->table_presales_activity, $data);
		$id = 0;
		if($this->db->insert_id()>0){
			$id = $this->db->insert_id();
			$this->db->where('contact_id',$data['company_id']);
			$this->db->where('lead_id',$data['lead_id']);
			$this->db->update($this->table_invitees,array('pre_sale_activity'=>$data['activity_date']));
		}
		return $id;
	}
	
	function findSalesActivityCompanies($leadID){
		$companyData  = array();
		$getInviteesCompanies = $this->db->select("c.company_name as orgName")->from($this->table_invitees.' as i')->join($this->table_company.' as c','c.id=i.contact_id')->where("i.lead_id",$leadID)->order_by('c.company_name ASC')->get();
		if ($getInviteesCompanies->num_rows() > 0) {
			 foreach ($getInviteesCompanies->result() as $row) {
				$companyData[] = $row;
			 }
		}
		return $companyData;
	}
	
	public function findBrokerDetails($brokerID){
		$data = array();
		if($brokerID>0){
			$query = $this->db->select("c.*,co.company_name , co.id as companyID")->from($this->table_contacts.' as c')->join($this->table_company.' as co','co.id = c.company_id')->where('c.id',$brokerID)->get();
			if ($query->num_rows() > 0) {
				$data = $query->first_row();
			}
		}
		return $data;
	}
	
	function findLeadCompanyBrokerDetails($leadID){
		$userID = $this->session->userdata['id'];
		$type = $this->session->userdata['type'];
		$details = array();
		if($userID>0 && $type!=9 && $type!=8){
			$userEmail = $this->session->userdata['email'];
			$contactDetails = $this->getContactByEmail($userEmail);
			if(count($contactDetails)>0){
				$query = $this->db->select("co.company_name , co.id as companyID, sblc.sales_company_id as SBLCID")->from($this->table_company.' as co')->join($this->table_sales_broker_lead_company.' as sblc','sblc.broker_company_id = co.id')->where('sblc.broker_company_id',$contactDetails->company_id)->where('sblc.lead_id',$leadID)->get();
				foreach ($query->result() as $row) {
					$details[] = $row;
				}
			}			
		} else {
			$query = $this->db->select("co.company_name , co.id as companyID, sblc.sales_company_id as SBLCID")->from($this->table_company.' as co')->join($this->table_sales_broker_lead_company.' as sblc','sblc.broker_company_id = co.id')->where('sblc.lead_id',$leadID)->get();
			foreach ($query->result() as $row) {
				$details[] = $row;
			}
		}
		return $details;
	}
	
	function findLeadCompanyPreBrokerDetails($leadID){
		$userID = $this->session->userdata['id'];
		$type = $this->session->userdata['type'];
		$details = array();
		$query = $this->db->select("co.company_name , co.id as companyID, sblc.sales_company_id as SBLCID")->from($this->table_company.' as co')->join($this->table_presale_broker.' as sblc','sblc.broker_company_id = co.id')->where('sblc.lead_id',$leadID)->get();
		foreach ($query->result() as $row) {
			$details[] = $row;
		}
		return $details;
	}
	
	
	function findCompaniesAssociate($contacts = array()){
		$companies = array();
		if(count($contacts)>0){
			$contact  = implode(',',$contacts);
			$findCompaniesIDs = $this->db->select('DISTINCT(c.id) as companyID')->from($this->table_company.' as c')->where('c.broker IN('.$contact.')')->get();
			if($findCompaniesIDs->num_rows()>0){
				foreach($findCompaniesIDs->result() as $row){
					$companies[] = $row->companyID;
				}
			}
		}
		return $companies;
	}
	
	function getPreSalesBrokerListByLead($leadID){
		$getPersons = $this->db->select("c.*,co.company_name")->from($this->table_contacts.' as c')->join($this->table_presale_broker.' as pb', 'pb.broker_id= c.id')->join($this->table_company.' as co','co.id = c.company_id')->where('pb.lead_id',$leadID)->order_by("c.first_name DESC")->get();
		$persons =array();
		if($getPersons->num_rows()>0){
			foreach ($getPersons->result() as $p) {
				$persons[] = $p;
			}
		}
		return $persons;
	}
	
	function getPreSalesActivity($leadID){
		$userType = $this->session->userdata['type'];
		$getInviteesCompanies = (object)array();
		if($userType<8){					
			$getInviteesCompanies = $this->db->select("c.*,i.stage")->from($this->table_invitees.' as i')->join($this->table_company.' as c','c.id=i.contact_id')->where("i.lead_id",$leadID)->order_by('i.pre_sale_activity DESC')->get();
			 
		} else {
			$getInviteesCompanies = $this->db->select("c.*")->from($this->table_invitees.' as i')->join($this->table_company.' as c','c.id=i.contact_id')->where("i.lead_id",$leadID)->order_by('i.pre_sale_activity DESC')->get();
		}
		$companyData = array();		
		if (is_a($getInviteesCompanies, 'CI_DB_mysqli_result') && $getInviteesCompanies->num_rows() > 0) {
            foreach ($getInviteesCompanies->result() as $row) {
				$getPersons = $this->db->select("c.*,co.company_name")->from($this->table_contacts.' as c')->join($this->table_presale_broker.' as pb', 'pb.broker_id= c.id')->join($this->table_company.' as co','co.id = c.company_id')->where("pb.company_id",$row->id)->where('pb.lead_id',$leadID)->order_by("c.first_name DESC")->get();
				$persons =array();
				if($getPersons->num_rows()>0){
					foreach ($getPersons->result() as $p) {
						$persons[] = $p;
					}
				}
				$activities = array();
				$getActivities = $this->db->select("s.*,c.first_name as firstName, c.last_name as lastName")->from($this->table_presales_activity." as s")->join($this->table_contacts.' as c','c.id = s.contact_id')->where('s.company_id',$row->id)->where('lead_id',$leadID)->order_by('s.activity_date DESC')->get();
				if($getActivities->num_rows()>0){
					foreach ($getActivities->result() as $a) {
						$email = array();
						if($a->email_id>0){
							$email = $this->findBoxNewById($a->email_id);
						}
						$a->email = $email;
						$activities[] = $a;
					}
				}
				/*$row->broker_details = $this->findBrokerDetails($row->broker);*/
				
				$companyData[]=array("company"=>$row,"people"=>$persons,"activities"=>$activities);
			}
		}
		return $companyData;
	}
	
	function getSalesActivity($leadID){
		$userType = $this->session->userdata['type'];
		$getInviteesCompanies = (object)array();
		if($userType<8){
			/*Get only those leads which are assigned to user*/
			/*
			$findUserEmail = $this->db->select('u.email')->from($this->table.' as u')->where('u.id',$this->session->userdata['id'])->get()->row()->email;
			if(!empty($findUserEmail) && $findUserEmail!=null){
				$getContactDetails = $this->db->select('c.*')->from($this->table_contacts.' as c')->where('trim(c.email)',$findUserEmail)->get();
				if($getContactDetails->num_rows()>0){
					$contact = $getContactDetails->first_row();
					$findAllContactsBelongsToContactCompany = $this->db->select("c.id")->from($this->table_contacts.' as c')->where("c.company_id",$contact->company_id)->get();
					$allContacts = array();
					if($findAllContactsBelongsToContactCompany->num_rows()>0){
						foreach($findAllContactsBelongsToContactCompany->result() as $row){
							$allContacts[] = $row->id;
						}
						if(count($allContacts)>0){
							$findCompanyAssociateToThisContacts = $this->findCompaniesAssociate($allContacts);
							$findCompanyAssociateToThisContacts[] = $contact->company_id;
							if(count($findCompanyAssociateToThisContacts)>0){
								$companies = implode(',',$findCompanyAssociateToThisContacts);
								$getInviteesCompanies = $this->db->select("c.*,i.stage")->from($this->table_invitees.' as i')->join($this->table_company.' as c','c.id=i.contact_id')->where("i.lead_id",$leadID)->where('c.id IN ('.$companies.')')->order_by('i.last_activity DESC')->get();
							}
						}
					}
				}
			}*/			
			$getInviteesCompanies = $this->db->select("c.*,i.stage")->from($this->table_invitees.' as i')->join($this->table_company.' as c','c.id=i.contact_id')->where("i.lead_id",$leadID)->order_by('i.last_activity DESC ,c.company_name ASC')->get();
		} else {
			$getInviteesCompanies = $this->db->select("c.*,i.stage")->from($this->table_invitees.' as i')->join($this->table_company.' as c','c.id=i.contact_id')->where("i.lead_id",$leadID)->order_by('i.last_activity DESC ,c.company_name ASC')->get();
		}
		$companyData = array();		
		if (is_a($getInviteesCompanies, 'CI_DB_mysqli_result') && $getInviteesCompanies->num_rows() > 0) {
            foreach ($getInviteesCompanies->result() as $row) {
				$getPersons = $this->db->select("*")->from($this->table_contacts)->where("company_id",$row->id)->order_by("first_name DESC")->get();
				$persons =array();
				if($getPersons->num_rows()>0){
					foreach ($getPersons->result() as $p) {
						$persons[] = $p;
					}
				}
				$activities = array();
				$getActivities = $this->db->select("s.*,c.first_name as firstName, c.last_name as lastName")->from($this->table_sales_activity." as s")->join($this->table_contacts.' as c','c.id = s.contact_id')->where('s.company_id',$row->id)->where('lead_id',$leadID)->order_by('s.activity_date DESC')->get();
				/*echo $this->db->last_query();*/
				if($getActivities->num_rows()>0){
					foreach ($getActivities->result() as $a) {
						$email = array();
						if($a->email_id>0){
							$email = $this->findBoxNewById($a->email_id);
						}
						$a->email = $email;
						$activities[] = $a;
					}
				}
				/*$row->broker_details = $this->findBrokerDetails($row->broker);*/
				
				$companyData[]=array("company"=>$row,"people"=>$persons,"activities"=>$activities);
			}
		}
		return $companyData;
	}	
	
	function getAcquisitionActivity($leadID){
		$userType = $this->session->userdata['type'];
		$getInviteesCompanies = (object)array();
		if($userType<8){
			/*Get only those leads which are assigned to user*/
			$findUserEmail = $this->db->select('u.email')->from($this->table.' as u')->where('u.id',$this->session->userdata['type'])->get()->row()->email;
			if(!empty($findUserEmail) && $findUserEmail!=null){
				$getContactDetails = $this->db->select('c.company_id')->from($this->table_contacts.' as c')->where('trim(c.email)',$findUserEmail)->get();
				if($getContactDetails->num_rows()>0){
					$contact = $getContactDetails->first_row();
					$findAllContactsBelongsToContactCompany = $this->db->select("c.id")->from($this->table_contacts.' as c')->where("c.company_id",$contact->company_id)->get();
					$allContacts = array();
					if($findAllContactsBelongsToContactCompany->num_rows()>0){
						foreach($findAllContactsBelongsToContactCompany->result() as $row){
							$allContacts[] = $row->id;
						}
						if(count($allContacts)>0){
							$findCompanyAssociateToThisContacts = $this->findCompaniesAssociate($allContacts);
							$findCompanyAssociateToThisContacts[] = $contact->company_id;
							if(count($findCompanyAssociateToThisContacts)>0){
								$companies = implode(',',$findCompanyAssociateToThisContacts);
								$getInviteesCompanies = $this->db->select("c.*,i.stage")->from($this->table_acquisition_company.' as i')->join($this->table_company.' as c','c.id=i.contact_id')->where("i.lead_id",$leadID)->where('c.id IN ('.$companies.')')->order_by('i.last_activity DESC, c.company_name ASC')->get();
							}
						}
					}
				}
			}			
		} else {
			$getInviteesCompanies = $this->db->select("c.*,i.stage")->from($this->table_acquisition_company.' as i')->join($this->table_company.' as c','c.id=i.contact_id')->where("i.lead_id",$leadID)->order_by('i.last_activity DESC ,c.company_name ASC')->get();
		}
		/*echo $this->db->last_query();*/
		$companyData = array();
		if (is_a($getInviteesCompanies, 'CI_DB_mysqli_result') && $getInviteesCompanies->num_rows() > 0) {
            foreach ($getInviteesCompanies->result() as $row) {
				$getPersons = $this->db->select("id,company_id,job_title,first_name,last_name,email,secondary_email,linkedin_url,phone,telephone,gateway,no_contact,new_email,new_phone,new_linkedin")->from($this->table_contacts)->where("company_id",$row->id)->order_by("first_name DESC")->get();
				$persons =array();
				if($getPersons->num_rows()>0){
					foreach ($getPersons->result() as $p) {
						$persons[] = $p;
					}
				}
				$activities = array();
				$getActivities = $this->db->select("s.*,c.first_name as firstName, c.last_name as lastName")->from($this->table_acquisition_activity." as s")->join($this->table_contacts.' as c','c.id = s.contact_id')->where('s.company_id',$row->id)->where('lead_id',$leadID)->order_by('s.activity_date DESC')->get();
				if($getActivities->num_rows()>0){
					foreach ($getActivities->result() as $a) {
						$email = array();
						if($a->email_id>0){
							$email = $this->findBoxNewById($a->email_id);
						}
						$a->email = $email;
						$activities[] = $a;
					}
				}
				$row->broker_details = $this->findBrokerDetails($row->broker);
				$companyData[]=array("company"=>$row,"people"=>$persons,"activities"=>$activities);
			}
		}
		return $companyData;
	}
	
	function companyListAssignedUser($userID){
		
	}
	
	function findLeadButtonData($leadID,$buttonID){
		$query = $this->db->select("b.button_id,b.type,b.name,b.description,b.status_message,b.reference_id,l.id,l.status as btnStatus,l.update_date,l.renewable,l.status_message_fill")->from($this->table_buttons .' as b')->join($this->table_lead_buttons .' as l','l.button_id = b.id')->where('l.lead_id',$leadID)->where('l.id',$buttonID)->order_by('l.sort ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
           $data = $query->first_row();
        }
		return $data;
	}
	
	function checkButtonList($leadID){
		$query = $this->db->select("b.button_id,b.type,b.name,b.description,b.status_message,b.reference_id,l.id,l.status as btnStatus,l.update_date,l.renewable,l.status_message_fill,l.blink,l.send_task")->from($this->table_buttons .' as b')->join($this->table_lead_buttons .' as l','l.button_id = b.id')->where('l.lead_id',$leadID)->order_by('l.sort ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		
		return $data;
	}
	
	function checkDocketButtonList($leadID){
		$query = $this->db->select("b.button_id,b.type,b.name,b.description,b.status_message,b.reference_id,l.id,l.status as btnStatus,l.update_date,l.renewable,l.blink,l.send_task")->from($this->table_buttons .' as b')->join($this->table_docket_buttons .' as l','l.button_id = b.id')->where('l.lead_id',$leadID)->order_by('l.sort ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		
		return $data;
	}
	
	function findButtonByButtonID($type,$buttonID){
		$query = $this->db->select('*')->from($this->table_buttons)->where('type',$type)->where('button_id',$buttonID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	function findLeadButtonByButtonID($leadID,$buttonID){
		$query = $this->db->select('*')->from($this->table_lead_buttons)->where('lead_id',$leadID)->where('button_id',$buttonID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		/*echo $this->db->last_query();*/
		return $data;
	}
	
	function findLeadButtonByID($leadID,$buttonID){
		$query = $this->db->select('*')->from($this->table_lead_buttons)->where('lead_id',$leadID)->where('id',$buttonID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	function findDocketButtonByID($leadID,$buttonID){
		$query = $this->db->select('*')->from($this->table_docket_buttons)->where('lead_id',$leadID)->where('id',$buttonID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	function findOriginalButtonByButtonID($buttonID){
		$query = $this->db->select('*')->from($this->table_buttons)->where('id',$buttonID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	function findButtonID($buttonID,$leadID){
		$query = $this->db->select('*')->from($this->table_lead_buttons)->where('lead_id',$leadID)->where('id',$buttonID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	public function updateButton($data,$id)
    {
        $this->db->where('id',$id)->update($this->table_lead_buttons,$data);
		return $this->db->affected_rows();
    }
	
	public function updateButtonBID($data,$id)
    {
        $this->db->where('button_id',$id)->update($this->table_lead_buttons,$data);
		return $this->db->affected_rows();
    }
	
	function updateDocketButtonBID($data,$id){
		$this->db->where('button_id',$id)->update($this->table_docket_buttons,$data);		
		return $this->db->affected_rows();
	}
	
	public function insertPreContacts($data){
		 $this->db->insert($this->table_precontacts,$data);
		return $this->db->insert_id();
	}
	
	public function insertPreCompanies($data){
		 $this->db->insert($this->table_precompanies,$data);
		return $this->db->insert_id();
	}
	
	public function updatePreCompanies($data,$id){
		$this->db->where('id',$id)->update($this->table_precompanies,$data);
		return $this->db->affected_rows();
	}
	
	public function updateCompany($data,$id){
		$this->db->where('id',$id)->update($this->table_company,$data);
		return $this->db->affected_rows();
	}
	
	public function updatePreContacts($data,$id){
		$this->db->where('id',$id)->update($this->table_precontacts,$data);
		return $this->db->affected_rows();
	}
	
	public function updatePreContactByFullContact($id,$data){
		$this->db->where('fullcontact',$id)->update($this->table_precontacts,$data);
		return $this->db->affected_rows();
	}
	
	public function updateContactByFullContact($id,$data){
		$this->db->where('fullcontact',$id)->update($this->table_contacts,$data);
		return $this->db->affected_rows();
	}
	public function updateContact($data,$id){
		$this->db->where('id',$id)->update($this->table_contacts,$data);
		return $this->db->affected_rows();
	}
	
	public function deleteContact($id){
		$this->db->where('id',$id)->delete($this->table_contacts);
		return $this->db->affected_rows();
	}
	
	public function insertLeadButton($data){
       $this->db->insert($this->table_lead_buttons,$data);
       return $this->db->insert_id();
    }
	
	public function insertDocketButton($data){
       $this->db->insert($this->table_docket_buttons,$data);
       return $this->db->insert_id();
    }
	
	public function insertPotentialParticipant($data){
		$this->db->insert($this->table_potential_participates,$data);
       return $this->db->insert_id();
	}
	
	public function deleteRequestToParticipate($ID){
		$this->db->where('id',$ID)->delete($this->table_request_to_participate);
		return $this->db->affected_rows();
	}
	
	public function deleteCommitments($licenseID){
		$this->db->where('license_id',$licenseID)->delete($this->table_commitments);
		return $this->db->affected_rows();
	}
	
	public function deleteRevisedDocumentByID($ID){
		$this->db->where('id',$ID)->delete($this->table_revised_documents);
		return $this->db->affected_rows();
	}
	
	public function insertCommitment($data){
		$this->db->insert($this->table_commitments,$data);
       return $this->db->insert_id();
	}
	
	public function updatePotentialData($data,$id){
		 $this->db->where('id',$id)->update($this->table_potential_participates,$data);		
		return $this->db->affected_rows();
	}
	
	public function updatePotentialDataByLicense($data,$id){
		 $this->db->where('license_id',$id)->update($this->table_potential_participates,$data);		
		return $this->db->affected_rows();
	}
	
	public function updateDocketButton($data,$id)
    {
        $this->db->where('id',$id)->update($this->table_docket_buttons,$data);
		
		return $this->db->affected_rows();
    }
	
	function findAllDisplayPriceData($licenseID,$select){
		$query = $this->db->select($select)->from($this->table_potential_participates)->where('license_id',$licenseID)->where('display',1)->order_by('price','DESC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data;
	}
	
	function runAlgoCheckSyndication($ID){
		$data = array('particpant_list'=>array(),'license_detail'=>array());
		$query = $this->db->select('license_id')->from($this->table_potential_participates)->where('id',$ID)->get();
		if ($query->num_rows() > 0) {
			$detail = $query->first_row();
			$data['particpant_list'] = $this->findAllDisplayPriceData($detail->license_id,"price,id");
			$getLicenseQuery = $this->db->select('asking_price,id,serial_number')->from($this->table_licenses)->where('id',$detail->license_id)->get();
			if ($getLicenseQuery->num_rows() > 0) {
				$data['license_detail'] = $getLicenseQuery->first_row();      
			}
		}
		return $data;
	}
	
	function getRevisedDocumentByID($ID,$select){
		$query = $this->db->select('*')->from($this->table_revised_documents)->where('id',$ID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	function getPotentialDataByID($ID){
		$query = $this->db->select('*')->from($this->table_potential_participates)->where('id',$ID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	function checkStage($leadID){
		$query = $this->db->select('*')->from($this->table_stage)->where('lead_id',$leadID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	function count_request_to_participate(){
		$data = $this->db->select('count(id) as totalRecords')->from($this->table_request_to_participate)->get()->row()->totalRecords;
		return $data;
	}
	
	function count_customer_request(){
		$data = $this->db->select('count(id) as totalRecords')->from($this->table_customer_request)->get()->row()->totalRecords;
		return $data;
	}
	
	function findRequestToParticipantById($ID,$select="*"){
		$query = $this->db->select($select)->from($this->table_request_to_participate)->where('id',$ID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	function checkLevel($leadID){
		$query = $this->db->select('*')->from($this->table_level)->where('lead_id',$leadID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	function checkLeadReport($leadID){
		$query = $this->db->select('*')->from($this->table_report)->where('lead_id',$leadID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	function checkOpenProjectDataByContactID($leadID,$contact_id,$type){		
		$query = $this->db->select('*')->from($this->table_lead_open_project)->where('contact_id',$contact_id)->where('lead_id',$leadID)->where('type',$type)->order_by('id','desc')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	function checkOpenProjectData($leadID,$type){		
		$query = $this->db->select('*')->from($this->table_lead_open_project)->where('lead_id',$leadID)->where('type',$type)->order_by('id','desc')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	function getAcquisitionData($leadID,$select ='a.*'){
		$query = $this->db->select($select)->from($this->table_acquisition.' as a')->where('a.lead_id',$leadID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();
        }
		return $data;
	}
	
	function getPersonCompanyDetailFromAcquisitionActivityLogByEmailID($emailID){
		$query = $this->db->select('contact_id,company_id')->from($this->table_acquisition_activity)->where('email_id',$emailID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	function findPersonInAnyActivity($contactID){
		$this->db->limit(1, 0);
		$this->db->order_by('id','DESC');	
		$query = $this->db->select('id')->from($this->table_acquisition_activity)->where('contact_id',$contactID)->get();
		if ($query->num_rows() > 0) {
            return $query->first_row();      
        } else {
			$this->db->limit(1, 0);
			$this->db->order_by('id','DESC');
			$query = $this->db->select('id')->from($this->table_sales_activity)->where('contact_id',$contactID)->get();
			if ($query->num_rows() > 0) {
				return $query->first_row();      
			} else {
				return array();
			}
		}
	}
	
	function getPersonCompanyDetailFromSalesActivityLogByEmailID($emailID){
		$query = $this->db->select('contact_id,company_id')->from($this->table_sales_activity)->where('email_id',$emailID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	function getPersonCompanyDetailFromPreSalesActivityLogByEmailID($emailID){
		$query = $this->db->select('contact_id,company_id')->from($this->table_presales_activity)->where('email_id',$emailID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	function findAllDocket(){
		$data = array();
		$query = $this->db->select('DISTINCT(a.lead_id)')->from($this->table_acquisition.' as a')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data;
	}
	
	function getPreContacts(){
		$data = array();
		$query = $this->db->select('*')->from($this->table_precontacts)->get();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data;
	}
	
	function findCompanyInPreContactAndDelete($companyName){
		$this->db->where('company_name',$companyName);
		$this->db->delete($this->table_precompanies);		
		return $this->db->affected_rows();
	}	
	
	function getPreCompanies(){
		$data = array();
		$query = $this->db->select('*')->from($this->table_precompanies)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data;
	}
	
	function getLitigationScrap(){
		$data = array();
		$query = $this->db->select('*')->from($this->table_litigation_scrap)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data;
	}
	
	function getFreePreContacts(){
		$data = array();
		$query = $this->db->select('*')->from($this->table_free_precontacts)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data;
	}
		
	function deletePreContact($id){
		$this->db->where('id',$id);
		$this->db->delete($this->table_precontacts);
		return $this->db->affected_rows();
	}
	
	function delete_all_precontacts(){
		$this->db->where('id >0');
		$this->db->delete($this->table_precontacts);
		return $this->db->affected_rows();
	}
	
	function deletePreCompany($id){
		$this->db->where('id',$id);
		$this->db->delete($this->table_precompanies);
		return $this->db->affected_rows();
	}
	
	function deleteApprovalRequest($leadID){
		$this->db->where('lead_id',$leadID);
		$this->db->delete($this->table_requests);
	}
	
	function deleteHistory($leadID){
		$this->db->where('lead_id',$leadID);
		$this->db->delete($this->table_history);
	}
	
	function deleteLeadButtons($leadID){
		$this->db->where('lead_id',$leadID);
		$this->db->delete($this->table_lead_buttons);
	}
	
	function deleteSalesActivity($emailID){
		$this->db->where('email_id',$emailID);
		$this->db->delete($this->table_sales_activity);
	}
	
	function deleteAcquisitionActivity($emailID){
		$this->db->where('email_id',$emailID);
		$this->db->delete($this->table_acquisition_activity);
	}
	
	function getAllUserHistory($userID,$leadID=0,$opportunity_id=0){
		$query = "";	
		if($leadID==0 && $opportunity_id==0){	
			$query = $this->db->select('h.message,h.id,h.create_date,u.name,u.id as userID,u.profile_pic,l.id as leadID,l.lead_name,l.plantiffs_name,l.type as leadType')->from($this->table_history.' as h')->join($this->table_lead.' as l ', 'l.id=h.lead_id')->join($this->table.' as u','u.id = h.user_id')->where('h.user_id',$userID)->order_by('h.id','DESC')->get();
		} else if($leadID>0 && $opportunity_id==0){	
			$query = $this->db->select('h.message,h.id,h.create_date,u.name,u.id as userID,u.profile_pic,l.id as leadID,l.lead_name,l.plantiffs_name,l.type as leadType')->from($this->table_history.' as h')->join($this->table.' as u','u.id = h.user_id')->join($this->table_lead.' as l ', 'l.id=h.lead_id')->where('h.lead_id',$leadID)->order_by('h.id','DESC')->get();
		} else {
			$query = $this->db->select('h.message,h.id,h.create_date,u.name,u.id as userID,u.profile_pic,l.id as leadID,l.lead_name,l.plantiffs_name,l.type as leadType')->from($this->table_history.' as h')->join($this->table_lead.' as l ', 'l.id=h.lead_id')->join($this->table_assign_lead.' aa a ', 'a.lead_id=h.lead_id')->join($this->table.' as u','u.id = h.user_id')->where('l.status','2')->where('h.lead_id',$leadID)->order_by('h.id','DESC')->get();
		}	
		$data = array();	
		if ($query->num_rows() > 0) {  
			foreach ($query->result() as $row) {  
				$data[] = $row; 
			}
		}
		return $data;
	}
	public function getLitigationComments($litigationID,$type){
		$query = $this->db->select('c.id,c.comment1,c.comment2,c.comment3,c.attractive,c.user_id,c.created,c.updated,u.name,u.email')->from('other_comments as c')->where('c.parent_id',$litigationID)->where('c.type',$type)->join('users as u','u.id=c.user_id','left outer')->order_by('c.id','DESC')->get();
		
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }            
        }
		return $data;
	}
	
	public function from_litigation_comment($data){
		// Inserting in Table(Litigation) 
		$this->db->insert($this->table_comment, $data);
		return $this->db->insert_id();
	}
	
	public function updateLeadStatus($data){
		$this->db->where('id', $data['id']);
		unset($data['id']);
		$this->db->update($this->table_lead,$data);	
		return $this->db->affected_rows();
	}
	
	public function from_litigation_update_comment($data){
        $id = $data['id'];
		unset($data['id']);
		$this->db->where('id', $id);		
		$this->db->update($this->table_comment,$data);	
		return $id;	
	}
	
	function userLeadTeamNote($leadID,$userID){
		$data = array();
		$query = $this->db->select('*')->from($this->table_comment)->where('parent_id',$leadID)->where('user_id',$userID)->get();
		if($query->num_rows()>0){
			$data = $query->first_row();
		}
		return $data;
	}
	
	public function from_litigation_update_comment_by_lead($leadID,$data){
		$this->db->where('parent_id', $leadID);		
		$this->db->update($this->table_comment,$data);	
		return $this->db->affected_rows();	
	}
	
	public function findLeadByType($leadType){
		$query = $this->db->select('l.*')->from($this->table_lead .' as l')->where('l.type',$leadType)->get();       
		$data = array();
		if ($query->num_rows() > 0) {
           foreach($query->result() as $row){
				$data[] = $row;
			}
        }
		return $data;
	}
	
	public function getLeadDataWithOptions($leadID,$select){
		$query = $this->db->select($select)->from($this->table_lead .' as l')->where('l.id',$leadID)->get();
       
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();
        }
		return $data;
	}
	
	public function getLeadData($leadID){
		$query = $this->db->select('l.*,u.name')->from($this->table_lead .' as l')->join('users as u', 'u.id = l.user_id')->where('l.id',$leadID)->get();
       
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();
        }
		return $data;
	}
	
	public function findSerialNumber($serialNumber){
		$query = $this->db->select('l.*')->from('litigations as l')->where('l.serial_number',trim($serialNumber))->get();
		
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();
        }
		return $data;
	}
	
	public function findPortfolioWithSerial($serialNumber){
		$query = $this->db->select('a.*,l.lead_name,l.serial_number')->from($this->table_acquisition.' as a')->join($this->table_lead.' as l','l.id=a.lead_id','left')->where('l.serial_number',trim($serialNumber))->where_in('l.status',array('0','1','2'))->get();		
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();
        }
		return $data;
	}
	
	public function findDemoPortfolioWithSerialList($serialNumbers){
		$query = $this->db->select('a.*,l.lead_name,l.serial_number')->from($this->table_acquisition.' as a')->join($this->table_lead.' as l','l.id=a.lead_id','left')->where_in('l.serial_number',$serialNumbers)->where_in('l.status',array('0','1','2'))->get();		
		$data = array();
		if ($query->num_rows() > 0) {
            foreach($query->result() as $row){
				$data[] = $row;
			}
        }
		return $data;
	}
	
	public function findLeadByName($leadName,$select="l.*"){
		$query = $this->db->select($select)->from($this->table_lead .' as l')->where('trim(l.lead_name)',trim($leadName))->get();
        $data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();
        }
		return $data;
	}
	
	
	public function checkDataFromSameOwnerToday($ownerName,$date,$type){
		$query = $this->db->select('count(*) as portfolio')->from($this->table_lead)->where('plantiffs_name',$ownerName)->where('type',$type)->where('date_format(create_date,"%Y-%m-%d")',$date)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();
        }
		return $data;
	}
	
	public function getUserById($ID){
		 $query = $this->db->select('u.*')->from($this->table.' as u')->where('u.id',$ID)->get();
		 $data = array();
		 if($query->num_rows()>0){
			 $data = $query->first_row();
		 }
		 return $data;
	}
	
    public function getUserPageAssign($url){
		$user_session_id = $this->session->userdata('id');
		$where = "( p.page_url = '$url')";
        $query = $this->db->select('u.*')->from('pages as p')->join('user_page_access_level as up', 'up.page_id = p.id')->join('users as u', 'u.id = up.user_id')->where($where)->get();
		$data=array();
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				$data[] = $row;
			}
		}
		/*Find Admin Users*/
		$query = $this->db->select('*')->from('users')->where('type','9')->get();
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				$data[] = $row;
			}
		}
		return $data;
	}
	
	public function insertFamilyPatentRelation($data){
		$this->db->insert($this->table_family_patent_relation,$data);
		return $this->db->insert_id();
	}
	
	public function insertPatentFamilyMember($data){
		$this->db->insert($this->table_patent_family_member,$data);
		return $this->db->insert_id();
	}
	
	public function checkFamilyPatentRelation($familyID,$patentID){
		return $this->db->select('count(pr.id) as countRelation')->from($this->table_family_patent_relation.' as pr')->where('pr.patent_id',$patentID)->where('pr.family_id',$familyID)->get()->row()->countRelation;		
	}
	
	public function checkFamilyMember($familyID,$publicationNumber,$applicationNumber){
		$query = $this->db->select('id')->from($this->table_patent_family_member.' as fm')->where('fm.family_id',$familyID)->where('fm.publication_number',$publicationNumber)->where('fm.application_number',$applicationNumber)->get();
		$data = array();
		if($query->num_rows()>0){
			$data = $query->first_row();
		}
		return $data;
	}
}
?>