<style>body{overflow:auto!important}#page-content{background:#ffffff!important} .btn-opp-block {width: 100%;}</style>
<script type="text/javascript">/* WYSIWYG editor */jQuery(document).ready(function(){$(function(){$(".wysiwyg-editor").summernote({fontsize:'15',height:350,toolbar:[["style",["bold","italic","underline","clear"]],["fontsize",["fontsize"]],["color",["color"]],["para",["ul","ol","paragraph"]],["height",["height"]],]});$(".wysiwyg-editor1").summernote({fontsize:'15',height:150,toolbar:[["style",["bold","italic","underline","clear"]],["fontsize",["fontsize"]],["color",["color"]],["para",["ul","ol","paragraph"]],["height",["height"]],]})})});$(".wysiwyg-editor,.wysiwyg-editor1").summernote('fontsize','15')</script>
<div class="row"> 
<div style='overflow-x: hidden; overflow-y: auto; height: auto;'>
<div class="pad10A">
<div class="col-md-12 col-sm-12 col-xs-12" id="contentPart">
<style id="tempStyles">.dashboard-box{overflow-y:scroll!important}.tab-pane{display:block}</style>
<script>
leadGlobal = "<?php echo $lead_id; ?>";
_token = "<?php echo $lead_id; ?>";
</script>	
	<div class="row">
		<div class="col-lg-12">
			<h3>Dockets Accordion</h3>
			<div class="form-group input-string-group bigmr " style="border: none !important;">
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(1)" style="font-size:13px;padding:0px;">Portfolio</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(2)" style="font-size:13px;padding:0;">Syndication</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(8)" style="font-size:13px;padding:0px;">Price</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(3)" style="font-size:13px;padding:0px;">Simulator</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(4)" style="font-size:13px;padding:0;">Documents</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(5)" style="font-size:13px;padding:0px;">Scope</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(6)" style="font-size:13px;padding:0;">Quality</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(7)" style="font-size:13px;padding:0;">Impact</a>
			</div>
		</div>	
		<div class="col-lg-12">
			<h3>Due Dilligence Accordion</h3>
			<div class="form-group input-string-group bigmr " style="border: none !important;">
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(17)" style="font-size:13px;padding:0px;">SellerDD</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(9)" style="font-size:13px;padding:0px;">TechDD</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(10)" style="font-size:13px;padding:0;">MarketDD</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(11)" style="font-size:13px;padding:0px;">LegalDD</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(12)" style="font-size:13px;padding:0px;">IllustrationDD</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(13)" style="font-size:13px;padding:0;">ImageDD</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(14)" style="font-size:13px;padding:0px;">PdfDD</a>
				<!--<a href="javascript://" class="btn mrg15R" onclick="openModalContent(15)" style="font-size:13px;padding:0;">IntroDD</a>-->
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(16)" style="font-size:13px;padding:0;">DictionaryDD</a>
			</div>
		</div>
	</div>
	<input type="hidden" name="other[lead_id]" id="leadID" value="<?php echo $lead_id?>" />	
