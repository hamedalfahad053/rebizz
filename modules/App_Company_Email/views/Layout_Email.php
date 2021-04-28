<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
	<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
		<!--begin::Info-->
		<div class="d-flex align-items-center flex-wrap mr-1">
			<!--begin::Mobile Toggle-->
			<button class="burger-icon burger-icon-left mr-4 d-inline-block d-lg-none" id="kt_subheader_mobile_toggle">
				<span></span>
			</button>
			<!--end::Mobile Toggle-->
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

<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">


	<!--begin::Entry-->
	<div class="d-flex flex-column-fluid">
		<!--begin::Container-->
		<div class="container-fluid">
			<!--begin::Profile 2-->
			<div class="d-flex flex-row">


				<!--begin::Aside-->
				<div class="flex-row-auto offcanvas-mobile w-300px w-xl-350px" id="kt_profile_aside">
					<!--begin::Card-->
					<div class="card card-custom">
						<!--begin::Body-->
						<div class="card-body pt-15">

							<!--begin::Nav-->

							<a href="<?= base_url(ADMIN_NAMESPACE_URL.'/Email/New_Message_Group') ?>" class="mb-10 btn btn-block btn-primary font-weight-bold text-uppercase py-4 px-6 text-center">ارسال رسالة جديدة</a>


							<a href="<?= base_url(ADMIN_NAMESPACE_URL.'/Email') ?>" class="text-left btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 btn-block"><i class="flaticon-multimedia"></i> البريد الوارد  </a>
							<div class="separator separator-dashed my-1"></div>
							<a href="<?= base_url(ADMIN_NAMESPACE_URL.'/Email/Outbox') ?>" class="text-left btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 btn-block"><i class="flaticon-paper-plane-1"></i> البريد الصادر </a>
							<div class="separator separator-dashed my-1"></div>
							<a href="<?= base_url(ADMIN_NAMESPACE_URL.'/Email/archive_Message') ?>" class="text-left btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 btn-block"><i class="flaticon-envelope"></i> الارشيف </a>
							<div class="separator separator-dashed my-1"></div>
							<!--end::Nav-->

						</div>
						<!--end::Body-->
					</div>
					<!--end::Card-->
				</div>
				<!--end::Aside-->

				<!--begin::Content-->
				<div class="flex-row-fluid ml-lg-8">

					<!--begin::Row-->
					<div class="row">
						<div class="col-lg-12">
							<?= $Page ?>
						</div>
					</div>
					<!--end::Row-->

				</div>
				<!--end::Content-->

			</div>
			<!--end::Profile 2-->
		</div>
		<!--end::Container-->
	</div>
	<!--end::Entry-->

</div>
<!--end::Content-->


<script type="text/javascript">
	var _initAside = function () {
		offcanvas = new KTOffcanvas('kt_profile_aside', {
			overlay: true,
			baseClass: 'offcanvas-mobile',
			toggleBy: 'kt_subheader_mobile_toggle'
		});
	}

	var _initForm = function() {
		avatar = new KTImageInput('kt_profile_avatar');
	}

	_initAside();
	_initForm();

</script>
