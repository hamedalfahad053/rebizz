<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">
            <!--begin::Page Heading-->
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <!--begin::Page Title-->
                <h5 class="text-dark font-weight-bold my-1 mr-5"><?= $Page_Title  ?></h5>
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
            <div class="col-lg-12">

                <form class="form"  action="<?= base_url(ADMIN_NAMESPACE_URL.'/System/Create_New_Functions') ?>" method="post">
                <?=  $this->session->flashdata('message'); ?>
                <?= CSFT_Form() ?>


                    <div class="card card-custom  mt-10">

                        <div class="card-header">
                            <div class="card-title">
                                <span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
                                <h3 class="card-label"><?= $Page_Title  ?> : <?= $Controllers->item_translation ?></h3>
                            </div>
                            <div class="card-toolbar"></div>
                        </div>

                        <div class="card-body">

                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label><?= lang('Global_form_title_ar') ?></label>
                                    <input type="text" name="title_ar" class="form-control" value="<?= set_value('title_ar'); ?>" placeholder="<?= lang('Global_form_title_ar') ?>"/>
                                </div>
                                <div class="col-lg-6">
                                    <label><?= lang('Global_form_title_en') ?></label>
                                    <input type="text" name="title_en" class="form-control" value="<?= set_value('title_en'); ?>" placeholder="<?= lang('Global_form_title_en') ?>"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label><?= lang('Functions_Code') ?></label>
                                    <input type="text" name="Functions_Code" class="form-control" value="<?= set_value('Controllers_Code'); ?>" placeholder="<?= lang('Controllers_Code') ?>"/>
                                </div>
                                <div class="col-lg-6">
                                    <label><?= lang('Controllers_Code') ?></label>
                                    <select name="Controllers_id" class="form-control selectpicker" data-live-search="true">
                                        <option value="<?= $Controllers->controllers_id ?>"><?= $Controllers->item_translation ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label><?= lang('Table_Status') ?> </label>
                                    <select name="status_functions" class="form-control selectpicker" data-live-search="true">
                                        <?php
                                        foreach ($status_controller AS $key => $value)
                                        {
                                            echo '<option value="'.$key.'">'.$value.'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label><?= lang('Basic_System') ?> </label>
                                    <select name="status_system"  class="form-control selectpicker" data-live-search="true">
                                        <?php
                                        foreach ($controller_status_system AS $key => $value)
                                        {
                                            echo '<option value="'.$key.'">'.$value.'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                        </div><!--<div class="card-body">-->

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
                    </div>

                </form>

            </div>
        </div>

    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->

<script type="text/javascript">

    $('.selectpicker').selectpicker({
        noneSelectedText : '<?= lang('Select_noneSelectedText'); ?>'
    });

</script>