</div>
</div>
</div>
</div>
<style>.width80{width:80%;}.width100{width:100%;}.modal.modal-opened-header, .modal{margin-top:170px !important;}.modal.modal-opened-header .modal-dialog, .modal .modal-dialog{margin-left:15px !important;}</style>
<div class="modal modal-opened-header fade width100" id="portfolioModal" tabindex="-1" role="dialog" aria-labelledby="calendarLabel" aria-hidden="true" style=''>
	<div class="modal-dialog width80" >
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">Portfolio Accordion Text</h4>				
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">
						<?php 
							$portfolio_text = "";
							if(count($acordion_text)>0 && isset($acordion_text->License->portfolio_text) && !empty($acordion_text->License->portfolio_text)){								
								$portfolio_text = $acordion_text->License->portfolio_text;
							} else if(count($template_accordion)>0){
								if(isset($template_accordion->portfolio_text)){
									$portfolio_text = $template_accordion->portfolio_text;
								}
							}
						?>
						<textarea class='wysiwyg-editor' name='portfolio_text' id='portfolio_text'><?php echo $portfolio_text;?></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="saveModalText(1,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
				<button type="button" onclick="saveModalText(1,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-opened-header fade width100" id="syndicationModal" tabindex="-1" role="dialog" aria-labelledby="calendarLabel" aria-hidden="true" style=''>
	<div class="modal-dialog width80" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">Syndication Accordion Text</h4>				
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">
						<?php 
							$syndication_tab = "";
							if(count($acordion_text)>0 && isset($acordion_text->License->syndication_tab)&& !empty($acordion_text->License->syndication_tab)){
								$syndication_tab = $acordion_text->License->syndication_tab;
							} else if(count($template_accordion)>0){
								if(isset($template_accordion->syndication_tab)){
									$syndication_tab = $template_accordion->syndication_tab;
								}
							}
						?>
						<textarea class='wysiwyg-editor' name='syndication_tab' id='syndication_tab'><?php echo $syndication_tab;?></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="saveModalText(2,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
				<button type="button" onclick="saveModalText(2,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-opened-header fade width100" id="simulatorModal" tabindex="-1" role="dialog" aria-labelledby="calendarLabel" aria-hidden="true" style=''>
	<div class="modal-dialog width80" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">Simulator Accordion Text</h4>				
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">
						<?php 
							$simulator_text = "";
							if(count($acordion_text)>0 && isset($acordion_text->License->simulator_text)&& !empty($acordion_text->License->simulator_text)){
								$simulator_text = $acordion_text->License->simulator_text;
							} else if(count($template_accordion)>0){
								if(isset($template_accordion->simulator_text)){
									$simulator_text = $template_accordion->simulator_text;
								}
							}
						?>
						<textarea class='wysiwyg-editor' name='simulator_text' id='simulator_text'><?php echo $simulator_text;?></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="saveModalText(3,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
				<button type="button" onclick="saveModalText(3,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-opened-header fade width100" id="documentsModal" tabindex="-1" role="dialog" aria-labelledby="calendarLabel" aria-hidden="true" style=' '>
	<div class="modal-dialog width80" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">Document Accordion Text</h4>				
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">
						<?php 
							$document_text = "";
							if(count($acordion_text)>0 && isset($acordion_text->License->document_text)&& !empty($acordion_text->License->document_text)){
								$document_text = $acordion_text->License->document_text;
							} else if(count($template_accordion)>0){
								if(isset($template_accordion->document_text)){
									$document_text = $template_accordion->document_text;
								}
							}
						?>
						<textarea class='wysiwyg-editor' name='document_text' id='document_text'><?php echo $document_text;?></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="saveModalText(4,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
				<button type="button" onclick="saveModalText(4,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-opened-header fade width100" id="scopeModal" tabindex="-1" role="dialog" aria-labelledby="calendarLabel" aria-hidden="true" style=' '>
	<div class="modal-dialog width80" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">Scope Accordion Text</h4>				
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">
						<?php 
							$due_diligence_tab = "";
							if(count($acordion_text)>0 && isset($acordion_text->License->due_diligence_tab)&& !empty($acordion_text->License->due_diligence_tab)){
								$due_diligence_tab = $acordion_text->License->due_diligence_tab;
							} else if(count($template_accordion)>0){
								if(isset($template_accordion->due_diligence_tab)){
									$due_diligence_tab = $template_accordion->due_diligence_tab;
								}
							}
						?>
						<textarea class='wysiwyg-editor' name='due_diligence_tab' id='due_diligence_tab'><?php echo $due_diligence_tab;?></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="saveModalText(5,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
				<button type="button" onclick="saveModalText(5,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-opened-header fade width100" id="qualityModal" tabindex="-1" role="dialog" aria-labelledby="calendarLabel" aria-hidden="true" style=' '>
	<div class="modal-dialog width80" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">Quality Accordion Text</h4>				
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<label class="col-lg-12 control-label mrg10T mrg10B">ClaimChart Accordion Text</label>
					<div class="col-lg-12">
						
						<?php 
							$claim_chart_tab = "";
							if(count($acordion_text)>0 && isset($acordion_text->License->claim_chart_tab)&& !empty($acordion_text->License->claim_chart_tab)){
								$claim_chart_tab = $acordion_text->License->claim_chart_tab;
							} else if(count($template_accordion)>0){
								if(isset($template_accordion->claim_chart_tab)){
									$claim_chart_tab = $template_accordion->claim_chart_tab;
								}
							}
						?>
						<textarea class='wysiwyg-editor' name='claim_chart_tab' id='claim_chart_tab'><?php echo $claim_chart_tab;?></textarea>
					</div>
				</div>				
			   <div class="clearfix"></div>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="saveModalText(6,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
				<button type="button" onclick="saveModalText(6,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-opened-header fade width100" id="priceModal" tabindex="-1" role="dialog" aria-labelledby="calendarLabel" aria-hidden="true" style=' '>
	<div class="modal-dialog width80" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">Price Accordion Text</h4>				
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">
						<?php 
							$price_tab = "";
							if(count($acordion_text)>0 && isset($acordion_text->License->price_tab)&& !empty($acordion_text->License->price_tab)){
								$price_tab = $acordion_text->License->price_tab;
							} else if(count($template_accordion)>0){
								if(isset($template_accordion->price_tab)){
									$price_tab = $template_accordion->price_tab;
								}
							}
						?>
						<textarea class='wysiwyg-editor' name='price_tab' id='price_tab'><?php echo $price_tab;?></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="saveModalText(8,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
				<button type="button" onclick="saveModalText(8,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-opened-header fade width100" id="impactModal" tabindex="-1" role="dialog" aria-labelledby="calendarLabel" aria-hidden="true" style=' '>
	<div class="modal-dialog width80" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">Impact Accordion Text</h4>				
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">
						<?php 
							$impact_tab = "";
							if(count($acordion_text)>0 && isset($acordion_text->License->impact_tab)&& !empty($acordion_text->License->impact_tab)){
								$impact_tab = $acordion_text->License->impact_tab;
							} else if(count($template_accordion)>0){
								if(isset($template_accordion->impact_tab)){
									$impact_tab = $template_accordion->impact_tab;
								}
							}
						?>
						<textarea class='wysiwyg-editor' name='impact_tab' id='impact_tab'><?php echo $impact_tab;?></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="saveModalText(7,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
				<button type="button" onclick="saveModalText(7,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
			</div>
		</div>
	</div>
