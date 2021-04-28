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

                <form class="form" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Users/Update_User/'.$Users->user_uuid) ?>" method="post">
                    <?= CSFT_Form() ?>
                    <div class="card-body">


                        <div class="form-group row">
                            <div class="col-lg-6 mt-5">
                                <label>الاسم باللغة العربية</label>
                                <input type="text" name="full_name_ar" value="<?= $Users->full_name_ar ?>" class="form-control" placeholder=""/>
                            </div>
                            <div class="col-lg-6 mt-5">
                                <label>الاسم باللغة الانجليزية</label>
                                <input type="text" name="full_name" value="<?= $Users->full_name ?>" class="form-control" placeholder="<?= lang('user_full_name_en') ?>"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6 mt-5">
                                <label><?= lang('Global_email') ?></label>
                                <input type="text" name="email" class="form-control"  value="<?= $Users->email ?>" placeholder="<?= lang('Global_email') ?>"/>
                            </div>
                            <div class="col-lg-6 mt-5">
                                <label><?= lang('Global_Mobile') ?></label>
                                <input type="text" name="mobile" class="form-control" value="<?= $Users->phone ?>" placeholder="<?= lang('Global_Mobile') ?>"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-3 mt-5">
                                <label>الفرع</label>
                                <select name="Locations_Users" id="Locations_Users"  title="اختر من فضلك "  class="form-control selectpicker">
                                    <?php
                                    foreach ($Locations_Users AS $value)
                                    {
                                    	if($Users->locations_id == $value['locations_id']){
                                    	    $Locations_select = 'selected="selected"';
	                                    }else{
		                                    $Locations_select = '';
	                                    }
                                        echo '<option '.$Locations_select.' value="'.$value['locations_id'].'">'.$value['locations_Name'].'</option>';
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
				                        if($Users->departments_id == $value['departments_id']){
					                        $departments_select = 'selected="selected"';
				                        }else{
					                        $departments_select = '';
				                        }
				                        echo '<option '.$departments_select.' value="'.$value['departments_id'].'">'.$value['departments_title'].'</option>';
			                        }
			                        ?>
		                        </select>
	                        </div>

                            <div class="col-lg-3 mt-5">
                                <label><?= lang('user_group') ?></label>
                                <select name="user_group" id="user_group"  title="اختر من فضلك "  class="form-control selectpicker">
                                    <?php

                                    $Get_User_Group = Get_Userid_Group($Users->id)->row();

                                    foreach ($Group_Users AS $value_d)
                                    {
	                                    if($Get_User_Group->group_id == $value_d['group_id']){
		                                    $User_Group_select = 'selected="selected"';
	                                    }else{
		                                    $User_Group_select = '';
	                                    }

                                        echo '<option '.$User_Group_select.' value="'.$value_d['group_id'].'">'.$value_d['group_title'].'</option>';
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
	                                    if($Users->banned == $key){
		                                    $User_status_select = 'selected="selected"';
	                                    }else{
		                                    $User_status_select = '';
	                                    }

                                        echo '<option '.$User_status_select.' value="'.$key.'">'.$value.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="submit" class="btn btn-primary mr-2">تعديل</button>
                            </div>
                            <div class="col-lg-6 text-lg-right">
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