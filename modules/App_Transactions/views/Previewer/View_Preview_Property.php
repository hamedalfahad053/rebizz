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
            <a href="<?= base_url(APP_NAMESPACE_URL . '/Transactions/View_Transaction/'.$Transactions->uuid.'') ?>" class="btn btn-success">
                <i class="flaticon2-arrow"></i>   العودة الى المعاملة
            </a>


        </div>
        <!--end::Toolbar-->
    </div>
</div>
<!--end::Subheader-->


<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
	<div class="container-fluid">

		<?php echo  $this->session->flashdata('message'); ?>

		<div class="card card-custom mb-5 mt-10">
			<div class="card-body">

				<table class="data_table table table-bordered table-hover display" width="100%">
					<tr>
						<th class="text-center bg-light-primary">المعاين</th>
						<th class="text-center bg-light-primary">تاريخ / وقت </th>
						<th class="text-center bg-light-primary">حالة الزيارة</th>
						<?php
						if(Check_Permissions(20)){
						?>
						<th class="text-center bg-light-primary">
                          اعتماد المعاينة
						</th>
						<?php
						}
						?>
					</tr>
					<tr>
						<td class="text-center"><?= $this->aauth->get_user($Coordination->preview_userid)->full_name ?></td>
						<td class="text-center">
							<?php
							$PREVIEW_Status_Stages_Transaction = array(
									"transaction_id" => $Transactions->transaction_id,
									"stages_key"     => 'PREVIEW',
									"stages_type"    => 'COMPLETE'
							);
							$Stages_Transaction_P = Get_Status_Stages_Transaction($PREVIEW_Status_Stages_Transaction)->row();
							echo date('Y-m-d h:i:s a',$Stages_Transaction_P->time_complete);
							?>
						</td>
						<td class="text-center">
							<?php
							if($Coordination->preview_Visit_acceptance ==0) {
								echo 'لم تعتمد ';
							}else{
								echo get_data_options_List_view('90',$Coordination->preview_Visit_acceptance);
							}
							?>
						</td>

						<?php
						if(Check_Permissions(20)){
						?>
						<td class="text-center">
							<?php
							if($Coordination->preview_Visit_acceptance ==0) {
							?>
							<!-- Button trigger modal-->
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">اعتماد / رفض</button>
							<!-- Modal-->
							<form class="form" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Preview/Create_Approval_Previewer/'.$this->uri->segment(4).'/'.$this->uri->segment(5)) ?>" method="post">
							<div class="modal fade" id="exampleModalLong" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">تعيين حالة الزيارة</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<i aria-hidden="true" class="ki ki-close"></i>
											</button>
										</div>
										<div class="modal-body">
											<div class="form-group row">
												<div class="col-lg-12">
													<label>حالة المعاينة</label>
													<?php
													$lang       = get_current_lang();
													$query_list = app()->db->from('portal_list_data list');
													$query_list = app()->db->join('portal_list_data_translation  list_translation', 'list.list_id=list_translation.item_id');
													$query_list = app()->db->where('list.list_key', 'LIST_LIST_VISITING_STATUS');
													$query_list = app()->db->where('list_translation.translation_lang', $lang);
													$query_list = app()->db->get()->row();

													$query_list_options = app()->db->from('portal_list_options_data list_options');
													$query_list_options = app()->db->join('portal_list_options_translation  options_translation', 'list_options.list_options_id = options_translation.item_id');
													$query_list_options = app()->db->where('list_options.list_id', $query_list->list_id);
													$query_list_options = app()->db->where('list_options.options_key !=','NEW_PENDING_TESTIMONY_PREVIEWER');
													$query_list_options = app()->db->where('list_options.options_key !=','SCHEDULED');
													$query_list_options = app()->db->where('list_options.options_key !=','DELAY');
													$query_list_options = app()->db->where('list_options.options_key !=','NO_RESPONSE');													$query_list_options = app()->db->where('options_translation.translation_lang', $lang);
													$query_list_options = app()->db->order_by('list_options.options_sort', ' DESC');
													$query_list_options = app()->db->get();
													?>
													<select data-live-search="true" data-size="5" name="LIST_VISITING_STATUS" class="form-control selectpicker" id="LIST_VISITING_STATUS" title="فضلا اختر من ...">
														<?php
														foreach ($query_list_options->result() AS $OP)
														{
															?>
															<option value="<?= $OP->list_options_id ?>"><?= $OP->item_translation ?></option>
															<?php
														}
														?>
													</select>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">اغلاق</button>
											<button type="submit" class="btn btn-primary font-weight-bold">اعتماد</button>
										</div>
									</div>
								</div>
							</div>
							</form>
							<?php
							}else{
								echo $this->aauth->get_user($Coordination->preview_Visit_userid_acceptance)->full_name;
								echo '<br>';
								echo date('Y-m-d h:i:s a',$Coordination->preview_Visit_date_completed);
							}
							?>
						</td>
						<?php
						}
						?>

					</tr>
				</table>




			</div>
		</div>

		<div class="card card-custom mb-5 mt-10">
			<div class="card-header">
				<div class="card-title">
					<span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
					<h3 class="card-label"> مكونات العقار </h3>
				</div>
				<div class="card-toolbar">

				</div>
			</div>
			<div class="card-body">
				<?php
				$Customs_With_CLIENT            = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_CLIENT');
				$Customs_With_Type_CUSTOMER     = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_CUSTOMER_CATEGORY');
				$Customs_With_Type_Property     = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_TYPE_OF_PROPERTY');
				$Customs_With_TYPES_APPRAISAL   = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_TYPES_OF_REAL_ESTATE_APPRAISAL');
				$Form_Components_Customs        = Get_View_Components_Customs(14,$Customs_With_CLIENT,$Customs_With_Type_CUSTOMER,$Customs_With_Type_Property,$Customs_With_TYPES_APPRAISAL);

				foreach ($Form_Components_Customs->result() AS $RC_Customs)
				{
					?>
					<h3 class="font-size-h5 mt-3 mb-3 font-weight-boldest"><?= $RC_Customs->item_translation ?></h3>
 					<table class="data_table table table-bordered table-hover display" width="100%">
						<?php
						$Get_Fields_Components = Building_Fields_Components_Views($RC_Customs->Forms_id, $RC_Customs->components_id,'All','All','All','All');
						foreach ($Get_Fields_Components as $GFC)
						{

							if($GFC['Fields_Type_Components'] == 'Fields'){

								$Get_Fields = Get_Fields(array("Fields_id"=>$GFC['Fields_id']))->row();

								if($Get_Fields->Fields_Type_Fields == 'file_multiple' or $Get_Fields->Fields_Type_Fields == 'file') {


								}else{

									?>
									<tr>
										<td class="bg-light-primary" width="50%"><?= $GFC['Fields_Title'] ?></td>
										<td>
											<?php
											$Transaction_data_by_key = Get_Transaction_Preview_data_by_key($Transactions->transaction_id,$this->data['Coordination']->Coordination_id,$GFC['Forms_id'],$GFC['components_id'],$GFC['Fields_key']);
											if($Transaction_data_by_key == false){
												echo 'غير مدخل';
											}else{
												echo $Transaction_data_by_key;
											}
											?>
										</td>
									</tr>
									<?php
								}


							}elseif($GFC['Fields_Type_Components'] == 'List'){

								$d = Get_Transaction_Preview_data_by_key($Transactions->transaction_id,$this->data['Coordination']->Coordination_id,$GFC['Forms_id'],$GFC['components_id'],$GFC['Fields_key']);
								?>
								<tr>
									<td class="bg-light-primary" width="50%"><?= $GFC['Fields_Title'] ?></td>
									<td>
										<?php
										$Transaction_data_by_options_List = get_data_options_List_view($GFC['Fields_id'],$d);

										if($Transaction_data_by_options_List == ''){
											echo 'غير مدخل';
										}else{
											echo $Transaction_data_by_options_List;
										}
										?>
									</td>
								</tr>
								<?php


							}
						} // foreach ($Get_Fields_Components as $GFC)
						?>
					</table>
					<?php
				}
				?>
			</div>
		</div>


		<div class="card card-custom mb-5 mt-10">
			<div class="card-header">
				<div class="card-title">
					<span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
					<h3 class="card-label"> الموقع الجغرافي </h3>
				</div>
				<div class="card-toolbar">
				</div>
			</div>
			<div class="card-body">
				<div id="map-content" class="mb-5 mt-5" style="height: 300px; width: 100%"></div>
				<table class="data_table table table-bordered table-hover display " width="100%">
					<tr>
						<td class="text-center bg-light-primary">خط الطول</td>
						<td class="text-center bg-light-primary">خط العرض</td>
						<td class="text-center bg-light-primary">خط الطول ( بالدقائق - الثواني )</td>
						<td class="text-center bg-light-primary">خط العرض ( بالدقائق - الثواني )</td>
					</tr>
					<tr>
						<td class="text-center"><?= Get_Transaction_Preview_data_by_key($Transactions->transaction_id,$this->data['Coordination']->Coordination_id,15,37,'LATITUDE'); ?></td>
						<td class="text-center"><?= Get_Transaction_Preview_data_by_key($Transactions->transaction_id,$this->data['Coordination']->Coordination_id,15,37,'LONGITUDE'); ?></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
					</tr>
				</table>
			</div>
		</div>

		<div class="card card-custom mb-5 mt-10">
			<div class="card-header">
				<div class="card-title">
					<span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
					<h3 class="card-label"> محيط العقار </h3>
				</div>
				<div class="card-toolbar">
				</div>
			</div>
			<div class="card-body">
				<table class="data_table table table-bordered table-hover display " width="100%">
					<tr>
						<td class="text-center bg-light-primary"> </td>
						<td class="text-center bg-light-primary"> </td>
					</tr>
					<tr>
						<td class="text-center"></td>
						<td class="text-center"></td>
					</tr>
				</table>
			</div>
		</div>

		<div class="card card-custom mb-5 mt-10">
			<div class="card-header">
				<div class="card-title">
					<span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
					<h3 class="card-label"> صور العقار </h3>
				</div>
				<div class="card-toolbar">

				</div>
			</div>
			<div class="card-body">
				<div class="d-flex align-items-center">
				<?php
				$query_transaction_files = $this->db->order_by('files_sort','ASC');
				$query_transaction_files = $this->db->where('file_isDeleted !=',1);
				$query_transaction_files = $this->db->where('preview_id  ',$Coordination->Coordination_id);
				$query_transaction_files = app()->db->where('transaction_id',$Transactions->transaction_id);
				$query_transaction_files = app()->db->get('protal_transaction_files');

				$f = 0;

				foreach ($query_transaction_files->result() AS $RF)
				{

					$Company_domain = Get_Company($this->aauth->get_user()->company_id)->companies_Domain;
					$Uploader_path = base_url().'uploads/companies/' . $Company_domain . '/' . FOLDER_FILE_Transaction_COMPANY;


					$Uploader_path.'/'.$RF->file_name;
				}
				?>
				</div>
			</div>
		</div>


		<div class="card card-custom mb-5 mt-10">
			<div class="card-header">
				<div class="card-title">
					<span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
					<h3 class="card-label"> التقييم المبدئي </h3>
				</div>
				<div class="card-toolbar">

				</div>
			</div>
			<div class="card-body">
				<table class="table table-striped table-bordered table-hover mt-3 data_table_Land_Comparisons">
				<tr>
					<th colspan="2" class="text-center">البيان</th>
					<th colspan="2" class="text-center">سعر المتر</th>
					<th colspan="2" class="text-center">الاجمالي</th>
				</tr>
				<?php
				$LIST_CLIENT                    = Transaction_data_by_key($Transactions->transaction_id,17,1,'LIST_CLIENT');
				$CUSTOMER_CATEGORY              = Transaction_data_by_key($Transactions->transaction_id,17,1,'LIST_CUSTOMER_CATEGORY');
				$TYPE_OF_PROPERTY               = Transaction_data_by_key($Transactions->transaction_id,17,1,'LIST_TYPE_OF_PROPERTY');
				$TYPES_OF_REAL_ESTATE_APPRAISAL = Transaction_data_by_key($Transactions->transaction_id,17,1,'LIST_TYPES_OF_REAL_ESTATE_APPRAISAL');
				$Form_Components  = Get_View_Components_Customs(17,$LIST_CLIENT,$CUSTOMER_CATEGORY,$TYPE_OF_PROPERTY,$TYPES_OF_REAL_ESTATE_APPRAISAL);

				foreach ($Form_Components->result() AS $RC)
				{


				$td       = '';
 				$i_tr     = 0;
				$open_tr  = '<tr>';
				$close_tr = '</tr>';

				$Get_Fields_Components = Building_Fields_Components_Forms($RC->Forms_id, $RC->components_id,$LIST_CLIENT,$CUSTOMER_CATEGORY,$TYPE_OF_PROPERTY,$TYPES_OF_REAL_ESTATE_APPRAISAL,'All');



						  foreach ($Get_Fields_Components as $GFC)
						  {
							  if($GFC['Fields_key'] ==='CONSUMPTION_RATIO'  or  $GFC['Fields_key'] ==='PROFIT_RATIO' or $GFC['Fields_key'] === 'ESTIMATED_COSTS' or $GFC['Fields_key'] === 'MARKET_VALUE'){

							  }else{

								  ++$i_tr;

								  $td .= '<td>'.$GFC['Fields_Title'].'</td>';
								  $td .= '<td>' . number_format(Get_Transaction_Preview_data_by_key($Transactions->transaction_id,$this->data['Coordination']->Coordination_id, $RC->Forms_id, $RC->components_id,$GFC['Fields_key'])) . '</td>';

								  if($i_tr == 3){

									  echo $open_tr.$td.$close_tr;

									  $td   = '';
									  $i_tr = 0;

								  }

							  }
						  }



			    }
				?>
				</table>



				<?php
				$get_evaluation_table = $this->db->where('transaction_id',$Transactions->transaction_id);
				$get_evaluation_table = $this->db->where('preview_id',$this->data['Coordination']->Coordination_id);
				$get_evaluation_table = $this->db->get('protal_transaction_preview_evaluation');

				if($get_evaluation_table->num_rows()>0){
					$get_evaluation_table_row = $get_evaluation_table->row();
				}
				?>

				<table class="table table-striped table-bordered table-hover mt-3 data_table_Land_Comparisons">
					<tr>
						<th class="text-center" width="25%">إجمالي قيمة الأرض</th>
						<td class="text-center"><?= number_format($get_evaluation_table_row->Total_Land) ?></td>
					</tr>
					<tr>
						<th class="text-center" width="25%">إجمالي قيمة المباني </th>
						<td class="text-center"><?= number_format($get_evaluation_table_row->Total_Building) ?></td>
					</tr>
					<tr>
						<th class="text-center" width="25%">نسبة الاستهلاك (%)</th>
						<td class="text-center">%<?= number_format($get_evaluation_table_row->CONSUMPTION_RATIO) ?></td>
					</tr>
					<tr>
						<th class="text-center" width="25%">قيمة الاستهلاك</th>
						<td class="text-center"><?= number_format($get_evaluation_table_row->CONSUMPTION_Total) ?></td>
					</tr>
					<tr>
						<th class="text-center" width="25%">التكلفة التقديرية (التكلفة)</th>
						<td class="text-center"><?= number_format($get_evaluation_table_row->ESTIMATED_COSTS) ?></td>
					</tr>
					<tr>
						<th class="text-center" width="25%">نسبة الربح (%)</th>
						<td class="text-center">%<?= number_format($get_evaluation_table_row->PROFIT_RATIO) ?></td>
					</tr>
					<tr>
						<th class="text-center" width="25%">قيمة الربح</th>
						<td class="text-center"><?= number_format($get_evaluation_table_row->PROFIT_Total) ?></td>
					</tr>
					<tr>
						<th class="text-center" width="25%">القيمة السوقية  (حسب المعطيات)</th>
						<td class="text-center"><?= number_format($get_evaluation_table_row->MARKET_VALUE) ?></td>
					</tr>
					<tr>
						<th class="text-center" width="25%">القيمة السوقية  (التقريبية)</th>
						<td class="text-center"><?= number_format($get_evaluation_table_row->MARKET_VALUE_Approximate) ?>
						</td>
					</tr>
				</table>

			</div>
		</div>



	</div>
</div>
<!--begin::Entry-->


<script  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDw_Thx2J7uq9eaqeb-WmZ2fBzUz7hZYGE&libraries=places&callback=initMap"></script>
<?= import_js(BASE_ASSET.'plugins/custom/gmaps/gmaps',''); ?>
<script type="text/javascript">
	    var map = new GMaps({ div: '#map-content' ,
		    lat: <?= Get_Transaction_Preview_data_by_key($Transactions->transaction_id,$this->data['Coordination']->Coordination_id, 15, 37, 'LATITUDE') ?>,
		    lng: <?= Get_Transaction_Preview_data_by_key($Transactions->transaction_id,$this->data['Coordination']->Coordination_id, 15, 37, 'LONGITUDE') ?>,
	    });

		map.addMarker({
			lat: <?= Get_Transaction_Preview_data_by_key($Transactions->transaction_id,$this->data['Coordination']->Coordination_id, 15, 37, 'LATITUDE') ?>,
			lng: <?= Get_Transaction_Preview_data_by_key($Transactions->transaction_id,$this->data['Coordination']->Coordination_id, 15, 37, 'LONGITUDE') ?>,
			zoom: 14,
			draggable: false,
			title: 'موقع العقار'
		});
</script>
