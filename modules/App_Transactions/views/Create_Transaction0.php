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

	    <form class="form" id="Form_Create_Transaction" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Transactions/Submit_Create_Transaction') ?>" enctype="multipart/form-data" method="post">
		    <?= CSFT_Form() ?>

		    <?php echo  $this->session->flashdata('message'); ?>


		    <input type="hidden" name="Transaction_Numbering" value="<?= $Transaction_Numbering->transaction_id ?>">

	        <div class="card card-custom mb-5 mt-5">
	            <div class="card-header">
	                <div class="card-title">
	                    <span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
	                    <h3 class="card-label">البيانات الاساسية للطلب</h3>
	                </div>
	                <div class="card-toolbar">
		                رقم المعاملة

		                <?= Create_Status_badge(array("key"=>"Success","value"=> date('Ymd').'-'.$Transaction_Numbering->transaction_id )); ?>

		                 تاريخ / وقت الانشاء

		                <?= Create_Status_badge(array("key"=>"Success","value"=> date('Y-m-d h:i:s a',$Transaction_Numbering->Create_Transaction_Date) )); ?>

	                </div>
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
					            <label> العميل
						            <a href="javascript:void(0);" data-toggle="modal" data-target="#CreateNewClient" class="">أضافة عميل جديد</a>
					            </label>
					            <div class="col-lg-12 col-md-12 col-sm-12">
						            <select name="Client_id" id="Client_id" title="اختر من فضلك "  class="form-control selectpicker" data-size="7" data-live-search="true" ></select>
					            </div>
				            </div>
				            <div class="col-lg-3 mt-5">
					            <label>نوع الطلب</label>
					            <div class="col-lg-12 col-md-12 col-sm-12">
						            <?= Get_Data_List('select','LIST_TYPES_OF_REAL_ESTATE_APPRAISAL') ?>
					            </div>
				            </div>
			            </div>

			            <div class="form-group row">
				            <div class="col-lg-3 mt-5">
					            <label>فئة العقار</label>
					            <?= Get_Select_Property_Types(); ?>
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


		                <div class="form-group row" >
			                <div class="col-lg-3 mt-5">
				                <?= Creation_Field_HTML_input('COMMISSIONING_NUMBER'); ?>
			                </div>
			                <div class="col-lg-3 mt-5">
				                <?= Creation_Field_HTML_input('DATE_AND_TIME_OF_COMMISSIONING'); ?>
			                </div>
			                <div class="col-lg-3 mt-5">
				                <?= Creation_Field_HTML_input('DATE_REQUIRED_FOR_DELIVERY'); ?>
			                </div>
			                <div class="col-lg-3 mt-5">
				                <?= Creation_Field_HTML_input('REQUIRED_DELIVERY_TIME'); ?>
			                </div>
		                </div>


		                 <div class="separator separator-dashed separator-border-1 mt-5 mb-5"></div>

				        <div class="form-group row">
			                <div class="col-lg-3 mt-5">
				                <?= Creation_Field_HTML_input('INSTRUMENT_NUMBER'); ?>
			                </div>
			                <div class="col-lg-3 mt-5">
				                <?= Creation_Field_HTML_input('DATE__INSTRUMENT'); ?>
			                </div>
			                <div class="col-lg-3 mt-5">
				                <?= Creation_Field_HTML_input('BUILDING_CLEARANCE_NUMBER'); ?>
			                </div>
				            <div class="col-lg-3 mt-5">
					            <?= Creation_Field_HTML_input('DATE_OF_BUILDING_CLEARANCE'); ?>
				            </div>
		                </div>

		                <div class="separator separator-dashed separator-border-1 mt-5 mb-5"></div>

			            <div class="form-group row">
				            <div class="col-lg-4 mt-5">
					            <?= Creation_Field_HTML_input('OWNER_REAL_ESTATE'); ?>
				            </div>
				            <div class="col-lg-4 mt-5">
					            <?= Creation_Field_HTML_input('OWNER_IDENTITY_NUMBER'); ?>
				            </div>
				            <div class="col-lg-4 mt-5">
					            <?= Creation_Field_HTML_input('OWNERS_MOBILE_NUMBER'); ?>
				            </div>
				            <div class="col-lg-4 mt-5">
					            <?= Creation_Field_HTML_input('OWNER_APPLICANT_EVALUATION'); ?>
				            </div>
				            <div class="col-lg-4 mt-5">
					            <?= Creation_Field_HTML_input('OWNER_APPLICANT_IDENTITY_NUMBER'); ?>
				            </div>
				            <div class="col-lg-4 mt-5">
					            <?= Creation_Field_HTML_input('OWNER_MOBILE_EVALUATION'); ?>
				            </div>
			            </div>

		                 <div class="form-group row">
				            <div class="col-lg-12 mt-5">
				                 <div id="Status_Transaction"></div>
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

				    <fieldset class="todos_labels">
					    <div class="repeatable"></div>
					    <div class="form-group" style="text-align:center;">
						    <input type="button" value="اضف المزيد" class="btn btn-primary add" align="center">
					    </div>
				    </fieldset>

			    </div>
		    </div>


		    <div class="card card-custom mb-3 mt-2">
			    <div class="card-header">
				    <div class="card-title">
					    <span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
					    <h3 class="card-label">ملاحظات عامة</h3>
				    </div>
				    <div class="card-toolbar"></div>
			    </div>
			    <div class="card-body">

			    </div>
		    </div>


		    <div class="card card-custom mb-5 mt-5">
			    <div class="card-footer">
				    <div class="row">
					    <div class="col-lg-6">
						    <button type="submit"   class="btn btn-primary mr-2">ارسال الطلب</button>
					    </div>
					    <div class="col-lg-6 text-lg-right">
						    <a href="<?= base_url(APP_NAMESPACE_URL.'/Transactions/Cancel_Create_Transaction') ?>" class="btn btn-danger"><?= lang('cancel_button') ?></a>
					    </div>
				    </div>
			    </div>
		    </div>

	    </form>



    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->




