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

        <form class="form" name="" action="<?= base_url(APP_NAMESPACE_URL.'/User_Group/Create_Group') ?>" method="post">
            <?= CSFT_Form() ?>


            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon-users-1 text-primary"></i>
                        </span>
                        <h3 class="card-label"><?= lang('add_new_group_button') ?></h3>
                    </div>
	                <div class="card-toolbar">

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
                        <h3 class="card-label">صلاحيات النظام العامة</h3>
                    </div>
                </div>
            </div>

            <?php
            foreach ($Controllers_Permissions AS $Row)
            {

            ?>

	            <div class="card card-custom mt-10">
		            <div class="card-header">
			            <div class="card-title">
	                        <span class="card-icon">
	                            <i class="flaticon-users-1 text-primary"></i>
	                        </span>
				            <h3 class="card-label"><?= $Row['Controllers_title'] ?></h3>
			            </div>
			            <div class="card-toolbar">
				            <label class="checkbox mt-3">
					            <input type="checkbox" value="1" name="" id="btnDiv3" class="select-all"/>
					            <span></span>
					            تحديد الكل / الغاء الكل
				            </label>
			            </div>
		            </div>
		            <div class="card-body"  id="">
			            <?php
			            $functions_Controller = Get_functions_Controller($Row['Controllers_id']);
			            if($functions_Controller->num_rows()>0){
					            ?>
					            <div class="checkbox-inline">
						            <?php

						            foreach ($functions_Controller->result() AS $F){
								            $Get_Permissions = Get_Permissions(array("area.area_id" => 3, "controllers.controllers_id" => $Row['Controllers_id'], "functions.function_id" => $F->function_id));
								            if ($Get_Permissions->num_rows() > 0) {
									            foreach ($Get_Permissions->result() AS $P)
									            {
									            ?>
										            <label class="checkbox mt-3">
											            <input type="checkbox" value="<?= $P->permissions_id ?>"  name="permissions[]"/>
											            <span></span>
											            <?= $P->permissions_title ?>
										            </label>
								                <?php
									            } // foreach ($Permissions AS $P)
								            } // if($Permissions != false)
						            } // foreach ($Row['Function'] AS $F)

					                ?>
					            </div>
					            <?php
			            } // if($functions != false)
			            ?>


		            </div>
	            </div>

            <?php
            }
            ?>


	        <div class="card-footer mt-10">
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
    <!--end::Container-->
</div>
<!--end::Entry-->


<script type="text/javascript">
	$('.select-all').on('click', function () {
		$(this).closest('div').find('.check').prop('checked', true);
	});
</script>