</div>
<!-- -->
<div class="modal modal-opened-header fade width100" id="tech_ddModal" tabindex="-1" role="dialog" aria-labelledby="calendarLabel" aria-hidden="true" style=' '>
	<div class="modal-dialog width80" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">TechDD Accordion Text</h4>				
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">
						<?php 
							$tech_dd = "";
							if(count($acordion_text)>0 && isset($acordion_text->License->tech_dd)&& !empty($acordion_text->License->tech_dd)){
								$tech_dd = $acordion_text->License->tech_dd;
							} else if(count($template_accordion)>0){
								if(isset($template_accordion->tech_dd)){
									$tech_dd = $template_accordion->tech_dd;
								}
							}
						?>
						<textarea class='wysiwyg-editor' name='tech_dd' id='tech_dd'><?php echo $tech_dd;?></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="saveModalText(9,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
				<button type="button" onclick="saveModalText(9,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
			</div>
		</div>
	</div>
</div>
<!-- -->
<!-- -->
<div class="modal modal-opened-header fade width100" id="market_ddModal" tabindex="-1" role="dialog" aria-labelledby="calendarLabel" aria-hidden="true" style=' '>
	<div class="modal-dialog width80" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">MarketDD Text</h4>				
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">
						<?php 
							$market_dd = "";
							if(count($acordion_text)>0 && isset($acordion_text->License->market_dd)&& !empty($acordion_text->License->market_dd)){
								$market_dd = $acordion_text->License->market_dd;
							} else if(count($template_accordion)>0){
								if(isset($template_accordion->market_dd)){
									$market_dd = $template_accordion->market_dd;
								}
							}
						?>
						<textarea class='wysiwyg-editor' name='market_dd' id='market_dd'><?php echo $market_dd;?></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="saveModalText(10,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
				<button type="button" onclick="saveModalText(10,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
			</div>
		</div>
	</div>
