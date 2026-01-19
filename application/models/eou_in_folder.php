<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/grid.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/buttons.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/tables.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<script src="<?php echo $Layout->baseUrl?>public/dragscroll.js" ></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-core.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/moment/moment.js"></script>
<style>
	body {
		overflow: auto !important;
		min-width: 0;
		font-family:arial;font-size:13px;
	}
	#page-content {
	    background: #ffffff !important;
	}
	iframe{border:0px;}
	a{text-decoration:none;}h4{font-size:16px;font-weight:300;margin:0}
	
	.mrg5R{margin-right:5px;}
	.scroll-container {
	width: 100%;
	height: 250px;
	margin: 5px 0;
	overflow: hidden;
}
.ui-menu-item{list-style:none;padding:10px;border:1px solid #56b2fe;margin-bottom:3px;}
	.ui-menu-item:hover{background-color:#56b2fe;color:#fff;}	
	.ui-helper-hidden-accessible{display:none;}
	.ui-autocomplete {
	padding:0px;margin:0px;
    max-height: 400px;
    overflow-y: auto;
    overflow-x: hidden;background:#fff;width:300px !important;
  }
.containerResearchHeader, .containerHeader{width:100%;overflow:hidden;}
.containerResearchBody, .containerBody{width:100%;height:250px;overflow:scroll;}
.dt{
    font-size: 13px;
    width: 100%;
    border-spacing: 0;
    border-collapse: separate;
}
table.fixedHeader, table.tableData{border:0px;}
table.fixedHeader th{border:0px !important;border-right:solid 1px #d1c8c8 !important}
table.tableData td{border:1px solid #d1c8c8;border-top:0px !important;border-right:0px !important;height:30px;min-height:30px;}
table.tableData tr.master td:last-child{border-right:solid 1px #d1c8c8 !important;}
.button-list{border:1px solid #d1c8c8;padding:0px 0px 0px 0px;cursor:pointer;float:right;}
table.tableData tr:first-child td{border-top:solid 0px #d1c8c8 !important}
.p-relative {
    position: relative;
}
.sort{
	width: 16px;
    height: 16px;
    top: -2px;
    cursor: pointer;
    background-repeat: no-repeat;
}
.icon-default {background: url(<?php echo $Layout->baseUrl?>public/images/sort_both.png);}
.icon-asc{background: url(<?php echo $Layout->baseUrl?>public/images/sort_asc.png);}
.icon-desc{background: url(<?php echo $Layout->baseUrl?>public/images/sort_desc.png);}

.p-absolute {
    position: absolute;
}
.table{border:1px #d1c8c8 !important;}
.mrg20L {margin-left:15px !important;}
.table > thead > tr > th {
    font-weight: normal;
    font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
	border-bottom: solid 1px #d1c8c8 !important;
	border-top: solid 1px #d1c8c8 !important;
}
.containerResearchHeader .table > thead > tr > th:first-child{
	border-left: solid 1px #d1c8c8 !important;
}
.containerResearchHeader .table > thead > tr > th:last-child{
	border-right: solid 1px #d1c8c8 !important;
}
.handsontable th {
    background: #fff;
    font-weight: normal;
}
.open_list{list-style:none;padding:0px;}
 .containerResearchBody ::-webkit-scrollbar{-webkit-appearance: none;width: 10px;}
 .containerResearchBody ::-webkit-scrollbar:vertical{width: 18px;}
 .containerResearchBody ::-webkit-scrollbar-thumb{border-radius: 1px;background-color: rgba(0,0,0,.3);box-shadow: 0 0 1px rgba(255,255,255,.3);}
 .filter{margin-left:0px;}
 .filter-sort, .sortIcon{margin-left:21px;}
 th.open{background:green;color:#fff !important;}
 th ul{list-style:none;padding:0px;}
 th ul li,th.open ul.open_list li,th.open ui.open_list li span{color:#222222 !important}
 table.sbo,table.sbo thead th,table.sbo tbody td, table.sbo tbody td:last-child{border:0px !important;}
 i.fa{width:13px;height:13px;}
 tr.cu td{padding:0px !important;}
 tr.cu table.sbo thead th, tr.cu table.sbo tbody td{/*border-bottom:1px solid #d1c8c8  !important;border-right:1px solid #d1c8c8 !important;*/}
 tr.cu table.sbo thead th, tr.cu table.sbo tbody td{padding:4px !important;}
 tr.cu table.sbo thead th{cursor:pointer;}
 tr.cu table.sbo thead th:last-child, tr.cu table.sbo tbody td:last-child{border-right:0px !important;}
 tr.cu table.sbo thead th.headerSortDown{background: url('<?php echo $Layout->baseUrl?>public/images/sort_desc.png');    background-repeat: no-repeat;background-position: right;background-color: #fff;}
tr.cu table.sbo thead th.headerSortUp{background: url('<?php echo $Layout->baseUrl?>public/images/sort_asc.png');    background-repeat: no-repeat;background-position: right;background-color: #fff;}tr.boldT td{font-weight:bold;}
.fa{margin-left:5px;}
.hide{display:none;}
</style>
<div class="row" style='width:100%;'>	
	<div class="col-xs-12" style='width:100%;'>
		<div class='col-lg-5' id="chart"></div>
		<div class='col-lg-7'>
			<div class="scroll-container col-lg-12 cp-border dragscroll">
				<div id='datatable-task-log' class="hot handsontable htRowHeaders htColumnHeaders" style='width:100%;'></div>
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
var hot1,isChecked;
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
var minTable = document.getElementById("datatable-task-log");
/*availableWidth = availableWidth-20;*/
function getManualColumnsWidth(availableWidth){
	availableWidth = availableWidth;
	CalWidth = availableWidth-20;
	colFirst = parseInt(CalWidth * 9/100);
	colFirst1 = parseInt(CalWidth * 20/100);
	colSecond = parseInt(CalWidth * 12/100);
	colThird = parseInt(CalWidth * 20/100);
	colFourth = parseInt(CalWidth * 7/100);
	colFifth = parseInt(CalWidth * 7/100);
	colSixth = parseInt(CalWidth * 10/100);
	colSeventh = parseInt(CalWidth * 18/100);
	colEighth = parseInt(CalWidth * 15/100);
	colNineth = parseInt(CalWidth * 15/100);
	return [colFirst,colFirst1,colSecond,colThird,colFourth,colFifth,colSixth,colSeventh,colEighth,colNineth];
}

jQuery('.scroll-container').css('height',mainHeight+'px');
userColumns = ['Date','Project','Type','Company','Assets','hh:mm','P.','Expert','Access Code','Password'];

function implementOutsourceTable(){
	_tableFixedHeader = jQuery("<thead/>");
	_tableFixedHeaderTr = jQuery("<tr/>");	
	jQuery.each(userColumns,function(i,c){
		_filterICON = "";
		_sortICON = "";
		_class="";
		_sortName = "";
		_filterField = "";
		switch(i){
			case 0:
			case 1:
			case 2:
			case 3:
				_filterICON = "<span class='button-list'><i class='fa fa-sort-down'></i></span>";
				_sortICON = "<span class='p-relative'><i class='icon-default p-absolute sort'></i></span>";
				_class = "filter-sort";
				_filterICON +='<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><a class="btn btn-default pull-left mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list"></div></div></div>';
				if(i==0){
					_filterField = "date";
					_sortName = "date";
				} else if(i==1){
					_filterField = "project";
					_sortName = "project";
				} else if(i==2){
					_filterField = "type";
					_sortName = "type";
				} else if(i==3){
					_filterField = "company";
					_sortName = "company";
				}
			break;
			case 4:
			case 5:
			case 6:
			case 7:
			case 8:
			case 9:
				_sortICON = "<span class='p-relative'><i class='icon-default p-absolute sort'></i></span>";
				_class = "sortIcon";
				if(i==4){
					_sortName = "assets";
				} else if(i==5){
					_sortName = "time";
				} else if(i==6){
					_sortName = "p.";
				} else if(i==7){
					_sortName = "expert";
				} else if(i==8){
					_sortName = "access_code";
				} else if(i==9){
					_sortName = "password";
				}
			break;

		}		
		_tableFixedHeaderTh = jQuery("<th/>").attr('sort-name',_sortName).attr('filter-name',_filterField).append(_sortICON+"<span class='"+_class+"'>"+c+"</span>"+_filterICON);
		_tableFixedHeaderTh.find('.button-list').off('click').on('click',function(){
			openFilterList(jQuery(this));
		});
		_tableFixedHeaderTr.append(_tableFixedHeaderTh);
	});
	_tableFixedHeader.append(_tableFixedHeaderTr);
	_tableBody = jQuery("<tbody/>");
	jQuery.each(_taskINString ,function(i,u){
		_tableBodyTr =jQuery("<tr/>").attr('id',i).addClass('main');
		/*Date*/
		_tableBodyTd = jQuery("<td/>").append(moment(new Date(u.create_date)).format('MMM DD, YY'));
		_tableBodyTr.append(_tableBodyTd);
		/*Project*/
		projectType = u.project_type;
		ID = u.id;
		leadID = u.lead_id;
		companyID = u.companyID;
		_tableBodyTd = jQuery("<td/>").append("<a href='javascript://' style='color:#56b2fe' onclick='getChartForThisProject("+leadID+","+projectType+","+companyID+",jQuery(this))'>"+u.project_name+"</a>");
		_tableBodyTr.append(_tableBodyTd);
		/*Type*/
		_tableBodyTd = jQuery("<td/>").append(u.type);
		_tableBodyTr.append(_tableBodyTd);
		/*Company*/
		_tableBodyTd = jQuery("<td/>").append("<a href='javascript://' style='color:#56b2fe' onclick='getChartAllProjectForThisCompany("+leadID+","+companyID+",jQuery(this))'>"+u.get_html_data+"</a>");
		_tableBodyTr.append(_tableBodyTd);
		/*Assets*/
		_tableBodyTd = jQuery("<td/>").append(u.total_patent);
		_tableBodyTr.append(_tableBodyTd);
		/*Time*/
		_tableBodyTd = jQuery("<td/>").append(u.duration);
		_tableBodyTr.append(_tableBodyTd);
		/*P.*/
		innerHTML="";
		if(u.permission_check=='show'){			
			checked = u.checked;
			$_checked="";
			if(checked=='1'){
				$_checked = "CHECKED='CHECKED'";
			}
			innerHTML='<input type="checkbox" onchange="changePermission(jQuery(this),'+leadID+','+ID+','+projectType+')" '+$_checked+' />';
		}
		_tableBodyTd = jQuery("<td/>").append(innerHTML);
		_tableBodyTr.append(_tableBodyTd);
		/*Email*/
		_tableBodyTd = jQuery("<td/>").append(u.email);
		_tableBodyTr.append(_tableBodyTd);
		/*Access Code*/
		_tableBodyTd = jQuery("<td/>").addClass('edit').attr('data-id',ID).attr('data-lead_id',leadID).attr('data-type','access_code').append(u.access_code);
		_tableBodyTr.append(_tableBodyTd);
		/*Password*/
		_tableBodyTd = jQuery("<td/>").addClass('edit').attr('data-id',ID).attr('data-lead_id',leadID).attr('data-type','password').append(u.password);
		_tableBodyTr.append(_tableBodyTd);		
		_tableBody.append(_tableBodyTr);
	});

	var minHandsTable = jQuery("<table/>").addClass('table tableData').attr('id','rs');
	var minHandsTableFixed = jQuery("<table/>").addClass('table fixedHeader').append(_tableFixedHeader);
		minHandsTable.append(_tableBody);
	_headerDiv = jQuery('<div/>').addClass('containerResearchHeader').append(minHandsTableFixed);
	_bodyDiv = jQuery('<div/>').addClass('containerResearchBody dragscroll').append(minHandsTable);
	jQuery(minTable).empty().append(_headerDiv).append(_bodyDiv);
	_getHeight = jQuery('.scroll-container').height();
	_calHeader = jQuery(minTable).find('div.containerResearchHeader').height();
	_calHeight = _getHeight - _calHeader - 15;
	jQuery(minTable).find('div.containerResearchBody').css("height",_calHeight+"px");
	_extraWidth = 0;
	_checkNavi = window.navigator;
	if(_checkNavi.platform.indexOf('Win')>=0){
		_extraWidth = 17;
	}
	jQuery(minTable).find('div.containerResearchHeader').css("width",jQuery(minTable).find('div.containerResearchHeader').width()-_extraWidth);
	editableColumns();
	setTimeout(function(){resizeTable(1)},2);
}
var oriVal;
function editableColumns(){
	jQuery("#rs").find('td.edit').on('dblclick',function(){
		var $td = jQuery(this);
		oriVal = $text.text();
		$td.text("");
		jQuery("<input type='text' />").appendTo(this).focus();
		$td.find('input[type="text"]').on('keypress',function(e){
			if (e.which === 13) {
				if(oriVal!=jQuery(this).val()){
					_ID = $td.attr('data-id');
					_leadID = $td.attr('data-lead_id');
					_columnType = $td.attr('data-type');
					jQuery.ajax({
						url:'<?php echo $Layout->baseUrl?>/opportunity/new_password_for_outsource',
						type:"POST",
						data:{id:_ID,lead_id:_leadID,col_type:_columnType,n_val:jQuery(this).val()},
						cache:false,
						success:function(data){
							if(parseInt(data)==0){
								alert("Please try after sometime.");
							}
						}
					});
				}
			}
		});
	});
	jQuery("#rs").on('focusout', 'td.edit > input', function () {
		var $this = $(this);
		$this.parent().text($this.val() || oriVal); // Use current or original val.
		$this.remove();// Don't just hide, remove the element.
	});
}

function openFilterList(o){
	jQuery(".containerResearchHeader .fixedHeader th").find('.list_options').hide();
	var parentTh = o.parents('th');
	if(parentTh.hasClass('n')){
		parentTh.find(".list_options").find('.p-absolute').parent().hide();
		jQuery(".containerResearchHeader .fixedHeader th").removeClass('n');
		
	} else {
		parentTh.addClass('n');
		_position = o.parent().position();
		parentTh.find(".list_options").find('.p-absolute').parent().show();
		_width = parentTh.width();
		if(_width<200){
			_width = 200;
		}
		_parentIndex = parentTh.index();
		if(parentTh.find(".list_options").find('.list').find('ul').length==0){
			_list = [];
			jQuery("#rs tbody").find('tr').each(function(){
				var _textData = jQuery(this).find('td').eq(_parentIndex).text();
				if(jQuery.inArray(_textData,_list)<0){
					_list.push(_textData);
				}
			});
			_selectUl = jQuery("<ul/>").addClass('open_list');
			jQuery.each(_list,function(i,c){
				if(c.id!=21){
					var _selectLi = jQuery("<li/>").css({'float':'left','width':'100%'});
					var checkBox = jQuery('<input/>').attr('type','checkbox').attr('value',c);
					var spanY = jQuery("<span/>").css('float','left').append(checkBox);
					var spanX = jQuery('<span/>').append(c);
					_selectLi.append(spanY).append(spanX);
					_selectUl.append(_selectLi);
				}		
			});
			parentTh.find(".list_options").find('.list').append(_selectUl);
			parentTh.find(".list_options").find('.p-absolute').css({height:'320px',top:31,left:_position.left,width:_width+'px',background:'#fff',border:'1px solid #d1c8c8'});
		}		
	}
}

function filterFromOutside(col,filter){
	filter = filter.toString().toLowerCase();
	var parentTH = jQuery(".containerResearchHeader").find('thead th').eq(col)
	parentTH.addClass('open');
	if(parentTH.find('input[type="checkbox"]').length>0){
		parentTH.find('input[type="checkbox"]').each(function(){
			var _textData  =jQuery(this).val();
			_textData = _textData.toString().toLowerCase();
			if(_textData==filter){
				jQuery(this).prop('checked',true);
			}
		});
	} else {
		_list = [];
		jQuery("#rs tbody").find('tr').each(function(){
			var _textData = jQuery(this).find('td').eq(col).text();
			if(jQuery.inArray(_textData,_list)<0){
				_list.push(_textData.toString().toLowerCase());
			}
		});
		_selectUl = jQuery("<ul/>").addClass('open_list');
		jQuery.each(_list,function(i,c){
			if(c.id!=21){
				_checked = false;
				if(c==filter){
					_checked = true;
				}
				var _selectLi = jQuery("<li/>").css({'float':'left','width':'100%'});
				var checkBox = jQuery('<input/>').attr('type','checkbox').attr('value',c).prop('checked',_checked);
				var spanY = jQuery("<span/>").css('float','left').append(checkBox);
				var spanX = jQuery('<span/>').append(c);
				_selectLi.append(spanY).append(spanX);
				_selectUl.append(_selectLi);
			}		
		});
		_position = parentTH.find('.button-list').position();
		_width = parentTH.width();
		if(_width<200){
			_width = 200;
		}
		parentTH.find(".list_options").find('.list').append(_selectUl);
		parentTH.find(".list_options").find('.p-absolute').css({height:'320px',top:31,left:_position.left,width:_width+'px',background:'#fff',border:'1px solid #d1c8c8'});
	}
	jQuery("#rs tbody").find("tr").each(function(){			
		var $trRow = jQuery(this);
		if($trRow.hasClass('hide')===false){
			var _textData = $trRow.find('td').eq(col).text();
			_textData = _textData.toString().toLowerCase();
			if(_textData!=filter){
				$trRow.addClass('hide');
			}
		}			
	});
	if(jQuery("#rs tbody").find('tr').eq(0).hasClass('hide')){
		_findRow = jQuery("#rs tbody").find('tr:not(.hide)').eq(0);
		_findRowOld = jQuery("#rs tbody").find('tr').eq(0);
		_findRowOld.find('td').each(function(i){
			_width = jQuery(this).css('width');
			_findRow.find('td').eq(i).css({width:_width,maxWidth:_width,minWidth:_width,wordBreak:'break-all'});	
		})
	}
}

function searchFilter(o){
	var parentTH = o.parents('th');
	parentTH.addClass('open');
	parentTH.removeClass('n');
	_filterSubTech = [];
	_parentIndex = parentTH.index();
	if(parentTH.find('input[type="checkbox"]:checked').length>0){
		parentTH.find('input[type="checkbox"]:checked').each(function(){
			_filterSubTech.push(jQuery(this).val());
		});
	}
	parentTH.find(".list_options").find('.p-absolute').parent().hide();
	if(_filterSubTech.length>0){		
		jQuery("#rs tbody").find("tr").each(function(){			
			var $trRow = jQuery(this);
			if($trRow.hasClass('hide')===false){
				var _textData = $trRow.find('td').eq(_parentIndex).text();
				if(jQuery.inArray(_textData,_filterSubTech)<0){
					$trRow.addClass('hide');
				}
			}			
		});
	} else {
		jQuery("#rs tbody").find("tr").removeClass('hide');
		parentTH.removeClass('open').removeClass('n');
	}
}
function clearFilter(o){
	var parentTH = o.parents('th');
	parentTH.removeClass('open');
	parentTH.find('input[type="radio"]').prop('checked',false);
	parentTH.find('input[type="checkbox"]').prop('checked',false);
	parentTH.find(".list_options").find('.p-absolute').parent().hide();
	jQuery("#rs tbody").find("tr").removeClass('hide');
	parentTH.removeClass('open').removeClass('n');
}

function resizeTable(t){
	var tableResearcherT = jQuery(minTable).find('table.tableData');
	var tableResearcherFixed = jQuery(minTable).find('table.fixedHeader');
		tableResearcherThead = tableResearcherFixed.find('tr');
		tableResearcherTbody = tableResearcherT.find('tbody tr');
		j=0;
		availableWidth = jQuery("#datatable-task-log").parent().parent().width();
		_columnsWidth = getManualColumnsWidth(availableWidth);
		console.log('innerW',_columnsWidth);
		tableResearcherTbody.find('td').css('width','').css('min-width','').css('max-width','');
		tableResearcherThead.find('th').css('width','').css('min-width','').css('max-width','');
		var trF;
		if(tableResearcherTbody.eq(0).hasClass('hide')){
			trF = jQuery("#rs tbody").find('tr:not(.hide)').eq(0);
		} else {
			trF = tableResearcherTbody.eq(0);
		}
		trF.find('td').each(function(i,th){
			var outerWidthTF = jQuery(this).outerWidth();
			width = outerWidthTF;
			switch(i){
				case 0:
					width = _columnsWidth[0];
				break;
				case 1:
					width = _columnsWidth[1];
				break;
				case 2:
					width = _columnsWidth[2];
				break;
				case 3:
					width = _columnsWidth[3];
				break;
				case 4:
					width = _columnsWidth[4];
				break;
				case 5:
					width = _columnsWidth[5];
				break;
				case 6:
					width = _columnsWidth[6];
				break;
				case 7:
					width = _columnsWidth[7];
				break;
				case 8:
					width = _columnsWidth[8];
				break;
				case 9:
					width = _columnsWidth[9];
				break;
			}	
			/*if(width==0){
				tableResearcherThead.find('th').eq(i).
			}*/
			tableResearcherThead.find('th').eq(i).css({width:width+"px",minWidth:width+"px",maxWidth:width+"px"});
			jQuery(this).css({width:width+"px",minWidth:width+"px",maxWidth:width+"px",wordBreak:'break-all'});
			j++;
		});
		tableResearcherT.css({tableLayout:'fixed',wordBreak:'break-all'});
		tableResearcherFixed.css({tableLayout:'fixed',wordBreak:'break-all'});
		if(t==1){setTimeout(scrollSynchronize,100);sortUserTable();}
}
function scrollSynchronize(){
	var $childE = jQuery("#datatable-task-log").find("div.containerResearchBody");
	var $childEH = jQuery("#datatable-task-log").find("div.containerResearchHeader");
	if($childE.length>0){		
		$childE.off('scroll').on('scroll',function(){
			var left = $childE.scrollLeft();
				$childEH.scrollLeft(left);
		})
	} else {
		setTimeout(function(){scrollSynchronize();},300);
	}
}
function sortUserTable(){
	jQuery('.sort').off('click').on('click',function(){
		_sortBy = 'ASC';
		sortOrder = 1;
		if(jQuery(this).hasClass('icon-asc')){
			_sortBy = 'DESC';
			sortOrder = -1;
		}
		var $this = jQuery(this);
		_parentThIndex = $this.parents('th').index();
		_sortField = $this.parents('th').attr('sort-name');
		if(_sortBy=='ASC'){
			$this.removeClass('icon-default').removeClass('icon-desc').addClass('icon-asc');
		} else {
			$this.removeClass('icon-default').addClass('icon-desc').removeClass('icon-asc');
		}		
		var arrData = $('#rs').find('tbody >tr:has(td)').get();
		arrData.sort(function(a, b) {
			var val1 = $(a).children('td').eq(_parentThIndex).text().toUpperCase();
			var val2 = $(b).children('td').eq(_parentThIndex).text().toUpperCase();
			if ($.isNumeric(val1) && $.isNumeric(val2))
				return sortOrder == 1 ? val1 - val2 : val2 - val1;
			else
        		return (val1 < val2) ? -sortOrder : (val1 > val2) ? sortOrder : 0;
     	});
		$.each(arrData, function(index, row) {
       		$('tbody').append(row);
      	});
		resizeTable(0);
	});
}

jQuery(window).resize(function(){
	setTimeout(function(){
		var width = jQuery(window).width();
		var height = jQuery(window).height();
		newHeight = (height - jQuery('#cn').outerHeight() - jQuery('#selected_contacts').outerHeight() - jQuery('.btnList').outerHeight() - 60 );
		jQuery('.scroll-container').css("height",newHeight+"px");
		_calHeader = jQuery(minTable).find('div.containerResearchHeader').height();
		_calHeight = newHeight - _calHeader - 15;
		jQuery(minTable).find('div.containerResearchBody').css("height",_calHeight+"px");
		_width = jQuery(minTable).find('div.containerResearchHeader').parent().width();
		_extraWidth = 0;
		_checkNavi = window.navigator;
		if(_checkNavi.platform.indexOf('Win')>=0){
			_extraWidth = 17;
		}
		jQuery(minTable).find('div.containerResearchHeader').css("width",_width-_extraWidth);
		var tableResearcherT = jQuery(minTable).find('table.tableData');
		var tableResearcherFixed = jQuery(minTable).find('table.fixedHeader');
		tableResearcherThead = tableResearcherFixed.find('tr');
		tableResearcherTbody = tableResearcherT.find('tbody tr');
		tableResearcherTbody.eq(0).find('td').each(function(i,th){
			jQuery(this).css('width','');
			jQuery(this).css('min-width','');
			jQuery(this).css('max-width','');
			tableResearcherThead.find('th').eq(i).css('width','');
			tableResearcherThead.find('th').eq(i).css('min-width','');
			tableResearcherThead.find('th').eq(i).css('max-width','');
		})
		resizeTable(1);
	},100);
});

implementOutsourceTable();
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
	jQuery("#chart").html('<iframe src="<?php echo $Layout->baseUrl?>customers/get_outsource_chart_by_project/'+leadID+'/'+type+'/'+company+'" style="width:100%;height:'+h+'px"></iframe>');
	o.css('color','red');
}
function getChartAllProjectForThisCompany(leadID,company,o){
	jQuery("#chart").html('');
	jQuery("#datatable-task-log").find('a').css('color','#56b2fe');
	h = jQuery(window).height() ;
	jQuery("#chart").html('<iframe src="<?php echo $Layout->baseUrl?>customers/get_outsource_chart_by_company/'+leadID+'/'+company+'" style="width:100%;height:'+h+'px"></iframe>');
	o.css('color','red');
}


</script>