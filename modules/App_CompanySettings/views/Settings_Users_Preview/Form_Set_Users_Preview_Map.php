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

		<div class="row">
			<div class="col-lg-12 mt-5">

				<div class="card card-custom mt-5">
					    <!--begin::Header-->
					    <div class="card-header">
					        <div class="card-title">
					            <h3 class="card-label">توزيع المعاينين على المناطق الجغرافية</h3>
					        </div>
					    </div>
					    <!--end::Header-->
				        <!--begin::Body-->
					    <form class="form" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Settings_Preview/Update_Set_Users_Preview_Map') ?>" method="post">
				        <div class="card-body">
							        <?= CSFT_Form() ?>
					                <input type="hidden" name="Users_Preview" value="<?=  $this->uri->segment(4); ?>">
							        <div class="form-group row">
							        <div class="col-lg-6 mt-5">
								        <label><?= lang('Global_Region_province') ?></label>
								        <div class="col-lg-12 col-md-12 col-sm-12">
									        <select name="Region_id" id="Region_id" title="اختر من فضلك" class="form-control selectpicker" data-size="7" data-live-search="true" >
									        </select>
								        </div>
							        </div>
							        <div class="col-lg-6 mt-5">
								        <label>المدينة</label>
								        <div class="col-lg-12 col-md-12 col-sm-12">
									        <select  name="City_id" id="City_id" title="اختر من فضلك" class="form-control selectpicker" data-size="7" data-live-search="true" >
									        </select>
								        </div>
							        </div>
<!--							        <div class="col-lg-4 mt-5">-->
<!--								        <label>الاحياء</label>-->
<!--								        <div class="col-lg-12 col-md-12 col-sm-12">-->
<!--									        <select name="District_id[]" id="District_id" title="اختر من فضلك" class="form-control selectpicker"  multiple="multiple" data-size="7" data-live-search="true" >-->
<!--									        </select>-->
<!--								        </div>-->
<!--							        </div>-->
						        </div>
				        </div>
					    <!--begin::Body-->
						<div class="card card-custom  mt-10">
							    <div class="card-footer">
								    <div class="row">
									    <div class="col-lg-6">
										    <button type="submit" class="btn btn-primary mr-2">تحديث</button>
									    </div>
									    <div class="col-lg-6 text-lg-right">
										    <button type="reset" class="btn btn-danger"><?= lang('cancel_button') ?></button>
									    </div>
								    </div>
							    </div>
						</div>
					    </form>
				</div>

			</div><!--<div class="col-lg-12 mt-5">-->
		</div>

	</div>
	<!--end::Container-->
</div>
<!--end::Entry-->

<?php
	$where_Assignment = array("users_preview_id" => $this->uri->segment(4),"company_id"=>app()->aauth->get_user()->company_id);
	$Get_Assignment_Map_users_preview = Get_Assignment_Map_users_preview($where_Assignment);

	if($Get_Assignment_Map_users_preview->num_rows()>0){

		$Map_users_preview = $Get_Assignment_Map_users_preview->row();
		$Get_Regions       = @Get_Regions(194,$Map_users_preview->regions_id)->row();
		$Get_City          = @Get_City(194,$Map_users_preview->regions_id,$Map_users_preview->city_id)->row();
		$Get_Districts     = @Get_Districts(194,$Map_users_preview->regions_id,$Map_users_preview->city_id)->result();

	}

	?>
<script type="text/javascript">

      function Get_Regions()
      {
      	  var selected = '';
	      var Country_id =194;
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
				      $("#Region_id").append('<option '+ selected +' value=' + value.id + '>' + value.Name + '</option>');
			      });

			      $("#Region_id").selectpicker('refresh');

			      $("#Region_id").trigger("change");

		      },
		      error: function () {
			      swal.fire(" خطا ", "في ارسال الطلب ", "error");
		      }
	      });
      }

      Get_Regions();


      $("#Region_id").change(function(event){
		      event.preventDefault();

		      var selected = '';
		      var Country_id = 194;
		      var Region_id = $('select[name=Region_id]').val();
		      $.ajax({
			      type: 'ajax',
			      method: 'get',
			      async: false,
			      dataType: 'json',
			      url: '<?= base_url('Ajax/Get_Cites') ?>',
			      data: {
				      Country_id: Country_id, Region_id: Region_id
			      },
			      success: function (data) {
				      $("#City_id").empty();

				      $.each(data, function (key, value) {
					      $("#City_id").append('<option ' + selected + ' value=' + value.id + '>' + value.Name + '</option>');
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

