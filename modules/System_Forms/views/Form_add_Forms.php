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
            <div class="card-body">

                <form class="form" name="" action="<?= base_url(ADMIN_NAMESPACE_URL.'/Forms/Create_Forms') ?>" method="post">
                    <?= CSFT_Form() ?>
                    <div class="card-body">

                        <div class="form-group row">
                            <div class="col-lg-6 mt-5">
                                <label>العنوان بالعربية</label>
                                <input type="text" name="title_ar" class="form-control" placeholder="<?= lang('user_full_name_ar') ?>"/>
                            </div>
                            <div class="col-lg-6 mt-5">
                                <label>العنوان بالانجليزية</label>
                                <input type="text" name="title_en" class="form-control" placeholder="<?= lang('user_full_name_en') ?>"/>
                            </div>
                        </div>

	                    <div class="form-group row">
		                    <div class="col-lg-4">
			                    <label>نوع التقييم</label>
			                    <select name="evaluation_types" class="form-control selectpicker" data-live-search="true">
                                    <?php
                                    $evaluation_types = Get_Evaluation_Types()->result();
                                    foreach ($evaluation_types AS $row_et)
                                    {
                                        echo '<option value="'.$row_et->evaluation_types_id.'">'.$row_et->item_translation.'</option>';
                                    }
                                    ?>
			                    </select>
		                    </div>

                            <div class="col-lg-4">
                                <label><?= lang('Table_Status') ?> </label>
                                <select name="Status" class="form-control selectpicker" data-live-search="true">
                                    <?php
                                    foreach ($status AS $key => $value)
                                    {
                                        echo '<option value="'.$key.'">'.$value.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label><?= lang('Basic_System') ?> </label>
                                <select name="status_system"  class="form-control selectpicker" data-live-search="true">
                                    <?php
                                    foreach ($status_system AS $key => $value)
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
                            <div class="col-lg-6">
                                <button type="submit" class="btn btn-primary mr-2"><?= lang('add_button') ?></button>
                            </div>
                            <div class="col-lg-6 text-lg-right">
                                <button type="reset" class="btn btn-danger"><?= lang('cancel_button') ?></button>
                            </div>
                        </div>
                    </div>

                </form>




            </div>
        </div>



    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->