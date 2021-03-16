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

	        <input type="hidden" value="" name="Transactions_uuid">

	        <div class="card card-custom mt-10">
		        <div class="card-header">
			        <div class="card-title">
				        <span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
				        <h3 class="card-label">بيانات الصك </h3>
			        </div>
			        <div class="card-toolbar">
				        <?= Create_One_Button_Text(array('title'=> 'استعلام عن الصك' ,'href'=> '')) ?>
			        </div>
		        </div>
                <div class="card-body">
                    <div class="card-body">

                        <div class="form-group row">
                            <div class="col-lg-6 mt-5">
                                <label> كتابة عدل </label>

                            </div>
	                        <div class="col-lg-6 mt-5">
		                        <?= Creation_Field_HTML_input('PropertyID') ?>
	                        </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-3 mt-5">
                                <?= Creation_Field_HTML_input('INSTRUMENT_NUMBER') ?>
                            </div>
                            <div class="col-lg-3 mt-5">
                                <?= Creation_Field_HTML_input('SCHEME_NUMBER') ?>
                            </div>
                            <div class="col-lg-3 mt-5">
                                <?= Creation_Field_HTML_input('BLOCK_NUMBER') ?>
                            </div>
                            <div class="col-lg-3 mt-5">
                                <?= Creation_Field_HTML_input('PART_NUMBER') ?>
                            </div>
                        </div>

	                    <div class="separator separator-dashed separator-border-2 mt-5 mb-5"></div>

	                    <div class="form-group row">
		                    <p class="font-size-h5"> <i class="flaticon2-map"></i>  المساحة و الحدود</p>
	                    </div>

                        <div class="form-group row">
                            <div class="col-lg-3 mt-5">
                                <?= Creation_Field_HTML_input('NORTHERN_BORDER') ?>
                            </div>
                            <div class="col-lg-3 mt-5">
                                <label> بطول </label>
                                <?= Creation_Field_HTML_input('NORTHERN_BORDER_LENGTH') ?>
                            </div>
                            <div class="col-lg-3 mt-5">
                                <?= Creation_Field_HTML_input('SOUTHERN_BORDER') ?>
                            </div>
                            <div class="col-lg-3 mt-5">
                                <?= Creation_Field_HTML_input('SOUTHERN_BORDER_LENGTH') ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-3 mt-5">
                                <?= Creation_Field_HTML_input('EASTERN_BORDER') ?>
                            </div>
                            <div class="col-lg-3 mt-5">
                                <label> بطول </label>
                                <?= Creation_Field_HTML_input('EASTERN_LENGTH') ?>
                            </div>
                            <div class="col-lg-3 mt-5">
                                <?= Creation_Field_HTML_input('WESTERN_BORDER') ?>
                            </div>
                            <div class="col-lg-3 mt-5">
                                <label> بطول </label>
                                <?= Creation_Field_HTML_input('WESTERN_LENGTH') ?>
                            </div>
                        </div>


                    </div>
                </div>
		        <div class="card-footer">
			        <div class="row">
				        <div class="col-lg-6">
					        <button type="submit"   class="btn btn-primary mr-2"> حفظ البيانات  </button>
				        </div>
				        <div class="col-lg-6 text-lg-right">
					        <a href="<?= base_url(APP_NAMESPACE_URL.'/Transactions/#') ?>" class="btn btn-danger"><?= lang('cancel_button') ?></a>
				        </div>
			        </div>
		        </div>
            </div>
        </form>


    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->


