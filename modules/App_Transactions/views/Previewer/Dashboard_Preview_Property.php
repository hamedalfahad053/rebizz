<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">

            <!--begin::Page Heading-->
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <!--begin::Page Title-->
                <h5 class="text-dark font-weight-bold my-1 mr-5"><?= $Page_Title ?></h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <?= $breadcrumbs ?>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page Heading-->

        </div>
        <!--end::Info-->
        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
            <a href="<?= base_url(APP_NAMESPACE_URL . '/Transactions/View_Transaction/'.$Transactions->uuid) ?>" class="btn btn-success">
                <i class="flaticon2-arrow"></i>   العودة للمعاملة
            </a>
        </div>
        <!--end::Toolbar-->
    </div>
</div>


<script  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDw_Thx2J7uq9eaqeb-WmZ2fBzUz7hZYGE&libraries=places&callback=initMap"></script>
<?= import_js(BASE_ASSET.'plugins/custom/gmaps/gmaps',''); ?>

<style type="text/css">
	#map-container {
		width:100%;
		height:400px;
		overflow:hidden;
	}

	/* ensures that the content fills its parent when shown again */
	#map-content {
		height: 100% !important;
		width: 100% !important;
	}
</style>

<!--end::Subheader-->
<?= import_css(BASE_ASSET.'css/pages/wizard/wizard-4',$this->data['direction']); ?>


