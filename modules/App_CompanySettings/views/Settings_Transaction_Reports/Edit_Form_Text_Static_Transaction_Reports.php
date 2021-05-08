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
                    <div class="card-header">
                        <div class="card-title">
                            <span class="card-icon">
                                <i class="flaticon-squares text-primary"></i>
                            </span>
                            <h3 class="card-label"><?= $Page_Title ?></h3>
                        </div>
                        <div class="card-toolbar"></div>
                    </div>
                    <div class="card-body">
                        <form class="form" action="<?= base_url(APP_NAMESPACE_URL.'/Settings_Transaction_Reports/Update_Text_Static_Transaction_Reports/'.$this->uri->segment(4)) ?>" method="post">
                            <?= CSFT_Form() ?>

	                        <?php echo  $this->session->flashdata('message'); ?>

	                        <input type="hidden" name="text_uuid" value="<?= $this->uri->segment(4) ?>">
                            <div class="form-group row">

                                <div class="col-lg-6 mt-5">
                                    <label>عنوان  النص بالعربية</label>
                                    <input type="text" name="title_ar" value="<?=  $text_static->title_ar;  ?>" class="form-control" placeholder="<?= lang('Global_form_title_ar') ?>"/>
                                </div>
                                <div class="col-lg-6 mt-5">
	                                <label>عنوان  النص بالانجليزية</label>
                                    <input type="text" name="title_en" value="<?=  $text_static->title_en;  ?>"  class="form-control" placeholder="<?= lang('Global_form_title_ar') ?>"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-12 mt-5">
                                    <label>النص بالعربية </label>
	                                <textarea name="text_ar" class="summernote" ><?=  $text_static->text_ar;  ?></textarea>
                                </div>
                            </div>

	                        <div class="form-group row">
		                        <div class="col-lg-12 mt-5">
			                        <label>النص بالانجليزية </label>
			                        <textarea name="text_en" class="summernote" ><?=  $text_static->text_en;  ?></textarea>
		                        </div>
	                        </div>


	                        <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <button type="submit" id="buttonCreateSections" class="btn btn-primary mr-2">تحديث</button>
                                    </div>
                                    <div class="col-lg-6 text-lg-right">

                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div><!--<div class="col-lg-12 mt-5">-->



        </div>

    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->