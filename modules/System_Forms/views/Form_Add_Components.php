
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


					<div class="form-group row">
						<div class="col-lg-3 mt-5">
							<label> فئة العميل </label>
							<?= Creation_List_HTML('select', 'LIST_CUSTOMER_CATEGORY', '','','options', '1','','','',array( 0=> "selectpicker"),'','','') ?>
							<label class="checkbox mt-7">
								<input type="checkbox" value="1"  checked="checked" name="All_CUSTOMER_CATEGORY"/>
								<span></span>
								عام لجميع العملاء
							</label>
						</div>
						<div class="col-lg-3 mt-5">
							<label> فئة العقار </label>
							<?= Get_Select_Property_Types('select','','1', '','') ?>
							<label class="checkbox mt-5">
								<input type="checkbox" value="1"  checked="checked" name="All_Property_Types"/>
								<span></span>
								عام لجميع العقارات
							</label>
						</div>
						<div class="col-lg-3 mt-5">
							<label> فئة الطلب </label>
							<?= Creation_List_HTML('select', 'LIST_TYPES_OF_REAL_ESTATE_APPRAISAL', '','','options', '1','','','',array( 0=> "selectpicker"),'','','') ?>

							<label class="checkbox mt-7">
								<input type="checkbox" value="1"  checked="checked" name="All_TYPES_APPRAISAL"/>
								<span></span>
								عام لجميع الطلبات
							</label>
						</div>
						<div class="col-lg-3 mt-5">
							<label> طريقة  التقييم </label>
							<?= Get_Select_evaluation_methods('select', '',1, '','evaluation_methods') ?>
							<label class="checkbox mt-5">
								<input type="checkbox" value="1"  checked="checked" name="All_evaluation_methods"/>
								<span></span>
								عام طرق التقييم
							</label>
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



