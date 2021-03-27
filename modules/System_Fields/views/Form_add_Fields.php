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
                        <form class="form" action="<?= base_url(ADMIN_NAMESPACE_URL.'/Fields/Create_Fields') ?>" method="post">
                            <?= CSFT_Form() ?>
                            <div class="form-group row">
                                <div class="col-lg-4 mt-5">
                                    <label><?= lang('Global_form_title_ar') ?></label>
                                    <input type="text" name="title_ar" class="form-control" placeholder="<?= lang('Global_form_title_ar') ?>"/>
                                </div>
                                <div class="col-lg-4 mt-5">
                                    <label><?= lang('Global_form_title_en') ?></label>
                                    <input type="text" name="title_en" class="form-control" placeholder="<?= lang('Global_form_title_en') ?>"/>
                                </div>



                                <div class="col-lg-4 mt-5">
                                    <label><?= lang('Type_Fields') ?></label>
                                    <select name="Type_Fields" id="Type_Fields"  class="form-control selectpicker" title="الرجاء إختيار نوع الحقل">
                                        <?php
                                        foreach ($Fields_Type AS $key => $value)
                                        {
                                            echo '<option value="'.$key.'">'.$value.'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

	                            <div class="col-lg-4 mt-5">
		                            <label>فئة الحقل</label>
		                            <?= Creation_List_HTML('select', 'LIST_FORM_TYPE', '','','options', '','','','',array( 0=> "selectpicker"),'','','') ?>
	                            </div>

	                            <div class="col-lg-4  mt-5">
		                            <label> هل النموذج يظهر بالاعدادت للشركات </label>
		                            <select name="Fields_view_company" class="form-control selectpicker" title="<?= lang("Select_noneSelectedText") ?>" data-live-search="true">
			                            <option value="0">لا</option>
			                            <option value="1">نعم</option>
		                            </select>
	                            </div>



	                            <div class="col-lg-4 mt-5">
                                    <label>حالة الحقل</label>
                                    <select name="status_Fields" id="Type_Fields"  class="form-control selectpicker" title="الرجاء اختر حالة الحقل">
                                        <?php
                                        foreach ($status AS $key => $value)
                                        {
                                            echo '<option value="'.$key.'">'.$value.'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-lg-4 mt-5">
                                    <label>حالة الحقل بالنظام</label>
                                    <select name="status_system" id="status_system"  class="form-control selectpicker" data-live-search="true" title="اختر حالة الحقل بالنظام">
                                        <?php
                                        foreach ($status_system AS $key => $value)
                                        {
                                            echo '<option value="'.$key.'">'.$value.'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                            </div>


                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <button type="submit" id="buttonCreateSections" class="btn btn-primary mr-2"><?= lang('add_button') ?></button>
                                    </div>
                                    <div class="col-lg-6 text-lg-right">
                                        <button type="reset" class="btn btn-danger"><?= lang('cancel_button') ?></button>
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



