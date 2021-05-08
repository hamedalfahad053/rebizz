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
	        <a class="btn btn-primary" href="<?= base_url(APP_NAMESPACE_URL . '/Settings_Transaction_Reports/Form_Text_Static_Transaction_Reports/') ?>" >
		        <i class="flaticon-edit"></i>     تعريف نص جديد
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

        <div class="row">
            <div class="col-lg-12 mt-5">
                <div class="card card-custom">
                    <div class="card-body">
	                    <?php echo  $this->session->flashdata('message'); ?>
	                    <style>th.dt-center,.dt-center { text-align: center; }</style>
	                    <table class="data_table table table-bordered table-hover display nowrap" width="100%">
		                    <thead>
		                    <tr>
			                    <th class="text-center">#</th>
			                    <th class="text-center">عنوان النص</th>
			                    <th class="text-center">بواسطة</th>
			                    <th class="text-center">الوقت</th>
			                    <th class="text-center">الخيارات</th>
		                    </tr>
		                    </thead>
		                    <tbody>
		                    <?php
		                    $f = 0;
		                    if($text_static->num_rows() == 0){

			                    echo Create_Status_Alert(array("key"=>'Danger',"value"=>'لا يوجد نصوص معرفة بالنظام'));

		                    }else{

			                    foreach ($text_static->result() AS $RF)
			                    {
				                    ?>
				                    <tr>
					                    <th class="text-center"><?= ++$f; ?></th>
					                    <th class="text-center"><?= $RF->title_ar ?></th>
					                    <th class="text-center">
						                    <?= $this->aauth->get_user($RF->createBy)->full_name ?>
					                    </th>
					                    <th class="text-center">
						                    <?= date('Y-m-d h:i:s a',$RF->createDate) ?>
					                    </th>
					                    <th class="text-center">
						                    <?php
						                    $options_Reports['edit'] = array("class" => '',"id" => '',"title" => 'تحرير',"data-attribute" => '',"icon"  => '',"href"  => base_url(APP_NAMESPACE_URL . '/Settings_Transaction_Reports/Edit_Form_Text_Static_Transaction_Reports/' . $RF->text_uuid));
						                    echo $Create_Options =  Create_Options_Button($options_Reports);
						                    ?>
					                    </th>
				                    </tr>
				                    <?php
			                    } // foreach ($text_static->result() AS $RF)

		                    }
		                    ?>
		                    </tbody>
	                    </table>


                    </div>
                </div>
            </div><!--<div class="col-lg-12 mt-5">-->
        </div>

    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->


<script type="text/javascript">
	$(document).ready(function() {

		$('.data_table').DataTable({
			responsive: true,
			pageLength: 10,
			language: {
				'lengthMenu': 'Display _MENU_',
			}
		});

	});
</script>
