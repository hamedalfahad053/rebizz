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

        <form class="form" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Transactions/Create_Transaction') ?>" enctype="multipart/form-data" method="post">
        <?= CSFT_Form() ?>

            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                                <span class="card-icon">
                                    <i class="flaticon-squares text-primary"></i>
                                </span>
                        <h3 class="card-label"> البيانات الاساسية للطلب </h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-body">

	                    <table class="data_table table table-bordered table-hover display nowrap" width="100%">
		                    <tr>
			                    <td class="text-center"> طريقة الاستلام</td>
			                    <td class="text-center"></td>
			                    <td class="text-center">رقم المعاملة</td>
			                    <td class="text-center"></td>
		                    </tr>
		                    <tr>
			                    <td class="text-center">وقت انشاء المعاملة</td>
			                    <td class="text-center"></td>
			                    <td class="text-center">تاريخ انشاء المعاملة</td>
			                    <td class="text-center"></td>
		                    </tr>


		                    <tr>
			                    <td class="text-center">فئة العميل</td>
			                    <td class="text-center"></td>
			                    <td class="text-center"> العميل</td>
			                    <td class="text-center"></td>
		                    </tr>

		                    <tr>
			                    <td class="text-center">رقم التكليف</td>
			                    <td class="text-center"></td>
			                    <td class="text-center">تاريخ / وقت التكليف</td>
			                    <td class="text-center"></td>
		                    </tr>
		                    <tr>
			                    <td class="text-center">الدولة</td>
			                    <td class="text-center"></td>
			                    <td class="text-center">المنطقة</td>
			                    <td class="text-center"></td>
		                    </tr>
		                    <tr>
			                    <td class="text-center">المدينة</td>
			                    <td class="text-center"></td>
			                    <td class="text-center"> الحي</td>
			                    <td class="text-center"></td>
		                    </tr>
	                    </table>
	                    <!--begin: Datatable -->


                    </div>
                </div>
            </div>


	        <div class="card card-custom mt-10">
		        <div class="card-header">
			        <div class="card-title">
                                <span class="card-icon">
                                    <i class="flaticon-interface-11 text-primary"></i>
                                </span>
				        <h3 class="card-label"> بيانات المالك / طالب التقييم  </h3>
			        </div>
		        </div>
		        <div class="card-body">
			        <div class="card-body">


			        </div>
		        </div>
	        </div>


	        <div class="card card-custom mt-10">
                <div class="card-header">
                    <div class="card-title">
                                <span class="card-icon">
                                    <i class="flaticon-interface-11 text-primary"></i>
                                </span>
                        <h3 class="card-label"> بيانات الصك  </h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-body">

                        <div class="form-group row">
                            <div class="col-lg-6 mt-5">
                                <label> كتابة عدل </label>
                                <?= Creation_Field_HTML_input('INSTRUMENT_NUMBER') ?>
                            </div>
                            <div class="col-lg-6 mt-5">
                                <label> رقم العقار </label>
                                <?= Creation_Field_HTML_input('INSTRUMENT_NUMBER') ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-3 mt-5">
                                <?= Creation_Field_HTML_input('INSTRUMENT_NUMBER') ?>
                            </div>
                            <div class="col-lg-3 mt-5">
                                <label> رقم المخطط </label>
                                <?= Creation_Field_HTML_input('INSTRUMENT_NUMBER') ?>
                            </div>
                            <div class="col-lg-3 mt-5">
                                <label> رقم البلك </label>
                                <?= Creation_Field_HTML_input('INSTRUMENT_NUMBER') ?>
                            </div>
                            <div class="col-lg-3 mt-5">
                                <label> رقم القطعة </label>
                                <?= Creation_Field_HTML_input('INSTRUMENT_NUMBER') ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-3 mt-5">
                                <label> الحد الشمالي </label>
                                <?= Creation_Field_HTML_input('INSTRUMENT_NUMBER') ?>
                            </div>
                            <div class="col-lg-3 mt-5">
                                <label> بطول </label>
                                <?= Creation_Field_HTML_input('INSTRUMENT_NUMBER') ?>
                            </div>
                            <div class="col-lg-3 mt-5">
                                <label> الحد الجنوبي </label>
                                <?= Creation_Field_HTML_input('INSTRUMENT_NUMBER') ?>
                            </div>
                            <div class="col-lg-3 mt-5">
                                <label> بطول </label>
                                <?= Creation_Field_HTML_input('INSTRUMENT_NUMBER') ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-3 mt-5">
                                <label> الحد الشرقي </label>
                                <?= Creation_Field_HTML_input('INSTRUMENT_NUMBER') ?>
                            </div>
                            <div class="col-lg-3 mt-5">
                                <label> بطول </label>
                                <?= Creation_Field_HTML_input('INSTRUMENT_NUMBER') ?>
                            </div>
                            <div class="col-lg-3 mt-5">
                                <label> الحد الغربي </label>
                                <?= Creation_Field_HTML_input('INSTRUMENT_NUMBER') ?>
                            </div>
                            <div class="col-lg-3 mt-5">
                                <label> بطول </label>
                                <?= Creation_Field_HTML_input('INSTRUMENT_NUMBER') ?>
                            </div>
                        </div>


                    </div>
                </div>
            </div>


            <div class="card card-custom mt-10">
                <div class="card-header">
                    <div class="card-title">
                                <span class="card-icon">
                                    <i class="flaticon-list-3 text-primary"></i>
                                </span>
                        <h3 class="card-label"> البيانات الاساسية للعقار </h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-body">

                        <div class="form-group row">
                            <div class="col-lg-3 mt-5">
                                <label> </label>

                            </div>
                            <div class="col-lg-3 mt-5">
                                <label> </label>

                            </div>
                            <div class="col-lg-3 mt-5">
                                <label>  </label>
                                <div class="col-lg-12 col-md-12 col-sm-12">

                                </div>
                            </div>
                            <div class="col-lg-3 mt-5">
                                <label> </label>

                            </div>
                        </div>


                    </div>
                </div>
            </div>


        </form>


    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->


