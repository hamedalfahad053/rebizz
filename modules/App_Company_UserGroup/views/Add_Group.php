


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

        <form class="form" name="" action="<?= base_url(ADMIN_NAMESPACE_URL.'/Group_Users/Create_Group') ?>" method="post">
            <?= CSFT_Form() ?>


            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon-users-1 text-primary"></i>
                        </span>
                        <h3 class="card-label"><?= lang('add_new_group_button') ?></h3>
                    </div>
                </div>
                <div class="card-body">
                        <div class="form-group row">
                            <div class="col-lg-4 mt-5">
                                <label><?= lang('name_group_ar') ?></label>
                                <input type="text" name="name_group_ar" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label><?= lang('name_group_en') ?></label>
                                <input type="text" name="name_group_en" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                            <div class="col-lg-4 mt-5">
                                <label><?= lang('Status_group') ?> </label>
                                <select name="Status_group" class="form-control selectpicker" data-live-search="true"  data-title="اختر من فضلك ">
                                    <?php
                                    foreach ($options_status_group AS $key => $value)
                                    {
                                        echo '<option value="'.$key.'">'.$value.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
            </div>
        </div>


            <div class="card card-custom mt-10">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon-users-1 text-primary"></i>
                        </span>
                        <h3 class="card-label">صلاحيات المجموعة</h3>
                    </div>
                </div>
            </div>


            <?php
            foreach ($Permissions AS $Row)
            {
            ?>
            <div class="col-lg-4  mt-10">
                <!--begin::List Widget 5-->
                <div class="card card-custom card-stretch gutter-b">
                    <!--begin::header-->
                    <div class="card-header border-0">
                        <h3 class="card-title font-weight-bolder"><?= $Row['Controllers_title'] ?></h3>
                    </div>
                    <!--end::header-->
                    <!--begin::Body-->
                    <div class="card-body pt-0">
                        <?php
                        foreach ($Row['controllers_functions'] AS $Row_F)
                        {
                        ?>
                        <!--begin::Item-->
                        <div class="d-flex align-items-center mb-3">
                            <!--begin::Checkbox-->
                            <label class="checkbox checkbox-lg checkbox-primary flex-shrink-0 m-0 mr-4">
                                <input type="checkbox" value="1">
                                <span></span>
                            </label>
                            <!--end::Checkbox-->
                            <!--begin::Text-->
                            <div class="d-flex flex-column flex-grow-1 py-2">
                                <a href="#" class="text-dark-75 font-weight-bold text-hover-primary font-size-lg mb-1"><?= $Row_F['functions_title'] ?></a>
                            </div>
                            <!--end::Text-->
                        </div>
                        <!--end::Item-->
                        <?php
                        }
                        ?>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::List Widget 5-->
            </div>
            <?php
            }
            ?>



        </form>


    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->