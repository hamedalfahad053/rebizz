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

            <a href="<?= base_url(APP_NAMESPACE_URL . '/Transactions/View_Transaction/'.$Transactions->uuid) ?>" class="btn btn-success">
                <i class="flaticon2-arrow"></i>   العودة للمعاملة
            </a>

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

		<div id="handle" class="navi navi-hover py-5">
			<?php
			foreach ($File_Transaction->result() AS $RC) {


				?>
				<div class="grid-square" data-File-Transaction="<?= $RC->uuid ?>">
					<div class="card mt-10 card-custom">
						<div class="card-header">
							<div class="card-title">
		                    <span class="card-icon">
		                       <i class="flaticon2-sort text-primary"></i>
		                    </span>
								<h3 class="card-label">
									<?= $RC->File_Name_In ?>
									<?php
									if($RC->LIST_TRANSACTION_DOCUMENTS){
										echo Get_options_List_Translation($RC->LIST_TRANSACTION_DOCUMENTS)->item_translation;
									}else{
										echo '-';
									}
									?>
								</h3>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
			?>
		</div>


		<form class="form" name="" action="<?= base_url(APP_NAMESPACE_URL . '/File_Transaction/Update_Sort_File_Transaction/'.$this->uri->segment(4)) ?>" enctype="multipart/form-data" method="post">
			<?= CSFT_Form() ?>
			<input type="hidden" name="Transactions_id"  value="<?= $Transactions->transaction_id ?>">
			<input type="hidden" name="File_Transaction" id="File_Transaction" >
			<div class="card mt-10 card-custom">
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-6">
							<button type="submit"   class="btn btn-primary mr-2">تحديث الترتيب</button>
						</div>
					</div>
				</div>
			</div>
		</form>

	</div>
	<!--end::Container-->
</div>
<!--end::Entry-->

<?php echo import_js(array(BASE_ASSET . 'plugins/jquery-ui', BASE_ASSET . 'plugins/Sortable/src/Sortable'), '') ?>
<script type="text/javascript">
	$('#handle').sortable({
		items : "[data-File-Transaction]",
		swap: true,
		animation: 150,
		update : function() {
			var postData = $(this).sortable('toArray',{
				attribute: 'data-File-Transaction',
				key: 'order',
				expression: /(.+)/
			});
			console.log(postData);
			$("#File_Transaction").val(postData);
		}
	});
</script>


