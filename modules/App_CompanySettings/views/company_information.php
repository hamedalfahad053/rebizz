<?php echo  $this->session->flashdata('message'); ?>

<form class="form" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Settings/Update_information') ?>" method="post">
	<?= CSFT_Form() ?>

	<div class="card card-custom">
		<div class="card-header">
			<div class="card-title">
                                <span class="card-icon">
                                    <i class="flaticon-squares text-primary"></i>
                                </span>
				<h3 class="card-label"><?= lang('companies_Commercial_registry') ?></h3>
			</div>
			<div class="card-toolbar">
			</div>
		</div>
		<div class="card-body">
			<div class="card-body">
				<div class="form-group row">
					<div class="col-lg-4 mt-5">
						<label><?= lang('companies_Trade_Name') ?></label>
						<input type="text" name="companies_Trade_Name" value="<?= $Company_Profile->companies_Trade_Name ?>" class="form-control" placeholder="<?= lang('companies_Trade_Name') ?>"/>
					</div>
					<div class="col-lg-4 mt-5">
						<label><?= lang('companies_Commercial_Registration_No') ?></label>
						<input type="text" name="companies_Commercial_Registration_No" value="<?= $Company_Profile->companies_Commercial_Registration_No ?>" class="form-control" placeholder="<?= lang('companies_Commercial_Registration_No') ?>"/>
					</div>
					<div class="col-lg-4 mt-5">
						<label><?= lang('companies_Unified_record_number') ?></label>
						<input type="text" name="companies_Unified_record_number" value="<?= $Company_Profile->companies_Unified_record_number ?>" class="form-control" placeholder="<?= lang('companies_Unified_record_number') ?>"/>
					</div>
					<div class="col-lg-4 mt-5">
						<label><?= lang('Global_Registration_Date') ?></label>
						<input type="text" name="Registration_Date" value="<?= date('Y-m-d',$Company_Profile->Registration_Date) ?>" class="form-control datepicker" placeholder="<?= lang('Global_Registration_Date') ?>"/>
					</div>
					<div class="col-lg-4 mt-5">
						<label><?= lang('Global_Expiry_Date') ?></label>
						<input type="text" name="Expiry_Date" value="<?= date('Y-m-d',$Company_Profile->Expiry_Date) ?>" class="form-control col-12 datepicker" placeholder="<?= lang('Global_Expiry_Date') ?>"/>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-lg-12 mt-5">
						<label><?= lang('companies_commercial_activities') ?></label>
						<input type="text" name="companies_commercial_activities" value="<?= $Company_Profile->companies_commercial_activities ?>" class="form-control" placeholder="<?= lang('companies_commercial_activities') ?>"/>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="card card-custom mt-10">
		<div class="card-header">
			<div class="card-title">
                                <span class="card-icon">
                                    <i class="flaticon-squares text-primary"></i>
                                </span>
				<h3 class="card-label"><?= lang('companies_Owner_information') ?></h3>
			</div>
			<div class="card-toolbar">
			</div>
		</div>
		<div class="card-body">
			<div class="card-body">

				<div class="form-group row">
					<div class="col-lg-4 mt-5">
						<label><?= lang('companies_owner_name') ?></label>
						<input type="text" name="companies_owner_name" class="form-control" placeholder="<?= lang('companies_owner_nam') ?>"/>
					</div>
					<div class="col-lg-4 mt-5">
						<label><?= lang('Global_Nationality') ?></label>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<select name="owner_Nationality_id" id="Nationality_id" class="form-control selectpicker" data-size="7" data-live-search="true" >
							</select>
						</div>
					</div>
					<div class="col-lg-4 mt-5">
						<label><?= lang('Global_Identification_Number') ?></label>
						<input type="text" name="owner_Identification_Number" value="<?= $Company_Profile->owner_Identification_Number ?>" class="form-control" placeholder="<?= lang('Global_Identification_Number') ?>"/>
					</div>

					<div class="col-lg-4 mt-5">
						<label><?= lang('Global_Issued_Date') ?></label>
						<input type="text" name="owner_Identification_Issued_Date" value="<?= date('Y-m-d',$Company_Profile->owner_Identification_Issued_Date) ?>" class="form-control datepicker" placeholder="<?= lang('Global_Issued_Date') ?>"/>
					</div>
					<div class="col-lg-4 mt-5">
						<label><?= lang('Global_Expiry_Date') ?></label>
						<input type="text" name="owner_Identification_Expiry_Date" value="<?= date('Y-m-d',$Company_Profile->owner_Identification_Expiry_Date) ?>" class="form-control datepicker" placeholder="<?= lang('Global_Expiry_Date') ?>"/>
					</div>
					<div class="col-lg-4 mt-5">
						<label><?= lang('Global_Issued_by') ?></label>
						<input type="text" name="owner_Identification_Issued_by" value="<?= $Company_Profile->owner_Identification_Issued_by ?>" class="form-control" placeholder="<?= lang('Global_Issued_by') ?>"/>
					</div>

					<div class="col-lg-4 mt-5">
						<label><?= lang('Global_Mobile') ?></label>
						<input type="text" name="owner_Mobile" class="form-control" value="<?= $Company_Profile->owner_Mobile ?>" placeholder="<?= lang('Global_Mobile') ?>"/>
					</div>
					<div class="col-lg-4 mt-5">
						<label><?= lang('Global_telephone') ?></label>
						<input type="text" name="owner_telephone" class="form-control" value="<?= $Company_Profile->owner_telephone ?>" placeholder="<?= lang('Global_telephone') ?>"/>
					</div>
					<div class="col-lg-12 mt-5">
						<label><?= lang('Global_address') ?></label>
						<input type="text" name="owner_address" class="form-control" value="<?= $Company_Profile->owner_address ?>" placeholder="<?= lang('Global_address') ?>"/>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="card card-custom mt-10">
		<div class="card-header">
			<div class="card-title">
                                <span class="card-icon">
                                    <i class="flaticon-squares text-primary"></i>
                                </span>
				<h3 class="card-label"><?= lang('companies_Contact_information') ?></h3>
			</div>
			<div class="card-toolbar">
			</div>
		</div>
		<div class="card-body">
			<div class="card-body">

				<div class="form-group row">
					<div class="col-lg-4 mt-5">
						<label><?= lang('Global_telephone') ?></label>
						<input type="text" name="companies_telephone" class="form-control" value="<?= $Company_Profile->companies_telephone ?>" placeholder="<?= lang('Global_telephone') ?>"/>
					</div>
					<div class="col-lg-4 mt-5">
						<label><?= lang('Global_Mobile') ?></label>
						<input type="text" name="companies_Mobile" class="form-control" value="<?= $Company_Profile->companies_Mobile ?>" placeholder="<?= lang('Global_Mobile') ?>"/>
					</div>
					<div class="col-lg-4 mt-5">
						<label><?= lang('Global_email') ?></label>
						<input type="text" name="companies_email" class="form-control" value="<?= $Company_Profile->companies_email ?>" placeholder="<?= lang('Global_email') ?>"/>
					</div>
					<div class="col-lg-4 mt-5">
						<label><?= lang('Global_website') ?></label>
						<input type="text" name="companies_website" class="form-control" value="<?= $Company_Profile->companies_website ?>"  placeholder="<?= lang('Global_website') ?>"/>
					</div>
					<div class="col-lg-4 mt-5">
						<label><?= lang('Global_postbox') ?></label>
						<input type="text" name="companies_postbox" class="form-control" value="<?= $Company_Profile->companies_postbox ?>" placeholder="<?= lang('Global_postbox') ?>"/>
					</div>
					<div class="col-lg-4 mt-5">
						<label><?= lang('Global_Postal_code') ?></label>
						<input type="text" name="companies_Postal_code" class="form-control" value="<?= $Company_Profile->companies_Postal_code ?>" placeholder="<?= lang('Global_Postal_code') ?>"/>
					</div>
				</div>

			</div>
		</div>
	</div>

	<div class="card card-custom mt-10">
		<div class="card-header">
			<div class="card-title">
                                <span class="card-icon">
                                    <i class="flaticon-squares text-primary"></i>
                                </span>
				<h3 class="card-label"><?= lang('companies_address_information') ?></h3>
			</div>
			<div class="card-toolbar">
			</div>
		</div>
		<div class="card-body">
			<div class="card-body">

				<div class="form-group row">
					<div class="col-lg-4 mt-5">
						<label><?= lang('Global_Region_province') ?></label>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<select name="companies_Region_id" id="companies_Region_id" class="form-control selectpicker" data-size="7" data-live-search="true" >
								<option selected value="<?= $Company_Profile->companies_Region_id ?>">
									<?php
									echo Get_Regions(194,$Company_Profile->companies_Region_id)->row()->name_ar;
									?>
								</option>
							</select>
						</div>
					</div>
					<div class="col-lg-4 mt-5">
						<label><?= lang('Global_City') ?></label>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<select  name="companies_City_id" id="companies_City_id" class="form-control selectpicker" data-size="7" data-live-search="true" >
								<option selected value="<?= $Company_Profile->companies_City_id ?>">
									<?php
									echo Get_City(194,$Company_Profile->companies_Region_id,$Company_Profile->companies_City_id)->row()->name_ar;
									?>
								</option>
							</select>
						</div>
					</div>
					<div class="col-lg-4 mt-5">
						<label><?= lang('Global_District') ?></label>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<select name="companies_District_id" id="companies_District_id" class="form-control selectpicker" data-size="7" data-live-search="true" >
								<option selected value="<?= $Company_Profile->companies_District_id ?>">
									<?php
									echo Get_Districts(194,$Company_Profile->companies_Region_id,$Company_Profile->companies_City_id,$Company_Profile->companies_District_id)->row()->name_ar;
									?>
								</option>
							</select>
						</div>
					</div>



					<div class="col-lg-6 mt-5">
						<label><?= lang('Global_street') ?>  </label>
						<input type="text" name="companies_street" class="form-control" value="<?= $Company_Profile->companies_street ?>" placeholder="<?= lang('Global_street') ?>"/>
					</div>
					<div class="col-lg-6 mt-5">
						<label><?= lang('Global_building_number') ?></label>
						<input type="text" name="companies_building_number" class="form-control" value="<?= $Company_Profile->companies_building_number ?>" placeholder="<?= lang('Global_building_number') ?>"/>
					</div>

					<div class="col-lg-12 mt-5">
						<label><?= lang('Global_details') ?> </label>
						<input type="text" name="companies_address_details" class="form-control" value="<?= $Company_Profile->companies_address_details ?>" placeholder="<?= lang('Global_details') ?>"/>
					</div>

					<div class="col-lg-12 mt-5">
						<label><?= lang('Google_Location_on_Google') ?> </label>


						<input type="text" name="companies_Location_on_Google" class="form-control" value="" placeholder="<?= lang('Google_Location_on_Google') ?>"/>
					</div>

				</div>

			</div>
		</div>
	</div>

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