</div>
<!-- -->
<!-- -->
<div class="modal modal-opened-header fade width100" id="legal_ddModal" tabindex="-1" role="dialog" aria-labelledby="calendarLabel" aria-hidden="true" style=' '>
	<div class="modal-dialog width80" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">LegalDD Accordion Text</h4>				
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">
						<?php 
							$legal_dd = "";
							if(count($acordion_text)>0 && isset($acordion_text->License->legal_dd)&& !empty($acordion_text->License->legal_dd)){
								$legal_dd = $acordion_text->License->legal_dd;
							} else if(count($template_accordion)>0){
								if(isset($template_accordion->legal_dd)){
									$legal_dd = $template_accordion->legal_dd;
								}
							}
						?>
						<textarea class='wysiwyg-editor' name='legal_dd' id='legal_dd'><?php echo $legal_dd;?></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="saveModalText(11,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
				<button type="button" onclick="saveModalText(11,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
			</div>
		</div>
	</div>
</div>
<!-- -->
<!-- -->
<div class="modal modal-opened-header fade width100" id="illustration_ddModal" tabindex="-1" role="dialog" aria-labelledby="calendarLabel" aria-hidden="true" style=' '>
	<div class="modal-dialog width80" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">IllustrationDD Accordion Text</h4>				
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">
						<?php 
							$illustration_dd = "";
							if(count($acordion_text)>0 && isset($acordion_text->License->illustration_dd)&& !empty($acordion_text->License->illustration_dd)){
								$illustration_dd = $acordion_text->License->illustration_dd;
							} else if(count($template_accordion)>0){
								if(isset($template_accordion->illustration_dd)){
									$illustration_dd = $template_accordion->illustration_dd;
								}
							}
						?>
						<textarea class='wysiwyg-editor' name='illustration_dd' id='illustration_dd'><?php echo $illustration_dd;?></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="saveModalText(12,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
				<button type="button" onclick="saveModalText(12,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
			</div>
		</div>
	</div>
</div>
<!-- -->
<!-- -->
<div class="modal modal-opened-header fade width100" id="image_ddModal" tabindex="-1" role="dialog" aria-labelledby="calendarLabel" aria-hidden="true" style=' '>
	<div class="modal-dialog width80" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">ImageDD Accordion Text</h4>				
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">
						<?php 
							$image_dd = "";
							if(count($acordion_text)>0 && isset($acordion_text->License->image_dd)&& !empty($acordion_text->License->image_dd)){
								$image_dd = $acordion_text->License->image_dd;
							} else if(count($template_accordion)>0){
								if(isset($template_accordion->image_dd)){
									$image_dd = $template_accordion->image_dd;
								}
							}
						?>
						<textarea class='wysiwyg-editor' name='image_dd' id='image_dd'><?php echo $image_dd;?></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="saveModalText(13,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
				<button type="button" onclick="saveModalText(13,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
			</div>
		</div>
	</div>
