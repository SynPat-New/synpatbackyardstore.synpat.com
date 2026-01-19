<?php
class Customer_model extends CI_Model{
	
	public $table_customer = 'customers';
	public $table_company = 'company';
	public $table_company_sector = 'company_sector';
	public $table_preferences = 'preferences';
	public $table_technology_preference = 'technology_preference';
	public $table_sector = 'sectors';
	public $table = "contacts";
	public $table_category = 'category';
	public $table_map_sector_category = 'map_sectors_departments';
	public $table_preference = 'preferences';
	public $table_wishlist = 'wishlist';
	public $table_customer_request = 'customer_request';
	public $table_acquisition_company = 'acquisition_company';
	public $table_invitees = 'backyard_invitees';
	public $pre_companies = 'pre_companies';
	public $table_scrapper_captcha_code = 'scrapper_captcha_code';
	
	public function checkEmailFromRequest($email){
		$queryMySend = $this->db->select("count(*) as userCount")->from($this->table_customer_request.' as c')->where('c.email',$email)->get()->row();
		return $queryMySend->userCount;
	}
	
	public function getCaptchaImage($JobID){
		$data = array('details'=>array(),'count'=>0);
		$queryMySend = $this->db->select("image,id,user_id")->from($this->table_scrapper_captcha_code.' as c')->where('c.job_id',$JobID)->where('status',0)->order_by('id','desc')->get();
		if($queryMySend->num_rows()>0){
			$data['details'] = $queryMySend->first_row();
		}
		$data['count'] = $this->db->select("count(*) as countImage")->from($this->table_scrapper_captcha_code.' as c')->where('c.job_id',$JobID)->where('status',1)->order_by('id','desc')->get()->row()->countImage;		
		return $data;
	}
	
	public function getUSPTOCaptcha($ID){
		$data = array();
		$queryMySend = $this->db->select("image,id,user_id")->from($this->table_scrapper_captcha_code.' as c')->where('c.id',$ID)->where('status',0)->get();
		if($queryMySend->num_rows()>0){
			$data = $queryMySend->first_row();
		}
		return $data;
	}
	
	public function updateCaptchaCode($data,$ID){
		$this->db->where('id',$ID);
		$this->db->update($this->table_scrapper_captcha_code, $data);
		return $this->db->affected_rows();
	}
	
	public function getCustomerRequest($Id){
		$queryMySend = $this->db->select("*")->from($this->table_customer_request.' as c')->where('c.id',$Id)->get()->row();
		return $queryMySend;
	}
	
	public function findCustomerRequestByEmail($email){
		$queryMySend = $this->db->select("*")->from($this->table_customer_request.' as c')->where('c.email',$email)->get()->row();
		return $queryMySend;
	}
	
	public function deleteCustomerRequest($ID){
		$this->db->delete($this->table_customer_request,array('id'=>$ID));	
		return $this->db->affected_rows();
	}
	public function checkEmail($email, $mode = 1){
		if($mode==1){
			$queryMySend = $this->db->select("count(*) as userCount")->from($this->table_customer.' as c')->where('c.email',$email)->get()->row();
			return $queryMySend->userCount;		
		} else {
			$queryMySend = $this->db->select("*")->from($this->table_customer.' as c')->where('c.email',$email)->get()->row();
			return $queryMySend;	
		}		
	}
	
	public function checkUserWithIDAndEmail($customerID,$email){
		$queryMySend = $this->db->select("*")->from($this->table_customer.' as c')->where('c.email',$email)->where('id',$customerID)->get()->row();
		return $queryMySend;	
	}
	
	public function checkActivationCode($code){
		$queryMySend = $this->db->select("*")->from($this->table_customer.' as c')->where('c.activation_code',$code)->get()->row();
		return $queryMySend;
	}
	
	public function checkCompanyExist($companyName){
		$queryMySend = $this->db->select("count(*) as companyCount")->from($this->table_company.' as c')->where('LOWER(c.company_name)',strtolower(trim($companyName)))->get()->row();
		return $queryMySend->companyCount;		
	}
	
	public function getCompanyData($companyName){
		$queryMySend = $this->db->select("*")->from($this->table_company.' as c')->where('LOWER(c.company_name)',strtolower(trim($companyName)))->get()->row();
		return $queryMySend;		
	}
	
