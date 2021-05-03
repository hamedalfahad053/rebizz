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
            <!--begin::Header-->
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">سجل الحقل</h3>
                </div>
            </div>
            <!--begin::Header-->
            <!--begin::Body-->
            <div class="card-body">

                <style>th.dt-center,.dt-center { text-align: center; }</style>
                <table class="data_table table table-bordered table-hover display nowrap" width="100%">
                    <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">المستخدم</th>
                        <th class="text-center">نوع العملية</th>
                        <th class="text-center">التاريخ / الوقت</th>
                        <th class="text-center"> القيمة </th>
                        <th class="text-center"> سبب التعديل </th>
                    </tr>
                    </thead>
                    <tbody>
		                    <?php
		                    if($History_Fields->num_rows()>0){

		                    $i = 0;

			                foreach ($History_Fields->result() as $ROW)
			                {
		                    ?>
	                        <tr>
	                            <td class="text-center"><?= ++$i ?></td>
	                            <td class="text-center"><?= $this->aauth->get_user($ROW->data_Create_id)->full_name ?></td>
	                            <td class="text-center">
		                            <?php
		                            if($ROW->History == 'Create' ) {
			                            echo  Create_Status_badge(array("key"=>"Success","value"=>'اضافة'));
		                            }elseif($ROW->History == 'Update' ) {
			                            echo  Create_Status_badge(array("key"=>"warning","value"=>'تعديل'));
		                            }elseif($ROW->History == 'Delete' ) {
			                            echo  Create_Status_badge(array("key"=>"Danger","value"=>'حذف'));
		                            }
		                            ?>
	                            </td>
	                            <td class="text-center"><?= date('Y-m-d h:i:s a',$ROW->data_Create_time); ?></td>
	                            <td class="text-center">
		                            <?php
				                    if($Query_Fields->Fields_Type == 'Fields'){
					                  echo Transaction_data_by_key_history($Transactions->transaction_id,$Query_Fields->Forms_id,$Query_Fields->Components_id,$Query_Fields->Fields_key);
				                    }elseif($Query_Fields->Fields_Type == 'List'){
					                    $d = Transaction_data_by_key($Transactions->transaction_id,$Query_Fields->Forms_id,$Query_Fields->Components_id,$Query_Fields->Fields_key);
					                    echo get_data_options_List_view($Query_Fields->Fields_id,$d);
				                    }
		                            ?>
	                            </td>
	                            <td class="text-center">
		                            <?php
		                            if($ROW->History == 'Create' ) {
			                            echo 'انشاء المعاملة';
		                            }else{
		                            	echo $ROW->Reason_modification;
		                            }
		                            ?>
	                            </td>
	                        </tr>
	                        <?php
	                        }

	                        }
	                        ?>
                    </tbody>
                </table>
                <!--begin: Datatable -->

            </div>
        </div>



    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->
