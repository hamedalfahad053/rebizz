
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


		<div class="card card-custom">

				<div class="card-header">
					<div class="card-title">
	                    <span class="card-icon">
	                        <i class="flaticon-squares text-primary"></i>
	                    </span>
						<h3 class="card-label"><?= $Page_Title ?></h3>
					</div>
					<div class="card-toolbar">
					</div>
				</div>

				<form class="form"  action="<?= base_url(ADMIN_NAMESPACE_URL.'/Forms/Create_Components') ?>" method="post">
				<?= CSFT_Form() ?>


				<div class="card-body">
                       <input type="hidden" name="Forms_id" value="<?= $this->uri->segment(4); ?>">
	                   <div class="form-group row">
		                    <div class="col-lg-4 mt-5">
			                    <label>العنوان باللغة العربية</label>
			                    <input type="text" id="Sections_title_ar" name="Sections_title_ar" class="form-control" placeholder=""/>
		                    </div>
		                    <div class="col-lg-4 mt-5">
			                    <label>العنوان باللغة الانجليزية</label>
			                    <input type="text" id="Sections_title_en" name="Sections_title_en" class="form-control" placeholder=""/>
		                    </div>
		                    <div class="col-lg-4 mt-5">
			                    <label> الحالة </label>
			                    <select id="Sections_Status" name="Sections_Status" class="form-control selectpicker" data-live-search="true"  data-title="اختر من فضلك ">
				                    <?php
				                    foreach ($status AS $key => $value)
				                    {
					                    echo '<option value="'.$key.'">'.$value.'</option>';
				                    }
				                    ?>
			                    </select>
		                    </div>
	                    </div>
                </div>

				<div class="card-footer">
					<div class="row">
						<div class="col-lg-12">
							<button type="submit"  class="btn btn-primary mr-2"><?= lang('add_button') ?></button>
						</div>
					</div>
				</div>
            </form>

	</div>

</div>
<!--end::Container-->
</div>
<!--end::Entry-->