</div>
<!-- -->
<!-- -->
<div class="modal modal-opened-header fade width100" id="pdf_ddModal" tabindex="-1" role="dialog" aria-labelledby="calendarLabel" aria-hidden="true" style=' '>
	<div class="modal-dialog width80" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">PdfDD Accordion Text</h4>				
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">
						<?php 
							$pdf_dd = "";
							if(count($acordion_text)>0 && isset($acordion_text->License->pdf_dd)&& !empty($acordion_text->License->pdf_dd)){
								$pdf_dd = $acordion_text->License->pdf_dd;
							} else if(count($template_accordion)>0){
								if(isset($template_accordion->pdf_dd)){
									$pdf_dd = $template_accordion->pdf_dd;
								}
							}
						?>
						<textarea class='wysiwyg-editor' name='pdf_dd' id='pdf_dd'><?php echo $pdf_dd;?></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="saveModalText(14,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
				<button type="button" onclick="saveModalText(14,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
			</div>
		</div>
	</div>
</div>
<!-- -->
<!-- -->
<!--<div class="modal modal-opened-header fade width100" id="intro_ddModal" tabindex="-1" role="dialog" aria-labelledby="calendarLabel" aria-hidden="true" style=' '>
	<div class="modal-dialog width80" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">IntroDD Accordion Text</h4>				
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">
						<?php 
							$intro_dd = "";
							if(count($acordion_text)>0 && isset($acordion_text->License->intro_dd)&& !empty($acordion_text->License->intro_dd)){
								$intro_dd = $acordion_text->License->intro_dd;
							} else if(count($template_accordion)>0){
								if(isset($template_accordion->intro_dd)){
									$intro_dd = $template_accordion->intro_dd;
								}
							}
						?>
						<textarea class='wysiwyg-editor' name='intro_dd' id='intro_dd'><?php echo $intro_dd;?></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="saveModalText(15,0)" class='btn btn-mwidth ' style='margin-right:1px;'>Save to Docket</button>
				<button type="button" onclick="saveModalText(15,1)" class='btn btn-mwidth ' style='margin-right:1px;'>Save to Skeleton</button>
			</div>
		</div>
	</div>
</div>-->
<!-- -->
<!-- -->
<div class="modal modal-opened-header fade width100" id="dictionary_ddModal" tabindex="-1" role="dialog" aria-labelledby="calendarLabel" aria-hidden="true" style=' '>
	<div class="modal-dialog width80" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">DictionaryDD Accordion Text</h4>				
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">
						<?php 
							$dictionary_dd = "";
							if(count($acordion_text)>0 && isset($acordion_text->License->dictionary_dd)&& !empty($acordion_text->License->dictionary_dd)){
								$dictionary_dd = $acordion_text->License->dictionary_dd;
							} else if(count($template_accordion)>0){
								if(isset($template_accordion->dictionary_dd)){
									$dictionary_dd = $template_accordion->dictionary_dd;
								}
							}
						?>
						<textarea class='wysiwyg-editor' name='dictionary_dd' id='dictionary_dd'><?php echo $dictionary_dd;?></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="saveModalText(16,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
				<button type="button" onclick="saveModalText(16,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
			</div>
		</div>
	</div>
</div>
<!-- -->
<!-- -->
<div class="modal modal-opened-header fade width100" id="seller_ddModal" tabindex="-1" role="dialog" aria-labelledby="calendarLabel" aria-hidden="true" style=' '>
	<div class="modal-dialog width80" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">SellerDD Accordion Text</h4>				
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">
						<?php 
						
							$seller_dd = "";
							if(count($acordion_text)>0 && isset($acordion_text->License->seller_dd)&& !empty($acordion_text->License->seller_dd)){
								$seller_dd = $acordion_text->License->seller_dd;
							} else if(count($template_accordion)>0){
								if(isset($template_accordion->seller_dd)){
									$seller_dd = $template_accordion->seller_dd;
								}
							}
						?>
						<textarea class='wysiwyg-editor' name='seller_dd' id='seller_dd'><?php echo $seller_dd;?></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="saveModalText(17,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
				<button type="button" onclick="saveModalText(17,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
			</div>
		</div>
	</div>
