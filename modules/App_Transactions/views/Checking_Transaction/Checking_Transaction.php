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
                <div class="card-toolbar"></div>
            </div>
            <div class="card-body">

                <div class="form-group row">
                    <div class="col-lg-4 mt-5">
                        <label>رقم الصك</label>
                        <input type="text" id="INSTRUMENT_NUMBER" name="INSTRUMENT_NUMBER" class="form-control" placeholder="رقم الصك"/>
	                    <span class="form-text text-muted"> لا يقبل ادخل الحروف فقط الارقام من  <code>0-9</code></span>
                    </div>
                    <div class="col-lg-4 mt-5">
                        <label>رقم التكليف</label>
                        <input type="text" id="COMMISSIONING_NUMBER" name="COMMISSIONING_NUMBER" class="form-control" placeholder="رقم التكليف"/>
	                    <span class="form-text text-muted"> لا يقبل ادخل الحروف فقط الارقام من  <code>0-9</code></span>
                    </div>
                    <div class="col-lg-4 mt-5">
                        <label>هوية طالب التقييم</label>
                        <input type="text" id="OWNER_APPLICANT_IDENTITY_NUMBER" name="OWNER_APPLICANT_IDENTITY_NUMBER" class="form-control" placeholder="هوية طالب التقييم"/>
	                    <span class="form-text text-muted"> لا يقبل ادخل الحروف فقط الارقام من  <code>0-9</code></span>
                    </div>
                </div>


	            <div id="Check_Instrument_Number_By_Transactions"></div>


            </div>
        </div>



    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->





<script type="text/javascript">

	// Entry Integer only
	$("#INSTRUMENT_NUMBER,#COMMISSIONING_NUMBER,#OWNER_APPLICANT_IDENTITY_NUMBER").inputmask({
		"mask": "9",
		"repeat": 10,
		"greedy": false
	});

    $('#INSTRUMENT_NUMBER,#COMMISSIONING_NUMBER,#OWNER_APPLICANT_IDENTITY_NUMBER').blur(function() {


            var INSTRUMENT_NUMBER = $('#INSTRUMENT_NUMBER').val();
            var COMMISSIONING_NUMBER = $('#COMMISSIONING_NUMBER').val();
            var OWNER_APPLICANT_IDENTITY_NUMBER = $('#OWNER_APPLICANT_IDENTITY_NUMBER').val();

            $.ajax({
                type: 'ajax',
                method: 'get',
                async: false,
                dataType: 'json',
                url: '<?= base_url( APP_NAMESPACE_URL.'/Transactions/Create_Transaction/Query_Ajax_Transaction') ?>',
                data: {
                    INSTRUMENT_NUMBER:INSTRUMENT_NUMBER,
                    COMMISSIONING_NUMBER:COMMISSIONING_NUMBER,
                    OWNER_APPLICANT_IDENTITY_NUMBER:OWNER_APPLICANT_IDENTITY_NUMBER
                },
                success: function (result) {
	                $("#Check_Instrument_Number_By_Transactions").empty();
                    $("#Check_Instrument_Number_By_Transactions").html(result.Transaction_Table);
                },
                error: function () {
                    swal.fire(" خطا ", "في ارسال الطلب ", "error");
                }
            });

    });
</script>