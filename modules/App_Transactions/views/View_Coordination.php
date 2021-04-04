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


	    <div class="card card-custom mb-5 mt-10">
		    <div class="card-header">
			    <div class="card-title">
				    <span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
				    <h3 class="card-label"> افادة المعاين و حالة الزيارة </h3>
			    </div>
			    <div class="card-toolbar">

			    </div>
		    </div>
		    <div class="card-body">

			    <?php
			    $p = 0;
			    $options_Preview = array();
			    if ($Preview_Visit_FeedBack->num_rows() == 0){

				    $msg_result['key'] = 'Danger';
				    $msg_result['value'] = 'لم يتم انشاء افادة حول زيارة المعاين';
				    $msg_result_view = Create_Status_Alert($msg_result);
				    echo $msg_result_view;

			    }else{
			    ?>

				    <style>th.dt-center,.dt-center { text-align: center; }</style>
				    <table class="data_table table table-bordered table-hover display nowrap" width="100%">
					    <thead>
					    <tr>
						    <th class="text-center">#</th>
						    <th class="text-center">الافادة</th>
						    <th class="text-center">وقت / تاريخ الافادة</th>
						    <th class="text-center">تاريخ الزيارة</th>
						    <th class="text-center">وقت الزيارة</th>
						    <th class="text-center">حالة الزيارة</th>
					    </tr>
					    </thead>
					    <tbody>
					    <?php
					    foreach ($Preview_Visit_FeedBack->result() AS $PVF)
					    {
						    ?>
						    <tr>
							    <td class="text-center"><?= ++$p ?></td>
							    <td class="text-center"><?= $PVF->feedback_text ?></td>
							    <td class="text-center"><?= date('Y-m-d h:i:s a',$PVF->CreateDate) ?></td>
							    <td class="text-center"><?= date('Y-m-d',$PVF->Date_visit) ?></td>
							    <td class="text-center"><?= $PVF->Time_visit ?></td>
							    <td class="text-center">
								   <?=  Create_Status_badge(array("key"=>"Danger","value"=>get_data_options_List_view('60',$PVF->VISITING_STATUS))); ?>
							    </td>

						    </tr>
						    <?php
					    }
					    ?>
					    </tbody>
				    </table>

			    <?php
			    } // if ($Preview_Visit_FeedBack->num_rows() == 0)
			    ?>

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

