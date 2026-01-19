<!--<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/typography.css">-->
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/grid.css">
<!--<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>themes/components/default.css">-->
<!--<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/buttons.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/forms.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/tables.css">
-->
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-core.js"></script>
<!--<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-widget.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-mouse.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-position.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/slimscroll/slimscroll.js"></script>-->
<!--<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">-->
<link  rel="stylesheet" media="screen" href="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/handsontable.min.css">
<link  rel="stylesheet" media="screen" href="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/pikaday/pikaday.css">
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/moment/moment.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/pikaday/pikaday.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/zeroclipboard/ZeroClipboard.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/handsontable.min.js"></script>
<!--<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>widgets/dropdowncheck/css/ui.dropdownchecklist.standalone.css">
<script src="<?php echo $Layout->aws_server_cdn;?>widgets/dropdowncheck/js/ui.dropdownchecklist-1.4-min.js"></script>
-->
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
		<div class='col-lg-5' id="chart">
			

		</div>
		<div class='col-lg-7'>
			<div class="scroll-container col-lg-12 cp-border">
				<div id='datatable-task-log' class="hot handsontable htRowHeaders htColumnHeaders" style='width:500px;'></div>
			</div>
					
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
						$getData = getUserCompanyByEmail($allEmails[0]);
						if(count($getData)>0){
							$companyID = $getData->company_id;
							$companyName = $getData->company_name;
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
					}
					$checkBox = 'hide';
					$checked=false;
					if($eou_data[$i]->permmission==1):$checked=true; endif;
					if((int)$eou_data[$i]->project_type==9 || (int)$eou_data[$i]->project_type==13):
					$checkBox = 'show';
					endif;
					$projectName = $eou_data[$i]->lead_name;
					   echo '{"id":"' .$eou_data[$i]->id. '","lead_id":"' .$eou_data[$i]->lead_id. '","project_type":"'.$eou_data[$i]->project_type.'","company_name":"'.$companyName.'","companyID":"'.$companyID.'","project_name":"' .strtolower($projectName). '","type":"' .$type. '","create_date":"' .date('M d,y',strtotime($eou_data[$i]->create_date)). '","email":"' .$allEmails[0]. '","get_html_data":"' .$htmlGetData. '","permission_check":"' .$checkBox. '","duration":"' .$eou_data[$i]->duration. '","total_patent":"' .$eou_data[$i]->total_patent. '","checked":"' .$checked. '","access_code":"' .$eou_data[$i]->access_code. '","password":"' .$eou_data[$i]->password. '"}';
					   if ($i < count($eou_data) - 1) {
						echo ",";
					  }
					}
					?>				
				];
				var filterOption = "<?php echo $filter_option?>";
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
					  colHeaders:['Date','Project','Type','Company','# Patents','Time Spent','P.','Expert','Access Code','Password'],
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
	h = jQuery(window).height() - 130;
	jQuery("#chart").html('<iframe src="<?php echo $Layout->baseUrl?>customers/get_outsource_chart_by_project/'+leadID+'/'+type+'/'+company+'" style="width:100%;height:'+h+'px"></iframe>');
	o.css('color','red');
}
function getChartAllProjectForThisCompany(leadID,company,o){
	jQuery("#chart").html('');
	jQuery("#datatable-task-log").find('a').css('color','#56b2fe');
	h = jQuery(window).height() - 130;
	jQuery("#chart").html('<iframe src="<?php echo $Layout->baseUrl?>customers/get_outsource_chart_by_company/'+leadID+'/'+company+'" style="width:100%;height:'+h+'px"></iframe>');
	o.css('color','red');
}</script>
		</div>
	</div>
</div>