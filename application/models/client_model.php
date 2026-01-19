<?php
class client_model extends CI_Model{
	public $table = "contacts";
	public $table_invite_sector = "invitees_in_sectors";
	public $table_sector = "sectors";
	public $table_company = 'company';
	public $table_customers = 'customers';
	public $table_company_sector = 'company_sector';
	public $table_preference = 'preferences';
	public $table_technology_preference = 'technology_preference';
	public $table_category = 'category';
	public $table_invitees = 'invitees';
	function __construct() {
		parent::__construct();
	}
	function insert($data){
		// Inserting in Table(Litigation) 
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}	
	function update($id,$data){
		$this->db->where('id', $id);
		$this->db->update($this->table,$data);
		return $this->db->affected_rows();
	}	
	function getAllClients(){
		$query = $this->db->select('*')->from($this->table)->order_by('name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }            
        }
		return $data;
	}	
	function findMissingSpotsContacts(){
		$query = $this->db->select('c.first_name,c.last_name,c.job_title,co.company_name,c.email,c.phone,c.linkedin_url')->from($this->table.' as c')->join($this->table_company.' as co','co.id = c.company_id')->where('c.email','')->or_where('c.linkedin_url','')->or_where('c.phone','')->order_by('first_name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }            
        }
		return $data;
	}	
	function getInfo($contactID){
		$query = $this->db->select('*')->from($this->table)->where('id',$contactID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();         
        }
		return $data;
	}	
	function find_contact_by_email($emailID){
		$query = $this->db->select('*')->from($this->table)->where('email',$emailID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();         
        }
		return $data;
	}
	function find_contact_by_linkedin($linkedIN){
		$query = $this->db->select('*')->from($this->table)->where('linkedin_url',$linkedIN)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();         
        }
		return $data;
	}	
	function deleteContact($ID){
		$this->db->delete($this->table,array("id"=>$ID));
		return $this->db->affected_rows();
	}	
	function deleteCompany($ID){
		$this->db->delete($this->table_company_sector,array("company_id"=>$ID));
		$this->db->delete($this->table_company,array("id"=>$ID));
		return $this->db->affected_rows();
	}	
	function find_contact($ID){
		$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name")->from($this->table.' as c')->join($this->table_company.' as co','co.id=c.company_id','left')->where("c.id",$ID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();         
        }
		return $data;
	}	
	function findSectorDataName($sectorName){
		$queryMySend = $this->db->select("*")->from($this->table_sector.' as c')->where('LOWER(c.name)',strtolower(trim($sectorName)))->get()->row();
		return $queryMySend;
	}	
	function getAllCompaniesWithMemAndSectorsSelectedWithPreferenceWithPaging($search,$sectors,$deptt,$typeMode=0,$numOfRecords=50){
		$data = array('count_all'=>0,'data'=>array());
		if($numOfRecords>0){
			$this->db->limit($numOfRecords,0);
		}
		if($typeMode==0){		
			if(trim($search)!=""){
				$query = $this->db->select("distinct(co.id),co.*, (SELECT COUNT(id) FROM ".$this->table_customers." as cus  WHERE cus.company_id = co.id) as userCount")->from($this->table_company.' as co')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->join($this->table_preference.' as p', 'p.customer_id = co.id','left')->where('co.company_name LIKE "%'.$search.'%"')->where('cs.sector_id IN ('.$sectors.')')->where('p.preference_id IN ('.$deptt.')')->order_by('co.company_name','ASC')->get();
			} else {
				$query = $this->db->select("distinct(co.id),co.*, (SELECT COUNT(id) FROM ".$this->table_customers." as cus  WHERE cus.company_id = co.id) as userCount")->from($this->table_company.' as co')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->join($this->table_preference.' as p', 'p.customer_id = co.id','left')->where('cs.sector_id IN ('.$sectors.')')->where('p.preference_id IN ('.$deptt.')')->order_by('co.company_name','ASC')->get();
			}
		} else {			
			if(trim($search)!=""){
				$query = $this->db->select("distinct(co.id),co.*, (SELECT COUNT(id) FROM ".$this->table_customers." as cus  WHERE cus.company_id = co.id) as userCount")->from($this->table_company.' as co')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where('co.company_name LIKE "%'.$search.'%"')->where('cs.sector_id IN ('.$sectors.')')->where('co.id NOT IN ( SELECT distinct(p.customer_id) FROM '.$this->table_preference.' as p)')->order_by('co.company_name','ASC')->get();
			} else {
				$query = $this->db->select("distinct(co.id),co.*, (SELECT COUNT(id) FROM ".$this->table_customers." as cus  WHERE cus.company_id = co.id) as userCount")->from($this->table_company.' as co')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where('cs.sector_id IN ('.$sectors.')')->where('co.id NOT IN ( SELECT distinct(p.customer_id) FROM '.$this->table_preference.' as p)')->order_by('co.company_name','ASC')->get();
			}
		}		
		/*echo $this->db->last_query();*/
		if ($query->num_rows() > 0) { 
            foreach ($query->result() as $row) {
				$usersList = $this->getAllContactBelongToCompany($row->id);
				$sectors = $this->getAllCompanySectors($row->id);
				$sectorsName = "";
				if(count($sectors)>0){
					foreach($sectors as $deptt){
						$sectorsName .= $deptt->sectorName.", ";
					}
					$sectorsName= substr($sectorsName,0,-2);
				}
				$row->sectorName = $sectorsName;
				$departments = $this->findMyPreferenceWithNameSub($row->id,0);
				$deptNames = "";
				if(count($departments)>0){
					foreach($departments as $deptt){
						$deptNames .= $deptt->name.", ";
					}
					$deptNames= substr($deptNames,0,-1);
				}
				$subdepartments = $this->findMyPreferenceWithNameSub($row->id,1);
				$subdeptNames = "";
				if(count($subdepartments)>0){
					foreach($subdepartments as $deptt){
						$subdeptNames .= $deptt->name.", ";
					}
					$subdeptNames= substr($subdeptNames,0,-1);
				}
				$technologies = $this->findTechnologiesPreferenceWithNameSub($row->id,0);
				$technologyNames = "";
				if(count($technologies)>0){
					foreach($technologies as $tech){
						$technologyNames .= $tech->name.", ";
					}
					$technologyNames= substr($technologyNames,0,-2);
				}
				$subTechnologies = $this->findTechnologiesPreferenceWithNameSub($row->id,1);
				$subTechnologyNames = "";
				if(count($subTechnologies)>0){
					foreach($subTechnologies as $tech){
						$subTechnologyNames .= $tech->name.", ";
					}
					$subTechnologyNames= substr($subTechnologyNames,0,-2);
				}
				$subsubTechnologies = $this->findTechnologiesPreferenceWithNameSub($row->id,2);				
				if(count($subsubTechnologies)>0){
					foreach($subsubTechnologies as $tech){
						$subTechnologyNames .= $tech->name.", ";
					}
					$subTechnologyNames= substr($subTechnologyNames,0,-2);
				}
				$row->technology_names = $technologyNames;
				$row->sub_technology_names = $subTechnologyNames;
				$row->company_users = $usersList;
				$row->department_names = $deptNames;
				$row->sub_department_names = $subdeptNames;
				$data['data'][] = $row;
            }            
        }		
		return $data;
	}
	function getAllCompaniesWithMemAndSectorsSelectedWithPreference($sectors,$deptt,$typeMode=0){
		if($typeMode==0){
			$query = $this->db->select("distinct(co.id),co.*, (SELECT COUNT(id) FROM ".$this->table_customers." as cus  WHERE cus.company_id = co.id) as userCount")->from($this->table_company.' as co')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->join($this->table_preference.' as p', 'p.customer_id = co.id','left')->where('cs.sector_id IN ('.implode(',',$sectors).')')->where('p.preference_id IN ('.$deptt.')')->order_by('co.company_name','ASC')->get();
		} else {
			$query = $this->db->select("distinct(co.id),co.*, (SELECT COUNT(id) FROM ".$this->table_customers." as cus  WHERE cus.company_id = co.id) as userCount")->from($this->table_company.' as co')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where('cs.sector_id IN ('.implode(',',$sectors).')')->where('co.id NOT IN ( SELECT distinct(p.customer_id) FROM '.$this->table_preference.' as p)')->order_by('co.company_name','ASC')->get();
		}
		
		/*echo $this->db->last_query();*/  
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$usersList = $this->getAllContactBelongToCompany($row->id);
				$sectors = $this->getAllCompanySectors($row->id);
				$sectorsName = "";
				if(count($sectors)>0){
					foreach($sectors as $deptt){
						$sectorsName .= $deptt->sectorName.", ";
					}
					$sectorsName= substr($sectorsName,0,-2);
				}
				$row->sectorName = $sectorsName;
				$departments = $this->findMyPreferenceWithNameSub($row->id,0);
				$deptNames = "";
				if(count($departments)>0){
					foreach($departments as $deptt){
						$deptNames .= $deptt->name.", ";
					}
					$deptNames= substr($deptNames,0,-1);
				}
				$subdepartments = $this->findMyPreferenceWithNameSub($row->id,1);
				$subdeptNames = "";
				if(count($subdepartments)>0){
					foreach($subdepartments as $deptt){
						$subdeptNames .= $deptt->name.", ";
					}
					$subdeptNames= substr($subdeptNames,0,-1);
				}
				$row->company_users = $usersList;
				$row->department_names = $deptNames;
				$row->sub_department_names = $subdeptNames;
				$data[] = $row;
            }            
        }		
		return $data;
	}	
	function getAllCompaniesWithMemAndSectorsSelected($sectors){
		$query = $this->db->select("co.*, (SELECT COUNT(id) FROM ".$this->table_customers." as cus  WHERE cus.company_id = co.id) as userCount")->from($this->table_company.' as co')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where('cs.sector_id IN ('.$sectors.')')->order_by('co.company_name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$usersList = $this->getAllContactBelongToCompany($row->id);
				$sectors = $this->getAllCompanySectors($row->id);
				$sectorsName = "";
				if(count($sectors)>0){
					foreach($sectors as $deptt){
						$sectorsName .= $deptt->sectorName.", ";
					}
					$sectorsName= substr($sectorsName,0,-2);
				}
				$row->sectorName = $sectorsName;
				$departments = $this->findMyPreferenceWithNameSub($row->id,0);
				$deptNames = "";
				if(count($departments)>0){
					foreach($departments as $deptt){
						$deptNames .= $deptt->name.", ";
					}
					$deptNames= substr($deptNames,0,-1);
				}
				$subdepartments = $this->findMyPreferenceWithNameSub($row->id,1);
				$subdeptNames = "";
				if(count($subdepartments)>0){
					foreach($subdepartments as $deptt){
						$subdeptNames .= $deptt->name.", ";
					}
					$subdeptNames= substr($subdeptNames,0,-1);
				}
				$technologies = $this->findTechnologiesPreferenceWithNameSub($row->id,0);
				$technologyNames = "";
				if(count($technologies)>0){
					foreach($technologies as $tech){
						$technologyNames .= $tech->name.", ";
					}
					$technologyNames= substr($technologyNames,0,-2);
				}
				$subTechnologies = $this->findTechnologiesPreferenceWithNameSub($row->id,1);
				$subTechnologyNames = "";
				if(count($subTechnologies)>0){
					foreach($subTechnologies as $tech){
						$subTechnologyNames .= $tech->name.", ";
					}
					$subTechnologyNames= substr($subTechnologyNames,0,-2);
				}
				$subsubTechnologies = $this->findTechnologiesPreferenceWithNameSub($row->id,2);				
				if(count($subsubTechnologies)>0){
					foreach($subsubTechnologies as $tech){
						$subTechnologyNames .= $tech->name.", ";
					}
					$subTechnologyNames= substr($subTechnologyNames,0,-2);
				}
				$row->technology_names = $technologyNames;
				$row->sub_technology_names = $subTechnologyNames;
				$row->company_users = $usersList;
				$row->department_names = $deptNames;
				$row->sub_department_names = $subdeptNames;
				$data[] = $row;
            }            
        }		
		return $data;
	}	
	function getAllCompaniesWithMemAndSectorsSelectedWithPaging($search,$sectors,$noOfRecords){
		$data = array('count_all'=>0,'data'=>array());
		if($numOfRecords>0){
			$this->db->limit($numOfRecords,0);
		}
		if(trim($search)!=""){
			$query = $this->db->select("co.*, (SELECT COUNT(id) FROM ".$this->table_customers." as cus  WHERE cus.company_id = co.id) as userCount")->from($this->table_company.' as co')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where('co.company_name LIKE "%'.$search.'%"')->where('cs.sector_id IN ('.$sectors.')')->order_by('co.company_name','ASC')->get();
		} else {
			$query = $this->db->select("co.*, (SELECT COUNT(id) FROM ".$this->table_customers." as cus  WHERE cus.company_id = co.id) as userCount")->from($this->table_company.' as co')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where('cs.sector_id IN ('.$sectors.')')->order_by('co.company_name','ASC')->get();
		}
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$usersList = $this->getAllContactBelongToCompany($row->id);
				$sectors = $this->getAllCompanySectors($row->id);
				$sectorsName = "";
				if(count($sectors)>0){
					foreach($sectors as $deptt){
						$sectorsName .= $deptt->sectorName.", ";
					}
					$sectorsName= substr($sectorsName,0,-2);
				}
				$row->sectorName = $sectorsName;
				$departments = $this->findMyPreferenceWithNameSub($row->id,0);
				$deptNames = "";
				if(count($departments)>0){
					foreach($departments as $deptt){
						$deptNames .= $deptt->name.", ";
					}
					$deptNames= substr($deptNames,0,-1);
				}
				$subdepartments = $this->findMyPreferenceWithNameSub($row->id,1);
				$subdeptNames = "";
				if(count($subdepartments)>0){
					foreach($subdepartments as $deptt){
						$subdeptNames .= $deptt->name.", ";
					}
					$subdeptNames= substr($subdeptNames,0,-1);
				}
				$technologies = $this->findTechnologiesPreferenceWithNameSub($row->id,0);
				$technologyNames = "";
				if(count($technologies)>0){
					foreach($technologies as $tech){
						$technologyNames .= $tech->name.", ";
					}
					$technologyNames= substr($technologyNames,0,-2);
				}
				$subTechnologies = $this->findTechnologiesPreferenceWithNameSub($row->id,1);
				$subTechnologyNames = "";
				if(count($subTechnologies)>0){
					foreach($subTechnologies as $tech){
						$subTechnologyNames .= $tech->name.", ";
					}
					$subTechnologyNames= substr($subTechnologyNames,0,-2);
				}
				$subsubTechnologies = $this->findTechnologiesPreferenceWithNameSub($row->id,2);				
				if(count($subsubTechnologies)>0){
					foreach($subsubTechnologies as $tech){
						$subTechnologyNames .= $tech->name.", ";
					}
					$subTechnologyNames= substr($subTechnologyNames,0,-2);
				}
				$row->technology_names = $technologyNames;
				$row->sub_technology_names = $subTechnologyNames;
				$row->company_users = $usersList;
				$row->department_names = $deptNames;
				$row->sub_department_names = $subdeptNames;
				$data['data'][] = $row;
            }            
        }		
		return $data;
	}	
	function getAllCompaniesWithMem($leadID = 0){
		if($leadID==0){
			$query = $this->db->select("co.*,(SELECT COUNT(id) FROM ".$this->table_customers." as cus  WHERE cus.company_id = co.id) as userCount")->from($this->table_company.' as co')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->order_by('co.company_name','ASC')->get();
		} else {
			$query = $this->db->select("co.*, (SELECT COUNT(id) FROM ".$this->table_customers." as cus  WHERE cus.company_id = co.id) as userCount")->from($this->table_company.' as co')->join($this->table_invitees.' as i','co.id=i.contact_id')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where("i.lead_id",$leadID)->order_by('co.company_name','ASC')->get();
		}		
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$usersList = $this->getAllContactBelongToCompany($row->id);
				$sectors = $this->getAllCompanySectors($row->id);
				$sectorsName = "";
				if(count($sectors)>0){
					foreach($sectors as $deptt){
						$sectorsName .= $deptt->sectorName.", ";
					}
					$sectorsName= substr($sectorsName,0,-2);
				}
				$row->sectorName = $sectorsName;
				$departments = $this->findMyPreferenceWithNameSub($row->id,0);
				$deptNames = "";
				if(count($departments)>0){
					foreach($departments as $deptt){
						$deptNames .= $deptt->name.", ";
					}
					$deptNames= substr($deptNames,0,-1);
				}
				$subdepartments = $this->findMyPreferenceWithNameSub($row->id,1);
				$subdeptNames = "";
				if(count($subdepartments)>0){
					foreach($subdepartments as $deptt){
						$subdeptNames .= $deptt->name.", ";
					}
					$subdeptNames= substr($subdeptNames,0,-1);
				}
				$technologies = $this->findTechnologiesPreferenceWithNameSub($row->id,0);
				$technologyNames = "";
				if(count($technologies)>0){
					foreach($technologies as $tech){
						$technologyNames .= $tech->name.", ";
					}
					$technologyNames= substr($technologyNames,0,-2);
				}
				$subTechnologies = $this->findTechnologiesPreferenceWithNameSub($row->id,1);
				$subTechnologyNames = "";
				if(count($subTechnologies)>0){
					foreach($subTechnologies as $tech){
						$subTechnologyNames .= $tech->name.", ";
					}
					$subTechnologyNames= substr($subTechnologyNames,0,-2);
				}
				$subsubTechnologies = $this->findTechnologiesPreferenceWithNameSub($row->id,2);				
				if(count($subsubTechnologies)>0){
					foreach($subsubTechnologies as $tech){
						$subTechnologyNames .= $tech->name.", ";
					}
					$subTechnologyNames= substr($subTechnologyNames,0,-2);
				}
				$row->technology_names = $technologyNames;
				$row->sub_technology_names = $subTechnologyNames;
				$row->company_users = $usersList;
				$row->department_names = $deptNames;
				$row->sub_department_names = $subdeptNames;
				$data[] = $row;
            }            
        }		
		return $data;
	}	
	public function findMyPreferenceWithNameSub($customerID,$type){
		$query = $this->db->select("c.*")->from($this->table_preference.' as p')->join($this->table_category.' as c','c.id = p.preference_id')->where("p.customer_id",$customerID)->where('c.type',$type)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data; 
	}
	public function findMyPreferenceWithName($customerID,$type){
		$query = $this->db->select("c.*")->from($this->table_preference.' as p')->join($this->table_category.' as c','c.id = p.preference_id')->where("p.customer_id",$customerID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data; 
	}	
	public function findTechnologiesPreferenceWithNameSub($companyID,$type){
		$query = $this->db->select("c.*")->from($this->table_technology_preference.' as p')->join($this->table_category.' as c','c.id = p.preference_id')->where("p.company_id",$companyID)->where('c.type',$type)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data; 
	}	
	function getAllContactBelongToCompany($companyID){
		$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name")->from($this->table.' as c')->where('c.company_id',$companyID)->order_by('c.first_name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$data[] = $row;
            }            
        }		
		return $data;
	}	
	function getAllContacts(){
		$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name as company_name,co.id as companyID")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id','left')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$sectors = $this->getAllCompanySectors($row->companyID);
				$sectorsName = "";
				if(count($sectors)>0){
					foreach($sectors as $deptt){
						$sectorsName .= $deptt->sectorName.", ";
					}
					$sectorsName= substr($sectorsName,0,-2);
				}
				$row->sectorName = $sectorsName;
				$departments = $this->findMyPreferenceWithNameSub($row->companyID,0);
				$deptNames = "";
				if(count($departments)>0){
					foreach($departments as $deptt){
						$deptNames .= $deptt->name.", ";
					}
					$deptNames= substr($deptNames,0,-1);
				}
				$subdepartments = $this->findMyPreferenceWithNameSub($row->companyID,1);
				$subdeptNames = "";
				if(count($subdepartments)>0){
					foreach($subdepartments as $deptt){
						$subdeptNames .= $deptt->name.", ";
					}
					$subdeptNames= substr($subdeptNames,0,-1);
				}
				$technologies = $this->findTechnologiesPreferenceWithNameSub($row->companyID,0);
				$technologyNames = "";
				if(count($technologies)>0){
					foreach($technologies as $tech){
						$technologyNames .= $tech->name.", ";
					}
					$technologyNames= substr($technologyNames,0,-2);
				}
				$subTechnologies = $this->findTechnologiesPreferenceWithNameSub($row->companyID,1);
				$subTechnologyNames = "";
				if(count($subTechnologies)>0){
					foreach($subTechnologies as $tech){
						$subTechnologyNames .= $tech->name.", ";
					}
					$subTechnologyNames= substr($subTechnologyNames,0,-2);
				}
				$subsubTechnologies = $this->findTechnologiesPreferenceWithNameSub($row->companyID,2);				
				if(count($subsubTechnologies)>0){
					foreach($subsubTechnologies as $tech){
						$subTechnologyNames .= $tech->name.", ";
					}
					$subTechnologyNames= substr($subTechnologyNames,0,-2);
				}
				$row->technology_names = $technologyNames;
				$row->sub_technology_names = $subTechnologyNames;
				$row->department_names = $deptNames;
				$row->sub_department_names = $subdeptNames;
				$data[] = $row;
            }            
        }		
		return $data;
	}	
	function getAllContactsWithPaging($noOfRecords=50){
		if($noOfRecords>0){
			$this->db->limit($noOfRecords,0);
		}
		/*$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name as company_name,s.id as sectorID, s.name as sectorName, co.id as companyID")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id','left')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->order_by('system_update','DESC')->get();*/
		$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name as company_name,co.id as companyID")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id','left')->order_by('system_update','DESC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$sectors = $this->getAllCompanySectors($row->companyID);
				$sectorsName = "";
				if(count($sectors)>0){
					foreach($sectors as $deptt){
						$sectorsName .= $deptt->sectorName.", ";
					}
					$sectorsName= substr($sectorsName,0,-2);
				}
				$row->sectorName = $sectorsName;
				$departments = $this->findMyPreferenceWithNameSub($row->companyID,0);
				$deptNames = "";
				if(count($departments)>0){
					foreach($departments as $deptt){
						$deptNames .= $deptt->name.", ";
					}
					$deptNames= substr($deptNames,0,-2);
				}
				$subdepartments = $this->findMyPreferenceWithNameSub($row->companyID,1);
				$subdeptNames = "";
				if(count($subdepartments)>0){
					foreach($subdepartments as $deptt){
						$subdeptNames .= $deptt->name.", ";
					}
					$subdeptNames= substr($subdeptNames,0,-2);
				}
				$technologies = $this->findTechnologiesPreferenceWithNameSub($row->companyID,0);
				$technologyNames = "";
				if(count($technologies)>0){
					foreach($technologies as $tech){
						$technologyNames .= $tech->name.", ";
					}
					$technologyNames= substr($technologyNames,0,-2);
				}
				$subTechnologies = $this->findTechnologiesPreferenceWithNameSub($row->companyID,1);
				$subTechnologyNames = "";
				if(count($subTechnologies)>0){
					foreach($subTechnologies as $tech){
						$subTechnologyNames .= $tech->name.", ";
					}
					$subTechnologyNames= substr($subTechnologyNames,0,-2);
				}
				$subsubTechnologies = $this->findTechnologiesPreferenceWithNameSub($row->companyID,2);				
				if(count($subsubTechnologies)>0){
					foreach($subsubTechnologies as $tech){
						$subTechnologyNames .= $tech->name.", ";
					}
					$subTechnologyNames= substr($subTechnologyNames,0,-2);
				}
				$row->technology_names = $technologyNames;
				$row->sub_technology_names = $subTechnologyNames;
				$row->department_names = $deptNames;
				$row->sub_department_names = $subdeptNames;
				$data[] = $row;
            }            
        }		
		return $data;
	}	
	function getAllContactsBySectorWithPaging($searchString,$sector,$noOfRecords){
		if($noOfRecords>0){
			$this->db->limit($noOfRecords,0);
		}
		if(!empty($searchString) && !empty($sector)){
			$searchStringExplode = explode(' ',$searchString);
			$whereString = "";
			if(count($searchStringExplode)==2){
				$stringOne = trim($searchStringExplode[0]);
				$stringTwo = trim($searchStringExplode[1]);
				if(!empty($stringOne) && !empty($stringTwo)){
					$whereString = 'upper(c.first_name)="'.strtoupper($stringOne).'" AND upper(c.last_name)="'.strtoupper($stringTwo).'"';
				}else {
					$whereString = 'c.first_name LIKE "%'.$searchString.'%" OR c.last_name LIKE "%'.$searchString.'%" OR co.company_name LIKE "%'.$searchString.'%" OR c.job_title LIKE "%'.$searchString.'%" OR c.email LIKE "%'.$searchString.'%" OR c.telephone LIKE "%'.$searchString.'%" OR c.phone LIKE "%'.$searchString.'%"';
				}
			}else {
				$whereString = 'c.first_name LIKE "%'.$searchString.'%" OR c.last_name LIKE "%'.$searchString.'%" OR co.company_name LIKE "%'.$searchString.'%" OR c.job_title LIKE "%'.$searchString.'%" OR c.email LIKE "%'.$searchString.'%" OR c.telephone LIKE "%'.$searchString.'%" OR c.phone LIKE "%'.$searchString.'%"';
			}
			$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name as company_name, co.id as companyID")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id','left')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where($whereString)->where('cs.sector_id IN ('.$sector.')')->order_by('system_update','DESC')->get();
		} else if(empty($searchString) && !empty($sector)){
			$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name as company_name, co.id as companyID")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id','left')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where('cs.sector_id IN ('.$sector.')')->order_by('system_update','DESC')->get();
		} else if(!empty($searchString) && empty($sector)){
			$searchStringExplode = explode(' ',$searchString);
			$whereString = "";
			if(count($searchStringExplode)==2){
				$stringOne = trim($searchStringExplode[0]);
				$stringTwo = trim($searchStringExplode[1]);
				if(!empty($stringOne) && !empty($stringTwo)){
					$whereString = 'upper(c.first_name)="'.strtoupper($stringOne).'" AND upper(c.last_name)="'.strtoupper($stringTwo).'"';
				} else {
					$whereString = 'c.first_name LIKE "%'.$searchString.'%" OR c.last_name LIKE "%'.$searchString.'%" OR co.company_name LIKE "%'.$searchString.'%" OR c.job_title LIKE "%'.$searchString.'%" OR c.email LIKE "%'.$searchString.'%" OR c.telephone LIKE "%'.$searchString.'%" OR c.phone LIKE "%'.$searchString.'%"';
				}
			} else {
				$whereString = 'c.first_name LIKE "%'.$searchString.'%" OR c.last_name LIKE "%'.$searchString.'%" OR co.company_name LIKE "%'.$searchString.'%" OR c.job_title LIKE "%'.$searchString.'%" OR c.email LIKE "%'.$searchString.'%" OR c.telephone LIKE "%'.$searchString.'%" OR c.phone LIKE "%'.$searchString.'%"';
			}
			$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name as company_name, co.id as companyID")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id','left')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where($whereString)->order_by('system_update','DESC')->get();
		} else {
			$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name as company_name, co.id as companyID")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id','left')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->order_by('system_update','DESC')->get();
		}
		/*echo $this->db->last_query();*/
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$sectors = $this->getAllCompanySectors($row->companyID);
				$sectorsName = "";
				if(count($sectors)>0){
					foreach($sectors as $deptt){
						$sectorsName .= $deptt->sectorName.", ";
					}
					$sectorsName= substr($sectorsName,0,-2);
				}
				$row->sectorName = $sectorsName;				
				$departments = $this->findMyPreferenceWithNameSub($row->companyID,0);
				$deptNames = "";
				if(count($departments)>0){
					foreach($departments as $deptt){
						$deptNames .= $deptt->name.", ";
					}
					$deptNames= substr($deptNames,0,-1);
				}
				$subdepartments = $this->findMyPreferenceWithNameSub($row->companyID,1);
				$subdeptNames = "";
				if(count($subdepartments)>0){
					foreach($subdepartments as $deptt){
						$subdeptNames .= $deptt->name.", ";
					}
					$subdeptNames= substr($subdeptNames,0,-1);
				}
				$technologies = $this->findTechnologiesPreferenceWithNameSub($row->companyID,0);
				$technologyNames = "";
				if(count($technologies)>0){
					foreach($technologies as $tech){
						$technologyNames .= $tech->name.", ";
					}
					$technologyNames= substr($technologyNames,0,-2);
				}
				$subTechnologies = $this->findTechnologiesPreferenceWithNameSub($row->companyID,1);
				$subTechnologyNames = "";
				if(count($subTechnologies)>0){
					foreach($subTechnologies as $tech){
						$subTechnologyNames .= $tech->name.", ";
					}
					$subTechnologyNames= substr($subTechnologyNames,0,-2);
				}
				$subsubTechnologies = $this->findTechnologiesPreferenceWithNameSub($row->companyID,2);				
				if(count($subsubTechnologies)>0){
					foreach($subsubTechnologies as $tech){
						$subTechnologyNames .= $tech->name.", ";
					}
					$subTechnologyNames= substr($subTechnologyNames,0,-2);
				}
				$row->technology_names = $technologyNames;
				$row->sub_technology_names = $subTechnologyNames;
				$row->department_names = $deptNames;
				$row->sub_department_names = $subdeptNames;
				$data[] = $row;
            }            
        }		
		return $data;
	}	
	function getAllContactsBySectorDepttWithPaging($searchString,$sector,$dept,$noOfRecords){
		if($noOfRecords>0){
			$this->db->limit($noOfRecords,0);
		}
		if(!empty($searchString) && !empty($dept)){
			$searchStringExplode = explode(' ',$searchString);
			$whereString = "";
			if(count($searchStringExplode)==2){
				$stringOne = trim($searchStringExplode[0]);
				$stringTwo = trim($searchStringExplode[1]);
				if(!empty($stringOne) && !empty($stringTwo)){
					$whereString = 'upper(c.first_name)="'.strtoupper($stringOne).'" AND upper(c.last_name)="'.strtoupper($stringTwo).'"';
				}else {
					$whereString = 'c.first_name LIKE "%'.$searchString.'%" OR c.last_name LIKE "%'.$searchString.'%" OR co.company_name LIKE "%'.$searchString.'%" OR c.job_title LIKE "%'.$searchString.'%" OR c.email LIKE "%'.$searchString.'%" OR c.telephone LIKE "%'.$searchString.'%" OR c.phone LIKE "%'.$searchString.'%"';
				}
			}else {
				$whereString = 'c.first_name LIKE "%'.$searchString.'%" OR c.last_name LIKE "%'.$searchString.'%" OR co.company_name LIKE "%'.$searchString.'%" OR c.job_title LIKE "%'.$searchString.'%" OR c.email LIKE "%'.$searchString.'%" OR c.telephone LIKE "%'.$searchString.'%" OR c.phone LIKE "%'.$searchString.'%"';
			}
			$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name as company_name, co.id as companyID")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id','left')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->join($this->table_preference.' as p', 'p.customer_id = co.id','left')->where('cs.sector_id IN ('.$sector.')')->where('p.preference_id IN ('.$dept.')')->where($whereString)->order_by('system_update','DESC')->get();
		} else if(empty($searchString) && !empty($dept)){
			$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name as company_name, co.id as companyID")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id','left')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->join($this->table_preference.' as p', 'p.customer_id = co.id','left')->where('cs.sector_id IN ('.$sector.')')->where('p.preference_id IN ('.$dept.')')->order_by('system_update','DESC')->get();
		} else if(!empty($searchString) && empty($dept)){
			$searchStringExplode = explode(' ',$searchString);
			$whereString = "";
			if(count($searchStringExplode)==2){
				$stringOne = trim($searchStringExplode[0]);
				$stringTwo = trim($searchStringExplode[1]);
				if(!empty($stringOne) && !empty($stringTwo)){
					$whereString = 'upper(c.first_name)="'.strtoupper($stringOne).'" AND upper(c.last_name)="'.strtoupper($stringTwo).'"';
				}else {
					$whereString = 'c.first_name LIKE "%'.$searchString.'%" OR c.last_name LIKE "%'.$searchString.'%" OR co.company_name LIKE "%'.$searchString.'%" OR c.job_title LIKE "%'.$searchString.'%" OR c.email LIKE "%'.$searchString.'%" OR c.telephone LIKE "%'.$searchString.'%" OR c.phone LIKE "%'.$searchString.'%"';
				}
			}else {
				$whereString = 'c.first_name LIKE "%'.$searchString.'%" OR c.last_name LIKE "%'.$searchString.'%" OR co.company_name LIKE "%'.$searchString.'%" OR c.job_title LIKE "%'.$searchString.'%" OR c.email LIKE "%'.$searchString.'%" OR c.telephone LIKE "%'.$searchString.'%" OR c.phone LIKE "%'.$searchString.'%"';
			}
			$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name as company_name, co.id as companyID")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id','left')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where('cs.sector_id IN ('.$sector.')')->where($whereString)->order_by('system_update','DESC')->get();
		} else {
			$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name as company_name, co.id as companyID")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id','left')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where('cs.sector_id IN ('.$sector.')')->order_by('system_update','DESC')->get();
		}
		
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$sectors = $this->getAllCompanySectors($row->companyID);
				$sectorsName = "";
				if(count($sectors)>0){
					foreach($sectors as $deptt){
						$sectorsName .= $deptt->sectorName.", ";
					}
					$sectorsName= substr($sectorsName,0,-2);
				}
				$row->sectorName = $sectorsName;
				$departments = $this->findMyPreferenceWithNameSub($row->companyID,0);
				$deptNames = "";
				if(count($departments)>0){
					foreach($departments as $deptt){
						$deptNames .= $deptt->name.", ";
					}
					$deptNames= substr($deptNames,0,-1);
				}
				$subdepartments = $this->findMyPreferenceWithNameSub($row->companyID,1);
				$subdeptNames = "";
				if(count($subdepartments)>0){
					foreach($subdepartments as $deptt){
						$subdeptNames .= $deptt->name.", ";
					}
					$subdeptNames= substr($subdeptNames,0,-1);
				}
				$technologies = $this->findTechnologiesPreferenceWithNameSub($row->companyID,0);
				$technologyNames = "";
				if(count($technologies)>0){
					foreach($technologies as $tech){
						$technologyNames .= $tech->name.", ";
					}
					$technologyNames= substr($technologyNames,0,-2);
				}
				$subTechnologies = $this->findTechnologiesPreferenceWithNameSub($row->companyID,1);
				$subTechnologyNames = "";
				if(count($subTechnologies)>0){
					foreach($subTechnologies as $tech){
						$subTechnologyNames .= $tech->name.", ";
					}
					$subTechnologyNames= substr($subTechnologyNames,0,-2);
				}
				$subsubTechnologies = $this->findTechnologiesPreferenceWithNameSub($row->companyID,2);				
				if(count($subsubTechnologies)>0){
					foreach($subsubTechnologies as $tech){
						$subTechnologyNames .= $tech->name.", ";
					}
					$subTechnologyNames= substr($subTechnologyNames,0,-2);
				}
				$row->technology_names = $technologyNames;
				$row->sub_technology_names = $subTechnologyNames;
				$row->department_names = $deptNames;
				$row->sub_department_names = $subdeptNames;
				$data[] = $row;
            }            
        }		
		return $data;
	}	
	function getAllCompanySectors($companyID){
		$data = array();
		if($companyID>0){
			$query = $this->db->select("s.name as sectorName, s.id as sectorID")->from($this->table_company_sector.' as cs')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where('cs.company_id',$companyID)->get();
			foreach ($query->result() as $row) {
				$data[] = $row;
            }
		}
		return $data;
	}	
	function getHoleContacts($contacts=array()){
		if(count($contacts)>0){
			/*$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name as company_name,s.id as sectorID, s.name as sectorName, co.id as companyID")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id','left')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where('c.id IN ('.implode(',',$contacts).') AND (c.email="" OR c.linkedin_url="" OR c.phone="" OR c.telephone="")')->get();*/
			
			$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name as company_name,s.id as sectorID, s.name as sectorName, co.id as companyID")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id','left')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where('c.id IN ('.implode(',',$contacts).')')->get();
		} else {
			$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name as company_name,s.id as sectorID, s.name as sectorName, co.id as companyID")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id','left')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where('c.email',"")->or_where('c.linkedin_url',"")->or_where('c.phone',"")->or_where('c.telephone',"")->get();
		}		
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$data[] = $row;
            }            
        }		
		return $data;
	}	
	function getAllAutoCompleteContacts(){
		$query = $this->db->select("c.id,CONCAT((c.first_name),(' '),(c.last_name),('- '),(co.company_name)) as label, c.email as `value`, c.secondary_email as secondary")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->order_by('c.first_name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$data[] = $row;
            }            
        }		
		return $data;
	}	
	function getAllContactsWithSectors(){
		$query = $this->db->select('*')->from($this->table)->order_by('name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$newArray['contact'] = $row;
				$querySector = $this->db->select('s.*')->from($this->table_invite_sector.'  as i')->join($this->table_sector.' as s', 's.id = i.market_id')->where('i.invite_id',$row->id)->get();
                if ($querySector->num_rows() > 0) {
					foreach ($querySector->result() as $sector) {
						$newArray['sector'][] = $sector;
					} 
				} else {
					$newArray['sector']= array();
				}
				$data[] = $newArray;
            }            
        }
		
		return $data;
	}	
	function getContactListBySectorID($sectorID){
		$query = $this->db->select('c.*')->from($this->table.' as c ')->join($this->table_invite_sector .' as ivs ', 'ivs.invite_id = c.id')->where('ivs.market_id',$sectorID)->order_by('c.name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$newArray['contact'] = $row;
				$querySector = $this->db->select('s.*')->from($this->table_invite_sector.'  as i')->join($this->table_sector.' as s', 's.id = i.market_id')->where('i.invite_id',$row->id)->get();
                if ($querySector->num_rows() > 0) {
					foreach ($querySector->result() as $sector) {
						$newArray['sector'][] = $sector;
					} 
				} else {
					$newArray['sector']= array();
				}
				$data[] = $newArray;
            }            
        }		
		return $data;
	}
}
?>