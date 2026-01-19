<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/typography.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/grid.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>themes/components/default.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/buttons.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/forms.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/colors.css">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>nestable.css">
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-widget.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-position.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/autocomplete/menu.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/autocomplete/autocomplete.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.1.2/js/dataTables.fixedHeader.min.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>jquery.nestable.js"></script>
<style>
	body {
		overflow: auto !important;overflow-x:hidden !important;
		min-width: 0;
		width: 100% !important;font-size:13px;font-family:arial;margin:0px;
	}
	ul{list-style:none;}
	#companyLinkedinUrl,#companyWebAddress{cursor:pointer !important;color:#56b2fe !important;}
	.ui-menu-item{list-style:none;padding:10px;border:1px solid #56b2fe;margin-bottom:3px;}
	.ui-menu-item:hover{background-color:#56b2fe;color:#fff;}	
	.ui-helper-hidden-accessible{display:none;}
	.ui-autocomplete {
	padding:0px;margin:0px;
    max-height: 200px;
    overflow-y: auto;
    overflow-x: hidden;width:300px !important;background:#fff;
  }
  .show_name {padding-top: 8px;padding-left: 5px;}
	</style>
<?php 
	$company_name = "";
	$web_address = "";
	$state = "";
	$city = "";
	$company_name_alias = "";
	$postal_code = "";
	$telephone = "";
	$email = "";
	$contractor = "";
	$broker = 0;
	$parentID = 0;
	$broker_details = array();
	$company_address = "";
	$linkedin_url = "";
	$country = "";
	$departments_list = array();
	$categories = array();
	$subdepartments_list = array();
	$sub_categories = array();
	$brokerFirm="";
	$brokerName="";
	$describing="";
	$industry = "";
	$specialties = "";
	$noOfEmployees = "";
	$parentName = "";
	$companyLogo = "";
	$similarOrganization = array();
	$id = $companyID;
	$companyUsers = array();
	$companySize="";
	$peopleAlsoViewed = "";
	$other1="";
	$other2="";
	$other3="";
	$other4="";
	$other5="";
	$companyType="";
	if(count($company)>0){
		$company_name = $company->company_name;
		$companyType = $company->company_type;
		$parentName = $company->parentName;
		$parentID = $company->parent_c;
		$company_name = preg_replace('/"/','',$company_name);
		$web_address = $company->web_address;
		$state = $company->state;
		$city = $company->city;
		$email = $company->email;
		$company_name_alias = $company->company_name_alias;
		$postal_code = $company->postal_code;
		$telephone = $company->telephone;
		$contractor = $company->contractor;
		$broker = $company->broker;
		$broker_details = $company->broker_details;
		if(count($broker_details)>0){
			$brokerFirm = $broker_details->company_name;
			$brokerName = $broker_details->first_name." ".$broker_details->last_name;
		}
		$company_address = $company->company_address;
		$linkedin_url = $company->linkedin_url;
		$peopleAlsoViewed = $company->similar_organisation;
		if($state!=""){
			$country = $state;
		}
		if($country!=""){
			if($company->country!=""){
				$country .= ", ".$company->country;
			}
		} else {
			$country = $company->country;
		}
		
		$categories = $company->categories;
		$departments_list = $company->departments_list;
		$subdepartments_list = $company->subdepartments_list;
		$sub_categories = $company->sub_categories;
		$companyUsers = $company->companyUsers;
		$describing = $company->describing;
		$industry = $company->industry;
		$specialties = $company->specialties;
		$noOfEmployees = number_format($company->no_of_employees);
		$companySize = $company->company_size;
		$companyLogo = $company->company_logo;
		$similarOrganization = $company->list;
		
		$other1 = $company->other1;
		$other2 = $company->other2;
		$other3 = $company->other3;
		$other4 = $company->other4;
		$other5 = $company->other5;
	}
?>

<style>
table.dataTable thead th, table.dataTable tfoot th{font-weight:normal;}
.nested-list-item .dd-handle {
    width: 22px;
    padding-left: 3px;
    background: none !IMPORTANT;
    border: 0;
    padding-right: 0;
}
div.nested-list-content .listbox{
	display: inline;
    margin-left: 10px;
    line-height: 10px;
}
div.nested-list-content {
    font-weight: normal;
    background: none;
    border: 0;
    border-bottom: 1px solid rgba(204, 204, 204, 0.2);
    padding-left: 25px;
}
.hide{display:none;}
.show{display:block;}
</style>

<?php echo form_open('opportunity/add_company/'.$companyID,array('class'=>"form-flat",'id'=>'ccompanyFormSubmit', 'style'=>'margin-left:2px; margin-right:0px;'));?>
<h4 class="modal-title pull-left" id="createContactModalLabel" style="width:100%;height:30px">Company</h4>
<div class="row">
	<div class="col-xs-12">		
		<div class="col-xs-9" style="width:80%;padding:0px;">		
		<button type="submit" id="buttonADDCCompany" class="btn btn-primary ">Save</button><!-- <button type="button" onclick="window.parent.getSectorsPage();" id="btnManageCategories" class="btn btn-primary btn-mwidth">Manage Categories</button>-->
		<button type="button" onclick="linkedInSearch();" id="btnManageCategories" class="btn btn-primary ">LinkedIn Search</button>	
		<button type="button" onclick="openAddContact()" id="" class="btn btn-primary">Add Contact</button>
		<button type="button" onclick="scrapeCompany();" id="" class="btn btn-primary">Scrape</button>
		<button type="button" onclick="openClasify();" id="" class="btn btn-primary ">Classify</button>
		<span id="loading_message"></span>
		<button type="button" onclick="deleteCompany(<?php echo $companyID?>);" id="" class="btn btn-primary ">Delete</button>
		<span id="loading_message"></span>
		</div>
		<div class="col-xs-3" id="companyLogo" style='text-align:center;width:17%;padding:0px;'>
		<?php 
			if($companyLogo!=""){
		?>
			<img src="<?php echo $companyLogo?>" style="height:120px;"/>
		<?php
			}
		?>
		</div>
	</div>
	
</div>
<div class="row"> <div class="col-xs-12" style='width:98%;padding:0px;'> <div class="col-xs-12">  
 <div class="row"> <div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label">Company Name:</label> <input type="text" name="company[company_name]" id="companyJobTitle" value="<?php echo $company_name?>" class="form-control" placeholder="" style='width:45%;'/> </div> </div><div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label">Short version for mail:</label> <input type="text" name="company[company_name_alias]" id="companyCompanyNameAlias" class="form-control" placeholder="" value="<?php echo $company_name_alias?>" style='width:26%;'/><input type="hidden" name="company[postal_code]" id="companyZip" class="form-control" placeholder="" value="<?php echo $postal_code?>"/> </div> </div> </div>
 <div class="row"><div class="col-xs-4"><div class="form-group input-string-group"> <label class="control-label">Other Names:</label> <input type="text" name="company[other1]" id="companyOther1" value="<?php echo $other1?>" class="form-control" placeholder="" style="width:198px"/></div></div><div class="col-xs-2"><div class="form-group input-string-group"> <label class="control-label">2</label> <input type="text" name="company[other2]" id="companyOther2" value="<?php echo $other2?>" class="form-control" placeholder="" style="width:121px"/></div></div><div class="col-xs-2"><div class="form-group input-string-group"> <label class="control-label">3</label> <input type="text" name="company[other3]" id="companyOther3" value="<?php echo $other3?>" class="form-control" placeholder="" style="width:121px"/></div></div><div class="col-xs-2"><div class="form-group input-string-group"> <label class="control-label">4</label> <input type="text" name="company[other4]" id="companyOther4" value="<?php echo $other4?>" class="form-control" placeholder="" style="width:121px"/></div></div><div class="col-xs-2"><div class="form-group input-string-group"> <label class="control-label">5</label> <input type="text" name="company[other5]" id="companyOther5" value="<?php echo $other5?>" class="form-control" placeholder="" style="width:121px"/></div></div></div><div class="row"> <div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label">Web address:</label> <input type="text" name="company[web_address]" id="companyWebAddress" class="form-control" placeholder="" value="<?php echo $web_address?>" style='width:54%;'/><input type="hidden" name="company[state]" id="companyState" class="form-control" placeholder="" value="<?php echo $state?>"/> </div> </div><div class="col-xs-6"> <div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label">Parent Search:</label> <input type="text" name="companyParentSearch" id="companyParentSearch" class="form-control" placeholder="" value="" /> </div> </div><div class="col-xs-5"> <div class="form-group input-string-group"> <label class="control-label">Parent:</label> <span class='show_name' style='display:block;height:17px;'><?php if($parentID>0):?><strong><a href='javascript://' onclick="window.parent.openCompanyEdit(<?php echo $parentID;?>);"><?php echo $parentName;?></a></strong><?php endif;?></div> <input type="hidden" name="company[parent_c]" id="companyParent" class="form-control" placeholder="" value="<?php echo $parentID;?>"/> </div><div class="col-xs-1"><a href='javascript://' onclick="resetParent(<?php echo $companyID?>);" style='position:absolute;top:12px;'><i class="fa fa-trash"></i></a></div> </div></div>
  </div> 
 <div class="row"> 
 <div class="col-xs-12"><div class="col-xs-6"><div class='col-xs-5'> <div class="form-group input-string-group"> <label class="control-label">Size:</label> <input type="text" name="company[company_size]" id="companySize" value="<?php echo $companySize;?>" class="form-control" /> </div></div><div class='col-xs-7'><div class="form-group input-string-group"> <label class="control-label">On LinkedIN:</label> <input type="text" name="company[no_of_employees]" class="form-control" id="companyNoOfEmployees" value="<?php echo $noOfEmployees;?>"/> </div></div> </div>  <div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label">LinkedIn:</label> <input type="text" name="company[linkedin_url]" id="companyLinkedinUrl" class="form-control" placeholder="" value="<?php echo $linkedin_url?>" style='width:61%;'/> </div> </div> </div> </div> 
 <div class="row"> <div class="col-xs-6"><div class='col-xs-5'> <div class="form-group input-string-group" style="margin:0px;"> <label class="control-label">Contractor:</label> <input type="checkbox" name="company[contractor]" id="companyContractor" value="1" style="text-align: left;margin:10px 0 0 5px;"/> </div></div><div class='col-xs-7'> <div class="form-group input-string-group" style="margin:0px;"> <label class="control-label">Type:</label> <input type="text" name="company[company_type]" id="companyType" class="form-control" value="<?php echo $companyType;?>"/> </div></div></div><div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label"><a href='javascript://' onclick='if(typeof window.parent.openCompanyBrokerFirm=="function"){window.parent.openCompanyBrokerFirm();} else {window.parent.parent.openCompanyBrokerFirm();}'>Broker:</a></label><input type="text"  id="companyBrokerName" class="form-control" placeholder="" value="<?php echo $brokerName;?>" style='width:72%;'/> <input type="hidden" name="company[broker]" id="companyBroker" class="form-control" placeholder="" value="<?php echo $broker?>"/><input type="hidden" name="company[email]" id="companyEmail" class="form-control" placeholder="" value="<?php echo $email?>"/><input type="hidden"  id="companyBrokerFirm" class="form-control" placeholder="" value="<?php echo $brokerFirm?>"/>
 </div> </div>   </div>
 <div class="row"> <div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label">Street:</label> <input type="text" name="company[company_address]" value="<?php echo $company_address?>" id="inviteeStreet" class="form-control" placeholder="" style='width:54%;'/> </div> </div><div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label">Telephone:</label> <input type="text" name="company[telephone]" id="companyTelephone" class="form-control" placeholder="" value="<?php echo $telephone?>" style='width:61%;'/> </div> </div></div> <div class="row"><div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label">City:</label> <input type="text" name="company[city]" id="companyCity" value="<?php echo $city?>" class="form-control" placeholder="" style='width:80%;'/> </div> </div> <div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label">Country/Region:</label> <input type="text" name="company[country]" value="<?php echo $country?>" id="companyCountry" class="form-control" placeholder="" style='width:45%;'/> </div> </div><div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label">Industry:</label> <input type="text" name="company[industry]" value="<?php echo $industry?>" id="companyIndustry" class="form-control" placeholder="" style='width:45%;'/> </div> </div><div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label">Specialities:</label> <input type="text" name="company[specialties]" value="<?php echo $specialties?>" id="companySpecialties" class="form-control" placeholder="" style='width:45%;'/> </div> </div><div class="col-xs-12"> <div class="form-group input-string-group"><textarea name="company[describing]" id="companyDescribing" class="form-control" placeholder="Describing the Company:" style='width:100%;height:120px !important;'><?php echo $describing?></textarea></div></div><div class="col-xs-12" id="company_similar_organization"> <div class="form-group input-string-group"> <label class="control-label">Similar Organizations:</label>	<?php if($companyID!=0): 
  			if($peopleAlsoViewed==""){
				if(count($similarOrganization)>0){
					  $s=1;
					foreach($similarOrganization as $organization){
				?>
					<span class='pull-left' style='margin-top:5px;margin-left:5px;'>
					<a href="javascript://" onclick='window.parent.openCompanyEdit(<?php echo $organization->id;?>)'><?php echo $organization->company_name;?></a>	
					<?php echo ($s<count($similarOrganization))?', ':'';?>
					</span>
				<?php
						$s++;
					}
				}
			} else {
				try{
					$similarOrganization = json_decode($peopleAlsoViewed);
					
					if(count($similarOrganization)>0){
						$viewOrg = array();
						foreach($similarOrganization as $org){
							$viewOrg[] = $org->name;
						}
			?>
						<span class='pull-left' style='margin-top:5px;margin-left:5px;width:80%;'><?php echo implode($viewOrg,", ")?></span>
			<?php
					}
				}catch(Exception $e){
					
				}
				
			}
		endif;
	?></div></div></div>
  </div>
	<div class='col-xs-12' id='company_users_show_table' style='margin-top:10px;padding:0px;width:97%;'>		
		<table class="table" style='width:100%;' id="table_list_user">
			<thead><tr><th>Name</th><th>Title</th><th>DirectTel</th><th>CompanyTel</th><th>MobileTel</th><th>Proximity</th><th>CC</th></tr></thead>
			<tbody>
				<?php 
					if(count($companyUsers)>0){
					foreach($companyUsers as $user){
				?>
				<tr data-id="<?php echo $user->id?>">
				<td style='padding:5px;'><a href='javascript://' onclick='editContact(<?php echo $user->id?>);'><?php echo $user->name?></a>&nbsp;&nbsp;<a href='javascript://' onclick='deleteContact(<?php echo $user->id?>);'><i class='fa fa-trash colorClass' title='Companies'></i></a></td>
				<td style='padding:5px;'><?php echo $user->job_title?></td>
				<td align='center' style='padding:5px;'><?php if(trim($user->telephone)!=''):?><a href='javascript://' onclick='window.parent.callFromLandline(encodeURIComponent("<?php echo $user->telephone?>"))'><i class='fa fa-phone' style='color:#1E88E5' title='DirectTel'></i></a><?php endif;?></td>
				<td align='center' style='padding:5px;'><?php if(trim($user->company_tel)!=''):?><a href='javascript://' onclick='window.parent.callFromLandline(encodeURIComponent("<?php echo $user->company_tel?>"))'><i class='fa fa-phone fa-phone-square' style='color:#1E88E5' title='CompanyTel'></i></a><?php endif;?></td>
				<td align='center' style='padding:5px;'><?php if(trim($user->phone)!=''):?><a href='javascript://' onclick='window.parent.callFromLandline(encodeURIComponent("<?php echo $user->phone?>"))'><i class='fa fa-phone fa-mobile' style='color:#1E88E5' title='MobileTel'></i></a><?php endif;?></td>
				<td style='padding:5px;'><?php echo $user->proximity?></td>
				<td style='padding:5px;'><?php echo $user->c_c?></td>
				</tr>
				<?php
					}
				}
				?>
			</tbody>
		</table>
	</div>
</div> 
</div> 
<div class="row hide" style='margin-top:10px;' id="clasify">
	<div class="col-sm-12">
		<div class="col-xs-5"><button type="button" class='action-menu' data-type='sector' data-action="expand-all" style='background:none !important;border:1px solid #efefef !important; font-size:17px;font-weight:bold;cursor:pointer;' >+</button></div>
		<div class="col-xs-7"><button type="button" class='action-menu' data-type='technology' data-action="expand-all" style='background:none !important;border:1px solid #efefef !important; font-size:17px;font-weight:bold;cursor:pointer;' >+</button></div>
	</div>
	<div class="col-xs-6" style='height:485px;overflow:auto'>
		<div class="dd" id="nestable"><?php echo buildCompanyMenu($companyID);?></div>
	</div>
	<div class="col-xs-6" style='height:485px;overflow:auto'>
		<div class="dd types" id="nestable1"><?php echo buildTechnologyMenu($companyID);?></div>
	</div>
	<div class="col-sm-12" id='loading' style='display:none;'>
		Loading......
	</div>
</div>
<input type="hidden" name="company[id]" id="companyId" class="form-control" value="<?php echo $companyID?>"/>
<style>
input[type=checkbox].css-checkbox, input[type=checkbox].css-checkbox-1, input[type=checkbox].css-checkbox-2, input[type=checkbox].css-checkbox-3 {
    position: absolute;
    overflow: hidden;
    clip: rect(0 0 0 0);
    height: 1px;
    width: 1px;
    margin: -1px;
    padding: 0;
    border: 0;
}
input[type=checkbox].css-checkbox:checked + div.listbox > span.css-label, input[type=checkbox].css-checkbox-1:checked + div.listbox > span.css-label1,input[type=checkbox].css-checkbox-2:checked + div.listbox > span.css-label2,input[type=checkbox].css-checkbox-3:checked + div.listbox > span.css-label3 {
    background-position: 0 -15px;
}
input[type=checkbox].css-checkbox  + div.listbox > span.css-label,input[type=checkbox].css-checkbox-1  + div.listbox > span.css-label1,input[type=checkbox].css-checkbox-2  + div.listbox > span.css-label2,input[type=checkbox].css-checkbox-3  + div.listbox > span.css-label3 {
    padding-left: 20px;
    height: 15px;
    display: inline-block;
    line-height: 15px;
    background-repeat: no-repeat;
    background-position: 0 0;
    font-size: 15px;
    vertical-align: middle;
    cursor: pointer;
}
input[type=checkbox].css-checkbox-1  + div.listbox > span.css-label1,input[type=checkbox].css-checkbox-3  + div.listbox > span.css-label3{
	font-size:13px;
}
.lite-gray-check {
    background-image: url(https://storage.googleapis.com/static.synpat.com/backyard/images/lite-gray-check.png);
}
.black-check {
    background-image: url(https://storage.googleapis.com/static.synpat.com/backyard/images/chrome-style.png);
}
.edit-btn{text-decoration:none;}
.sub-child .edit-btn{font-style:italic;color:red;}
.dataTables_wrapper.no-footer .dataTables_scrollBody{border-bottom:0px;}
.dataTables_wrapper.no-footer div.dataTables_scrollBody table{border-bottom:0px solid #d1c8c8;}
table.dataTable thead th, table.dataTable thead td{padding:5px 4px;font-size:13px;}
#table_list_user_info{display:none;}
.css-label1>a,.css-label3>a{color:#56b2fe;}
.dd-item > button[data-action="cancel"]:before{content:'';}
.dd-item >button[data-action="expand"],.dd-item >button[data-action="collapse"]{top:2px;}
.table > thead > tr > th{border-top:0px;border-left:0px;border-bottom:0px;}
.table > thead > tr > th:last-child,.table > tbody > tr > td:last-child{border-right:0px;}
.table > tbody > tr > td{border-top:0px;border-left:0px;}
</style>


<script>
__baseUrl = '<?php echo $Layout->baseUrl?>';
function deleteCompany(ID){
	jQuery.ajax({
		type:'POST',
		url:__baseUrl+'opportunity/deleteCompany',
		data:{delete_link:ID},
		cache:false,
		success:function(data){
			if(data>0){
				window.parent.deleteCompanyCheckInOtherPopup(ID);
				window.parent.closeSlideBarCompany();
			}					
		}
	});
}
function editContact(ID){
	if(typeof window.parent.editContact=="function"){
		window.parent.editContact(ID);
	} else {
		window.parent.parent.editContact(ID);
	}
}	
function deleteContact(ID){
	if(typeof window.parent.deleteGoogleContactModal=="function"){
		window.parent.deleteGoogleContactModal(ID);
	} else {
		window.parent.parent.deleteGoogleContactModal(ID);
	}
}
function resetParent(ID){
	jQuery("#companyParent").val(0);
	jQuery(".show_name").empty();
	jQuery("#buttonADDCCompany").trigger('click');
}
function openClasify(){
	if(jQuery("#clasify").hasClass('hide')){
		jQuery("#clasify").removeClass('hide').addClass('show');
	} else {
		jQuery("#clasify").removeClass('show').addClass('hide');
	}
	widthChange();
}
function linkedInSearch(){
	_companyName = jQuery("#companyJobTitle").val();
	urlString = "";
	if(_companyName!=""){
		urlString = "https://www.linkedin.com/vsearch/p?company="+_companyName+"&openAdvancedForm=true&companyScope=C&locationType=Y&orig=ADVS&sa=D&sntz=1";
		window.open(urlString,'_blank');
	} else {
		alert("Company name is blank");
	}	
}

function widthChange(){
	jQuery('.input-string-group').each(function(){
		var $this = jQuery(this);
		var _w = $this.outerWidth();
		if($this.find('.control-label').length>0){
			lbl = $this.find('.control-label').outerWidth();
			if($this.find('input[type="text"]').length>0){
				inputW = _w - lbl-20;
				$this.find('input[type="text"]').css('width',inputW+'px');
			} else if($this.find('span.show_name').length>0){
				inputW = _w - lbl-35;
				$this.find('span.show_name').css('width',inputW+'px');
			} else if($this.find('input[type="checkbox"]').length>0){
				$this.find('input[type="checkbox"]').css('width', '10px');
			}
		}
	})
}
jQuery(window).resize(function(){
	console.log("Resize");
	widthChange()
})
var _dataTable="",newHeight="";
	jQuery(document).ready(function() {
		newHeight = (jQuery(window).height() - 120);
		widthChange();
		checkBoxClickEvent();
		jQuery("#companyParentSearch").autocomplete({
		minLength: 2,
		source: function (request, response) {
			jQuery.ajax({
				url: __baseUrl+'opportunity/search_company_by_name',
				dataType: "json",
				data: { query: request.term },
				success: function (data) {
					response($.map(data, function (item) {
						return {
							label: item.Name,
							value: item.Name,
							realValue: item.UID,
							sectorId: item.SectorID,
							sectorName: item.SectorName,
						};
					}));
				},
			});
		},
		select: function (event, ui) {
			jQuery("#companyParent").val(ui.item.realValue);
			jQuery(".show_name").html('<strong><a href="javascript://" onclick="window.parent.openCompanyEdit('+ui.item.realValue+');" >'+ui.item.label+'</a></strong>');widthChange();
			/*findContactsForThisCompany(ui.item.realValue);*/
		}
	});
	setTimeout(function(){jQuery('.ui-autocomplete').css('height',newHeight+'px');},200);
		jQuery("#companyLinkedinUrl").on('click',function(){
			_linkedin = jQuery(this).val();
			if(_linkedin.indexOf('linkedin')>=0){
				window.open(_linkedin,"_blank");
			}
		});
		jQuery("#companyWebAddress").on('click',function(){
			if(jQuery(this).val()!=""){
				window.open(jQuery(this).val(),"_blank");
			}
		});
		/**/
	jQuery('.action-menu').on('click', function(e){
		var target = $(e.target),action = target.data('action'),type=target.data('type');
		_string = "";
		if(type=="sector"){
			_string = "nestable";
		} else {
			_string = "nestable1";
		}
		if (action === 'expand-all') {			
			jQuery('.dd').nestable('expandAll');
			jQuery(this).html('-').data('action','collapse-all');
		}
		if (action === 'collapse-all') {
			jQuery('.dd').nestable('collapseAll');
			jQuery(this).html('+').data('action','expand-all');
		}
	});
	callDataTable();
	jQuery("#ccompanyFormSubmit").submit(function(e){
		e.preventDefault();
		if(jQuery('input[name="company[sector][]"]:checked').length>0){
			saveCompany(false,true);
		} else {
			alert("Please select sector.");
		}
	})
	
} );
function openAddContact(){
	window.parent.openContactBoxForSelectedCompany(jQuery("#companyId").val(),jQuery("#companyJobTitle").val());
}
function callDataTable(){
	_dataTable = jQuery('#table_list_user').DataTable( {
        fixedHeader: true,
		searching:false,
		paging:false,
		deferRender:    true,
        scrollY:        500,
        scrollCollapse: true,
		scroller:       true,
		"oLanguage": {
			"sEmptyTable": "No record found!"
		}
    } );
}

_companyID = '<?php echo $companyID?>';
function checkBoxClickEvent(){
	jQuery('span.css-label').off('click').on('click',function(){
		_chk = jQuery(this).parent().parent().find('.css-checkbox');
		if(typeof _chk=="object"){
			jQuery(this).addClass('black-check').removeClass('lite-gray-check');
			if(_chk.is(':checked')==false){
				_chk.prop("checked",true);
			} else {
				_chk.prop("checked",false);
			}
			checkMeWithOther(_chk);
		}
	});
	jQuery('span.css-label2').off('click').on('click',function(){
		_chk = jQuery(this).parent().parent().find('.css-checkbox-2');
		if(typeof _chk=="object"){
			jQuery(this).addClass('black-check').removeClass('lite-gray-check');
			if(_chk.is(':checked')==false){
				_chk.prop("checked",true);
			} else {
				_chk.prop("checked",false);
			}
			checkMeWithOther(_chk,1);
		}
	});
	jQuery('span.css-label1').off('click').on('click',function(){
		_chk = "";
		_chk = jQuery(this).parent().parent().find('.css-checkbox-1');
		if(typeof _chk=="object"){
			jQuery(this).addClass('black-check').removeClass('lite-gray-check');
			if(_chk.is(':checked')==false){
				_chk.prop("checked",true);
			} else {
				_chk.prop("checked",false);
			}
			checkedMyChild(_chk);
		}
	});
	jQuery('span.css-label3').off('click').on('click',function(){
		_chk = "";
		_chk = jQuery(this).parent().parent().find('.css-checkbox-3');
		if(typeof _chk=="object"){
			jQuery(this).addClass('black-check').removeClass('lite-gray-check');
			if(_chk.is(':checked')==false){
				_chk.prop("checked",true);
			} else {
				_chk.prop("checked",false);
			}
			checkedMyChild(_chk,1);
		}
	});
}
__options = { 
		collapse:true,
		maxDepth:3,
		group: 1,
		dropCallback: function(details) {		   
		    var order = new Array();
		    jQuery("li[data-id='"+details.destId +"']").find('ol:first').children().each(function(index,elem) {
			 order[index] = jQuery(elem).attr('data-id');
		    });
			var rootOrder = new Array();
		    if (order.length === 0){
				var rootOrder = new Array();
				jQuery("#nestable > ol > li").each(function(index,elem) {
				  rootOrder[index] = jQuery(elem).attr('data-id');
				});
		    }
			
		    _sourceAdd = jQuery("li[data-id='"+details.sourceId +"']").data('type');
		    if(jQuery("li[data-id='"+details.destId +"']").find('ol:first').find('li').length==0 || jQuery("li[data-id='"+details.destId +"']").find('ol:first').find('li').length==1){			    
				
				_destAdd = jQuery("li[data-id='"+details.destId +"']").data('type');
				
			    if(typeof _destAdd!="undefined"){
					if(_destAdd=="category"){
						_destAdd ="subcategory"
					}
			 		jQuery("li[data-id='"+details.destId +"']").find('ol:first').data('t',_destAdd);
			    }
		    } else {
				
				_destAdd = jQuery("li[data-id='"+details.destId +"']").find('ol:first').data('t');
			}	
			
		    if(details.destId!=null && _destAdd=="sector"){
				_destAdd = "category";
			}
			if(typeof _destAdd=="undefined" && details.destId==null){
				
			   _destAdd = "sector";
		    } else {
				
				_destAdd = "category";
			}
			
			sp = { source : details.sourceId, 
			  destination: details.destId, 
			  order:JSON.stringify(order),
			  rootOrder:JSON.stringify(rootOrder) ,
			  sourceType:_sourceAdd,
			  destType:_destAdd
			};
			
		    jQuery.post(__baseUrl+'opportunity/update_sector_category_subcategory', sp	, function(data) {
			  //console.log('data '+data); 
				if(_sourceAdd=="sector"){
					
				}
			})
		    .done(function() { 
				console.log('updated...');
				updateCategorySectorArea();
		    })
		    .fail(function() {  })
		    .always(function() {  });
		}
	};
__options1 = { 
		collapse:true,
		maxDepth:3,
		group: 1,
		dropCallback: function(details) {		   
		    var order = new Array();
		    jQuery("#nestable1 li[data-id='"+details.destId +"']").find('ol:first').children().each(function(index,elem) {
			 order[index] = jQuery(elem).attr('data-id');
		    });
			var rootOrder = new Array();
		    if (order.length === 0){
				var rootOrder = new Array();
				jQuery("#nestable1 > ol > li").each(function(index,elem) {
				  rootOrder[index] = jQuery(elem).attr('data-id');
				});
		    }
		    _sourceAdd = jQuery("#nestable1 li[data-id='"+details.sourceId +"']").data('type');
		    if(jQuery("#nestable1 li[data-id='"+details.destId +"']").find('ol:first').find('li').length==0 || jQuery("#nestable1 li[data-id='"+details.destId +"']").find('ol:first').find('li').length==1){			    
				_destAdd = jQuery("#nestable1 li[data-id='"+details.destId +"']").data('type');
			    if(typeof _destAdd!="undefined"){
					if(_destAdd=="sub-technology"){
						_destAdd ="subsub-technology";
					}
			 		jQuery("#nestable1 li[data-id='"+details.destId +"']").find('ol:first').data('t',_destAdd);
			    }
		    } else {
				_destAdd = jQuery("#nestable1 li[data-id='"+details.destId +"']").find('ol:first').data('t');
			}		
		    if(typeof _destAdd=="undefined"){
			   _destAdd = "technology";
		    }
			sp = { source : details.sourceId, 
			  destination: details.destId, 
			  order:JSON.stringify(order),
			  rootOrder:JSON.stringify(rootOrder) ,
			  sourceType:_sourceAdd,
			  destType:_destAdd
			};
			
		    jQuery.post(__baseUrl+'opportunity/update_sector_category_subcategory', sp	, function(data) {
			  //console.log('data '+data); 
				if(_sourceAdd=="sector"){
					
				}
			})
		    .done(function() { 
				console.log('updated...');
				updateCategorySectorArea();
		    })
		    .fail(function() {  })
		    .always(function() {  });
		}
	};
function callNestable(){
	jQuery('#nestable').nestable(__options);		
	jQuery('#nestable1').nestable(__options1);	
	jQuery(".dd-nodrag").on("mousedown", function(event) { // mousedown prevent nestable click
		event.preventDefault();
		return false;
	});
}
function addFromTop(ID,o){
	if(jQuery('#'+ID).is(':visible')){
		jQuery('#'+ID).find('.span-show').show();
		jQuery('#'+ID).hide();
		jQuery('#'+ID).find('.span-edit').hide();
		jQuery('#'+ID).find('.span-wait').hide();
		_object = o.parent().parent();
		_object.find('button[data-action="expand"]').eq(0).show();
		_object.find('button[data-action="collapse"]').eq(0).hide();
		_object.addClass('dd-collapsed');
		_object.find('ol.dd-list').eq(0).hide();
	} else {
		console.log('#'+ID);
		jQuery('#'+ID).show();
		jQuery('#'+ID).find('.span-show').hide();
		jQuery('#'+ID).find('.span-edit').show();
		jQuery('#'+ID).find('.span-wait').hide();
		_object = o.parent().parent();
		_object.find('button[data-action="expand"]').eq(0).hide();
		_object.find('button[data-action="collapse"]').eq(0).show();
		_object.removeClass('dd-collapsed');
		_object.find('ol.dd-list').eq(0).show();
	}
}
function addMe(o){
	o.parent().find('.span-show').hide();
	o.parent().find('.span-edit').show();
	o.parent().parent().find('.span-wait').hide();
} 
function cancelMe(o,s){
	console.log('cancel me1');
	o.parent().parent().find('input[type="text"]').val("");
	o.parent().parent().find('textarea').val("");
	o.parents('.nested-list-content').css('min-height','');
	o.parent().parent().find('.span-edit').hide();
	o.parent().parent().find('.span-show').show();
	o.parent().parent().find('.span-wait').hide();
	_id = o.parent().parent().parent().attr('id');
	console.log(_id);
	if(_id!="ChildT" && _id!="Child"){
		o.parent().parent().parent().hide();	
	}	
}
function addSaveMe(o){ 
	console.log(o.parent().html());
	o.parent().find('.span-wait').show();
	_t = o.parents('li').data('t');
	_p = 0;
	if(_t!="sector"){
		_p = o.parents('li').data('p');
	}	
	_n = o.parent().find('input[type="text"]').val();
	if(_n!=""){
		sp = {t:_t,p:_p,n:_n};
		jQuery.ajax({
			type:'POST',
			url:__baseUrl+'opportunity/add_sector_category_subcategory',
			data:sp,
			dataType:'json',
			success:function(d){
				o.parent().find('.span-wait').hide();
				if(typeof d.id!="undefined"){
					switch(o.parents('ol').data('t')){
						case 'technology':
							_li='<li class="dd-item nested-list-item dd-collapsed" data-order="0" data-id="'+d.id+'" data-type="technology"><button data-action="collapse" type="button" style="display: none;">Collapse</button><button data-action="expand" type="button" style="display: block;">Expand</button><div class="dd-handle nested-list-handle dd-nodrag"></div><div class="nested-list-content" style="padding-left:0px"><a href="javascript://" onclick="addFromTop(\'ulChildT'+d.id+'\',jQuery(this),1)"><i class="fa fa-long-arrow-down" style="font-size:8px;"></i></a><input type="checkbox" class="css-checkbox" name="preferences[technology][]" onchange="checkMeWithOther(jQuery(this),1)" value="'+d.id+'"><div class="listbox"><span class="show-span css-label black-check"><a class="edit-btn" href="javascript://" onclick="openForEdit(jQuery(this))">'+d.n+'</a></span><span class="edit-span" style="display:none"><input type="text" class="form-control" style="width:250px;display:inline;" value="'+d.n+'"><a href="javascript://" onclick="updateMe(jQuery(this));" style="margin-left:5px;">Save</a><a href="javascript://" onclick="closeMe(jQuery(this));" style="margin-left:5px;">Cancel</a><a class="btn-delete" style="margin-left:5px;" href="javascript://" onclick="deleteMe(jQuery(this))">Delete</a></span></div></div><ol class="dd-list" data-t="sub-technology" style="display: none;"><li data-t="sub-technology" id="ulChildT'+d.id+'" data-p="'+d.id+'" style="display:none" class="dd-item nested-list-item adding"><button data-action="cancel">&nbsp;</button><div class="dd-handle nested-list-handle dd-nodrag"></div><div class="nested-list-content"><span style="display:none" class="span-edit"><input type="text" maxlength="30" style="margin-left:15px;" placeholder="Type here..."><a style="margin-left:5px;" href="javascript://" onclick="addSaveMe(jQuery(this))">Save</a><a style="margin-left:5px" href="javascript://" onclick="cancelMe(jQuery(this))">Cancel</a><span class="span-wait" style="display:none;margin-left:5px">Please wait...</span></span></div></li></ol></li>';
							o.parents('#ChildT').before(_li);
							o.parents('ol').find('.span-edit').find('input').val('');
							o.parents('ol').find('.span-edit').hide();
							o.parents('ol').find('.span-show').show();
							o.parents('ol').find('.span-wait').hide();
							checkBoxClickEvent();
						break;
						case 'sub-technology':
							_dataP = d.p;
							_li='<li class="dd-item nested-list-item dd-collapsed" data-id="'+d.id+'" data-type="sub-technology"><button data-action="collapse" type="button" style="display: none;">Collapse</button><button data-action="expand" type="button" style="display: block;">Expand</button><div class="dd-handle nested-list-handle dd-nodrag"></div><div class="nested-list-content"><a href="javascript://" onclick="addFromTop(\'ulChildChildT'+d.id+'\',jQuery(this),1)"><i class="fa fa-long-arrow-down" style="font-size:8px;"></i></a><input class="parent css-checkbox-1" type="checkbox" name="preferences[subtechnology][]" onclick="checkedMyChild(jQuery(this),1)" value="'+d.id+'"><div class="listbox"><span class="show-span css-label1 black-check"><a class="edit-btn" href="javascript://" onclick="openForEdit(jQuery(this))">'+d.n+'</a></span><span class="edit-span" style="display:none"><input type="text" class="form-control" style="width:250px;display:inline;" value="'+d.n+'"><a href="javascript://" onclick="updateMe(jQuery(this));" style="margin-left:5px;">Update</a><a href="javascript://" onclick="closeMe(jQuery(this));" style="margin-left:5px;">Cancel</a><a class="btn-delete" style="margin-left:5px;" href="javascript://" onclick="deleteMe(jQuery(this))">Delete</a></span></div></div><ol class="dd-list sub-child" data-t="subsub-technology"><li id="ulChildChildT'+d.id+'" data-t="subsub-technology" data-p="'+d.id+'" class="dd-item nested-list-item adding" style="display:none"><button data-action="cancel">&nbsp;</button><div class="dd-handle nested-list-handle dd-nodrag"></div><div class="nested-list-content"><span style="display:none" class="span-edit"><input type="text" maxlength="30" style="margin-left:30px;" placeholder="Type here..."><a style="margin-left:5px;" href="javascript://" onclick="addSaveMe(jQuery(this))">Save</a><a style="margin-left:5px" href="javascript://" onclick="cancelMe(jQuery(this))">Cancel</a><span class="span-wait" style="display:none;margin-left:5px">Please wait...</span></span></div></li></ol></li>';
							o.parents('#ulChildT'+_dataP).before(_li);
							o.parents('ol').find('.span-edit').find('input').val('');
							o.parents('#ulChildT'+_dataP).hide();
							o.parents('ol').find('.span-edit').hide();
							o.parents('ol').find('.span-show').show();
							o.parents('ol').find('.span-wait').hide();
							checkBoxClickEvent();
						break;
						case 'subsub-technology':
							_dataP = d.p;
							_li='<li class="dd-item nested-list-item" data-id="'+d.id+'" data-type="subsub-technology"><button data-action="cancel">&nbsp;</button><div class="dd-handle nested-list-handle dd-nodrag"></div><div class="nested-list-content"><input class="child" type="checkbox" name="sub[technology][]" onclick="checkedMyParent(jQuery(this),1)" value="'+d.id+'"><div class="listbox"><span class="show-span"><a class="edit-btn" href="javascript://" onclick="openForEdit(jQuery(this))">'+d.n+'</a></span><span class="edit-span" style="display:none"><input type="text" class="form-control" style="width:250px;display:inline;" value="'+d.n+'"><a href="javascript://" onclick="updateMe(jQuery(this));" style="margin-left:5px;">Update</a><a href="javascript://" onclick="closeMe(jQuery(this));" style="margin-left:5px;">Cancel</a><a class="btn-delete" style="margin-left:5px;" href="javascript://" onclick="deleteMe(jQuery(this))">Delete</a></span></div></div></li>';
							o.parents('#ulChildChildT'+_dataP).before(_li);
							o.parents('ol').find('.span-edit').find('input').val('');
							o.parents('#ulChildChildT'+_dataP).hide();
							o.parents('ol').find('.span-edit').hide();
							o.parents('ol').find('.span-show').show();
							o.parents('ol').find('.span-wait').hide();
						break;
						case 'sector':
							_li='<li class="dd-item nested-list-item dd-collapsed" data-order="0" data-id="'+d.id+'" data-type="sector"><button data-action="collapse" type="button" style="display: none;">Collapse</button><button data-action="expand" type="button" style="display: block;">Expand</button><div class="dd-handle nested-list-handle dd-nodrag"></div><div class="nested-list-content" style="padding-left:0px"><a href="javascript://" onclick="addFromTop(\'ulChild'+d.id+'\',jQuery(this))"><i class="fa fa-long-arrow-down" style="font-size:8px;"></i></a><input type="checkbox" class="css-checkbox" name="company[sector][]" onchange="checkMeWithOther(jQuery(this))" value="'+d.id+'"><div class="listbox"><span class="show-span css-label black-check"><a class="edit-btn" href="javascript://" onclick="openForEdit(jQuery(this))">'+d.n+'</a></span><span class="edit-span" style="display:none"><input type="text" class="form-control" style="width:250px;display:inline;" value="'+d.n+'"><a href="javascript://" onclick="updateMe(jQuery(this));" style="margin-left:5px;"><i class="fa fa-check"></i></a><a href="javascript://" onclick="closeMe(jQuery(this));" style="margin-left:5px;"><i class="fa fa-times"></i></a><a class="btn-delete" style="margin-left:5px;" href="javascript://" onclick="deleteMe(jQuery(this))"><i class="fa fa-trash"></i></a></span></div></div><ol class="dd-list" data-t="category"><li data-t="category" id="ulChild'+d.id+'" data-p="'+d.id+'" class="dd-item nested-list-item adding" style="display: none;"><button data-action="cancel">&nbsp;</button><div class="dd-handle nested-list-handle dd-nodrag"></div><div class="nested-list-content"><span style="display:none" class="span-edit"><input type="text" maxlength="30" style="margin-left:15px;" placeholder="Type here..."><a style="margin-left:5px;" href="javascript://" onclick="addSaveMe(jQuery(this))"><i class="fa fa-check"></i></a><a style="margin-left:5px" href="javascript://" onclick="cancelMe(jQuery(this))"><i class="fa fa-times"></i></a><span class="span-wait" style="display:none;margin-left:5px">Please wait...</span></span></div></li></ol></li>';
							o.parents('#Child').before(_li);
							o.parents('ol').find('.span-edit').find('input').val('');
							o.parents('ol').find('.span-edit').hide();
							o.parents('ol').find('.span-show').show();
							o.parents('ol').find('.span-wait').hide();
							checkBoxClickEvent();
						break;
						case 'category':
							console.log('Case 1');
							_dataP = d.p;
							_li='<li class="dd-item nested-list-item dd-collapsed" data-id="'+d.id+'" data-type="category"><button data-action="collapse" type="button" style="display: none;">Collapse</button><button data-action="expand" type="button" style="display: block;">Expand</button><div class="dd-handle nested-list-handle dd-nodrag"></div><div class="nested-list-content"><a href="javascript://" onclick="addFromTop(\'ulChildChild'+d.id+'\',jQuery(this),1)"><i class="fa fa-long-arrow-down" style="font-size:8px;"></i></a><input class="parent css-checkbox-1" type="checkbox" name="preferences[departments][]" onclick="checkedMyChild(jQuery(this))" value="'+d.id+'"><div class="listbox"><span class="show-span css-label1 black-check"><a class="edit-btn" href="javascript://" onclick="openForEdit(jQuery(this))">'+d.n+'</a></span><span class="edit-span" style="display:none"><input type="text" class="form-control" style="width:250px;display:inline;" value="'+d.n+'"><a href="javascript://" onclick="updateMe(jQuery(this));" style="margin-left:5px;"><i class="fa fa-check"></i></a><a href="javascript://" onclick="closeMe(jQuery(this));" style="margin-left:5px;"><i class="fa fa-times"></i></a><a class="btn-delete" style="margin-left:5px;" href="javascript://" onclick="deleteMe(jQuery(this))"><i class="fa fa-trash"></i></a></span></div></div><ol class="dd-list sub-child" data-t="subcategory" ><li id="ulChildChild'+d.id+'" data-t="sub-category" data-p="'+d.id+'" class="dd-item nested-list-item adding" style="display: none;"><button data-action="cancel">&nbsp;</button><div class="dd-handle nested-list-handle dd-nodrag"></div><div class="nested-list-content"><span style="display:none" class="span-edit"><input type="text" maxlength="30" style="margin-left:30px;" placeholder="Type here..."><a style="margin-left:5px;" href="javascript://" onclick="addSaveMe(jQuery(this))"><i class="fa fa-check"></i></a><a style="margin-left:5px" href="javascript://" onclick="cancelMe(jQuery(this))"><i class="fa fa-times"></i></a><span class="span-wait" style="display:none;margin-left:5px">Please wait...</span></span></div></li></ol></li>';
							o.parents('#ulChild'+_dataP).before(_li);
							o.parents('ol').find('.span-edit').find('input').val('');
							o.parents('#ulChild'+_dataP).hide();
							o.parents('ol').find('.span-edit').hide();
							o.parents('ol').find('.span-show').show();
							o.parents('ol').find('.span-wait').hide();
							checkBoxClickEvent();
						break;
						case 'subcategory':
							_dataP = d.p;
							_li='<li class="dd-item nested-list-item" data-id="'+d.id+'" data-type="subcategory"><button data-action="cancel">&nbsp;</button><div class="dd-handle nested-list-handle dd-nodrag"></div><div class="nested-list-content"><input class="child" type="checkbox" name="sub[departments][]" onclick="checkedMyParent(jQuery(this))" value="'+d.id+'"><div class="listbox"><span class="show-span"><a class="edit-btn" href="javascript://" onclick="openForEdit(jQuery(this))">'+d.n+'</a></span><span class="edit-span" style="display:none"><input type="text" class="form-control" style="width:250px;display:inline;" value="'+d.n+'"><a href="javascript://" onclick="updateMe(jQuery(this));" style="margin-left:5px;"><i class="fa fa-check"></i></a><a href="javascript://" onclick="closeMe(jQuery(this));" style="margin-left:5px;"><i class="fa fa-times"></i></a><a class="btn-delete" style="margin-left:5px;" href="javascript://" onclick="deleteMe(jQuery(this))"><i class="fa fa-trash"></i></a></span></div></div></li>';
							o.parents('#ulChildChild'+_dataP).before(_li);
							o.parents('ol').find('.span-edit').find('input').val('');
							o.parents('#ulChildChild'+_dataP).hide();
							o.parents('ol').find('.span-edit').hide();
							o.parents('ol').find('.span-show').show();
							o.parents('ol').find('.span-wait').hide();
						break;
					}
				} else {
					alert('Please try again later.');
				}				
			}
		});
	} else {
		alert("Please fill the name.");
	}
}
function updateCategorySectorArea(){
	window.location = window.location.href;	
}
function openForEdit(o){
	$parent = o.parents('li');
	_id = $parent.data('id');
	if(!isNaN(_id)){
		o.parents('div.listbox').find('span.show-span').hide();
		o.parents('div.listbox').find('span.edit-span').show();
	} else {
		alert("Opps problem in showing editing box.");
	}	
}
function deleteMe(o){
	$parent = o.parents('li');
	_id = $parent.data('id');
	if(!isNaN(_id)){
		jQuery("#loading").show();
		fields = {
			t:$parent.data('type'),
			id:$parent.data('id')
		};
		jQuery.post(__baseUrl+'opportunity/delete_all_types', fields	, function(data) {
		  //console.log('data '+data); 
		})
	   .done(function(d) { 
		jQuery("#loading").hide();
		 if(parseInt(d)>0){
			/*window.location = window.location.href;*/
			updateCategorySectorArea();
		 }
	   });
	} else {
		alert("Open popup again....");
	}
}
function updateMe(o){
	$inputBox = o.parents('div.listbox').find('span.edit-span').find('input[type="text"]');
	if($inputBox.length>0){
		jQuery("#loading").show();
		$parent = o.parents('li');
		_inputVal = $inputBox.val();
		fields = {
			t:$parent.data('type'),
			id:$parent.data('id'),
			name:_inputVal
		};
		jQuery.post(__baseUrl+'opportunity/update_all_types', fields	, function(data) {
		  //console.log('data '+data); 
		})
	    .done(function(d) { 
		jQuery("#loading").hide();
		if(d>0){
			$inputBox.val(_inputVal);
			o.parents('div.listbox').find('span.show-span').find('a.edit-btn').html(_inputVal); 
		}
		o.parents('div.listbox').find('span.edit-span').hide();
		o.parents('div.listbox').find('span.show-span').show();
	   });
	}	
}
function closeMe(o){
	o.parents('div.listbox').find('span.edit-span').hide();
	o.parents('div.listbox').find('span.show-span').show();
}
function checkMeWithOther(o,s){
	var secChild = o.parents('li').find("ol li");
	secChild.find('.css-label2').removeClass('lite-gray-check');
	secChild.find('.css-label3').removeClass('lite-gray-check');
	secChild.find('input[type="checkbox"]').each(function(){
		if(o.is(':checked')==true){
			jQuery(this).prop("checked",true);
		} else {
			jQuery(this).prop("checked",false);
			
		}
	});	
}
function checkedMyParent(o,s){
	$LI = o.parent().parent().parent().parent();
	if($LI.length>0){
		if(typeof s=="undefined"){
			if(o.is(':checked')===false){
				_tap = false;				
				var selParent = o.parent().parent();
				if(selParent.siblings().length>0){
					selParent.siblings().each(function(cc){
						if(jQuery(this).find('input[type="checkbox"]:checked').length>0){
							_tap = true;
							return false;
						}
					})
				}
				$LI.find('input.parent').prop('checked',_tap);
				$LI.parent().parent().find('input.css-checkbox').prop('checked',_tap);
				if(_tap===false){
					$LI.find('span.css-label1').addClass('black-check').removeClass('lite-gray-check');
					$LI.parent().parent().find('span.css-label').addClass('black-check').removeClass('lite-gray-check');
				} 
				/*$LI.parent().parent().find('span.css-label1')*/
			} else{
				$LI.find('input.parent').prop('checked',true);
				$LI.find('span.css-label1').removeClass('black-check').addClass('lite-gray-check');
				$LI.parent().parent().find('input.css-checkbox').prop('checked',true);
				$LI.parent().parent().find('span.css-label').removeClass('black-check').addClass('lite-gray-check');
				/*$LI.parent().parent().find('span.css-label1')*/
			}
		} else {
			if(o.is(':checked')===false){
				_tap = false;		
				var selParent = o.parent().parent();
				if(selParent.siblings().length>0){
					selParent.siblings().each(function(cc){
						if(jQuery(this).find('input[type="checkbox"]:checked').length>0){
							_tap = true;
							return false;
						}
					})
				}
				$LI.find('input.parent').prop('checked',_tap);
				$LI.parent().parent().find('input.css-checkbox-2').prop('checked',_tap);
				if(_tap===false){
					$LI.find('span.css-label3').addClass('black-check').removeClass('lite-gray-check');
					$LI.parent().parent().find('span.css-label2').addClass('black-check').removeClass('lite-gray-check');
				}
				/*$LI.parent().parent().find('span.css-label3')*/
			} else{
				console.log('TRUE');
				$LI.find('input.parent').prop('checked',true);
				$LI.find('span.css-label3').removeClass('black-check').addClass('lite-gray-check');
				$LI.parent().parent().find('input.css-checkbox-2').prop('checked',true);
				$LI.parent().parent().find('span.css-label2').removeClass('black-check').addClass('lite-gray-check');
				/*$LI.parent().parent().find('span.css-label3')*/
			}
		}
		
	}
}
function checkedMyChild(o,s){
	_nextChild = o.parent().next('.dd-list');
	if(_nextChild.length>0){
		_nextChild.find('li').each(function(i){
			if(o.is(':checked')){
				jQuery(this).find('input[type="checkbox"]').prop('checked',true);
			} else {
				jQuery(this).find('input[type="checkbox"]').prop('checked',false);
			}
			
		});
	}
	_string = 'input[name="company[sector][]"]';
	if(typeof s!="undefined"){
		_string = 'input[name="preferences[technology][]"]';
	}
	if(o.is(':checked')===true){
		if(typeof s=="undefined"){
			o.parent().parent().parent().parent().find(_string).next().find('span.css-label').removeClass('black-check').addClass('lite-gray-check');
		} else {
			o.parent().parent().parent().parent().find(_string).next().find('span.css-label2').removeClass('black-check').addClass('lite-gray-check');
		}
		o.parent().parent().parent().parent().find(_string).prop('checked',true);		
	} else {
		_df = false;		
		o.parent().parent().parent().parent().find('input.parent').each(function(){
			if(jQuery(this).is(':checked')){
				_df = true;
			}
		});
		if(_df===true){
			o.parent().parent().parent().parent().find(_string).prop('checked',true);
			if(typeof s=="undefined"){
			o.parent().parent().parent().parent().find(_string).next().find('span.css-label').removeClass('black-check').addClass('lite-gray-check');
			} else {
				o.parent().parent().parent().parent().find(_string).next().find('span.css-label2').removeClass('black-check').addClass('lite-gray-check');
			}
		} else {
			o.parent().parent().parent().parent().find(_string).prop('checked',false);
			if(typeof s=="undefined"){
			o.parent().parent().parent().parent().find(_string).next().find('span.css-label').addClass('black-check').removeClass('lite-gray-check');
			} else {
				o.parent().parent().parent().parent().find(_string).next().find('span.css-label2').addClass('black-check').removeClass('lite-gray-check');
			}
		}
	}
}
callNestable();
function saveCompany(scrape,push){
	jQuery("#loading_message").html("Please wait...");
	jQuery.ajax({
		type:'POST',
		url:jQuery("#ccompanyFormSubmit").attr("action"),
		data:jQuery("#ccompanyFormSubmit").serializeArray(),
		dataType:'json',
		success:function(d){
			if(typeof d.success!="undefined" && d.success>0){
				jQuery("#companyId").val(d.success);
				/*alert("Record updated");*/
				jQuery("#loading_message").html("Record updated");
				setTimeout(function(){jQuery("#loading_message").html("");},2000);
				/*Close Slider*/
				/*window.parent.closeSlideBarCompany();*/
				/*Synchronise*/
				if(push===true){
					window.parent.pushingCompany(jQuery("#companyId").val());
				}
				if(scrape===true){
					scrapeCompany();
				}
				/*End Synchronise*/
			}else  {
				if(typeof d.error_message!="undefined" && d.error_message!=""){
					alert(d.error_message);
				} else {
					alert("Please try after sometime.");
				}
			}
		}
	});
}

function checkListForC(){
	if(window.parent.companyQuList.length>0){
		_found = false;
		for(i=0;i<window.parent.companyQuList.length;i++){
			if(window.parent.companyQuList[i].company==jQuery("#companyId").val()){
				_found = true;
				return '';
			}
		}
		if(_found===false){
			var scrapCompany = {company:jQuery("#companyId").val(),url:jQuery("#companyLinkedinUrl").val(),type:33};
			checkQueList(scrapCompany);
			if(window.parent.scraperCompanyRequest==null || (typeof window.parent.scraperCompanyRequest.readyState!=undefined && window.parent.scraperCompanyRequest.readyState==4)){
				window.parent.sendScrapperCompanyRequest(33);
			}
		} else {
			setTimeout(checkListForC,500);
		}
	} else {
		scrapeCompany();
	}
}

function scrapeCompany(){
	if(jQuery("#companyLinkedinUrl").val()!=""){
		linkedINUrl = jQuery("#companyLinkedinUrl").val();
		if(linkedINUrl.indexOf('linkedin.com')>=0){
			if(jQuery("#companyId").val()>0){
				var scrapCompany = {company:jQuery("#companyId").val(),url:encodeURIComponent(jQuery("#companyLinkedinUrl").val()),type:33};
				checkQueList(scrapCompany);
				if(window.parent.scraperCompanyRequest==null || (typeof window.parent.scraperCompanyRequest.readyState!=undefined && window.parent.scraperCompanyRequest.readyState==4)){
					window.parent.sendScrapperCompanyRequest(33);
				} else {
					setTimeout(checkListForC,500);
				}
			} else {
				/*save company first then run scrapper */
				jQuery.ajax({
					type:'POST',
					url:__baseUrl+'opportunity/check_company_linkedin_url',
					data:{linkedin_url:linkedINUrl},
					dataType:'json',
					success:function(d){
						if(typeof d.id!="undefined" && d.id>0){
							url =  __baseUrl+'opportunity/add_company/'+d.id;
							window.location = url;
							window.parent.checkCompanyProfileLoadRunScrape(d.id);
							/*Similar Organizations */
						} else {
							/*save company */
							saveCompany(true,false);							
						}
					}
				});
			}
		}
	}
}
function checkQueList(scrapCompany){
	if(window.parent.companyQuList.length==0){
		window.parent.companyQuList.push(scrapCompany);
	}else {
		_entry = true;
		jQuery.each(window.parent.companyQuList,function(i,c){
			if(c.company==scrapCompany.company){
				_entry = false;
				return false;
			}
		});
		if(_entry===true){
			window.parent.companyQuList.push(scrapCompany);
		}
	}	
}
</script>
<?php echo form_close();?>