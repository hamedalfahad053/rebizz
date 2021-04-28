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

        <div class="card card-custom mt-10">

	        <form class="form" id="Form_Create_Transaction" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Settings_Transaction/Create_Receipt_Transactions_Setting') ?>" enctype="multipart/form-data" method="post">
		        <?= CSFT_Form() ?>
                <!--begin::Body-->
                <div class="card-body">
                    <?php echo  $this->session->flashdata('message'); ?>
		            <div class="form-group row">

			            <div class="col-lg-6 mt-5">
				            <label>اختر الموظف</label>
				            <select name="emp_id"  class="form-control selectpicker" data-live-search="true"  data-title="اختر من فضلك ">
					            <?php
					            $Company_Users   = Get_Company_Users(array("users.company_id" => $this->aauth->get_user()->company_id,"users.banned"=>0));
					            foreach ($Company_Users->result() as $Row)
					            {

						            if($Row->position_id != NULL){
						                $Position =  Get_options_List_Translation($Row->position_id)->item_translation;
						            }else{
						                $Position = 'غير محدد';
						            }

						            if(Check_Permissions(12) or Check_Permissions(9))
						            {
							            echo '<option value="'.$Row->user_id.'" data-subtext="'.$Position.'" data-icon="la la-user font-size-lg bs-icon">'.$Row->full_name.'</option>';
						            }

					            }
					            ?>
				            </select>
			            </div>

		            </div>
		            <div class="form-group row">

			            <div class="col-lg-4 mt-5">
				            <label>طريقة الاستلام</label>
				            <?= Creation_List_HTML('select', 'LIST_METHOD_OF_RECEIPT', '','','options', '1','','','',array( 0=> "selectpicker"),'','','') ?>
			            </div>

			            <div class="col-lg-4 mt-5">
				            <label>فئة العميل</label>
				            <?= Creation_List_HTML('select', 'LIST_CUSTOMER_CATEGORY', '','','options', '1','','','',array( 0=> "selectpicker"),'','','') ?>
			            </div>

			            <div class="col-lg-4 mt-5">
				            <label>العميل</label>
				            <select name="LIST_CLIENT" id="LIST_CLIENT" multiple="multiple"  class="form-control selectpicker" title="الرجاء إختيار العميل">

					            <?php
					            $where_Client_Company = array(
							            "company_id" => $this->aauth->get_user()->company_id
					            );
					            $Get_All_Clients = Get_Client_Company($where_Client_Company);

					            if ($Get_All_Clients->num_rows() > 0) {

						            foreach ($Get_All_Clients->result() as $ROW)
						            {
							            echo '<option value="'.$ROW->client_id.'">'.$ROW->name.'</option>';

						            } // foreach ($Get_All_Clients->result() as $ROW)

					            } // if ($Get_All_Clients->num_rows() > 0)

					            ?>
				            </select>
			            </div>

		            </div>
	            </div>
	            <!--end: Card Body-->
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

        </div><!--<div class="card card-custom mt-10">-->

    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->



<script type="text/javascript">







</script>

