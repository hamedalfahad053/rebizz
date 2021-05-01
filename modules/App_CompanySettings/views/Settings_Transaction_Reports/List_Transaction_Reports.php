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
	        <a class="btn btn-primary" href="<?= base_url(APP_NAMESPACE_URL . '/Settings_Transaction_Reports/Form_Add_Transaction_Reports/') ?>" >
		        <i class="flaticon-psd"></i>    انشاء تقرير جديد
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

        <div class="row">

            <div class="col-lg-12 mt-5">
                <div class="card card-custom">
                    <div class="card-body">

	                    <style>th.dt-center,.dt-center { text-align: center; }</style>
	                    <table class="data_table table table-bordered table-hover display nowrap" width="100%">
		                    <thead>
		                    <tr>
			                    <th class="text-center">#</th>
			                    <th class="text-center">اسم التقرير</th>
			                    <th class="text-center"> نوع التقييم</th>
			                    <th class="text-center">تخصيص التقرير</th>
			                    <th class="text-center">بواسطة / الوقت</th>
			                    <th class="text-center">الحالة</th>
			                    <th class="text-center">الخيارات</th>
		                    </tr>
		                    </thead>
		                    <tbody>
		                    <?php
		                    $f = 0;
		                    foreach ($Get_Reports->result() AS $RF)
		                    {
			                    ?>
			                    <tr>
				                    <th class="text-center"><?= ++$f; ?></th>
				                    <th class="text-center"><?= $RF->Reports_title_ar ?></th>
				                    <th class="text-center"><?= Get_options_List_Translation($RF->Reports_TYPES)->item_translation ?></th>
				                    <th class="text-center">
					                    <?php
					                    if($RF->Reports_Clint == 0){
					                    	echo  Create_Status_badge(array("key" => "Success", "value" => lang('عام')));
					                    }else{
						                   $Where_Get_Client = array("client_id"=>$RF->Reports_Clint);
						                   $Get_Client       =  Get_Client_Company($Where_Get_Client)->row();
						                   echo Create_Status_badge(array("key" => "Danger", "value" => $Get_Client->name));
					                    }
					                    ?>
				                    </th>
				                    <th class="text-center">
					                    <?= $this->aauth->get_user($RF->Reports_createBy)->full_name ?> -
					                    <?= date('Y-m-d h:i:s a',$RF->Reports_createDate) ?>
				                    </th>
				                    <th class="text-center">
					                    <?php
					                    if ($RF->Reports_Status == 1) {
						                   echo Create_Status_badge(array("key" => "Success", "value" => lang('Status_Active')));
					                    } else {
					                       echo  Create_Status_badge(array("key" => "Danger", "value" => lang('Status_Disabled')));
					                    }
					                    ?>
				                    </th>
				                    <th class="text-center">

					                    <?php
					                    $options_Reports['edit'] = array("class" => '',"id" => '',"title" => 'تحرير',"data-attribute" => '',"icon"  => '',"href"  => base_url(APP_NAMESPACE_URL . '/Settings_Transaction_Reports/Editor_Transaction_Reports/' . $RF->build_reports_uuid));
					                    echo $Create_Options =  Create_Options_Button($options_Reports);
					                    ?>

				                    </th>
			                    </tr>
			                    <?php
		                    }
		                    ?>
		                    </tbody>
	                    </table>


                    </div>
                </div>
            </div><!--<div class="col-lg-12 mt-5">-->

        </div>

    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->