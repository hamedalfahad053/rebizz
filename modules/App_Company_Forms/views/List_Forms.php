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


        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="flaticon-squares text-primary"></i>
                    </span>
                    <h3 class="card-label"><?= $Page_Title ?></h3>
                </div>
                <div class="card-toolbar">
                </div>
            </div>
            <div class="card-body">

            <?php echo  $this->session->flashdata('message'); ?>

	            <style>th.dt-center,.dt-center { text-align: center; }</style>
	            <table class="data_table table table-bordered table-hover display nowrap" width="100%">
		            <thead>
		            <tr>
			            <th class="text-center">#</th>
			            <th class="text-center">عنوان النموذج</th>
			            <th class="text-center">حالة النموذج</th>
			            <th class="text-center">ادارة النموذج</th>
		            </tr>
		            </thead>
		            <tbody>
		            <?php
		            $i = 0;
		            foreach ($Forms AS $R)
		            {
		            ?>
		            <tr>
			            <td class="text-center"><?= ++$i ?></td>
			            <td class="text-center"><?= $R['Forms_title'] ?></td>
			            <td class="text-center"><?= $R['Forms_Status'] ?></td>
			            <td class="text-center">
				            <?php
				            $options['custom'] = array(
						            "class"          => 'Create_Transaction',
						            "id"             => '',
						            "title"          => 'اعداد النموذج',
						            "icon"           => 'flaticon2-settings',
						            "color"          => 'primary',
						            "data-attribute" => '',
						            "href"           => base_url(APP_NAMESPACE_URL.'/Forms/Manage_Forms_Transaction/'.$R['Forms_uuid'])
				            );
				            echo Create_Options_Button($options);
				            ?>
			            </td>
		            </tr>
		            <?php
		            }
		            ?>
		            </tbody>
	            </table>
	            <!--begin: Datatable -->

            </div>
        </div>



    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->




<script type="text/javascript">
    $(document).ready(function() {

        $('.data_table').DataTable({
            responsive: true
        });

    });
</script>
