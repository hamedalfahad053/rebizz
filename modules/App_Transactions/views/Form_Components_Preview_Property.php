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

        <form class="form" id="Form_Create_Transaction"  action="<?= base_url(APP_NAMESPACE_URL.'/Transactions/Create_Components_Preview_Property/'.$Transactions->uuid.'/'.$Coordination->Coordination_uuid) ?>" enctype="multipart/form-data" method="post">
            <?= CSFT_Form() ?>
            <?php echo  $this->session->flashdata('message'); ?>





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
