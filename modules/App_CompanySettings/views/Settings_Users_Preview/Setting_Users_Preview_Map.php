

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

		</div>
		<!--end::Toolbar-->
	</div>
</div>
<!--end::Subheader-->


<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
	<!--begin::Container-->
	<div class="container-fluid">

		<div class="row">
			<div class="col-lg-12 mt-5">
				<div class="card card-custom">
					<div class="card-body">
						<?php echo  $this->session->flashdata('message'); ?>

						<?php
						if($Users_Preview == false){
							$msg_result['key'] = 'Danger';
							$msg_result['value'] = 'لا يوجد مستخدمين بصلاحيات معاين ';
							$msg_result_view = Create_Status_Alert($msg_result);
							echo $msg_result_view;
						}else{
							?>

							<style>th.dt-center,.dt-center { text-align: center; }</style>
							<table class="data_table table table-bordered table-hover display nowrap" width="100%">
								<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">المعاين</th>
									<th class="text-center">المنطقة</th>
									<th class="text-center">المدينة</th>
									<th class="text-center">الخيارات</th>
								</tr>
								</thead>
								<tbody>
								<?php
								$i = 0;

								foreach ($Users_Preview AS $Row)
								{

									$where_Assignment = array(
										"users_preview_id" => $Row->users_id,
										"company_id"       => app()->aauth->get_user()->company_id
									);
									$Get_Assignment_Map_users_preview = Get_Assignment_Map_users_preview($where_Assignment);

									if($Get_Assignment_Map_users_preview->num_rows()>0){

										$Map_users_preview = $Get_Assignment_Map_users_preview->row();
										$Get_Regions = Get_Regions(194,$Map_users_preview->regions_id)->row();
										$Get_City    = Get_City(194,$Map_users_preview->regions_id,$Map_users_preview->city_id)->row();

									}else{
										$msg_result['key'] = 'Danger';
										$msg_result['value'] = 'لم يتم تحديد النطاق الجغرافي للمستخدم ';
										$msg_result_view = Create_Status_Alert($msg_result);
										echo $msg_result_view;
									}

									?>
									<tr>
										<td class="text-center"><?= ++$i ?></td>
										<td class="text-center"><?= $Row->full_name ?></td>
										<td class="text-center"><?= @$Get_Regions->name_ar ?></td>
										<td class="text-center"><?= @$Get_City->name_ar ?></td>
										<td class="text-center">
											<?php
											$options_transaction['Assignment'] = array(
													"class"          => '',
													"id"             => '',
													"title"          => ' المنطقة الجغرافية',
													"data-attribute" => '',
													"icon"           => '',
													"href"           => base_url(APP_NAMESPACE_URL.'/Settings_Preview/Update_Set_Users_Preview_Map/'.$Row->users_id)
											);
											echo Create_Options_Button($options_transaction)
											?>
										</td>
									</tr>
									<?php
								}
								?>
								</tbody>
							</table>
							<!--begin: Datatable -->
							<?php
						}
						?>

					</div>
				</div>
			</div><!--<div class="col-lg-12 mt-5">-->
		</div>

	</div>
	<!--end::Container-->
</div>
<!--end::Entry-->




