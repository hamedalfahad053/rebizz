
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

<?php
$Form_id = $this->uri->segment(4);
?>



<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
	<!--begin::Container-->
	<div class="container-fluid">


		    <?php echo  $this->session->flashdata('message'); ?>
		    <form class="form" id="FormAddFields" action="<?= base_url(ADMIN_NAMESPACE_URL.'/Forms/Create_List_Components') ?>" method="post">
			<?= CSFT_Form() ?>


                <div class="card card-custom">
	                <div class="card-header">
		                <div class="card-title">
			                <h3 class="card-label"> اضافة قائمة بيانات  </h3>
		                </div>
		                <div class="card-toolbar">
		                </div>
	                </div>
	                <!--end::Header-->
                    <div class="card-body">
	                    <input type="hidden"  name="Form_id"       value="<?= $this->uri->segment(4) ?>" />
	                    <input type="hidden"  name="Components_id" value="<?= $this->uri->segment(5) ?>" />
	                    <div class="form-group row">

		                    <div class="col-lg-3 mt-5">
			                    <label> نوع  القائمة </label>
			                    <select name="Fields_data" id="Fields_data" title="اختر من فضلك " class="form-control selectpicker" data-size="7" data-live-search="true">
				                    <option value="options">خيارات القائمة مباشرة</option>
				                    <option value="options_table">خيارات جدول مباشرة</option>
				                    <option value="table_to_table_ajax">خيارات جدول مرتبطة بجدول اخر</option>
				                    <option value="options_to_options_ajax">قائمة مرتبطة بقائمة اخرى</option>
				                    <option value="options_to_table_ajax">قائمة تفلتر جدول</option>

				                    <option value="ajax">تعريف قائمة للاجاكس</option>
			                    </select>
		                    </div>

		                    <div class="col-lg-3 mt-5">
			                    <label>القائمة</label>
			                    <select name="List_id" id="List_id" class="form-control selectpicker" data-size="7" data-live-search="true">
				                    <?php
				                    foreach ($Get_All_List AS $Row_List)
				                    {
					                    echo '<option value="'.$Row_List->list_id.'">'.$Row_List->item_translation.'</option>';
				                    }
				                    ?>
			                    </select>
		                    </div>

	                    </div>
	                    <div class="form-group row">
		                    <div class="col-lg-3 mt-5">
			                    <label> فئة العميل </label>
			                    <?= Creation_List_HTML('select', 'LIST_CUSTOMER_CATEGORY', '','','options', '1','','','',array( 0=> "selectpicker"),'','','') ?>
			                    <label class="checkbox mt-7">
				                    <input type="checkbox" value="1"  checked="checked" name="All_CUSTOMER_CATEGORY"/>
				                    <span></span>
				                    عام لجميع العملاء
			                    </label>
		                    </div>
		                    <div class="col-lg-3 mt-5">
			                    <label> فئة العقار </label>
			                    <?= Get_Select_Property_Types('select','','1', '','') ?>
			                    <label class="checkbox mt-5">
				                    <input type="checkbox" value="1"  checked="checked" name="All_Property_Types"/>
				                    <span></span>
				                    عام لجميع العقارات
			                    </label>
		                    </div>
		                    <div class="col-lg-3 mt-5">
			                    <label> فئة الطلب </label>
			                    <?= Creation_List_HTML('select', 'LIST_TYPES_OF_REAL_ESTATE_APPRAISAL', '','','options', '1','','','',array( 0=> "selectpicker"),'','','') ?>

			                    <label class="checkbox mt-7">
				                    <input type="checkbox" value="1"  checked="checked" name="All_TYPES_APPRAISAL"/>
				                    <span></span>
				                    عام لجميع الطلبات
			                    </label>
		                    </div>
		                    <div class="col-lg-3 mt-5">
			                    <label> طريقة  التقييم </label>
			                    <?= Get_Select_evaluation_methods('select', '',1, '','evaluation_methods') ?>
			                    <label class="checkbox mt-5">
				                    <input type="checkbox" value="1"  checked="checked" name="All_evaluation_methods"/>
				                    <span></span>
				                    عام طرق التقييم
			                    </label>
		                    </div>
	                    </div>
                    </div>
                </div>

				<div class="card card-custom mt-10">
					<div class="card-header">
						<div class="card-title">
							<h3 class="card-label"> ارتباط القائمة  </h3>
						</div>
						<div class="card-toolbar">
						</div>
					</div>
					<!--end::Header-->
					<div class="card-body">

						<div id="Linking_Lists"></div>

					</div>
				    <div class="card-footer">
			           <div class="row">
				          <div class="col-lg-12">
					         <button type="submit"  class="btn btn-primary mr-2"><?= lang('add_button') ?></button>
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
	$('#List_id,#Fields_data').change(function(event){
		event.preventDefault();

		var Fields_data = $('select[name=Fields_data]').val();
		var List_id     = $('select[name=List_id]').val();

	          $.ajax({
		          type: 'ajax',
		          method: 'get',
		          async: false,
		          dataType: 'html',
		          url: '<?= base_url(ADMIN_NAMESPACE_URL . '/Forms/Ajax_Setting_List') ?>',
		          data: {
			          Fields_data: Fields_data, List_id: List_id
		          },
		          success: function (data) {
			          $("#Linking_Lists").html(data);
			          $('.selectpicker').selectpicker('refresh');
		          },
		          error: function () {
			          swal.fire(" خطا ", "في ارسال الطلب ", "error");
		          }
	          });
	});
</script>

