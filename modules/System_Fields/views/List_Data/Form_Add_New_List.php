<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">
            <!--begin::Page Heading-->
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <!--begin::Page Title-->
                <h5 class="text-dark font-weight-bold my-1 mr-5"><?= $Page_Title  ?></h5>
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

        <div class="row">
            <div class="col-lg-12">

                <form class="form"  action="<?= base_url(ADMIN_NAMESPACE_URL.'/List_Data/Create_List_Data') ?>" method="post">
                    <?= CSFT_Form() ?>
                    <?php echo  $this->session->flashdata('message'); ?>

                    <div class="card card-custom">
                       <div class="card-header">
                                <div class="card-title">
                                    <span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
                                    <h3 class="card-label"><?= $Page_Title ?></h3>
                                </div>
                                <div class="card-toolbar"></div>
                            </div>
                          <div class="card-body">

                              <div class="form-group row">
                                 <div class="col-lg-4">
                                   <label><?= lang('Global_form_title_ar') ?></label>
                                   <input type="text" name="title_ar" class="form-control" value="<?= set_value('title_ar'); ?>" placeholder="<?= lang('Global_form_title_ar') ?>"/>
                                 </div>

                                 <div class="col-lg-4">
                                   <label><?= lang('Global_form_title_en') ?></label>
                                   <input type="text" name="title_en" class="form-control" value="<?= set_value('title_en'); ?>" placeholder="<?= lang('Global_form_title_en') ?>"/>
                                 </div>

                                 <div class="col-lg-4">
                                      <label><?= lang('Table_Status') ?> </label>
                                      <select name="list_status" class="form-control selectpicker" data-live-search="true">
                                          <?php
                                          foreach ($List_status AS $key => $value)
                                          {
                                              echo '<option value="'.$key.'">'.$value.'</option>';
                                          }
                                          ?>
                                      </select>
                                 </div>
                              </div>

	                          <div class="form-group row">

	                              <div class="col-lg-4">
		                              <label>نوع القائمة</label>
		                              <select name="list_type" id="list_type" class="form-control selectpicker" data-live-search="true">
			                              <option value="OPTIONS">خيارات</option>
			                              <option value="TABLE">جدول بيانات</option>
		                              </select>
	                              </div>

	                              <div class="col-lg-4">
		                              <label>قائمة  تظهر للعميل</label>
		                              <select name="list_view" title="اختر من فضلك" class="form-control selectpicker" data-live-search="true">
				                        <option value="0">لا</option>
			                            <option value="1">نعم</option>
		                              </select>
	                              </div>

                              </div>

                          </div>
                    </div><!--<div class="card card-custom">-->




	                <div class="card card-custom  mt-10" id="div_Create_Table" style="display:none">
		                <div class="card-header">
			                <div class="card-title">
				                <span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
				                <h3 class="card-label"> ربط الخيارات بجدول بيانات </h3>
			                </div>
			                <div class="card-toolbar"></div>
		                </div>
		                <div class="card-body">
			                <div class="form-group row">
				                <div class="col-lg-6">
					                <label>  اختر جدول البيانات المطلوب </label>
					                <select name="Table_primary"  id="Table_primary" class="form-control selectpicker" data-live-search="true">
						                <?php
						                foreach ($tables_db AS $table)
						                {
							                echo '<option value="'.$table.'">'.$table.'</option>';
						                }
						                ?>
					                </select>
				                </div>
				                <div class="col-lg-6">
					                <label>  اختر حقل القيمة </label>
					                <select name="Table_primary_fields" id="Table_primary_fields"  class="form-control selectpicker" data-live-search="true"></select>
				                </div>
			                </div>

			                <div class="form-group row">
				                <div class="checkbox-list">
					                <label class="checkbox">
						                <input type="checkbox" value="1" name="Linking_table"/>
						                <span></span>
						                ربط جدول اضافي اذا كان نفس الجدول اترك الحقل
					                </label>
				                </div>
			                </div>

			                <div class="form-group row mt-10">
				                <div class="col-lg-6">
					                <label>  اختر جدول البيانات المطلوب </label>
					                <select name="Table_Join"  id="Table_Join" class="form-control selectpicker" data-live-search="true">
						                <?php
						                foreach ($tables_db AS $table)
						                {
							                echo '<option value="'.$table.'">'.$table.'</option>';
						                }
						                ?>
					                </select>
				                </div>
				                <div class="col-lg-6">
					                <label>  اختر حقل العنوان </label>
					                <select name="Table_Join_fields" id="Table_Join_fields"  class="form-control selectpicker" data-live-search="true"></select>
				                </div>
			                </div>
			                <?= Create_Status_Alert(array("key"=>'Warning',"value"=>'يجب ان تكون قيمة الحقل الاساسي مطابقة لقيمة الحقل الثانوي')); ?>
			                <div class="form-group row mt-10">
				                <div class="col-lg-6">
					                <label>  حقل الجدول الاساسي </label>
					                <select name="Table_primary_joining_fields" id="Table_primary_joining_fields"  class="form-control selectpicker" data-live-search="true"></select>
				                </div>
				                <div class="col-lg-6">
					                <label>  حقل الجدول الثانوي </label>
					                <select name="Table_Join_joining_fields" id="Table_Join_joining_fields"  class="form-control selectpicker" data-live-search="true"></select>
				                </div>
			                </div>
		                </div>
	                </div><!--<div class="card card-custom">-->



	                <div class="card card-custom  mt-10" id="div_Create_options" style="display:none">
		                <div class="card-header">
			                <div class="card-title">
				                <span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
				                <h3 class="card-label">خيارات القائمة</h3>
			                </div>
			                <div class="card-toolbar"></div>
		                </div>
		                <div class="card-body">

			                <div id="kt_repeater">
				                <div class="form-group row">
					                <div data-repeater-list="option_list" class="col-lg-12">
						                <div data-repeater-item class="form-group row align-items-center">
							                <div class="col-md-2">
								                <label><?= lang('Global_form_title_ar') ?></label>
								                <input type="text" name="option_ar" value="<?php echo set_value('option_ar'); ?>" class="form-control" placeholder="<?= lang('Global_form_title_ar') ?>"/>
								                <div class="d-md-none mb-2"></div>
							                </div>
							                <div class="col-md-2">
								                <label><?= lang('Global_form_title_en') ?></label>
								                <input type="text" name="option_en" value="<?php echo set_value('option_en'); ?>" class="form-control" placeholder="<?= lang('Global_form_title_en') ?>"/>
								                <div class="d-md-none mb-2"></div>
							                </div>
							                <div class="col-md-2">
								                <label><?= lang('Table_Status') ?></label>
								                <select name="options_status" title="اختر"  class="form-control">
									                <?php
									                foreach ($List_status AS $key => $value)
									                {
										                echo '<option value="'.$key.'">'.$value.'</option>';
									                }
									                ?>
								                </select>
								                <div class="d-md-none mb-2"></div>
							                </div>
							                <div class="col-md-2">
								                <label><?= lang('options_status') ?></label>
								                <select name="options_status_system" title="اختر"  class="form-control">
									                <?php
									                foreach ($List_status_system AS $key => $value)
									                {
										                echo '<option value="'.$key.'">'.$value.'</option>';
									                }
									                ?>
								                </select>
								                <div class="d-md-none mb-2"></div>
							                </div>
							                <div class="col-md-2">
								                <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger"><i class="la la-trash-o"></i>حذف</a>
							                </div>
						                </div>
					                </div>
				                </div>
				                <div class="form-group row">
					                <label class="col-lg-2 col-form-label text-right"></label>
					                <div class="col-lg-4">
						                <a href="javascript:;" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary"><i class="la la-plus"></i> اضافة المزيد</a>
					                </div>
				                </div>
			                </div>
		                </div>
	                </div><!--<div class="card card-custom">-->



                    <div class="card card-custom  mt-10">
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
                    </div>
                </form>


            </div>
        </div>

    </div>
    <!--end::Container-->