<!--begin::Entry-->
<div class="d-flex flex-column-fluid">

	<!--begin::Container-->
	<div class="container-fluid">
		<div class="card card-custom card-transparent">
			<div class="card-body p-0">


				<?php
				$this->load->library('Arabic',array());
				$obj = new I18N_Arabic('Date');

				$y = '2021 04 26';

				echo $obj->gregToJd(9,26,1442);
				?>
				<!--begin: Wizard-->
				<div class="wizard wizard-4" id="kt_wizard" data-wizard-state="step-first" data-wizard-clickable="true">

					<!--begin: Wizard Nav-->
					<div class="wizard-nav">
						<div class="wizard-steps">
							<!--begin::Wizard Step 1 Nav-->
							<div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
								<div class="wizard-wrapper">
									<div class="wizard-number">1</div>
									<div class="wizard-label">
										<div class="wizard-title">البيانات الاساسية</div>
										<div class="wizard-desc">بيانات العقار رقم القطعة الخ... </div>
									</div>
								</div>
							</div>
							<!--end::Wizard Step 1 Nav-->

							<!--begin::Wizard Step 3 Nav-->
							<div class="wizard-step" data-wizard-type="step">
								<div class="wizard-wrapper">
									<div class="wizard-number">2</div>
									<div class="wizard-label">
										<div class="wizard-title">الموقع الجغرافي</div>
										<div class="wizard-desc">حدد موقع العقار على الخريطة</div>
									</div>
								</div>
							</div>
							<!--end::Wizard Step 3 Nav-->

							<!--begin::Wizard Step 2 Nav-->
							<div class="wizard-step" data-wizard-type="step">
								<div class="wizard-wrapper">
									<div class="wizard-number">3</div>
									<div class="wizard-label">
										<div class="wizard-title">صور العقار</div>
										<div class="wizard-desc">صور للعقار من الداخل و الخارج و المحيط</div>
									</div>
								</div>
							</div>
							<!--end::Wizard Step 2 Nav-->

							<!--begin::Wizard Step 4 Nav-->
							<div class="wizard-step" data-wizard-type="step">
								<div class="wizard-wrapper">
									<div class="wizard-number">4</div>
									<div class="wizard-label">
										<div class="wizard-title">التقييم</div>
										<div class="wizard-desc">تقييم سعر الارض و المباني و مقارانات الاسعار</div>
									</div>
								</div>
							</div>
							<!--end::Wizard Step 4 Nav-->
						</div>
					</div>
					<!--end: Wizard Nav-->


					<!--begin: Wizard Body-->
					<div class="card card-custom card-shadowless rounded-top-0">
						<div class="card-body p-0">
							<div class="row justify-content-center py-8 py-lg-8 py-sm-5 px-lg-12">
								<div class="col-xl-12 col-xxl-12">
										<!--begin: Wizard Form-->
										<form class="form mt-0 mt-lg-12" method="post" action="<?= base_url(APP_NAMESPACE_URL . '/Transactions/Create_Preview_Property/'.$Transactions->uuid) ?>"  id="kt_form"  enctype="multipart/form-data">

											<input type="hidden" name="Transaction_id" value="<?= $Transactions->transaction_id ?>">
											<input type="hidden" name="Coordination_id" value="<?= $Coordination->Coordination_id ?>">

												<!--begin: Wizard Step 1-->
												<div class="p-5" data-wizard-type="step-content" data-wizard-state="current">

													<?php
													$LIST_CLIENT                    = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_CLIENT');
													$CUSTOMER_CATEGORY              = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_CUSTOMER_CATEGORY');
													$TYPE_OF_PROPERTY               = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_TYPE_OF_PROPERTY');
													$TYPES_OF_REAL_ESTATE_APPRAISAL = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_TYPES_OF_REAL_ESTATE_APPRAISAL');

													$Form_Components  = Get_View_Components_Customs(14,$LIST_CLIENT,$CUSTOMER_CATEGORY,$TYPE_OF_PROPERTY,$TYPES_OF_REAL_ESTATE_APPRAISAL);

													foreach ($Form_Components->result() AS $RC)
													{
														?>
														<h3 class="font-size-h5 font-weight-boldest"><?= $RC->item_translation ?></h3>
														<div class="separator separator-dashed separator-border-1 separator-primary"></div>
														<div class="form-group row">
																	<?php
																	$Get_Fields_Components = Building_Fields_Components_Forms($RC->Forms_id, $RC->components_id,$LIST_CLIENT,$CUSTOMER_CATEGORY,$TYPE_OF_PROPERTY,$TYPES_OF_REAL_ESTATE_APPRAISAL,'All');

																	foreach ($Get_Fields_Components as $GFC)
																	{

																		if($GFC['Fields_Type_Components'] == 'Fields'){

																			$Where_Get_Fields = array("Fields_id" => $GFC['Fields_id']);
																			$Get_Fields       = Get_Fields($Where_Get_Fields)->row();
																			?>

																			<div class="col-lg-3 mt-5">
																				<?php
																				echo Building_Field_Forms($Get_Fields->Fields_key,
																						true,
																						$Get_Fields->Fields_key.'-'.$RC->Forms_id.'-'.$RC->components_id,
																						'',
																						$Get_Fields->Fields_key,
																						'',
																						'',
																						'',
																						'',
																						'',
																						'');

																				?>
																			</div>

																			<?php

																		}elseif($GFC['Fields_Type_Components'] == 'List'){
																			?>

																			<div class="col-lg-3 mt-5">
																				<?php
																				$class_List      = array( 0 => "selectpicker");
																				echo Building_ChekBox_Forms('radio',$RC->Forms_id,
																						$RC->components_id,
																						$GFC['Fields_id'],
																						$multiple = '',
																						$selected='',
																						$style='',
																						$id='',
																						$class = array( 0=>"selectpicker"),
																						$disabled='',
																						$label='',
																						$js='');
																				?>
																			</div>
																			<?php
																		}

																	} // foreach
																	?>
																</div><!-- <div class="form-group row"> -->
														<?php
													}
													?>

												</div>
												<!--end: Wizard Step 1-->


												<!--begin: Wizard Step 2-->
												<div class="p-5" data-wizard-type="step-content">
													<?= $this->load->view('../../modules/App_Transactions/views/Previewer/Template_Map'); ?>
												</div>
												<!--end: Wizard Step 2-->



												<!--begin: Wizard Step 3-->
												<div class="p-5" data-wizard-type="step-content">
													<?= $this->load->view('../../modules/App_Transactions/views/Previewer/Tamplate_Ajax_Uploaded_File_Previewer', $this->data); ?>
												</div>
												<!--end: Wizard Step 3-->




												<!--begin: Wizard Step 4-->
												<div class="p-5" data-wizard-type="step-content">

													<?php
													$LIST_CLIENT                    = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_CLIENT');
													$CUSTOMER_CATEGORY              = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_CUSTOMER_CATEGORY');
													$TYPE_OF_PROPERTY               = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_TYPE_OF_PROPERTY');
													$TYPES_OF_REAL_ESTATE_APPRAISAL = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_TYPES_OF_REAL_ESTATE_APPRAISAL');

													$Form_Components  = Get_View_Components_Customs(17,$LIST_CLIENT,$CUSTOMER_CATEGORY,$TYPE_OF_PROPERTY,$TYPES_OF_REAL_ESTATE_APPRAISAL);

													foreach ($Form_Components->result() AS $RC)
													{
														?>
														<h3 class="font-size-h5 font-weight-boldest"><?= $RC->item_translation ?></h3>
														<div class="separator separator-dashed separator-border-1 separator-primary"></div>
														<div class="form-group row">
															<?php
															$Get_Fields_Components = Building_Fields_Components_Forms($RC->Forms_id, $RC->components_id,$LIST_CLIENT,$CUSTOMER_CATEGORY,$TYPE_OF_PROPERTY,$TYPES_OF_REAL_ESTATE_APPRAISAL,'All');

															foreach ($Get_Fields_Components as $GFC)
															{

																if($GFC['Fields_key'] !='CONSUMPTION_RATIO'  and  $GFC['Fields_key'] !='PROFIT_RATIO' and $GFC['Fields_key'] != 'ESTIMATED_COSTS' and $GFC['Fields_key'] != 'MARKET_VALUE'){

																	if($GFC['Fields_Type_Components'] == 'Fields'){
																		$Where_Get_Fields = array("Fields_id" => $GFC['Fields_id']);
																		$Get_Fields       = Get_Fields($Where_Get_Fields)->row();
																		?>
																		<div class="col-sm-4  col-lg-4  mt-5">
																			<?php
																			echo Building_Field_Forms($Get_Fields->Fields_key,
																					true,
																					$Get_Fields->Fields_key.'-'.$RC->Forms_id.'-'.$RC->components_id,
																					'',
																					$Get_Fields->Fields_key,
																					'',
																					'',
																					'',
																					'',
																					array("data-calculations"=>"true",  "min"=> 0, "value" => 0,"step"=> 0.0 ),
																					'');

																			?>
																		</div>
																		<?php
																	} // if($GFC['Fields_Type_Components'] == 'Fields')

																} // if(){ Fields ignor



															} // foreach


															?>
														</div><!-- <div class="form-group row"> -->
														<?php
													}

													$this->load->view('../../modules/App_Transactions/views/Previewer/Template_Total_Evluation_Preview_Property');
													?>


                                                    <div class="row">
	                                                    <?= $this->load->view('../../modules/App_Transactions/views/Previewer/Template_Table_Land_Comparisons', $this->data); ?>
                                                    </div>


												</div>
												<!--end: Wizard Step 4-->


												<!--begin: Wizard Actions-->
												<div class="d-flex justify-content-between border-top mt-5 p-10">
													<div class="mr-2">
														<button type="button" class="btn btn-light-primary font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-prev">السابق</button>
													</div>
													<div>
														<button type="submit" class="btn btn-success font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-submit">ارسال وحفظ البيانات</button>
														<button type="button" class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-next">التالي</button>
													</div>
												</div>
												<!--end: Wizard Actions-->

										</form>
										<!--end: Wizard Form-->
								</div>
							</div>
						</div>
					</div>
					<!--end: Wizard Bpdy-->
				</div>
				<!--end: Wizard-->


			</div>
		</div>
	</div>
	<!--end::Container-->