<script type="text/javascript">
	function Country_id(){
		var Country_id  = 194;
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
				$("#companies_Region_id").empty();
				$.each(data, function (key, value) {
					$("#companies_Region_id").append('<option value=' + value.id + '>' + value.Name + '</option>');
				});
				$("#companies_Region_id").selectpicker('refresh');
			},
			error: function () {
				swal.fire(" خطا ", "في ارسال الطلب ", "error");
			}
		});
	}
	Country_id();

	$('#companies_Region_id').change(function(event){
		event.preventDefault();
		var Country_id  = 194;
		var Region_id   = $('select[name=companies_Region_id]').val();
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
				$("#companies_City_id").empty();
				$.each(data, function (key, value) {
					$("#companies_City_id").append('<option value=' + value.id + '>' + value.Name + '</option>');
				});
				$("#companies_City_id").selectpicker('refresh');
			},
			error: function () {
				swal.fire(" خطا ", "في ارسال الطلب ", "error");
			}
		});
	});
	$('#companies_City_id').change(function(event){
		event.preventDefault();
		var Country_id  = 194;
		var Region_id   = $('select[name=companies_Region_id]').val();
		var City_id     = $('select[name=companies_City_id]').val();
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
				$("#companies_District_id").empty();
				$.each(data, function (key, value) {
					$("#companies_District_id").append('<option value=' + value.id + '>' + value.Name + '</option>');
				});
				$("#companies_District_id").selectpicker('refresh');
			},
			error: function () {
				swal.fire(" خطا ", "في ارسال الطلب ", "error");
			}
		});
	});

	function get_Nationality(){
		$.ajax({
			type: 'ajax',
			method: 'get',
			async: false,
			dataType: 'json',
			url: '<?= base_url( 'Ajax/Get_Nationality') ?>',
			success: function (data) {
				$("#Nationality_id").empty();
				$.each(data, function (key, value) {
					$("#Nationality_id").append('<option value=' + value.id + '>' + value.Name + '</option>');
				});
				$("#Nationality_id").selectpicker('refresh');
			},
			error: function () {
				swal.fire(" خطا ", "في ارسال الطلب ", "error");
			}
		});
	} // function get_Nationality()

	get_Nationality();
</script>
