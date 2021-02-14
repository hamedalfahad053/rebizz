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

	    <form class="form" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Transactions/Create_Transaction') ?>" enctype="multipart/form-data" method="post">
		    <?= CSFT_Form() ?>

		    <input type="hidden"  name="start_time_entry" value="<?= time(); ?>">

	        <div class="card card-custom mb-5 mt-5">
	            <div class="card-header">
	                <div class="card-title">
	                    <span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
	                    <h3 class="card-label">البيانات الاساسية للطلب</h3>
	                </div>
	                <div class="card-toolbar"></div>
	            </div>
	            <div class="card-body">


		           <div class="form-group row">
			           <div class="col-lg-3 mt-5">
				           <label>طريقة الاستلام</label>
				           <?= Get_Data_List('select','LIST_METHOD_OF_RECEIPT') ?>
			           </div>
			           <div class="col-lg-3 mt-5">
				           <label>فئة العميل</label>
				           <?= Get_Data_List('select','LIST_CUSTOMER_CATEGORY') ?>
			           </div>
			           <div class="col-lg-3 mt-5">
				           <label> العميل </label>
				           <div class="col-lg-12 col-md-12 col-sm-12">
					           <select name="Client_id" id="Client_id" title="اختر من فضلك "  class="form-control selectpicker" data-size="7" data-live-search="true" >
					           </select>
				           </div>
			           </div>
			           <div class="col-lg-3 mt-5">
				           <label> نوع الطلب </label>
				           <div class="col-lg-12 col-md-12 col-sm-12">
					           <select name="Type_evaluation_request" id="Type_evaluation_request" title="اختر من فضلك "  class="form-control selectpicker" data-size="7" data-live-search="true" >

					           </select>
				           </div>
			           </div>
		           </div>

		            <div class="form-group row">
			            <div class="col-lg-3 mt-5">
				            <label>فئة العقار</label>
				            <?= Get_Select_Property_Types(); ?>
			            </div>
			            <div class="col-lg-3 mt-5">
				            <?= Creation_Field_HTML_input('INSTRUMENT_NUMBER') ?>
			            </div>
			            <div class="col-lg-3 mt-5">
                          <div id="INSTRUMENT_NUMBER_STATUS"></div>
			            </div>
			            <div class="col-lg-3 mt-5">
				            <label>تحويل المعاملة الى :</label>
				            <?php
				            echo Get_Data_List('select','LIST_TRANSFER_THE_TRANSACTION_TO')
				            ?>
			            </div>
		            </div>

		            <div class="form-group row">
			            <div class="col-lg-3 mt-5">
				            <label><?= lang('Global_Country') ?></label>
				            <div class="col-lg-12 col-md-12 col-sm-12">
					            <select name="Country_id" id="Country_id" title="اختر من فضلك "  class="form-control selectpicker" data-size="7" data-live-search="true" >
					            </select>
				            </div>
			            </div>
			            <div class="col-lg-3 mt-5">
				            <label><?= lang('Global_Region_province') ?></label>
				            <div class="col-lg-12 col-md-12 col-sm-12">
					            <select name="Region_id" id="Region_id" title="اختر من فضلك " class="form-control selectpicker" data-size="7" data-live-search="true" >
					            </select>
				            </div>
			            </div>
			            <div class="col-lg-3 mt-5">
				            <label><?= lang('Global_City') ?></label>
				            <div class="col-lg-12 col-md-12 col-sm-12">
					            <select  name="City_id" id="City_id" title="اختر من فضلك " class="form-control selectpicker" data-size="7" data-live-search="true" >
					            </select>
				            </div>
			            </div>
			            <div class="col-lg-3 mt-5">
				            <label><?= lang('Global_District') ?></label>
				            <div class="col-lg-12 col-md-12 col-sm-12">
					            <select name="District_id" id="District_id" title="اختر من فضلك " class="form-control selectpicker" data-size="7" data-live-search="true" >
					            </select>
				            </div>
			            </div>
		            </div>


	            </div>
	        </div>

		    <div class="separator separator-dashed my-8"></div>

		    <div class="card card-custom mb-3 mt-2">
			    <div class="card-header">
				    <div class="card-title">
					    <span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
					    <h3 class="card-label">مرفقات الطلب</h3>
				    </div>
				    <div class="card-toolbar"></div>
			    </div>
			    <div class="card-body">

				    <div id="kt_repeater_1">
					    <div class="form-group row" id="kt_repeater_1">
						    <div data-repeater-list="" class="col-lg-12">
							    <div data-repeater-item class="form-group row align-items-center">
								    <div class="col-md-3">
									    <label>عنوان المستند</label>
									    <input type="email" class="form-control" placeholder="Enter full name"/>
									    <div class="d-md-none mb-2"></div>
								    </div>
								    <div class="col-md-3">
									    <label>اختر الملف</label>
									    <input type="file" class="form-control-file" placeholder=""/>
									    <div class="d-md-none mb-2"></div>
								    </div>
								    <div class="col-md-4">
									    <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger">
										    <i class="la la-trash-o"></i>حذف
									    </a>
								    </div>
							    </div>
						    </div>
					    </div>
					    <div class="form-group row">
						    <label class="col-lg-2 col-form-label text-right"></label>
						    <div class="col-lg-4">
							    <a href="javascript:;" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary">
								    <i class="la la-plus"></i>اضافة المزيد
							    </a>
						    </div>
					    </div>
				    </div>


			    </div>

		    </div>

		    <div class="separator separator-dashed my-8"></div>


		    <div class="card card-custom mb-3 mt-3">
			    <div class="card-header">
				    <div class="card-title">
					    <span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
					    <h3 class="card-label">ملاحظات المعاملة</h3>
				    </div>
				    <div class="card-toolbar"></div>
			    </div>
			    <div class="card-body">
				    <div class="form-group row">
					    <div class="col-lg-12 mt-5">
						    <div class="summernote"></div>
					    </div>
				    </div>
			    </div>
		    </div>


		    <div class="card card-custom mb-5 mt-5">
			    <div class="card-footer">
				    <div class="row">
					    <div class="col-lg-6">
						    <button type="submit"   class="btn btn-primary mr-2">ارسال الطلب</button>
					    </div>
					    <div class="col-lg-6 text-lg-right">
						    <button type="reset" class="btn btn-danger"><?= lang('cancel_button') ?></button>
					    </div>
				    </div>
			    </div>
		    </div>


	    </form>



    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->


