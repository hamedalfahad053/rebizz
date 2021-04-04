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






							    <div class="card card-custom mb-3 mt-2">
								    <div class="card-body">
		                                <ul class="nav nav-tabs nav-bold nav-tabs-line">
		                                    <li class="nav-item">
		                                        <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1_4">
		                                            <span class="nav-icon"><i class="flaticon-cogwheel icon-md"></i></span>
		                                            <span class="nav-text">البيانات الاساسية</span>
		                                        </a>
		                                    </li>

			                                <li class="nav-item">
				                                <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2_4">
					                                <span class="nav-icon"><i class="flaticon-arrows icon-md"></i></span>
					                                <span class="nav-text"> المنسق </span>
				                                </a>
			                                </li>

		                                    <li class="nav-item">
		                                        <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_3_4">
		                                            <span class="nav-icon"><i class="flaticon-visible icon-md"></i></span>
		                                            <span class="nav-text"> المعاين</span>
		                                        </a>
		                                    </li>
		                                    <li class="nav-item">
		                                        <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_4_4">
		                                            <span class="nav-icon"><i class="flaticon-price-tag icon-md"></i></span>
		                                            <span class="nav-text"> التقييم  </span>
		                                        </a>
		                                    </li>

		                                    <li class="nav-item">
		                                        <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_6_4">
		                                            <span class="nav-icon"><i class="flaticon-layers icon-md"></i></span>
		                                            <span class="nav-text"> حركة المعاملة </span>
		                                        </a>
		                                    </li>

		                                </ul>
								    </div>
							    </div>


                                <div class="tab-content">

                                    <div class="tab-pane fade show active" id="kt_tab_pane_1_4" role="tabpanel" aria-labelledby="kt_tab_pane_1_4">
                                        <?php
                                        echo $this->load->view('../../modules/App_Transactions/views/View_Transactions_Tab_Data', $this->data);
                                        ?>
                                    </div>

                                    <div class="tab-pane fade" id="kt_tab_pane_2_4" role="tabpanel" aria-labelledby="kt_tab_pane_2_4">
	                                    <?php
	                                    echo $this->load->view('../../modules/App_Transactions/views/View_Transactions_Tab_Coordinator', $this->data);
	                                    ?>
                                    </div>

                                    <div class="tab-pane fade" id="kt_tab_pane_3_4" role="tabpanel" aria-labelledby="kt_tab_pane_3_4">
	                                    <?php
	                                    echo $this->load->view('../../modules/App_Transactions/views/View_Transactions_Tab_Preview_RealEstate', $this->data);
	                                    ?>
                                    </div>

                                    <div class="tab-pane fade" id="kt_tab_pane_4_4" role="tabpanel" aria-labelledby="kt_tab_pane_4_4">
	                                    <?php
	                                    echo $this->load->view('../../modules/App_Transactions/views/View_Transactions_Tab_Evaluation', $this->data);
	                                    ?>
                                    </div>

	                                <div class="tab-pane fade" id="kt_tab_pane_5_4" role="tabpanel" aria-labelledby="kt_tab_pane_5_4">
		                                <?php
		                                echo $this->load->view('../../modules/App_Transactions/views/View_Transactions_Tab_Transaction_Documents', $this->data);
		                                ?>
	                                </div>

	                                <div class="tab-pane fade" id="kt_tab_pane_6_4" role="tabpanel" aria-labelledby="kt_tab_pane_6_4">
		                                <?php
		                                echo $this->load->view('../../modules/App_Transactions/views/View_Transactions_Tab_Activety_log', $this->data);
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