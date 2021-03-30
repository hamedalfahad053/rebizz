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
		    <div class="card-body">
		            <?php echo  $this->session->flashdata('message'); ?>
	                <?php
	                if($Transactions == false){
		                $msg_result['key'] = 'Danger';
		                $msg_result['value'] = 'لا يوجد معاملات مسندة  لقسم الادخال و المراجعة';
		                $msg_result_view = Create_Status_Alert($msg_result);
                        echo $msg_result_view;
	                }else{
	                ?>

				    <style>th.dt-center,.dt-center { text-align: center; }</style>
				    <table class="data_table table table-bordered table-hover display nowrap" width="100%">
					    <thead>
					    <tr>
						    <th class="text-center">رقم المعاملة</th>
						    <th class="text-center">طالب التقييم والمالك</th>
						    <th class="text-center">موقع العقار</th>
						    <th class="text-center">بواسطة / التاريخ</th>
						    <th class="text-center">بحيازة</th>
						    <th class="text-center">حالة المعاملة</th>
						    <th class="text-center">الخيارات</th>
					    </tr>
					    </thead>
					    <tbody>
					    <?php
					    foreach ($Transactions AS $Row)
					    {
						    ?>
						    <tr>
							    <td class="text-center">
								    <?php
								    echo $CLIENT = Transaction_data_by_key($Row['transaction_id'],'LIST_CLIENT');
								    ?>
							    </td>
							    <td class="text-center">


							    </td>
							    <td class="text-center">

							    </td>
							    <td class="text-center">

							    </td>
							    <td class="text-center">

							    </td>
							    <td class="text-center">

							    </td>
							    <td class="text-center">
								    <?php
								    $options_transaction['edit'] = array(
										    "class"          => '',
										    "id"             => '',
										    "title"          => 'استكمال البيانات و المراجعة',
										    "data-attribute" => '',
										    "icon"           => '',
										    "href"           => base_url(APP_NAMESPACE_URL.'/Transactions_DataEntries/Check_DataEntries/'.$Row['transaction_uuid'])
								    );

								    $options_transaction['back'] = array(
										    "class"          => '',
										    "id"             => '',
										    "title"          => 'اعادة المعاملة لقسم الاستقبال',
										    "data-attribute" => '',
										    "icon"           => '',
										    "href"           => base_url(APP_NAMESPACE_URL.'/Transactions_DataEntries/Return_Transaction/'.$Row['transaction_uuid'])
								    );

								    $options_transaction['Assignment'] = array(
										    "class"          => '',
										    "id"             => '',
										    "title"          => 'اسناد المعاملة لموظف اخر',
										    "data-attribute" => '',
										    "icon"           => '',
										    "href"           => base_url(APP_NAMESPACE_URL.'/Transactions_DataEntries/Assignment_Transaction/'.$Row['transaction_uuid'])
								    );
								    echo Create_Options_Button($options_transaction)
								    ?>
							    </td>
						    </tr>
						    <?php
					    }
					    ?>
					    </tbody>
				    </table>
				    <!--begin: Datatable -->
	                <?php
	                }
	                ?>
		    </div>
	    </div>



    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->


<script type="text/javascript">
	$(document).ready(function() {

		$('.data_table').DataTable({
			responsive: true,
			pageLength: 10,
			language: {
				'lengthMenu': 'Display _MENU_',
			}
		});

	});
</script>

