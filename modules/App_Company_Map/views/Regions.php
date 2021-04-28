<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">
            <!--begin::Mobile Toggle-->
            <button class="burger-icon burger-icon-left mr-4 d-inline-block d-lg-none" id="kt_subheader_mobile_toggle">
                <span></span>
            </button>
            <!--end::Mobile Toggle-->
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


<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">

            <div class="card card-custom">
                <div class="card-body">


	                <?php echo  $this->session->flashdata('message'); ?>

	                <style>th.dt-center,.dt-center { text-align: center; }</style>
	                <table class="data_table table table-bordered table-hover display nowrap" width="100%">
		                <thead>
		                <tr>
			                <th class="text-center">#</th>
			                <th class="text-center">المنطقة</th>
			                <th class="text-center">المدن</th>
			                <th class="text-center">خريطة المنطقة</th>
			                <th class="text-center">الخيارات</th>
		                </tr>
		                </thead>
		                <tbody>

		                <?php
		                $i = 0;
		                foreach ($Get_Regions->result()  as $R)
		                {


		                ?>
		                <tr>
			                <td class="text-center"><?= ++$i; ?></td>
			                <td class="text-center"><?= $R->name_ar ?></td>
				            <td class="text-center">
					         <a href="<?= base_url(APP_NAMESPACE_URL . '/Map/cities/'.$R->region_uuid) ?>" class="btn btn-primary">
			                   <?= Get_City(194,$R->region_id)->num_rows(); ?>
					         </a>
			                </td>
			                <td class="text-center">
				                <a href="<?= base_url(APP_NAMESPACE_URL . '/Map/View_Map/Regions/'.$R->region_uuid) ?>" class="btn btn-success">
                                 <i class="flaticon2-map"></i>
				                </a>
			                </td>
			                <td class="text-center">
				                <?php
                                 echo $R->Point;
				                ?>
			                </td>
		                </tr>
		                <?php
		                }
		                ?>
		                </tbody>
	                </table>


                </div>
            </div>



        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
<!--end::Content-->



<script type="text/javascript">
	$(document).ready(function() {

		$('.data_table').DataTable({
			responsive: true,
			pageLength: 13,
			language: {
				'lengthMenu': 'Display _MENU_',
			}
		});

	});
</script>