	public function getCompaniesListJSON($companyName){
		$query = $this->db->select("c.company_name,c.linkedin_url,c.id")->from($this->table_company.' as c')->join($this->table_company_sector.' as cs','cs.company_id = c.id')->where('LOWER(c.company_name) LIKE "%'.strtolower(trim($companyName)).'%"')->where('cs.sector_id',21)->order_by('c.company_name',' ASC')->get();
		$data = array('companies'=>array(),'other_list'=>array());
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data['companies'][] = $row->company_name;
                $data['other_list'][] = $row;
            }
        }	
		$query = $this->db->select("c.company_name,c.linkedin_url,c.id")->from($this->pre_companies.' as c')->where('LOWER(c.company_name) LIKE "%'.strtolower(trim($companyName)).'%"')->order_by('c.company_name',' ASC')->get();
		/*echo $this->db->last_query();*/
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data['companies'][] = $row->company_name;
                $data['other_list'][] = $row;
            }
        }
		return $data; 
	}
	
	function getCategoriesListJSON($categoryName){
		$sectorID = 21;
		$data = array('categories'=>array(),'sub_category'=>array(),'other_list'=>array());
		$query = $this->db->query("SELECT name,id FROM ".$this->table_category." WHERE id IN (SELECT category_id FROM ".$this->table_map_sector_category."  WHERE sector_id=".(int)$sectorID.") ORDER BY name ASC");
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data['categories'][] = $row->name;
				if(trim($categoryName)!="" && $row->name == trim($categoryName)){					
					$querySubCategory = $this->db->select("*")->from($this->table_category)->where("parent IN (SELECT id FROM ".$this->table_category." WHERE type=0 AND name ='".$categoryName."')")->order_by('name','ASC')->get();
					if ($querySubCategory->num_rows() > 0) {
						foreach ($querySubCategory->result() as $rowSub) {
							$data['sub_category'][] = $rowSub->name;
							$data['other_list'][] = $rowSub;
						}
					}
				}
            }
        }
		return $data; 
	}
	
	public function getAllCustomerRequest(){
		$this->db->limit(2000,0);
		$query = $this->db->select("*")->from($this->table_customer_request)->order_by('id','DESC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data; 
	}
	
	public function insertCustomerRequest($data){
		$this->db->insert($this->table_customer_request, $data);
		return $this->db->insert_id();
	}
	
	public function insertCustomer($data){
		$this->db->insert($this->table_customer, $data);
		return $this->db->insert_id();
	}
	
	public function deleteCompanySector($companyID){
		$this->db->where('company_id',$companyID);
		$this->db->delete($this->table_company_sector);
	}
	
	public function addCompanySector($data){
		$this->db->insert($this->table_company_sector, $data);
		return $this->db->insert_id();
	}
	
	public function updateCompanySectorWithCompanyID($companyID,$data){
		$this->db->where("company_id",$companyID);
		$this->db->update($this->table_company_sector, $data);
		/*echo $this->db->last_query();*/
		return $this->db->affected_rows();
	}
	
	
	public function insertCustomerPreference($data){
		$this->db->insert($this->table_preference, $data);
		return $this->db->insert_id();
	}
	
	public function deleteCustomerPreference($customerID){
		$this->db->delete($this->table_preference,array('customer_id'=>$customerID));	
		return $this->db->affected_rows();
	}
	
	public function insertCompany($data){
		$this->db->insert($this->table_company, $data);
		return $this->db->insert_id();
	}
	
	public function insertWishlist($data){
		$this->db->insert($this->table_wishlist, $data);
		return $this->db->insert_id();
	}
	
	public function checkWishList($productID,$customerID){
		$queryMySend = $this->db->select("*")->from($this->table_wishlist.' as w')->where('w.customer_id',$customerID)->where('w.portfolio_id',$productID)->get()->row();
		return $queryMySend;
	} 
	
	public function deleteWishlist($ID){
		$this->db->delete($this->table_wishlist,array('id'=>$ID));	
		return $this->db->affected_rows();
	}
	
	public function updateUserInfo($userID,$data){
		$this->db->where('id',$userID);
		$this->db->update($this->table_customer,$data);
		return $this->db->affected_rows();
	}
	
	public function updateCompanyData($companyID,$data){
		$this->db->where('id',$companyID);
		$this->db->update($this->table_company,$data);
		return $this->db->affected_rows();
	}
	
	public function deleteCustomer($customerID){
		$this->db->delete($this->table_customer,array('id'=>$customerID));	
		return $this->db->affected_rows();
	}
	
	public function login($email,$password){
		$query = $this->db->select("c.*,cc.id as company_id, cc.company_name, cc.company_address,cc.telephone,cc.bank_name,cc.bank_account_no,cc.routing_no,cc.membership,cc.start_date,cc.end_date")->from($this->table_customer .' as c')->join($this->table_company.' as cc','c.company_id=cc.id')->where("c.email",$email)->where("c.password",$password)->get();
		$data = array();
		if(count($query->num_rows())>0){
			$data = $query->first_row();
			$this->updateUserInfo($data->id,array('last_login'=>date('Y-m-d H:i:s')));
		}
		return $data;
	}
	
	public function checUserDetail($userID){
		$query = $this->db->select("c.*,cc.id as company_id, cc.company_name, cc.company_address,cc.telephone,cc.bank_name,cc.bank_account_no,cc.routing_no,cc.membership,cc.start_date,cc.end_date")->from($this->table_customer .' as c')->join($this->table_company.' as cc','c.company_id=cc.id')->where("c.id",$userID)->get();
		$data = array();
		if(count($query->num_rows())>0){
			$data = $query->first_row();
		}
		return $data;
	}
	
	public function categoryList($categoryParent){
		$query = $this->db->select("*")->from($this->table_category)->where("parent",$categoryParent)->order_by('name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data; 
	}
	
	function getCategoryBySector($sectorID){
		$query = $this->db->query("SELECT * FROM ".$this->table_category." WHERE id IN (SELECT category_id FROM ".$this->table_map_sector_category."  WHERE sector_id=".(int)$sectorID.") ORDER BY id ASC");
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data; 
	}
	
	function getCategoryByAllSector($sectors){
		$data = array();
		if(count($sectors)){
			foreach($sectors as $sec){
				$query = $this->db->query("SELECT * FROM ".$this->table_category." WHERE id IN (SELECT category_id FROM ".$this->table_map_sector_category."  WHERE sector_id=".(int)$sec->sectorID.") ORDER BY id ASC");
				if ($query->num_rows() > 0) {
					foreach ($query->result() as $row) {
						$data[] = $row;
					}
				}
			}			
		}		
		return $data;
	}
	
	function updateFromCategoryToTechnologies(){
		$query = $this->db->select("company_id")->from($this->table_company_sector)->where('sector_id',79)->order_by('id','ASC')->get();
		$data = array();
		$technologiesCategory = $this->getCategoryBySector(21);
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$queryPreference = $this->db->select("preference_id")->from($this->table_preferences)->where('customer_id',$row->company_id)->order_by('id','ASC')->get();
				echo $this->db->last_query()."<br/>";
				if ($queryPreference->num_rows() > 0) {
					foreach ($queryPreference->result() as $rowPreference) {
						if(count($technologiesCategory)>0){
							foreach($technologiesCategory as $techCategory){
								echo "P:".$rowPreference->preference_id." @@ ".$techCategory->id."<br/>";
								if($rowPreference->preference_id==$techCategory->id){
									$parent = $this->db->select('parent')->from($this->table_category)->where('id',$techCategory->id)->get()->row()->parent;
									if($parent>0){
										$parent = 1;
									}
									$this->db->insert($this->table_technology_preference, array('company_id'=>$row->company_id,'preference_id'=>$rowPreference->preference_id,'type'=>$parent));
									echo $this->db->insert_id()."<br/>";
									break;
								}
							}
						}
					}
				}
			}
		}
	}
	
	public function mainCategoryList(){
		$query = $this->db->select("*")->from($this->table_category)->where("id IN(1,2,3,4,5,6,7,8,9,10,11,12)")->order_by('id','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data; 
	}
	
	public function categoryListWithMoreThanOne($listCategories){
		$explodeCategory = explode(',',$listCategories);
		$data = array();
		if(count($explodeCategory)>0){
			foreach($explodeCategory as $parentCat){
				$query = $this->db->select("*")->from($this->table_category)->where("parent",$parentCat)->order_by('name','ASC')->get();
				if ($query->num_rows() > 0) {
					foreach ($query->result() as $row) {
						$data[] = $row;
					}
				}
			}
		}		
		return $data; 
	}
	
	public function getCustomerWishListIDs($customerID){
		$query = $this->db->select("portfolio_id")->from($this->table_wishlist)->where("customer_id",$customerID)->order_by('id','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row->portfolio_id;
            }
        }
		return $data; 
	}
	
	public function getUsersList($companyID){
		$query = $this->db->select("*")->from($this->table_customer)->where("company_id",$companyID)->order_by('first_name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data; 
	}
	
	public function findMyPreference($customerID){
		$query = $this->db->select("*")->from($this->table_preference)->where("customer_id",$customerID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data; 
	}
	
	public function findMyPreferenceWithName($customerID){
		$query = $this->db->select("c.*")->from($this->table_preference.' as p')->join($this->table_category.' as c','c.id = p.preference_id')->where("p.customer_id",$customerID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data; 
	}
	
	/*public function getCompanyDataByID($companyID){
		$query = $this->db->select("c.*,s.name as sectorName, s.id as sectorID")->from($this->table_company.' as c')->join($this->table_company_sector.' as cs','cs.company_id = c.id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where('c.id',$companyID)->order_by('c.company_name','ASC')->get();		
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();
			$data->broker_details = $this->findBrokerDetails($data->broker);
			$data->companyUsers = $this->getAllContactBelongToCompany($companyID);
			$data->categories = $this->getCategoryBySector($data->sectorID);
			$departments = $this->findMyPreferenceWithNameSub($companyID,0);
			$subdepartments = $this->findMyPreferenceWithNameSub($companyID,1);
			$selctedcategory = array();
			foreach($departments as $sub){
				$selctedcategory[] = $sub->id;
			}
			$data->departments_list = $departments;
			$data->subdepartments_list = $subdepartments;
			if(count($selctedcategory)>0){
				$data->sub_categories = $this->categoryListWithMoreThanOne(implode(',',$selctedcategory));
			} else {
				$data->sub_categories = array();
			}
        }
		return $data;
	}*/
	
	public function findCompanyDataByUserIDAndEmail($userID,$userEmail){
		$query = $this->db->select("c.*")->from($this->table_contacts.' as c')->join($this->table_company.' as co','co.id=c.company_id','left')->where('c.id',$userID)->where('c.email',$userEmail)->or_where('c.secondary_email',$userEmail)->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$userData = $query->first_row();
			$companyID = $userData->company_id;
			$query = $this->db->select("c.*")->from($this->table_company.' as c')->where('c.id',$companyID)->order_by('c.company_name','ASC')->get();	
			if ($query->num_rows() > 0) {
				$data = $query->first_row();			
				$data->sectors = $this->findCompanySectors($companyID);
				$data->broker_details = $this->findBrokerDetails($data->broker);
				$data->companyUsers = $this->getAllContactBelongToCompany($companyID);
				/*$data->categories = $this->getCategoryBySector($data->sectorID);*/
				$data->categories = $this->getCategoryByAllSector($data->sectors);
				$departments = $this->findMyPreferenceWithNameSub($companyID,0);
				$subdepartments = $this->findMyPreferenceWithNameSub($companyID,1);
				$selctedcategory = array();
				foreach($departments as $sub){
					$selctedcategory[] = $sub->id;
				}
				$data->departments_list = $departments;
				$data->subdepartments_list = $subdepartments;
				if(count($selctedcategory)>0){
					$data->sub_categories = $this->categoryListWithMoreThanOne(implode(',',$selctedcategory));
				} else {
					$data->sub_categories = array();
				}
			}
        } 
	}
	
	public function getCompanyDataByID($companyID){
		$query = $this->db->select("c.*")->from($this->table_company.' as c')->where('c.id',$companyID)->order_by('c.company_name','ASC')->get();		
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();			
			$data->sectors = $this->findCompanySectors($companyID);
			$data->broker_details = $this->findBrokerDetails($data->broker);
			$data->companyUsers = $this->getAllContactBelongToCompany($companyID);
			/*$data->categories = $this->getCategoryBySector($data->sectorID);*/
			$data->categories = $this->getCategoryByAllSector($data->sectors);
			$departments = $this->findMyPreferenceWithNameSub($companyID,0);
			$subdepartments = $this->findMyPreferenceWithNameSub($companyID,1);
			$selctedcategory = array();
			foreach($departments as $sub){
				$selctedcategory[] = $sub->id;
			}
			$data->departments_list = $departments;
			$data->subdepartments_list = $subdepartments;
			if(count($selctedcategory)>0){
				$data->sub_categories = $this->categoryListWithMoreThanOne(implode(',',$selctedcategory));
			} else {
				$data->sub_categories = array();
			}
        }
		return $data;
	}
	
	public function findCompanySectors($companyID){
		$data = array();
		if($companyID>0){
			$query = $this->db->select("s.name as sectorName, s.id as sectorID")->from($this->table_company_sector.' as cs')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where('cs.company_id',$companyID)->get();
			foreach ($query->result() as $row) {
				$data[] = $row;
            }
		}
		return $data;
	}
	
	public function findBrokerDetails($brokerID){
		$data = array();
		if($brokerID>0){
			$query = $this->db->select("c.*,co.company_name , co.id as companyID")->from($this->table.' as c')->join($this->table_company.' as co','co.id = c.company_id')->where('c.id',$brokerID)->get();
			if ($query->num_rows() > 0) {
				$data = $query->first_row();
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
	
	public function findCompanyBySearch($search,$select){
		if(empty($select)){
			$select = "c.*,s.name as sectorName, s.id as sectorID";
		}
		$query = $this->db->select($select)->from($this->table_company.' as c')->join($this->table_company_sector.' as cs','cs.company_id = c.id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->order_by('c.company_name','ASC')->like('c.company_name',$search)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$data[] = $row;
            }
        }
		return $data; 
	}
	
	public function companyListWithSectorName($select){
		if(empty($select)){
			$select = "c.*,s.name as sectorName, s.id as sectorID";
		}
		$query = $this->db->select($select)->from($this->table_company.' as c')->join($this->table_company_sector.' as cs','cs.company_id = c.id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->order_by('c.company_name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$data[] = $row;
            }
        }
		return $data; 
	}
	
	public function companyList($activity=0,$leadID=0){
		if($leadID==0){
			$query = $this->db->select("c.*,s.name as sectorName, s.id as sectorID")->from($this->table_company.' as c')->join($this->table_company_sector.' as cs','cs.company_id = c.id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->order_by('c.company_name','ASC')->get();
		} else {
			if($activity==1){
				$query = $this->db->select("c.*,s.name as sectorName, s.id as sectorID")->from($this->table_company.' as c')->join($this->table_company_sector.' as cs','cs.company_id = c.id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->join($this->table_invitees.' as i','c.id=i.contact_id')->where("i.lead_id",$leadID)->order_by('c.company_name','ASC')->get();
			} else if($activity==2){
				$query = $this->db->select("c.*,s.name as sectorName, s.id as sectorID")->from($this->table_company.' as c')->join($this->table_company_sector.' as cs','cs.company_id = c.id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->join($this->table_acquisition_company.' as i','c.id=i.contact_id')->where("i.lead_id",$leadID)->order_by('c.company_name','ASC')->get();
			} else {
				$query = $this->db->select("c.*,s.name as sectorName, s.id as sectorID")->from($this->table_company.' as c')->join($this->table_company_sector.' as cs','cs.company_id = c.id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->order_by('c.company_name','ASC')->get();
			}			
		}
		
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$usersList = $this->getAllContactBelongToCompany($row->id);
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
	
	public function companyListWithPaging($search,$numOfRecords=50){
		$data = array('count_all'=>0,'data'=>array());	
		if($numOfRecords>0){
			$this->db->limit($numOfRecords,0);
		}
		if(trim($search)!=""){
			$query = $this->db->select("c.*")->from($this->table_company.' as c')->where('c.company_name LIKE "%'.$search.'%"')->order_by('c.company_name','ASC')->get();
		} else {
			$query = $this->db->select("c.*")->from($this->table_company.' as c')->order_by('c.company_name','ASC')->get();
		}
		if ($query->num_rows() > 0) { 
            foreach ($query->result() as $row) {
				$usersList = $this->getAllContactBelongToCompany($row->id);
				$sectors = $this->findCompanySectors($row->id);
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
	
	public function findMyPreferenceWithNameSub($customerID,$type){
		$query = $this->db->select("c.*")->from($this->table_preference.' as p')->join($this->table_category.' as c','c.id = p.preference_id')->where("p.customer_id",$customerID)->where('c.type',$type)->get();
		$this->db->last_query();
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
	
	public function customersList($companyID){
		if($companyID!=null){
			$query = $this->db->select("first_name,last_name,email,phone_number,id")->from($this->table_customer)->where("company_id",$companyID)->order_by('first_name','ASC')->get();
		} else {
			$query = $this->db->select("*")->from($this->table_customer)->order_by('first_name','ASC')->get();
		}		
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data;  
	}
	
	public function getAllCustomerCompanyList(){
		$query = $this->db->select("distinct(c.id) as companyID,c.*, cu.create_date as activationDate,cu.last_login as lastLogin")->from($this->table_customer.' as cu')->join($this->table_company.' as c','c.id = cu.company_id')->order_by('company_name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data; 
	}
	
	function getUsersByActDeactCompanies($companyID,$status){
		$query = $this->db->select("count(*) as users")->from($this->table_customer)->where("company_id",$companyID)->where("status",$status)->get()->row();
		/*echo $this->db->last_query();*/
		return $query->users;
	}
}

?>