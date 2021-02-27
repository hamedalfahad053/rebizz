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



            <form class="form" name="" action="<?= base_url(APP_NAMESPACE_URL . '/Clients/Create_Client') ?>" enctype="multipart/form-data" method="post">
                <?= CSFT_Form() ?>


                        <div class="card-body">
                        <?php echo  $this->session->flashdata('message'); ?>
                        <div class="form-group row">
                            <div class="col-sm-12 col-md-6 mt-5">
                                <label><?= lang('client_name') ?> </label>
                                <input type="text" name="name" class="form-control" placeholder="<?= lang('client_name') ?>" />
                            </div>

                            <div class="col-sm-12 col-md-6 mt-5">
                                <label><?= lang('client_type') ?></label>
                                <?= Get_Data_List('select', 'LIST_CUSTOMER_CATEGORY') ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 col-md-6 mt-5">
                                <label><?= lang('Global_email') ?> </label>
                                <input type="email" name="email" class="form-control" placeholder="<?= lang('Global_email') ?>" />
                            </div>

                            <div class="col-sm-12 col-md-6 mt-5">
                                <label><?= lang('Global_Phone') ?> </label>
                                <input type="tel" name="Phone" class="form-control" placeholder="<?= lang('Global_Phone') ?>" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 col-md-12 mt-5">
                                <label>شعار العميل</label>
                                <input type="file" name="logo_client" class="form-control-file"  />
                            </div>

                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 col-md-6 mt-5">
                                <label><?= lang('Status_add_System') ?> </label>
                                <select name="is_active" class="form-control selectpicker" data-live-search="true" data-title="اختر الحالة ">
                                    <?php
                                    foreach ($List_status as $key => $value) {
                                        echo '<option value="' . $key . '">' . $value . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="submit"   class="btn btn-primary mr-2">اضافة العميل</button>
                                </div>
                            </div>
                        </div>
            </form>
        </div>
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->


