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
	        <?= Create_One_Button_Text(array('title'=> 'اضافة صلاحيات موظف','href'=>base_url(APP_NAMESPACE_URL.'/Settings_Transaction/Form_Add_Receipt_Transactions'))) ?>
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


                <!--begin::Body-->
                <div class="card-body">


	                <?php echo  $this->session->flashdata('message'); ?>

	                <style>th.dt-center,.dt-center { text-align: center; }</style>
	                <table class="data_table table table-bordered table-hover display nowrap" width="100%">
		                <thead>
		                <tr>
			                <th class="text-center">#</th>
			                <th class="text-center">الموظف</th>
			                <th class="text-center">طريقة الاستلام</th>
			                <th class="text-center">فئة العملاء</th>
			                <th class="text-center">العملاء</th>
			                <th class="text-center">الخيارات</th>
		                </tr>
		                </thead>
		                <tbody>

		                <?php
		                $i = 0;
		                if($Get_Receipt_Emp->num_rows()>0){
			                foreach ($Get_Receipt_Emp->result() as $r)
			                {

				            $array_METHOD_OF_RECEIPT = @explode(',', $r->LIST_METHOD_OF_RECEIPT);
				            $array_CUSTOMER_CATEGORY = @explode(',', $r->LIST_CUSTOMER_CATEGORY);
				            $array_CLIENT            = @explode(',', $r->LIST_CLIENT);
			                ?>
				                <tr>
					                <td class="text-center"><?= ++$i ?></td>
					                <td class="text-center"><?= $this->aauth->get_user($r->receipt_emp_userid)->full_name ?></td>
					                <td class="text-center">
						                <?php
				                        foreach ($array_METHOD_OF_RECEIPT as $M)
				                        {
					                        $d = get_data_options_List_view('6',$M);
				                        	echo '<span class="label label-primary label-inline mr-2">'.$d.'</span>';
				                        }
						                ?>
					                </td>
					                <td class="text-center">
						                <?php
						                foreach ($array_CUSTOMER_CATEGORY as $C)
						                {
							                $f = get_data_options_List_view('16',$C);
							                echo '<span class="label label-primary label-inline mr-2">'.$f.'</span>';
						                }
						                ?>
					                </td>
					                <td class="text-center">
						                <?php
						                foreach ($array_CLIENT as $L)
						                {
							                $g = get_data_options_List_view('19',$L);
							                echo '<span class="label label-primary label-inline mr-2">'.$g.'</span>';
						                }
						                ?>
					                </td>
					                <td class="text-center">

						                <?php

						                $options_transaction['edit'] = array(
						                		"class" => '',
								                "id" => '',"title" => 'تعديل',
								                "data-attribute" => '',"icon"  => '',
								                "href"  => base_url(APP_NAMESPACE_URL . '/Settings_Transaction/Edit_Receipt_Transactions/' . $r->receipt_emp_uuid));

						                ?>
					                </td>
				                </tr>
			                <?php
			                }
		                }
		                ?>

		                </tbody>
	                </table>
	                <!--begin: Datatable -->


                </div>
                <!--end: Card Body-->



        </div><!--<div class="card card-custom mt-10">-->

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