<script type="text/template" id="todos_labels">

	<div class="field-group row">
		<div class="col-lg-4 mt-5">
			<label for="NameFile_{?}">اسم الملف</label>
			<div class="col-lg-12 col-md-12 col-sm-12">
				<input type="text" name="FILE_Name[]" id="FILE_Name[{?}]"  class="form-control">
			</div>
		</div>
		<div class="col-lg-4 mt-5">
			<label for="File_{?}">مرفقات المعاملة</label>
			<div class="col-lg-12 col-md-12 col-sm-12">
				<input type="file" name="FILE_Transaction[]" id="FILE_Transaction[{?}]" class="form-control-file">
			</div>
		</div>
		<div class="col-lg-4 mt-5">
			<label for=""></label>
			<input type="button" class="btn btn-danger span-2 delete" value="حذف" />
		</div>
	</div>

</script>


<?= import_js(BASE_ASSET.'js/pages/crud/forms/editors/summernote',''); ?>
<?= import_js(BASE_ASSET.'plugins/jquery.repeatable',''); ?>



<script type="text/javascript">
	// function autosave() {
	// 	jQuery('form').each(function() {
	// 		jQuery.ajax({
	// 			url: 'savetest.php',
	// 			data: {
	// 				'autosave' : true,
	// 				'formData' : jQuery(this).serialize()},
	// 			type: 'POST',
	// 			success: function(data){

	// 			}// end successful POST function
	// 		}); // end jQuery ajax call
	// 	}); // end setting up the autosave on every form on the page
	// }// end function autosave()
	//
	// jQuery(function($) {
	// 	setInterval(autosave, 30 * 1000);
	// });
</script>



<script type="text/javascript">


	$(function() {
		$(".todos_labels .repeatable").repeatable({
			addTrigger: ".todos_labels .add",
			deleteTrigger: ".todos_labels .delete",
			template: "#todos_labels",
			startWith: 1,
			max:10
		});
	});

    $('#INSTRUMENT_NUMBER').blur(function() {
        if($(this).val().length > 1) {
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
	                $("#Status_Transaction").html(data);
                },
                error: function () {
	                swal.fire(" خطا ", "في ارسال الطلب ", "error");
                }
            });
        } // if( $(this).val().length > 5 )
    })


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
				    $("#Client_id").empty();
				    $("#Client_id").selectpicker('refresh');
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
	// Filter Clients By CATEGORY

	function Get_Regions() {
		var Country_id = 194;
		$.ajax({
			type: 'ajax',
			method: 'get',
			async: false,
			dataType: 'json',
			url: '<?= base_url('Ajax/Get_Regions') ?>',
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
	}

	Get_Regions();

	$('#Region_id').change(function(event){
		event.preventDefault();
		var Country_id  = 194;
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
		var Country_id  = 194;
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
				$("#District_id").append('<option value="0"><?= lang('unknown') ?></option>');
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
