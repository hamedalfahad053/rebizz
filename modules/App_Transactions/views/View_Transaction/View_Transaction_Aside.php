<div class="flex-row-auto offcanvas-mobile w-300px w-xl-350px" id="kt_profile_aside">
    <!--begin::Card-->
    <div class="card card-custom">
        <!--begin::Body-->
        <div class="card-body pt-15">
            <!--begin::Nav-->

	        <!--begin::User-->
	        <div class="text-center mb-10">

		        <div class="symbol symbol-60 symbol-circle symbol-xl-90">
			        <?php
			        $path = $LoginUser_Company_Path_Folder.'/'.FOLDER_FILE_Company_client_logo.'/';
			        ?>
			        <div class="symbol-label" style="background-image:url('<?= Get_Client_Logo($LoginUser_Company_Path_Folder,$this->aauth->get_user()->company_id,Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_CLIENT')); ?>')"></div>
		        </div>

		        <?php
		        $client_id   = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_CLIENT');
		        $client_info = Get_Client_Company(array("client_id"=>$client_id))->row();
		        ?>
		        <h4 class="font-weight-bold my-2">العميل :  <?= $client_info->name ?> </h4>

		        <h4 class="font-weight-bold my-2">
			        <?php
			        $type_Transaction_ASID = Transaction_data_by_key($Transactions->transaction_id,1,1,'LIST_TYPES_OF_REAL_ESTATE_APPRAISAL');
			        echo get_data_options_List_view('4',$type_Transaction_ASID);
			        ?>
		        </h4>

		        <div class="font-weight-bold my-2">رقم المعاملة : <?= date('Ymd',$Transactions->Create_Transaction_Date).$Transactions->transaction_id;?></div>
		        <span class="font-weight-bold my-2">حالة المعاملة : <?= get_data_options_List_view(9,$Transactions->Transaction_Status_id); ?></span>
	        </div>
	        <!--end::User-->


            <a href="<?= base_url(APP_NAMESPACE_URL.'/Transactions/View_Transaction/'.$Transactions->uuid); ?>"
               class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 btn-block"> البيانات الاساسية </a>



	        <?php
	        $CREATE_A_TRANSACTION_Status_Stages_Transaction = array(
	           "transaction_id" => $Transactions->transaction_id,
			   "stages_key"     => 'CREATE_A_TRANSACTION',
			   "stages_type"    => 'COMPLETE'
	        );
	        if(Get_Status_Stages_Transaction($CREATE_A_TRANSACTION_Status_Stages_Transaction)->num_rows() == 0){

	        if(Check_Permissions(13)) {
	        ?>
		    <div class="separator separator-dashed separator-border-1 mt-1"></div>
	        <a href="<?= base_url(APP_NAMESPACE_URL.'/Review_Entry_Transactions/Check_DataEntries/'.$Transactions->uuid) ?>"
		    class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 btn-block">ادخال البيانات</a>
	        <?php
	        } // if(Check_Permissions(13))

	        } // Get_Status_Stages_Transaction
	        ?>

	        <?php
	        $DATA_ENTRY_Status_Stages_Transaction = array(
			        "transaction_id" => $Transactions->transaction_id,
			        "stages_key"     => 'DATA_ENTRY',
			        "stages_type"    => 'COMPLETE'
	        );
	        if(Get_Status_Stages_Transaction($DATA_ENTRY_Status_Stages_Transaction)->num_rows()>0){

	        if(Check_Permissions(16) OR Check_Permissions(17) OR Check_Permissions(18)
	        OR Check_Permissions(19) OR Check_Permissions(20) OR Check_Permissions(21)
	        OR Check_Permissions(22)) {
	        ?>
	        <div class="separator separator-dashed separator-border-1 mt-1"></div>
	        <a href="<?= base_url(APP_NAMESPACE_URL.'/Coordinator/Dashboard/'.$Transactions->uuid) ?>"
	           class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 btn-block">المنسق</a>
		    <?php
	        }
	        }
	        ?>

	        <?php
	        $COORDINATION_AND_QUALITY_Status_Stages_Transaction = array(
			        "transaction_id" => $Transactions->transaction_id,
			        "stages_key"     => 'COORDINATION_AND_QUALITY',
			        "stages_type"    => 'COMPLETE'
	        );
	        if(Get_Status_Stages_Transaction($COORDINATION_AND_QUALITY_Status_Stages_Transaction)->num_rows()>0){

	        ?>
	        <div class="separator separator-dashed separator-border-1 mt-1"></div>
	        <a href="<?= base_url(APP_NAMESPACE_URL.'/Preview/Dashboard/'.$Transactions->uuid) ?>"
	           class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 btn-block">المعاينة</a>
	        <?php
	        }
	        ?>


	        <?php
	        $PREVIEW_Status_Stages_Transaction = array(
			        "transaction_id" => $Transactions->transaction_id,
			        "stages_key"     => 'PREVIEW',
			        "stages_type"    => 'COMPLETE'
	        );
	        if(Get_Status_Stages_Transaction($PREVIEW_Status_Stages_Transaction)->num_rows()>0){
	        ?>
	        <div class="separator separator-dashed separator-border-1 mt-1"></div>
	        <a href="<?= base_url(APP_NAMESPACE_URL.'/Evaluation/Dashboard/'.$Transactions->uuid) ?>"
	           class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 btn-block">التقييم</a>
		    <?php
	        }
	        ?>


	        <?php
	        $EVALUATION_Status_Stages_Transaction = array(
			        "transaction_id" => $Transactions->transaction_id,
			        "stages_key"     => 'EVALUATION',
			        "stages_type"    => 'COMPLETE'
	        );
	        if(Get_Status_Stages_Transaction($EVALUATION_Status_Stages_Transaction)->num_rows()>0){
	        ?>
	        <div class="separator separator-dashed separator-border-1 mt-1"></div>
	        <a href="<?= base_url(APP_NAMESPACE_URL.'/Report_Transaction/Settings/'.$Transactions->uuid) ?>"
	           class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 btn-block">اعداد التقرير</a>
		    <?php
	        }
	        ?>


	        <?php
	        if(Check_Permissions(42)){
	        ?>
	        <div class="separator separator-dashed separator-border-1 mt-1"></div>
	        <a href="<?= base_url(APP_NAMESPACE_URL.'/Transaction_Log/log/'.$Transactions->uuid) ?>"
	           class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 btn-block">سجل المعاملة</a>
		        <?php
	        }
	        ?>


	        <?php
	        if(Check_Permissions(43)){
	        ?>
	        <div class="separator separator-dashed separator-border-1 mt-1"></div>
	        <a href="<?= base_url(APP_NAMESPACE_URL.'/Work_Team/Assign_Transaction/'.$Transactions->uuid) ?>"
	           class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 btn-block">فريق العمل</a>
	        <?php
	        }
	        ?>

	        <?php
	        if(Check_Permissions(49)){
		        ?>
		        <div class="separator separator-dashed separator-border-1 mt-1"></div>
		        <a href="<?= base_url(APP_NAMESPACE_URL.'/Transactions/Notes_Transaction/'.$Transactions->uuid) ?>"
		           class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 btn-block"> الملاحظات </a>
		        <?php
	        }
	        ?>



	        <!--end::Nav-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Card-->
</div>