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

		<div class="card card-custom mt-10">
			<!--begin::Body-->
			<div class="card-body">

				<?php echo  $this->session->flashdata('message'); ?>

				<form class="form" id="Form_Create_Transaction" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Settings_Transaction/Create_Receipt_Transactions_Setting') ?>" enctype="multipart/form-data" method="post">
					<?= CSFT_Form() ?>
					<!--begin::Body-->
					<div class="card-body">


						<div class="form-group row">

							<div class="col-lg-4 mt-5">
								<label>حجم النص</label>

							</div>

							<div class="col-lg-4 mt-5">
								<label>لون النص</label>

							</div>

							<div class="col-lg-4 mt-5">
								<label>ظل </label>

							</div>
							<div class="col-lg-4 mt-5">
								<label>لون الظل </label>

							</div>
							<div class="col-lg-4 mt-5">
								<label>مقاس الظل </label>

							</div>

							<div class="col-lg-4 mt-5">
								<label>موقع النص</label>

							</div>

							<div class="col-lg-4 mt-5">
								<label>تباعد النص</label>

							</div>


						</div>
					</div>
					<!--end: Card Body-->
					<div class="card-footer">
						<div class="row">
							<div class="col-lg-6">
								<button type="submit" class="btn btn-primary mr-2">تحديث</button>
							</div>
							<div class="col-lg-6 text-lg-right">

							</div>
						</div>
					</div>
				</form>




			</div>
			<!--end: Card Body-->
		</div><!--<div class="card card-custom mt-10">-->

	</div>
	<!--end::Container-->
</div>
<!--end::Entry-->

