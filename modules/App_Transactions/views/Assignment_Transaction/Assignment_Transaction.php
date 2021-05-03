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

	        <?= Create_One_Button_Text(array('title'=>  'اضافة موظف لفريق العمل','href'=>base_url(APP_NAMESPACE_URL.'/Transactions/New_Assign_Transaction/'.$this->uri->segment(4)))) ?>
	        <a href="<?= base_url(APP_NAMESPACE_URL . '/Transactions/View_Transaction/'.$this->uri->segment(4)) ?>" class="btn btn-success">
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
        <div class="card card-custom mb-5 mt-10">

            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label"> فريق العمل  </h3>
                </div>
                <div class="card-toolbar">

                </div>
            </div>
            <div class="card-body">
                <style>th.dt-center,.dt-center { text-align: center; }</style>
                <table class="data_table table table-bordered table-hover display nowrap" width="100%">
                    <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">الموظف</th>
                        <th class="text-center">القسم</th>
                        <th class="text-center">تاريخ الاضافة</th>
                        <th class="text-center">الحالة</th>
                        <th class="text-center">الخيارات</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        if($assign != false){
                            foreach ($assign AS $R)
                            {
                            ?>
                            <tr>
                                <td class="text-center"><?= ++$i ?></td>
                                <td class="text-center"><?= $R['assign_userid'] ?></td>
                                <td class="text-center"><?= $R['Department'] ?></td>
                                <td class="text-center"><?= $R['assign_time'] ?></td>
                                <td class="text-center">
	                                <?php
	                                if($R['assign_type'] == 1) {
		                                echo Create_Status_badge(array("key"=>"Success","value"=> 'نشط'));
	                                }else{
		                                echo Create_Status_badge(array("key"=>"Danger", "value"=> 'غير نشط'));
	                                }
	                                ?>
                                </td>
                                <td class="text-center">
	                                <?php
	                                if($R['assign_type'] == 0) {
		                                $options['active'] = array("class"=>"","id"=>"","title" => lang('active_button'), "data-attribute" => '',
				                                "href" => base_url(APP_NAMESPACE_URL.'/Transactions/Reset_Assign_Transaction/'.$R['uuid'].'/'.$this->uri->segment(4)) );
	                                }else {
		                                $options['disable'] = array("class"=>"","id"=>"","title" => lang('disable_button'), "data-attribute" => '',
				                                "href" => base_url(APP_NAMESPACE_URL.'/Transactions/Unset_Assign_Transaction/'.$R['uuid'].'/'.$this->uri->segment(4)));
	                                }
	                                echo Create_Options_Button($options);
	                                ?>
                                </td>
                            </tr>
                            <?php
                            }
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


<script type="text/javascript">
	$(document).ready(function() {

		$('.data_table').DataTable({
			responsive: true
		});

	});
</script>
