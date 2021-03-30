

<?php
$Customs_With_CLIENT            = Transaction_data_by_key($Transactions->transaction_id,'LIST_CLIENT');
$Customs_With_Type_CUSTOMER     = Transaction_data_by_key($Transactions->transaction_id,'LIST_CUSTOMER_CATEGORY');
$Customs_With_Type_Property     = Transaction_data_by_key($Transactions->transaction_id,'LIST_TYPE_OF_PROPERTY');
$Customs_With_TYPES_APPRAISAL   = Transaction_data_by_key($Transactions->transaction_id,'LIST_TYPES_OF_REAL_ESTATE_APPRAISAL');

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
								$this->load->view('../../modules/App_Transactions/views/tamplet/tamplet_row_transaction_files',$data_files);
							}else{
								?>
								<tr>
									<td><?= $GFC['Fields_Title'] ?></td>
									<td><?= Transaction_data_by_key($Transactions->transaction_id,$GFC['Fields_key']) ?></td>
									<td><button type="button" class="btn btn-icon btn-sm btn-light-warning mx-2" data-toggle="modal" data-target="#exampleModalCenter"><i class="la la-edit"></i></button>
								</tr>
								<?php
							}


						}elseif($GFC['Fields_Type_Components'] == 'List'){

							$d = Transaction_data_by_key($Transactions->transaction_id,$GFC['Fields_key']);
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


<?php
$Customs_With_CLIENT            = Transaction_data_by_key($Transactions->transaction_id,'LIST_CLIENT');
$Customs_With_Type_CUSTOMER     = Transaction_data_by_key($Transactions->transaction_id,'LIST_CUSTOMER_CATEGORY');
$Customs_With_Type_Property     = Transaction_data_by_key($Transactions->transaction_id,'LIST_TYPE_OF_PROPERTY');
$Customs_With_TYPES_APPRAISAL   = Transaction_data_by_key($Transactions->transaction_id,'LIST_TYPES_OF_REAL_ESTATE_APPRAISAL');

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
								$data_files['Get_Transaction_files'] = Get_Transaction_files(array("Transaction_id"=>$Transactions->transaction_id))->result();
								$this->load->view('../../modules/App_Transactions/views/tamplet/tamplet_row_transaction_files',$data_files);
							}else{
								?>
								<tr>
									<td><?= $GFC['Fields_Title'] ?></td>
									<td><?= Transaction_data_by_key($Transactions->transaction_id,$GFC['Fields_key']) ?></td>
									<td><button type="button" class="btn btn-icon btn-sm btn-light-warning mx-2" data-toggle="modal" data-target="#exampleModalCenter"><i class="la la-edit"></i></button>
								</tr>
								<?php
							}


						}elseif($GFC['Fields_Type_Components'] == 'List'){

							$d = Transaction_data_by_key($Transactions->transaction_id,$GFC['Fields_key']);
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