</div>
<!-- -->
<script>
function closeAllModal(){jQuery("#portfolioModal,#syndicationModal,#simulatorModal,#documentsModal,#scopeModal,#qualityModal,#impactModal,#priceModal,#tech_ddModal,#market_ddModal,#legal_ddModal,#illustration_ddModal,#image_ddModal,#pdf_ddModal,#intro_ddModal,#dictionary_ddModal,#seller_ddModal").modal("hide");}
function openModalContent(type){closeAllModal();switch(type){case 1:jQuery("#portfolioModal").modal("show");break;case 2:jQuery("#syndicationModal").modal("show");break;case 3:jQuery("#simulatorModal").modal("show");break;case 4:jQuery("#documentsModal").modal("show");break;case 5:jQuery("#scopeModal").modal("show");break;case 6:jQuery("#qualityModal").modal("show");break;case 7:jQuery("#impactModal").modal("show");break;case 8:jQuery("#priceModal").modal("show");break;case 9:jQuery("#tech_ddModal").modal("show");break;case 10:jQuery("#market_ddModal").modal("show");break;case 11:jQuery("#legal_ddModal").modal("show");break;case 12:jQuery("#illustration_ddModal").modal("show");break;case 13:jQuery("#image_ddModal").modal("show");break;case 14:jQuery("#pdf_ddModal").modal("show");break;case 15:jQuery("#intro_ddModal").modal("show");break;case 16:jQuery("#dictionary_ddModal").modal("show");break;case 17:jQuery("#seller_ddModal").modal("show");break;}}
function saveModalText(type,mode){$text="";switch(type){case 1:$text=jQuery("#portfolio_text").code();if($text!=""){jQuery.ajax({type:'POST',url:"<?php echo $Layout->baseUrl?>opportunity/save_accordion_text",data:{lead_id:leadGlobal,portfolio_text:$text,mode:mode},cache:false,success:function(){jQuery("#portfolioModal").modal("hide");}})}
break;case 2:$text=jQuery("#syndication_tab").code();if($text!=""){jQuery.ajax({type:'POST',url:"<?php echo $Layout->baseUrl?>opportunity/save_accordion_text",data:{lead_id:leadGlobal,syndication_tab:$text,mode:mode},cache:false,success:function(){jQuery("#syndicationModal").modal("hide");}})}
break;case 3:$text=jQuery("#simulator_text").code();if($text!=""){jQuery.ajax({type:'POST',url:"<?php echo $Layout->baseUrl?>opportunity/save_accordion_text",data:{lead_id:leadGlobal,simulator_text:$text,mode:mode},cache:false,success:function(){jQuery("#simulatorModal").modal("hide");}})}
break;case 4:$text=jQuery("#document_text").code();if($text!=""){jQuery.ajax({type:'POST',url:"<?php echo $Layout->baseUrl?>opportunity/save_accordion_text",data:{lead_id:leadGlobal,document_text:$text,mode:mode},cache:false,success:function(){jQuery("#documentsModal").modal("hide");}})}
break;case 5:$text=jQuery("#due_diligence_tab").code();if($text!=""){jQuery.ajax({type:'POST',url:"<?php echo $Layout->baseUrl?>opportunity/save_accordion_text",data:{lead_id:leadGlobal,due_diligence_tab:$text,mode:mode},cache:false,success:function(){jQuery("#scopeModal").modal("hide");}})}
break;case 6:$text=jQuery("#claim_chart_tab").code();if($text!=""){jQuery.ajax({type:'POST',url:"<?php echo $Layout->baseUrl?>opportunity/save_accordion_text",data:{lead_id:leadGlobal,claim_chart_tab:$text,mode:mode},cache:false,success:function(){jQuery("#qualityModal").modal("hide");}})}
break;case 7:$text=jQuery("#impact_tab").code();if($text!=""){jQuery.ajax({type:'POST',url:"<?php echo $Layout->baseUrl?>opportunity/save_accordion_text",data:{lead_id:leadGlobal,impact_tab:$text,mode:mode},cache:false,success:function(){jQuery("#impactModal").modal("hide");}})}
break;case 8:$text=jQuery("#price_tab").code();if($text!=""){jQuery.ajax({type:'POST',url:"<?php echo $Layout->baseUrl?>opportunity/save_accordion_text",data:{lead_id:leadGlobal,price_tab:$text,mode:mode},cache:false,success:function(){jQuery("#priceModal").modal("hide");}})}
break;
case 8:$text=jQuery("#price_tab").code();if($text!=""){jQuery.ajax({type:'POST',url:"<?php echo $Layout->baseUrl?>opportunity/save_accordion_text",data:{lead_id:leadGlobal,price_tab:$text,mode:mode},cache:false,success:function(){jQuery("#priceModal").modal("hide");}})}
break;
case 9:$text=jQuery("#tech_dd").code();if($text!=""){jQuery.ajax({type:'POST',url:"<?php echo $Layout->baseUrl?>opportunity/save_accordion_text",data:{lead_id:leadGlobal,tech_dd:$text,mode:mode},cache:false,success:function(){jQuery("#tech_ddModal").modal("hide");}})}
break;
case 10:$text=jQuery("#market_dd").code();if($text!=""){jQuery.ajax({type:'POST',url:"<?php echo $Layout->baseUrl?>opportunity/save_accordion_text",data:{lead_id:leadGlobal,market_dd:$text,mode:mode},cache:false,success:function(){jQuery("#market_ddModal").modal("hide");}})}
break;
case 11:$text=jQuery("#legal_dd").code();if($text!=""){jQuery.ajax({type:'POST',url:"<?php echo $Layout->baseUrl?>opportunity/save_accordion_text",data:{lead_id:leadGlobal,legal_dd:$text,mode:mode},cache:false,success:function(){jQuery("#legal_ddModal").modal("hide");}})}
break;
case 12:$text=jQuery("#illustration_dd").code();if($text!=""){jQuery.ajax({type:'POST',url:"<?php echo $Layout->baseUrl?>opportunity/save_accordion_text",data:{lead_id:leadGlobal,illustration_dd:$text,mode:mode},cache:false,success:function(){jQuery("#illustration_ddModal").modal("hide");}})}
break;
case 13:$text=jQuery("#image_dd").code();if($text!=""){jQuery.ajax({type:'POST',url:"<?php echo $Layout->baseUrl?>opportunity/save_accordion_text",data:{lead_id:leadGlobal,image_dd:$text,mode:mode},cache:false,success:function(){jQuery("#image_ddModal").modal("hide");}})}
break;
case 14:$text=jQuery("#pdf_dd").code();if($text!=""){jQuery.ajax({type:'POST',url:"<?php echo $Layout->baseUrl?>opportunity/save_accordion_text",data:{lead_id:leadGlobal,pdf_dd:$text,mode:mode},cache:false,success:function(){jQuery("#pdf_ddModal").modal("hide");}})}
break;
case 15:$text=jQuery("#intro_dd").code();if($text!=""){jQuery.ajax({type:'POST',url:"<?php echo $Layout->baseUrl?>opportunity/save_accordion_text",data:{lead_id:leadGlobal,intro_dd:$text,mode:mode},cache:false,success:function(){jQuery("#intro_ddModal").modal("hide");}})}
break;
case 16:$text=jQuery("#dictionary_dd").code();if($text!=""){jQuery.ajax({type:'POST',url:"<?php echo $Layout->baseUrl?>opportunity/save_accordion_text",data:{lead_id:leadGlobal,dictionary_dd:$text,mode:mode},cache:false,success:function(){jQuery("#dictionary_ddModal").modal("hide");}})}
break;
case 17:$text=jQuery("#seller_dd").code();if($text!=""){jQuery.ajax({type:'POST',url:"<?php echo $Layout->baseUrl?>opportunity/save_accordion_text",data:{lead_id:leadGlobal,seller_dd:$text,mode:mode},cache:false,success:function(){jQuery("#seller_ddModal").modal("hide");}})}
break;




}}
</script>