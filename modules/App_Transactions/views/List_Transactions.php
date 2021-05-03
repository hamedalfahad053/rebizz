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
				    $msg_result['value'] = 'لا يوجد معاملات';
				    $msg_result_view = Create_Status_Alert($msg_result);
				    echo $msg_result_view;
			    }else{
				    ?>

				    <style>th.dt-center,.dt-center { text-align: center; }</style>
				    <table class="data_table table table-bordered table-hover display nowrap" width="100%">
					    <thead>
					    <tr>
						    <th class="text-center">رقم المعاملة</th>

						    <th class="text-center">المالك</th>
						    <th class="text-center">طالب التقييم</th>

						    <th class="text-center">موقع العقار</th>
						    <th class="text-center">بواسطة / التاريخ</th>
						    <th class="text-center">نوع التقييم</th>
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


								    <img src="
								    <?php

								    $path = $LoginUser_Company_Path_Folder.'/'.FOLDER_FILE_Company_client_logo.'/';
								    echo Get_Client_Logo($LoginUser_Company_Path_Folder,$this->aauth->get_user()->company_id,Transaction_data_by_key($Row['transaction_id'],1,1,'LIST_CLIENT'));
								    ?>"  height="35" width="35" >

								    <br>

								    <?= date('Ymd',$Row['Create_Transaction_Date']).$Row['transaction_id'];?>

							    </td>

							    <?php
							    if(Transaction_data_by_key($Row['transaction_id'],13,4,'OWNER_REAL_ESTATE')){
							    ?>
							    <td class="text-center">
								    <?= Transaction_data_by_key($Row['transaction_id'],13,4,'OWNER_REAL_ESTATE') ?>
								    <?= Transaction_data_by_key($Row['transaction_id'],13,4,'OWNERS_MOBILE_NUMBER') ?>
							    </td>
							    <td class="text-center">
								    <?= Transaction_data_by_key($Row['transaction_id'],13,4,'OWNER_APPLICANT_EVALUATION') ?>
								    <?= Transaction_data_by_key($Row['transaction_id'],13,4,'OWNER_MOBILE_EVALUATION') ?>
							    </td>
							    <?php
							    }else{
							    ?>
								    <td class="text-center">--</td><td class="text-center">--</td>
							    <?php
							    }
							    ?>

							    <td class="text-center">
								    <?php
								    $d = Transaction_data_by_key($Row['transaction_id'],1,1,'LIST_REGION');
								    echo get_data_options_List_view(20,$d);
								    ?>
								     -
								    <?php
								    $d = Transaction_data_by_key($Row['transaction_id'],1,1,'LIST_CITY');
								    echo get_data_options_List_view(21,$d);
								    ?>
								     -
								    <?php
								    $d = Transaction_data_by_key($Row['transaction_id'],1,1,'LIST_DISTRICT');
								    echo get_data_options_List_view(22,$d);
								    ?>
							    </td>
							    <td class="text-center">
								    <?= $this->aauth->get_user($Row['Create_Transaction_By_id'])->full_name ?>
								    <br>
								    <?= date('Y-m-d h:i:s a',$Row['Create_Transaction_Date']);?>
							    </td>
							    <td class="text-center">
								    <?php
								    $d = Transaction_data_by_key($Row['transaction_id'],1,1,'LIST_TYPES_OF_REAL_ESTATE_APPRAISAL');
								    echo get_data_options_List_view(4,$d);
								    ?>
							    </td>
							    <td class="text-center">
								    <?php
								    echo get_data_options_List_view(29,$Row['Transaction_Stage'],'key');
								    ?>
								    <br>

							    </td>
							    <td class="text-center">
								    <?=  get_data_options_List_view(9,$Row['Transaction_Status_id']); ?>
							    </td>
							    <td class="text-center">
								    <?=  $Row['transaction_options'] ?>
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

		$(".Create_Transaction").click(function(e) {
			e.preventDefault();

			Swal.fire({
				title: "انشاء معاملة جديدة",
				text: "سيتم انشاء رقم معاملة مباشرة هل انت متأكد من انشاء معاملة جديدة",
				icon: "warning",
				showCancelButton: true,
				confirmButtonText: "نعم تابع",
				cancelButtonText: "الغاء الامر",
				reverseButtons: true

		}).then(function(result) {
				if (result.value) {
					window.location= "<?= base_url(APP_NAMESPACE_URL.'/Transactions/Create_Transaction/') ?>"
				} else if (result.dismiss === "cancel") {
					Swal.fire("الغاء العملية", "تم الغاء طلب انشاء معاملة جديدة", "error");
				}
			});
		});


		$('.data_table').DataTable({
			responsive: true,
			pageLength: 10,
			language: {
				'lengthMenu': 'Display _MENU_',
			}
		});

	});
</script>

