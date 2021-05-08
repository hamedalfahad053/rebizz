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


		<form class="form" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Settings_Preview/Update_Set_Fees_Preview') ?>" method="post">
			<?= CSFT_Form() ?>
			<input type="hidden" name="Users_Preview_id" value="<?= $Users_Preview->user_uuid ?>">
			<div class="row">
				<div class="col-lg-12 mt-5">
					<div class="card card-custom">

						<div class="card-body">

							<?php echo  $this->session->flashdata('message'); ?>

							<?php
							$query_users_preview_map  = app()->db->where('users_preview_id',$Users_Preview->id);
							$query_users_preview_map  = app()->db->get('protal_users_preview_map');

							if($query_users_preview_map->num_rows()>0){

								$query_users_preview_map  = $query_users_preview_map->row();

								$Get_Regions = Get_Regions(194,$query_users_preview_map->regions_id)->row();
								$Get_City    = Get_City(194,$query_users_preview_map->regions_id,$query_users_preview_map->city_id)->row();

							}
							?>
							<table class="table table-bordered table-hover display nowrap" width="100%">
								<thead>
								<tr>
									<th class="text-center bg-light-primary">المعاين</th>
									<th class="text-center bg-light-primary">المنطقة</th>
									<th class="text-center bg-light-primary">المدينة</th>
								</tr>
								</thead>
								<tbody>
								<tr>
									<th class="text-center"><?= $Users_Preview->full_name ?></th>
									<th class="text-center"><?= @$Get_Regions->name_ar ?></th>
									<th class="text-center"><?= @$Get_City->name_ar ?></th>
								</tbody>
							</table>
							<style>th.dt-center,.dt-center { text-align: center; }</style>
							<table class="data_table table table-bordered table-hover display nowrap" width="100%">
								<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">نوع العقار</th>
									<th class="text-center">اتعاب الزيارة</th>
								</tr>
								</thead>
								<tbody>

								<?php
								$i = 0;

								foreach ($Property_Types AS $Row)
								{


									$query_preview_fees = app()->db->where('company_id',$this->aauth->get_user()->company_id);
									$query_preview_fees = app()->db->where('preview_fees_userid',$Users_Preview->id);
									$query_preview_fees = app()->db->where('preview_fees_property_types_id',$Row->Property_Types_id);
									$query_preview_fees = app()->db->get('protal_users_preview_fees');

									if($query_preview_fees->num_rows()>0){

										if($query_preview_fees->row()->preview_fees_amount !=0){
											$preview_fees_amount = $query_preview_fees->row()->preview_fees_amount;
										}else{
											$preview_fees_amount = 0;
										}

									}else{
										$preview_fees_amount = 0;
									}

									?>

									<tr>
										<td class="text-center"><?= ++$i ?></td>
										<td class="text-center"><?= $Row->item_translation ?></td>
										<td class="text-center">
											<input type="hidden" name="Property_Types_id[]" value="<?= $Row->Property_Types_uuid ?>">
											<input type="number" name="Amount_Preview[]" class="form-control" value="<?= $preview_fees_amount ?>" placeholder="حدد القيمة رقماً">
										</td>
									</tr>
									<?php
								}
								?>
								</tbody>
							</table>
						</div>
						<div class="card-footer">
							<div class="row">
								<div class="col-lg-6">
									<button type="submit" class="btn btn-primary  mr-2">تحديث</button>
								</div>
								<div class="col-lg-6 text-lg-right">
								</div>
							</div>
						</div>

					</div>
				</div><!--<div class="col-lg-12 mt-5">-->
			</div>
		</form>


	</div>
	<!--end::Container-->
</div>
<!--end::Entry-->

