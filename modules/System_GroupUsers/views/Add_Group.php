

<style type="text/css">
    .dropdown-toggle {
        padding-right: 5px !important;
    }
    .bootstrap-select.btn-group,.dropdown-toggle,.filter-option,.filter-option-inner-inner{
        text-align: right !important;
    }

    .bootstrap-select.btn-group .dropdown-toggle .caret {
        left: 12px !important;
        right: unset !important;;
    }
</style>


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
                        <i class="flaticon-users-1 text-primary"></i>
                    </span>
                    <h3 class="card-label"><?= lang('add_new_group_button') ?></h3>
                </div>
            </div>
            <div class="card-body">

                <form class="form" name="" action="<?= base_url(ADMIN_NAMESPACE_URL.'/Group_Users/Create_Group') ?>" method="post">
                    <?= CSFT_Form() ?>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-lg-6 mt-5">
                                <label><?= lang('name_group') ?></label>
                                <input type="text" name="name_group" class="form-control" placeholder="<?= lang('name_group') ?>"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6 mt-5">
                                <label><?= lang('owner_group') ?> </label>
                                <select name="owner_group"  class="form-control selectpicker" data-live-search="true">
                                    <?php
                                    foreach ($Users AS $RG)
                                    {
                                        echo '<option value="'.$RG['User_id'].'">'.$RG['User_name'].' - '.$RG['User_Email'].' </option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-6 mt-5">
                                <label><?= lang('Status_group') ?> </label>
                                <select name="Status_group" class="form-control selectpicker" data-live-search="true">
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