<form class="form" name="" action="<?= base_url(APP_NAMESPACE_URL . '/Clients/Create_Contracts/') ?>" method="post" enctype="multipart/form-data">


    <?= CSFT_Form() ?>


	<input type="hidden" name="Clients_id" value="<?= $this->uri->segment(4) ?>" />

	<!--begin: Card Contract basic information-->
	<div class="card card-custom card-stretch gutter-b">
		<!--begin::Header-->
		<div class="card-header">
			<div class="card-title">
                    <span class="card-icon">
                        <i class="flaticon-squares text-primary"></i>
                    </span>
				<h3 class="card-label">بيانات العقد الأساسية</h3>
			</div>
			<div class="card-toolbar">
			</div>
		</div>
		<!--end::Header-->


        <?php echo  $this->session->flashdata('message'); ?>

		<!--begin::Body-->
		<div class="card-body">
			<div class="form-group row">
				<div class="col-lg-6 mt-5">
					<label>مسمى العقد</label>
					<input type="text" name="Contracts_name" class="form-control" placeholder="<?= lang('name_group') ?>"/>
				</div>

				<div class="col-lg-12 mt-5">
					<label>وصف</label>
					<textarea type="text" name="Contracts_description" class="form-control" placeholder="" ></textarea>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-lg-4 mt-5">
					<label>يبدا بتاريخ</label>
					<input type="text" name="Contracts_start_date" class="form-control datepicker" placeholder=" "/>
				</div>
				<div class="col-lg-4 mt-5">
					<label>ينتهي بتاريخ</label>
					<input type="text" name="Contracts_end_date" class="form-control datepicker"
					       placeholder="<?= lang('name_group') ?>"/>
				</div>
				<div class="col-lg-4 mt-5">
					<label> تنسيق ترقيم المعاملات </label>
					<input type="text" name="Code_Transaction" class="form-control"
					       placeholder="RAJ"/>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-lg-6 mt-5">
					<label>التجديد التلقائي </label>
					<select name="is_auto_renew" class="form-control selectpicker" data-live-search="true"
					        data-title="اختر من فضلك ">
                        <?php
                        foreach ($Contracts_is_auto_renew as $key => $value) {
                            echo '<option value="' . $key . '">' . $value . '</option>';
                        }
                        ?>
					</select>
				</div>
				<div class="col-lg-6 mt-5">
					<label>مستندات العقد</label>
					<input type="file" name="contract_file" class="form-control-file" placeholder="<?= lang('name_group') ?>"/>
				</div>
			</div>
		</div>
		<!--end: Card Body-->
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
	<!--end: Card for submit-->
</form>


