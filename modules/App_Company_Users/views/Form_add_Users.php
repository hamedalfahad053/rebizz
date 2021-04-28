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

                <form class="form" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Users/Create_Users') ?>" method="post">
                    <?= CSFT_Form() ?>
                    <div class="card-body">

	                    <?php echo  $this->session->flashdata('message'); ?>


                        <div class="form-group row">
                            <div class="col-lg-6 mt-5">
                                <label>الاسم باللغة العربية</label>
                                <input type="text" name="full_name_ar" value="<?php echo set_value('full_name_ar'); ?>" class="form-control" placeholder="<?= lang('user_full_name_ar') ?>"/>
                            </div>
                            <div class="col-lg-6 mt-5">
                                <label>الاسم باللغة الانجليزية</label>
                                <input type="text" name="full_name"  value="<?php echo set_value('full_name'); ?>" class="form-control" placeholder="<?= lang('user_full_name_en') ?>"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6 mt-5">
                                <label><?= lang('Global_email') ?></label>
                                <input type="text" name="email" class="form-control"  value="<?php echo set_value('email'); ?>"  placeholder="<?= lang('Global_email') ?>"/>
                            </div>
                            <div class="col-lg-6 mt-5">
                                <label><?= lang('Global_Mobile') ?></label>
                                <input type="text" name="mobile" class="form-control"  value="<?php echo set_value('mobile'); ?>" placeholder="<?= lang('Global_Mobile') ?>"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6 mt-5">
                                <label><?= lang('Auth_password') ?></label>
                                <input type="password" name="password" class="form-control" placeholder="<?= lang('Auth_password') ?>"/>
                            </div>
                            <div class="col-lg-6 mt-5">
                                <label><?= lang('Auth_confirm_password') ?></label>
                                <input type="password" name="confirm_password" class="form-control" placeholder="<?= lang('Auth_confirm_password') ?>"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-3 mt-5">
                                <label>الفرع</label>
                                <select name="Locations_Users" id="Locations_Users"  title="اختر من فضلك "  class="form-control selectpicker">
                                    <?php
                                    foreach ($Locations_Users AS $value)
                                    {
                                        echo '<option value="'.$value['locations_id'].'">'.$value['locations_Name'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>

	                        <div class="col-lg-3 mt-5">
		                        <label>القسم </label>
		                        <select name="departments_id" id="departments_id"  title="اختر من فضلك "  class="form-control selectpicker">
			                        <?php
			                        foreach ($departments AS $value)
			                        {
				                        echo '<option value="'.$value['departments_id'].'">'.$value['departments_title'].'</option>';
			                        }
			                        ?>
		                        </select>
	                        </div>

                            <div class="col-lg-3 mt-5">
                                <label><?= lang('user_group') ?></label>
                                <select name="user_group" id="user_group"  title="اختر من فضلك "  class="form-control selectpicker">
                                    <?php
                                    foreach ($Group_Users AS $value_d)
                                    {
                                        echo '<option value="'.$value_d['group_id'].'">'.$value_d['group_title'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-lg-3 mt-5">
                                <label><?= lang('Table_Status') ?></label>
                                <select name="user_Status" id="user_Status"  title="اختر من فضلك "  class="form-control selectpicker">
                                    <?php
                                    foreach ($user_status AS $key => $value)
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

<script type="text/javascript">

    $('.selectpicker').selectpicker({
        noneSelectedText : '<?= lang('Select_noneSelectedText'); ?>'
    });

</script>