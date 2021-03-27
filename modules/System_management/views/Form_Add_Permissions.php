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

        <form class="form"  action="<?= base_url(ADMIN_NAMESPACE_URL.'/System/Create_New_Functions') ?>" method="post">
            <?=  $this->session->flashdata('message'); ?>
            <?= CSFT_Form() ?>

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
                            <div class="col-lg-4">
                                <label><?= lang('System_Area') ?></label>
                                <select id="Area_id" name="Area_id" class="form-control selectpicker" data-live-search="true">
                                    <option><?= lang('Select_noneSelectedText'); ?></option>
                                    <?php
                                    foreach ($System_Area AS  $value)
                                    {
                                        echo '<option value="'.$value['area_id'].'">'.$value['area_name'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label><?= lang('Controllers_Code') ?></label>
                                <select id="Controllers_id" name="Controllers_id" class="form-control selectpicker" data-live-search="true">

                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label><?= lang('Functions_Code') ?></label>
                                <select id="Functions_id" name="Functions_id"  class="form-control selectpicker" data-live-search="true">

                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label><?= lang('Table_Status') ?> </label>
                                <select name="status_Permissions" class="form-control selectpicker" data-live-search="true">
                                    <?php
                                    foreach ($status_Permissions AS $key => $value)
                                    {
                                        echo '<option value="'.$key.'">'.$value.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label><?= lang('Basic_System') ?> </label>
                                <select name="status_Permissions"  class="form-control selectpicker" data-live-search="true">
                                    <?php
                                    foreach ($Permissions_status_system AS $key => $value)
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
                </div>
            </div>

        </form>

    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->


<script type="text/javascript">


    $('.selectpicker').selectpicker({
        noneSelectedText : '<?= lang('Select_noneSelectedText'); ?>'
    });

    $(document).on('change', '#Area_id', function(e){

        e.preventDefault();
        var Area_id       =  $('select[name="Area_id"]').val();
        $.ajax({
            type: 'ajax',
            method: 'get',
            url: '<?= base_url(ADMIN_NAMESPACE_URL .'/System/Controllers_ajax_json') ?>',
            data: { Area_id:Area_id},
            async: false,
            dataType: 'json',
            success: function(data){
                $("#Controllers_id").empty();
                $("#Controllers_id").append('<option>اختر </option>');
                $.each(data.data, function (key, value) {
                    $("#Controllers_id").append('<option value=' + value.controllers_id + '>' + value.controllers_name + '</option>');
                });
                $("#Controllers_id").selectpicker('refresh');
            },
            error: function(){
                swal.fire("خطا بالارسال",'', "error");
            }
        });

    }); // $(document).on('change', '#Area_id', function(e)


    $(document).on('change', '#Controllers_id', function(e){
        e.preventDefault();
        var Controllers_id       =  $('select[name="Controllers_id"]').val();
        $.ajax({
            type: 'ajax',
            method: 'get',
            url: '<?= base_url(ADMIN_NAMESPACE_URL .'/System/Functions_Controllers_ajax_json') ?>',
            data: { Controllers_id:Controllers_id},
            async: false,
            dataType: 'json',
            success: function(data){
                $("#Functions_id").empty();
                $("#Functions_id").append('<option>اختر </option>');
                $.each(data.data, function (key, value) {
                    $("#Functions_id").append('<option value=' + value.function_id + '>' + value.function_name + '</option>');
                });
                $("#Functions_id").selectpicker('refresh');
            },
            error: function(){
                swal.fire("خطا بالارسال",'', "error");
            }
        });

    }); // $(document).on('change', '#Area_id', function(e)


</script>
