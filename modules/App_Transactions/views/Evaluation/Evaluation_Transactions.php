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
            <a href="<?= base_url(APP_NAMESPACE_URL . '/Transactions/View_Transaction/'.$this->uri->segment(4)) ?>" class="btn btn-success">
                <i class="flaticon2-arrow"></i>   العودة للمعاملة
            </a>
        </div>
        <!--end::Toolbar-->

    </div>
</div>

<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
	<!--begin::Container-->
	<div class="container-fluid">


		<div class="card card-custom mb-5 mt-10">

			<div class="card-header">
				<div class="card-title">
					<span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
					<h3 class="card-label">طريقة التقييم </h3>
				</div>
				<div class="card-toolbar">
				</div>
			</div>

				<div class="card-body">





				</div>


		</div>

	</div>
</div>


