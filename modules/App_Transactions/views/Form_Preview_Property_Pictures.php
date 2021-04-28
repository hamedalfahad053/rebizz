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
	        <a href="<?= base_url(APP_NAMESPACE_URL . '/Transactions/Dashboard_Preview_Property/'.$Transactions->uuid.'/'.$Coordination->Coordination_uuid) ?>" class="btn btn-success">
		        <i class="flaticon2-arrow"></i>   العودة الى لوحة المعاين
	        </a>
        </div>
        <!--end::Toolbar-->
    </div>
</div>
<!--end::Subheader-->

<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container-fluid">

        <form class="form" id="Form_Create_Transaction" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Transactions/Create_Photo_Preview_Property/'.$Transactions->uuid.'/'.$Coordination->Coordination_uuid) ?>" enctype="multipart/form-data" method="post">
            <?= CSFT_Form() ?>


            <?php echo  $this->session->flashdata('message'); ?>


            <?php
            $LIST_CLIENT                    = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_CLIENT');
            $CUSTOMER_CATEGORY              = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_CUSTOMER_CATEGORY');
            $TYPE_OF_PROPERTY               = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_TYPE_OF_PROPERTY');
            $TYPES_OF_REAL_ESTATE_APPRAISAL = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_TYPES_OF_REAL_ESTATE_APPRAISAL');

            $Form_Components  = Get_View_Components_Customs(16,$LIST_CLIENT,$CUSTOMER_CATEGORY,$TYPE_OF_PROPERTY,$TYPES_OF_REAL_ESTATE_APPRAISAL);

            foreach ($Form_Components->result() AS $RC)
            {
                ?>
                <input type="hidden" name="Form_id" value="16">
                <input type="hidden" name="Transaction_id" value="<?= $Transactions->transaction_id ?>">
                <div class="card card-custom mt-10">

                    <!--begin::Header-->
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">
                                <?= $RC->item_translation ?>
                            </h3>
                        </div>
                        <div class="card-toolbar">

                        </div>
                    </div>
                    <!--begin::Header-->

                    <!--begin::Body-->
                    <div class="card-body">

                        <div class="form-group row">
                            <?php
                            $Get_Fields_Components = Building_Fields_Components_Forms($RC->Forms_id, $RC->components_id,$LIST_CLIENT,$CUSTOMER_CATEGORY,$TYPE_OF_PROPERTY,$TYPES_OF_REAL_ESTATE_APPRAISAL,'All');

                            foreach ($Get_Fields_Components as $GFC)
                            {

                                if($GFC['Fields_Type_Components'] == 'Fields')
                                {
                                ?>


	                                <fieldset class="todos_labels_<?= $RC->components_id ?>">
		                                <div class="repeatable"></div>
		                                <div class="form-group row mt-10">
			                                <input type="button" value="اضف المزيد" class="btn btn-primary add_<?= $RC->components_id ?>" align="center">
		                                </div>
	                                </fieldset>

	                                <script type="text/template" id="todos_labels_<?= $RC->components_id ?>">
		                                <div class="field-group form-group row">
			                                <div class="col-lg-4 mt-5">
				                                <label for="NameFile_{?}">اسم الملف</label>
				                                <input type="text" name="FILE_Name[]" id="FILE_Name[{?}]"  class="form-control">
				                                <input type="hidden" name="components_id[]" id="components_id[{?}]"  value="<?= $RC->components_id ?>">
				                                <input type="hidden" name="Forms_id[]" id="Forms_id[{?}]"  value="<?= $RC->Forms_id ?>">
				                                <input type="hidden" name="preview_id[]" id="preview_id[{?}]"  value="<?= $Coordination->Coordination_id ?>">
			                                </div>
			                                <div class="col-lg-4 mt-5">
				                                <label for="File_{?}">الملف</label>
				                                <input type="file" name="FILE[]" id="FILE[{?}]" class="form-control-file">
			                                </div>
			                                <div class="col-lg-4 mt-5">
				                                <label for=""></label>
				                                <input type="button" class="btn btn-danger span-2 delete_<?= $RC->components_id ?>" value="حذف" />
			                                </div>
		                                </div>
	                                </script>


                                <?= import_js(BASE_ASSET.'plugins/jquery.repeatable',''); ?>
	                                <script>
		                                $(function() {
			                                $(".todos_labels_<?= $RC->components_id ?> .repeatable").repeatable({
				                                addTrigger: ".todos_labels_<?= $RC->components_id ?> .add_<?= $RC->components_id ?>",
				                                deleteTrigger: ".todos_labels_<?= $RC->components_id ?> .delete_<?= $RC->components_id ?>",
				                                template: "#todos_labels_<?= $RC->components_id ?>",
				                                startWith: 1,
				                                min:1,
				                                max:5
			                                });
		                                });
	                                </script>

	                            <?php
                                }


                            } // foreach
                            ?>
                        </div><!-- <div class="form-group row"> -->
                    </div>
                    <!--begin::Body-->


                </div><!--<div class="card card-custom mt-10">-->
                <?php
            }
            ?>




            <?php
            $where_Stages_Assignment = array(
                "stages_key" => 'COORDINATION_AND_QUALITY',
                "company_id" => $this->aauth->get_user()->company_id
            );
            $Get_Stages_Transaction = Assignment_Transaction_Departments_To($where_Stages_Assignment);

            if($Get_Stages_Transaction == false) {

                $msg_result['key']   = 'Danger';
                $msg_result['value'] = 'لا يوجد ضبط صحيح لاسناد المعاملة ';
                $msg_result_view = Create_Status_Alert($msg_result);
                echo '<br>';
                echo $msg_result_view;

            }else{

                $Assignment_Type_where = array(
                    'stages_key' => 'COORDINATION_AND_QUALITY',
                    'company_id' => $this->aauth->get_user()->company_id
                );
                $Assignment_Type = Get_Stages_Transaction_Company($Assignment_Type_where)->row();

                if($Assignment_Type->attribution_method == 1){
                    echo '<input type="hidden" name="Assignment_userid" value="'.$Get_Stages_Transaction['userid'].'">';
                }elseif($Assignment_Type->attribution_method == 2){
                    ?>
                    <div class="card card-custom mb-5 mt-5">
                        <!--begin::Header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">تحويل الطلب الى </h3>
                            </div>
                        </div>
                        <!--begin::Header-->
                        <!--begin::Body-->
                        <div class="card-body">
                            <select name="Assignment_userid" class="form-control selectpicker" data-live-search="true"  data-title="اختر من فضلك ">
                                <?php
                                $t = 'عدد المعاملات الحالية :';
                                foreach ($Get_Stages_Transaction AS $key_user)
                                {
                                    echo '<option  data-subtext="  '.$t.$key_user['Assignment_Num'].'" value="'.$key_user['userid'].'">'.$key_user['full_name'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <!--begin::Body-->
                    </div>
                    <?php
                } // if($Assignment_Type->attribution_method == 1)
                ?>


                <div class="card card-custom mt-10">
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="submit"   class="btn btn-primary mr-2"> حفظ البيانات  </button>
                            </div>
                            <div class="col-lg-6 text-lg-right">
                            </div>
                        </div>
                    </div>
                </div>

                <?php
            }
            ?>



        </form>

    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->
