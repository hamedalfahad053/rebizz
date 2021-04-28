

<?php
$Customs_With_CLIENT            = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_CLIENT');
$Customs_With_Type_CUSTOMER     = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_CUSTOMER_CATEGORY');
$Customs_With_Type_Property     = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_TYPE_OF_PROPERTY');
$Customs_With_TYPES_APPRAISAL   = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_TYPES_OF_REAL_ESTATE_APPRAISAL');

$Form_Components_Customs        = Get_View_Components_Customs(1,$Customs_With_CLIENT,$Customs_With_Type_CUSTOMER,$Customs_With_Type_Property,$Customs_With_TYPES_APPRAISAL);
foreach ($Form_Components_Customs->result() AS $RC_Customs)
{
	?>
	<div class="card card-custom mt-10">
		<!--begin::Header-->
		<div class="card-header">
			<div class="card-title">
				<h3 class="card-label">
					<?= $RC_Customs->item_translation ?>
				</h3>
			</div>
		</div>
		<!--begin::Header-->
		<!--begin::Body-->
		<div class="card-body">
			<div class="form-group row">
				<table class="data_table table table-bordered table-hover display nowrap" width="100%">

					<?php
					$Get_Fields_Components = Building_Fields_Components_Views($RC_Customs->Forms_id, $RC_Customs->components_id,'All','All','All','All');
					foreach ($Get_Fields_Components as $GFC)
					{
						if($GFC['Fields_Type_Components'] == 'Fields'){

							$Get_Fields = Get_Fields(array("Fields_id"=>$GFC['Fields_id']))->row();

							if($Get_Fields->Fields_Type_Fields == 'file_multiple' or $Get_Fields->Fields_Type_Fields == 'file') {
								$data_files['Get_Transaction_files'] = Get_Transaction_files(array("Transaction_id"=>$Transactions->transaction_id))->result();
								$this->load->view('../../modules/App_Transactions/views/Template/Template_row_transaction_files',$data_files);
							}else{
								?>
								<tr>
									<td><?= $GFC['Fields_Title'] ?></td>
									<td><?= Transaction_data_by_key($Transactions->transaction_id,$GFC['Forms_id'],$GFC['components_id'],$GFC['Fields_key']) ?></td>
									<td>
										<a href="<?= base_url(APP_NAMESPACE_URL.'/Transactions/Edit_Data_Transaction/'.$Transactions->uuid.'/'.$GFC['Forms_id'].'/'.$GFC['components_id'].'/'.$GFC['Fields_key']) ?>" class="btn btn-icon btn-sm btn-light-warning mx-2"><i class="la la-edit"></i></a>
									    <a href="<?= base_url(APP_NAMESPACE_URL.'/Transactions/History_Data_Transaction/'.$Transactions->uuid.'/'.$GFC['Forms_id'].'/'.$GFC['components_id'].'/'.$GFC['Fields_key']) ?>" class="btn btn-icon btn-sm btn-light-info mx-2"><i class="flaticon2-information"></i></a>
									</td>
								</tr>
								<?php
							}


						}elseif($GFC['Fields_Type_Components'] == 'List'){

							$d = Transaction_data_by_key($Transactions->transaction_id,$GFC['Forms_id'],$GFC['components_id'],$GFC['Fields_key']);
							?>
							<tr>
								<td><?= $GFC['Fields_Title'] ?></td>
								<td><?= get_data_options_List_view($GFC['Fields_id'],$d); ?></td>
								<td>
                                    <a class="btn btn-icon btn-sm btn-light-warning mx-2"><i class="la la-edit"></i></a>
                                    <a class="btn btn-icon btn-sm btn-light-info mx-2"><i class="flaticon2-information"></i></a>
                                </td>
							</tr>
							<?php
						}
					} // foreach ($Get_Fields_Components as $GFC)
					?>
				</table>

			</div><!-- <div class="form-group row"> -->
		</div>
		<!--begin::Body-->
	</div><!--<div class="card card-custom mt-10">-->
	<?php
} // foreach ($Form_Components_Customs->result() AS $RC_Customs)
?>