</div>
<!--end::Entry-->

<script type="text/javascript">

    $('.selectpicker').selectpicker({   noneSelectedText : '<?= lang('Select_noneSelectedText'); ?>' });

    $('#list_type').change(function(event){
	    event.preventDefault();
	    var list_type   = $('select[name=list_type]').val();
	    if (list_type === 'OPTIONS') {
		    $("#div_Create_Table").hide();
            $("#div_Create_options").show();
	    }else{
		    $("#div_Create_options").hide();
	    }
	    if (list_type === 'TABLE') {
		    $("#div_Create_options").hide();
		    $("#div_Create_Table").show();
	    }else{
		    $("#div_Create_Table").hide();
	    }
    });

    $('#kt_repeater').repeater({
        initEmpty: false,
        defaultValues: {
            'text-input': 'foo',
        },
        show: function () {
            $(this).slideDown();
        },
        hide: function (deleteElement) {
	        if(confirm('هل انت متأكد من عملية حذف العنصر ؟')) {
		        $(this).slideUp(deleteElement);
	        }
        },
        isFirstItemUndeletable: true
    });

    $('#Table_primary').change(function(event){
	    event.preventDefault();
	    var table_data   = $('select[name=Table_primary]').val();
	    $.ajax({
		    type: 'ajax',
		    method: 'get',
		    async: false,
		    dataType: 'json',
		    url: '<?= base_url( ADMIN_NAMESPACE_URL.'/List_Data/Ajax_fields_Table_Database') ?>',
		    data: {
			    table_data:table_data
		    },
		    success: function (data) {
			    $("#Table_primary_fields").empty();
			    $.each(data, function (key, value) {
				    $("#Table_primary_fields").append('<option value=' + value.id + '>' + value.Name + '</option>');
				    $("#Table_Join_joining_fields").append('<option value=' + value.id + '>' + value.Name + '</option>');
			    });
			    $("#Table_primary_fields").selectpicker('refresh');
			    $("#Table_Join_joining_fields").selectpicker('refresh');
		    },
		    error: function () {
			    swal.fire(" خطا ", "في ارسال الطلب ", "error");
		    }
	    });
    });

    $('#Table_Join').change(function(event){
	    event.preventDefault();
	    var table_data   = $('select[name=Table_Join]').val();
	    $.ajax({
		    type: 'ajax',
		    method: 'get',
		    async: false,
		    dataType: 'json',
		    url: '<?= base_url( ADMIN_NAMESPACE_URL.'/List_Data/Ajax_fields_Table_Database') ?>',
		    data: {
			    table_data:table_data
		    },
		    success: function (data) {
			    $("#Table_Join_fields").empty();
			    $.each(data, function (key, value) {
				    $("#Table_Join_fields").append('<option value=' + value.id + '>' + value.Name + '</option>');
				    $("#Table_primary_joining_fields").append('<option value=' + value.id + '>' + value.Name + '</option>');
			    });
			    $("#Table_Join_fields").selectpicker('refresh');
			    $("#Table_primary_joining_fields").selectpicker('refresh');
		    },
		    error: function () {
			    swal.fire(" خطا ", "في ارسال الطلب ", "error");
		    }
	    });
    });
</script>


