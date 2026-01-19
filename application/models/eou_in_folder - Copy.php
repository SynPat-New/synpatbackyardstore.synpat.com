<style>
	body {
		overflow: auto !important;
	}
	#page-content {
	    background: #ffffff !important;
	}

	#datatable-task-log_wrapper .dataTables_scroll {
		background: none;
		clear: both;
	}
	#datatable-task-log_wrapper .dataTables_info {
		display: none;
	}
	.dataTables_scroll{
		background:none;
	}

	div.dataTables_info {
		display: none !important;
	}
</style>


<script type="text/javascript" src="<?php echo $Layout->awsUrl; ?>public/widgets/datatable/datatable.js"></script>
						<script type="text/javascript" src="<?php echo $Layout->awsUrl; ?>public/widgets/datatable/datatable-bootstrap.js"></script>
						<script type="text/javascript" src="<?php echo $Layout->awsUrl; ?>public/widgets/datatable/datatable-tabletools.js"></script>
<script>
var ___table = "";
jQuery(document).ready(function(){
	___table =jQuery("#datatable-task-log").DataTable( {
				"searching":false,
				"scrollY": "554px",
				"scrollX": true,
				"scrollCollapse": true,
				"paging": false,
				"oLanguage": {
					"sEmptyTable":     "<p class='alert alert-info'>No record found!</p>"
				}				
			});
});
function changePermission(o,l,i){
	$d=0;
	if(o.prop('checked')){
		$d=1;
	}
	jQuery.ajax({
		url:'<?php echo $Layout->baseUrl?>/opportunity/file_permission_technical',
		type:"POST",
		data:{d:$d,t:l,i:i},
		cache:false,
		success:function(data){
			
		}
	});
}
function getChartForThisProject(leadID,type,company,o){
	jQuery("#chart").html('');
	jQuery("#datatable-task-log").find('a').css('color','#56b2fe');
	h = jQuery(window).height();
	jQuery("#chart").html('<iframe src="<?php echo $Layout->baseUrl?>opportunity/get_outsource_chart_by_project/'+leadID+'/'+type+'/'+company+'" style="width:100%;height:'+h+'px"></iframe>');
	o.css('color','red');
}
function getChartAllProjectForThisCompany(leadID,company,o){
	jQuery("#chart").html('');
	jQuery("#datatable-task-log").find('a').css('color','#56b2fe');
	h = jQuery(window).height();
	jQuery("#chart").html('<iframe src="<?php echo $Layout->baseUrl?>opportunity/get_outsource_chart_by_company/'+leadID+'/'+company+'" style="width:100%;height:'+h+'px"></iframe>');
	o.css('color','red');
}
</script>
<div class='col-lg-5' id="chart">
	

</div>
<div class='col-lg-7'>
	<table class="table" id="datatable-task-log">
		<thead>
			<tr>
				<th>Project</th>
				<th>Date</th>
				<th>Expert</th>
				<th width="150px">Company</th>
				<th>Permi.</th>
				<th>Time Spent</th>
				<th># Patents</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				for($i=0;$i<count($eou_data);$i++){
					$allEmails = explode(',',$eou_data[$i]->expert);
					$companyID = 0;
					$getData = array();
					if(trim($allEmails[0])!=''){
						$getData = getUserCompanyByEmail($allEmails[0]);
						$companyID = $getData->company_id;
					}
			?>
			<tr>				
				<td>
				<?php 
					$type = "";
					switch((int)$eou_data[$i]->project_type){
						case 1:
							$type = "Patent";
						break;
						case 2:
							$type = "TechDD";
						break;
						case 3:
							$type = "LegalDD";
						break;
						case 4:
							$type = "IllustrationDD";
						break;
						case 5:
							$type = "Royalty";
						break;
						case 6:
							$type = "Invitees";
						break;
						case 7:
							$type = "SellerDD";
						break;
						case 8:
							$type = "Introduction";
						break;
						case 9:
							$type = "CompareDD";
						break;
						case 10:
							$type = "PdfDD";
						break;
						case 11:
							$type = "IntroImages";
						break;
					}					
				?><a href='javascript://' style='color:#56b2fe' onclick='getChartForThisProject(<?php echo $eou_data[$i]->lead_id?>,<?php echo $eou_data[$i]->project_type?>,<?php echo $companyID?>,jQuery(this))'><?php echo $eou_data[$i]->lead_name.' - '.$type;?></a></td>
				<td><?php echo date('m-d-Y',strtotime($eou_data[$i]->create_date))?></td>
				<td><?php echo $allEmails[0];?></td>
				<td width="150px">
					<?php 
							if(count($getData)>0){
					?>
								<a href='javascript://' style='color:#56b2fe' onclick='getChartAllProjectForThisCompany(<?php echo $eou_data[$i]->lead_id?>,<?php echo $getData->company_id?>,jQuery(this))'><?php echo $getData->company_name;?></a>
					<?php
							}
					?>
				</td>
				<td>
					<?php if((int)$eou_data[$i]->project_type==9):?>
					<input type="checkbox" onchange="changePermission(jQuery(this),<?php echo $eou_data[$i]->lead_id?>,<?php echo $eou_data[$i]->id?>)" <?php if($eou_data[$i]->permmission==1):?>checked='checked'<?php endif;?> />
					<?php endif;?>
				</td>
				<td><?php echo $eou_data[$i]->duration?></td>
				<td><?php echo $eou_data[$i]->total_patent?></td>				
			</tr>
			<?php
				}
			?>
		</tbody>
	</table>
</div>