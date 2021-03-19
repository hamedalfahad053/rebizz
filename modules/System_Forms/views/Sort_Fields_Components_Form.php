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


	    <?php echo  $this->session->flashdata('message'); ?>

	    <div id="handle" class="navi navi-hover py-5">
			<?php
			foreach ($Form_Components->result() AS $RC) {

			if($RC->Fields_Type == 'Fields'){
				$Fields_info = 	Get_Fields(array("Fields_id"=>$RC->Fields_id))->row();
			}elseif($RC->Fields_Type == 'List'){
				$Fields_info = 	Get_All_List(array("list_id"=>$RC->Fields_id))->row();
			}

			?>
			<div class="grid-square" data-id-Fields="<?= $RC->Fields_id ?>">
		        <div class="card mt-10 card-custom">
		            <div class="card-header">
		                <div class="card-title">
		                    <span class="card-icon">
		                       <i class="flaticon2-sort text-primary"></i>
		                    </span>
		                    <h3 class="card-label"><?= $Fields_info->item_translation ?></h3>
		                </div>
		            </div>
		        </div>
			</div>
			<?php
			}
			?>
	    </div>


	    <form class="form" name="" action="<?= base_url(ADMIN_NAMESPACE_URL . '/Forms/Update_Fields_Components_Form') ?>" enctype="multipart/form-data" method="post">
		<?= CSFT_Form() ?>
		    <input type="hidden" name="Forms_id"      value="<?= $this->uri->segment(4); ?>">
		    <input type="hidden" name="Components_id" value="<?= $this->uri->segment(5); ?>">
		    <input type="hidden" name="Fields_sort" id="Fields_sort" >
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




<script type="text/javascript">
	$('#handle').sortable({
		items : "[data-id-Fields]",
		swap: true,
		animation: 150,
		update : function() {
			var postData = $(this).sortable('toArray',{
				attribute: 'data-id-Fields',
				key: 'order',
				expression: /(.+)/
			});
			console.log(postData);
			$("#Fields_sort").val(postData);
		}
	});
</script>