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

		<div class="card card-custom mt-10">

			<!--begin::Header-->
			<div class="card-header">
				<div class="card-title">
					<h3 class="card-label">
						<?= $RC->item_translation ?>
					</h3>
				</div>
				<div class="card-toolbar">

				</div>
			</div>
			<!--begin::Header-->

			<form class="form" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Settings_Transaction/Update_Setting') ?>"  method="post">
		        <?= CSFT_Form() ?>
		        <!--begin::Body-->
		        <div class="card-body">


		                <div class="form-group row">

			                <div class="col-lg-12 mt-5">
				                <label>الموظف</label>
				                <select name="Table_Data_page_Length"  class="form-control selectpicker" data-live-search="true"  data-title="اختر من فضلك ">
					                <?php
					                for ($x = 10; $x <= 500; $x++) {
						                echo '<option value="'.$x.'">'.$x.'</option>';
					                }
					                ?>
				                </select>
			                </div>

		                    <div class="col-lg-12 mt-5">
		                        <label>طريقة الاستلام</label>
		                        <select name="Table_Data_page_Length"  class="form-control selectpicker" data-live-search="true"  data-title="اختر من فضلك ">
		                            <?php
		                            for ($x = 10; $x <= 500; $x++) {
		                                echo '<option value="'.$x.'">'.$x.'</option>';
		                            }
		                            ?>
		                        </select>
		                    </div>

			                <div class="col-lg-12 mt-5">
				                <label>فئة العميل</label>
				                <select name="Table_Data_page_Length"  class="form-control selectpicker" data-live-search="true"  data-title="اختر من فضلك ">
					                <?php
					                for ($x = 10; $x <= 500; $x++) {
						                echo '<option value="'.$x.'">'.$x.'</option>';
					                }
					                ?>
				                </select>
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

		                </div>
		            </div>
		        </div>
		    </form>


		</div><!--<div class="card card-custom mt-10">-->

	</div>
	<!--end::Container-->
</div>
<!--end::Entry-->