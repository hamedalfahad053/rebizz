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





    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">



            <!--Start  ::Base  Status Transaction-->
	        <div class="row">
		        <div class="col-xl-3">
			        <!--begin::Stats Widget 29-->
			        <div class="card card-custom bg-success card-stretch gutter-b">
				        <!--begin::Body-->
				        <div class="card-body">
							<span class="svg-icon svg-icon-primary svg-icon-2x">
								<img src="<?= BASE_ASSET.'media/svg/icons/Devices/Display1.svg'; ?>" height="48" width="48"/>
							</span>
					        <span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">28</span>
					        <span class="font-weight-bold text-dark-75 font-size-sm">معاملات جارية</span>
				        </div>
				        <!--end::Body-->
			        </div>
			        <!--end::Stats Widget 29-->
		        </div>
		        <div class="col-xl-3">
			        <!--begin::Stats Widget 30-->
			        <div class="card card-custom bg-info card-stretch gutter-b">
				        <!--begin::Body-->
				        <div class="card-body">
							<span class="svg-icon svg-icon-primary svg-icon-2x">
								<img src="<?= BASE_ASSET.'media/svg/icons/Shopping/Calculator.svg'; ?>" height="48" width="48"/>
							</span>
					        <span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block">54</span>
					        <span class="font-weight-bold text-white font-size-sm">تحت التقييم </span>
				        </div>
				        <!--end::Body-->
			        </div>
			        <!--end::Stats Widget 30-->
		        </div>
		        <div class="col-xl-3">
			        <!--begin::Stats Widget 31-->
			        <div class="card card-custom bg-danger card-stretch gutter-b">
				        <!--begin::Body-->
				        <div class="card-body">
					        <span class="svg-icon svg-icon-primary svg-icon-2x">
								<img src="<?= BASE_ASSET.'media/svg/icons/Media/Repeat.svg'; ?>" height="48" width="48"/>
							</span>
					        <span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block">50</span>
					        <span class="font-weight-bold text-white font-size-sm">تحت المراجعة</span>
				        </div>
				        <!--end::Body-->
			        </div>
			        <!--end::Stats Widget 31-->
		        </div>
		        <div class="col-xl-3">
			        <!--begin::Stats Widget 32-->
			        <div class="card card-custom bg-dark card-stretch gutter-b">
				        <!--begin::Body-->
				        <div class="card-body">
					        <span class="svg-icon svg-icon-primary svg-icon-2x">
								<img src="<?= BASE_ASSET.'media/svg/icons/General/Settings-1.svg'; ?>"  height="48" width="48"/>
							</span>
					        <span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 text-hover-primary d-block">23</span>
					        <span class="font-weight-bold text-white font-size-sm">للاعتماد</span>
				        </div>
				        <!--end::Body-->
			        </div>
			        <!--end::Stats Widget 32-->
		        </div>
	        </div>
	        <!--End ::Base  Status Transaction-->





	        <!--Start ::Base Table Data-->
	        <div class="row">
		        <div class="col-lg-12">
			        <!--begin: Card Contract basic information-->
			        <div class="card card-custom card-stretch gutter-b">
				        <!--begin::Header-->
				        <div class="card-header">
					        <div class="card-title">
			                    <span class="card-icon">
			                        <i class="flaticon-squares text-primary"></i>
			                    </span>
						        <h3 class="card-label">احدث المعاملات</h3>
					        </div>
					        <div class="card-toolbar"></div>
				        </div>
				        <!--end::Header-->
				        <!--begin::Body-->
				        <div class="card-body">
					        <table class="data_table table table-bordered table-hover display nowrap" width="100%">
						        <thead>
						        <tr>
							        <th class="text-center">رقم المعاملة</th>
							        <th class="text-center">طالب التقييم والمالك</th>
							        <th class="text-center">حالة المعاملة</th>
							        <th class="text-center">موقع العقار</th>
							        <th class="text-center">بواسطة</th>
							        <th class="text-center">الخيارات</th>
						        </tr>
						        </thead>
						        <tbody>
							        <tr>
								        <td class="text-center"></td>
								        <td class="text-center"></td>
								        <td class="text-center"></td>
								        <td class="text-center"></td>
								        <td class="text-center"></td>
								        <td class="text-center"></td>
							        </tr>
						        </tbody>
					        </table>
					        <!--begin: Datatable -->
				        </div>
				        <!--end: Card Body-->
			        </div>
			        <!--end: Card Contract basic information-->
		        </div>
	        </div>
	        <!--End ::Base Table Data-->








        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->