</div>
<!--end::Entry-->




<?= $this->load->view('../../modules/App_Transactions/views/Previewer/modal_add_Comparisons', $this->data); ?>




<script type="text/javascript">

		function Get_Ajax_Data_Table_Land_Comparisons() {
			var Transactions_id        = <?= $Transactions->transaction_id ?>;
			var Coordination_id        = <?= $Coordination->Coordination_id ?>;
			$.ajax({
				url : "<?= base_url(APP_NAMESPACE_URL . '/Transactions/Ajax_Comparisons_Land_Comparisons') ?>",
				type:'get',
				data: {
					Transactions_id:Transactions_id,Coordination_id:Coordination_id
				},
				dataType: 'html',
				beforeSend: function(){
					$('#Ajax_Data_Table_Land_Comparisons').append("<div style='text-align: center;'><i class='fa fa-spinner fa-spin fa-5x fa-fw'></i></div>")
				},
				success: function(response) {
					$("#Ajax_Data_Table_Land_Comparisons").empty();
					$("#Ajax_Data_Table_Land_Comparisons").html(response);
				},
				error: function(){

				}
			});
		} // Get_All_Data_Ajax()

		Get_Ajax_Data_Table_Land_Comparisons();




		var _wizardEl;
		var _formEl;
		var _wizardObj;

		var _initWizard = function () {

			_wizardObj = new KTWizard(_wizardEl, {
				startStep: 1, // initial active step number
				clickableSteps: true  // allow step clicking
			});
			_wizardObj.on('change', function (wizard) {
				if (wizard.getStep() > wizard.getNewStep()) {
					return; // Skip if stepped back
				}
			});

			// Change event
			_wizardObj.on('changed', function (wizard) {
				KTUtil.scrollTop();
			});

			// Submit event
			_wizardObj.on('submit', function (wizard) {
				_formEl.submit(); // Submit form
			});

		}
		_wizardEl = KTUtil.getById('kt_wizard');
		_formEl = KTUtil.getById('kt_form');
		_initWizard();

		var Total_Land     = 0;
		var Total_Building = 0;

			<?php
			$where_Get_Calculations = array(
				"Form_loc" => "Preview_Property_FORM",
			);
			$Get_Calculations = Get_Calculations($where_Get_Calculations);
	        foreach ($Get_Calculations->result() AS $R_GC)
	        {

			if($R_GC->Type_Value == 'Building'){
			?>
				$('#<?= $R_GC->Field_C_key ?>').attr("data-type","Building").prop("readonly",true).addClass("form-control-solid");
			<?php
			}
			if($R_GC->Type_Value == 'Land'){
			?>
				$('#<?= $R_GC->Field_C_key ?>').attr("data-type","Land").prop("readonly",true).addClass("form-control-solid");
			<?php
			}
			?>


			$('#<?= $R_GC->Field_A_key ?>,#<?= $R_GC->Field_B_key ?>').keyup(function() {


				var <?= $R_GC->Field_A_key ?>  = $('#<?= $R_GC->Field_A_key ?>').val();
				var <?= $R_GC->Field_B_key ?>  = $('#<?= $R_GC->Field_B_key ?>').val();
				$('#<?= $R_GC->Field_C_key ?>').val(<?= $R_GC->Field_A_key ?> * <?= $R_GC->Field_B_key ?>);

			});
			<?php
			}
	        ?>

			var PROFIT_RATIO         = 0;
			var CONSUMPTION_RATIO    = 0;
			var CONSUMPTION_Building = 0;
			var ESTIMATED_COSTS      = 0;
			var PROFIT_Total         = 0;

			$(document).on("keyup","input[data-calculations=true]",function(){
				Total_Land = 0;
				Total_Building = 0;

				$('input[data-type="Building"]').each(function(){
					Total_Building += parseFloat($(this).val()) || 0;
				});

				$('input[data-type="Land"]').each(function(){
					Total_Land += parseFloat($(this).val()) || 0;
				});

				CONSUMPTION_RATIO = parseFloat($('#CONSUMPTION_RATIO').val()) || 0;
				if(CONSUMPTION_RATIO !== null  &&  CONSUMPTION_RATIO !== undefined && CONSUMPTION_RATIO !== '' ){
					if(CONSUMPTION_RATIO !== 0) {
						CONSUMPTION_Building = parseFloat((CONSUMPTION_RATIO / 100) * Total_Building);
					}
					else{
						CONSUMPTION_Building = 0;
					}
				}
				 ESTIMATED_COSTS = parseFloat((Total_Building - CONSUMPTION_Building)  + Total_Land);
				$('#ESTIMATED_COSTS').val(ESTIMATED_COSTS);



				PROFIT_RATIO = parseFloat($('#PROFIT_RATIO').val()) || 0;
				if(PROFIT_RATIO !== null  &&  PROFIT_RATIO !== undefined && PROFIT_RATIO !== '' ){
					if(PROFIT_RATIO !== 0) {
						PROFIT_Total = parseFloat((PROFIT_RATIO / 100) * (ESTIMATED_COSTS));
					}
					else{
						PROFIT_Total = 0;
					}
				}

				// Value Table input
				$('#Total_Land').val(Total_Land);
				$('#Total_Building').val(Total_Building);
				$('#CONSUMPTION_Total').val(CONSUMPTION_Building);
				$('#PROFIT_Total').val(PROFIT_Total);
				var MARKET_VALUE = parseFloat(PROFIT_Total + ESTIMATED_COSTS);
				$('#MARKET_VALUE').val(MARKET_VALUE);
				$('#MARKET_VALUE_Approximate').val(Math.round(MARKET_VALUE));

			});
</script>