<?php
$Customs_With_CLIENT            = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_CLIENT');
$Customs_With_Type_CUSTOMER     = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_CUSTOMER_CATEGORY');
$Customs_With_Type_Property     = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_TYPE_OF_PROPERTY');
$Customs_With_TYPES_APPRAISAL   = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_TYPES_OF_REAL_ESTATE_APPRAISAL');
$Form_Components_Customs        = Get_View_Components_Customs(13,$Customs_With_CLIENT,$Customs_With_Type_CUSTOMER,$Customs_With_Type_Property,$Customs_With_TYPES_APPRAISAL);

foreach ($Form_Components_Customs->result() AS $RC_Customs)
{
	?>
	<div class="card card-custom mt-10">
		<!--begin::Header-->
		<div class="card-header">
			<div class="card-title">
				<h3 class="card-label">
					<?= $RC_Customs->item_translation ?>
				</h3>
			</div>
		</div>
		<!--begin::Header-->
		<!--begin::Body-->
		<div class="card-body">
			<div class="form-group row">
				<table class="data_table table table-bordered table-hover display nowrap" width="100%">
					<?php
					$Get_Fields_Components = Building_Fields_Components_Views($RC_Customs->Forms_id, $RC_Customs->components_id,'All','All','All','All');
					foreach ($Get_Fields_Components as $GFC)
					{

						if($GFC['Fields_Type_Components'] == 'Fields'){

							$Get_Fields = Get_Fields(array("Fields_id"=>$GFC['Fields_id']))->row();

							if($Get_Fields->Fields_Type_Fields == 'file_multiple' or $Get_Fields->Fields_Type_Fields == 'file') {
							?>

								<table class="data_table table table-bordered table-hover display nowrap" width="100%">
									<thead>
									<tr>
										<th class="text-center">اسم الملف</th>
										<th class="text-center">تحميل</th>
										<th class="text-center">بواسطة / التاريخ</th>
									</tr>
									</thead>
									<tbody>
									<?php
									$i=0;
									$Get_Transaction_files = Get_Transaction_files(array("Transaction_id"=>$Transactions->transaction_id));
									if($Get_Transaction_files->num_rows()>0){

										foreach ($Get_Transaction_files->result() as $File)
										{
										?>
										<tr>
											<td class="text-center"><?= $File->raw_name ?></td>
											<td class="text-center"><?= $this->aauth->get_user($File->file_createBy)->full_name ?></td>
											<td class="text-center"><?= date('Y-m-d',$File->file_createDate) ?></td>
										</tr>
										<?php
										} // foreach

									}else{
										echo 'لا يوجد مرفقات ';
									}
									?>
									</tbody>
								</table>

							<?php
							}else{

								?>
								<tr>
									<td><?= $GFC['Fields_Title'] ?></td>
									<td>
										<?php
										$Transaction_data_by_key = Transaction_data_by_key($Transactions->transaction_id,$GFC['Forms_id'],$GFC['components_id'],$GFC['Fields_key']);
										if($Transaction_data_by_key == false){
											echo 'غير مدخل';
										}else{
											echo $Transaction_data_by_key;
										}
										?>
									</td>
									<td></td>
								</tr>
								<?php
							}


						}elseif($GFC['Fields_Type_Components'] == 'List'){

							$d = Transaction_data_by_key($Transactions->transaction_id,$GFC['Forms_id'],$GFC['components_id'],$GFC['Fields_key']);
							?>
							<tr>
								<td><?= $GFC['Fields_Title'] ?></td>
								<td><?= get_data_options_List_view($GFC['Fields_id'],$d); ?></td>
								<td></td>
							</tr>
							<?php


						}
					} // foreach ($Get_Fields_Components as $GFC)
					?>
				</table>

			</div><!-- <div class="form-group row"> -->
		</div>
		<!--begin::Body-->
	</div><!--<div class="card card-custom mt-10">-->
	<?php
} // foreach ($Form_Components_Customs->result() AS $RC_Customs)
?>