<script type="text/javascript">

	$('.summernote').summernote({
		height: 150
	});

	$('#kt_repeater_1').repeater({
		initEmpty: false,
		defaultValues: {
			'text-input': 'foo'
		},
		show: function () {
			$(this).slideDown();
		},
		isFirstItemUndeletable: true,
		hide: function (deleteElement) {
			$(this).slideUp(deleteElement);
		}
	});

    $('#INSTRUMENT_NUMBER').blur(function() {
        if($(this).val().length > 3) {
            var INSTRUMENT_NUMBER = $(this).val();
            $.ajax({
                type: 'ajax',
                method: 'get',
                async: false,
                dataType: 'html',
                url: '<?= base_url( APP_NAMESPACE_URL.'/Transactions/Check_Instrument_Number_By_Transactions') ?>',
	            data: {
		            INSTRUMENT_NUMBER:INSTRUMENT_NUMBER
	            },
                success: function (data) {
	                $("#INSTRUMENT_NUMBER_STATUS").html(data);
                },
                error: function () {
	                swal.fire(" خطا ", "في ارسال الطلب ", "error");
                }
            });
        } // if( $(this).val().length > 5 )
    })

	var arrows;
	if (KTUtil.isRTL()) {
		arrows = {
			leftArrow: '<i class="la la-angle-right"></i>',
			rightArrow: '<i class="la la-angle-left"></i>'
		}
	} else {
		arrows = {
			leftArrow: '<i class="la la-angle-left"></i>',
			rightArrow: '<i class="la la-angle-right"></i>'
		}
	}

    // Filter Clients By CATEGORY
    $('#LIST_CUSTOMER_CATEGORY').change(function(event){
	    event.preventDefault();
	    var CUSTOMER_CATEGORY  = $('select[name=LIST_CUSTOMER_CATEGORY]').val();
	    $.ajax({
		    type: 'ajax',
		    method: 'get',
		    async: false,
		    dataType: 'json',
		    url: '<?= base_url( 'Ajax/Ajax_Filter_CUSTOMER_CATEGORY') ?>',
		    data: {
			    CUSTOMER_CATEGORY:CUSTOMER_CATEGORY
		    },
		    success: function (data) {
		    	if(data.type == false){
				    swal.fire(" عفوا ", "لايوجد عملاء تحت هذه الفئة ", "error");
			    }else{
				    $("#Client_id").empty();
				    $.each(data.data, function (key, value) {
					    $("#Client_id").append('<option value=' + value.Client_id + '>' + value.Client_name + '</option>');
				    });
				    $("#Client_id").selectpicker('refresh');
			    }

		    },
		    error: function () {
			    swal.fire(" خطا ", "في ارسال الطلب ", "error");
		    }
	    });
    });



	$('.datepicker').datepicker({
		rtl: KTUtil.isRTL(),
		todayHighlight: true,
		orientation: "bottom left",
		templates: arrows
	});

	$('.selectpicker').selectpicker();

	function get_Countries(){
		$.ajax({
			type: 'ajax',
			method: 'get',
			async: false,
			dataType: 'json',
			url: '<?= base_url( 'Ajax/Get_Countries') ?>',
			success: function (data) {
				$("#Country_id").empty();
				$.each(data, function (key, value) {
					$("#Country_id").append('<option value=' + value.id + '>' + value.Name + '</option>');
				});

				$("#Country_id").selectpicker('refresh');
			},
			error: function () {
				swal.fire(" خطا ", "في ارسال الطلب ", "error");
			}
		});
	} // function get_Countries()

	get_Countries();


	$('select[name=Country_id]').val(194);
	$('select[name=Country_id]').change();


	$('#Country_id').change(function(event){
		event.preventDefault();
		var Country_id  = $('select[name=Country_id]').val();
		$.ajax({
			type: 'ajax',
			method: 'get',
			async: false,
			dataType: 'json',
			url: '<?= base_url( 'Ajax/Get_Regions') ?>',
			data: {
				Country_id: Country_id
			},
			success: function (data) {
				$("#Region_id").empty();
				$.each(data, function (key, value) {
					$("#Region_id").append('<option value=' + value.id + '>' + value.Name + '</option>');
				});
				$("#Region_id").selectpicker('refresh');
			},
			error: function () {
				swal.fire(" خطا ", "في ارسال الطلب ", "error");
			}
		});
	});


	$('#Region_id').change(function(event){
		event.preventDefault();
		var Country_id  = $('select[name=Country_id]').val();
		var Region_id   = $('select[name=Region_id]').val();
		$.ajax({
			type: 'ajax',
			method: 'get',
			async: false,
			dataType: 'json',
			url: '<?= base_url( 'Ajax/Get_Cites') ?>',
			data: {
				Country_id:Country_id,Region_id:Region_id
			},
			success: function (data) {
				$("#City_id").empty();
				$.each(data, function (key, value) {
					$("#City_id").append('<option value=' + value.id + '>' + value.Name + '</option>');
				});
				$("#City_id").selectpicker('refresh');
			},
			error: function () {
				swal.fire(" خطا ", "في ارسال الطلب ", "error");
			}
		});
	});


	$('#City_id').change(function(event){
		event.preventDefault();
		var Country_id  = $('select[name=Country_id]').val();
		var Region_id   = $('select[name=Region_id]').val();
		var City_id     = $('select[name=City_id]').val();
		$.ajax({
			type: 'ajax',
			method: 'get',
			async: false,
			dataType: 'json',
			url: '<?= base_url( 'Ajax/Get_Districts') ?>',
			data: {
				Country_id:Country_id,Region_id:Region_id,City_id:City_id
			},
			success: function (data) {
				$("#District_id").empty();
				$.each(data, function (key, value) {
					$("#District_id").append('<option value=' + value.id + '>' + value.Name + '</option>');
				});
				$("#District_id").selectpicker('refresh');
			},
			error: function () {
				swal.fire(" خطا ", "في ارسال الطلب ", "error");
			}
		});
	});




</script>
