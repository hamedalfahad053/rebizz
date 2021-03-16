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
                    <?= Create_One_Button_Text(array('class' => "Create_Transaction",'title'=> 'انشاء طلب جديد','href'=> '#')) ?>
                </div>
            </div>
            <div class="card-body">
                <div class="card-body">

                    <?php echo  $this->session->flashdata('message'); ?>


	                <?php
	                if($Transactions==false){

		                $msg_result['key'] = 'Danger';
		                $msg_result['value'] = 'لا يوجد معاملات تم انشاؤها حاليا';
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
		                           <img src="<?= $Row['Client_logo']; ?>" height="35" width="35" >
		                            <br>
		                            <?= $Row['transaction_number']; ?>
		                            <br>
		                            <?= Create_Status_badge(array("key"=>"Success","value"=>$Row['LIST_METHOD_OF_RECEIPT'])); ?>
	                            </td>
	                            <td class="text-center">
		                            <?= $Row['OWNER_REAL_ESTATE'] ?> - <?= $Row['OWNER_IDENTITY_NUMBER'] ?> - <?= $Row['OWNERS_MOBILE_NUMBER'] ?>
		                            <br>
		                            <?= $Row['OWNER_APPLICANT_EVALUATION'] ?> - <?= $Row['OWNER_APPLICANT_IDENTITY_NUMBER'] ?> - <?= $Row['OWNER_MOBILE_EVALUATION'] ?>
	                            </td>
		                        <td class="text-center"><?= $Row['location_Property'] ?></td>
	                            <td class="text-center"><?= $Row['Create_Transaction_By_id'] ?> - <?= $Row['Create_Transaction_Date'] ?></td>
		                        <td class="text-center"><?= $Row['Transaction_Status'] ?></td>
		                        <td class="text-center"><?= $Row['Options_Transaction'] ?></td>
	                        </tr>
	                        <?php
	                        }
                        ?>
                        </tbody>
                    </table>
	                <?php
	                } // if($Transactions==false)
	                ?>
                    <!--begin: Datatable -->


                </div>
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

