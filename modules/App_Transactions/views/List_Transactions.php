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


                    <?php echo  $this->session->flashdata('message'); ?>
	                <?php
	                if($Transactions == false){

		                $msg_result['key'] = 'Danger';
		                $msg_result['value'] = 'لا يوجد معاملات تم انشاؤها حاليا';
		                $msg_result_view = Create_Status_Alert($msg_result);
                        echo $msg_result_view;

	                }else{
	                ?>




	                <?php
	                }
	                ?>


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

