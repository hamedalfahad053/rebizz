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
	        <?= Create_One_Button_Text_Without_tooltip(array("class"=>"","id"=>"",'title' => lang('add_new_Client_button'), 'href' => base_url(APP_NAMESPACE_URL.'/Clients/Create_New_Client'))) ?>

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

            <div class="card-body">

                <?php echo  $this->session->flashdata('message'); ?>

                <style>
                    th.dt-center,
                    .dt-center {
                        text-align: center;
                    }
                </style>
                <table class="data_table table table-bordered table-hover display nowrap" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
	                        <th class="text-center">شعار العميل</th>
                            <th class="text-center"><?= lang('client_name') ?></th>
                            <th class="text-center">فئة العميل</th>
                            <th class="text-center"><?= lang('Table_Status') ?></th>
	                        <th class="text-center">بواسطة / التاريخ</th>
                            <th class="text-center"><?= lang('Table_Options') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($ClientList !== false) {
                            foreach ($ClientList as $row) {
                        ?>
                                <tr>
                                    <td class="text-center"><?= $row['Client_id'] ?></td>
	                                <td class="text-center"><img src="<?= $row['Client_logo']; ?>" height="35" width="35" ></td>
	                                <td class="text-center"><?= $row['Client_name'] ?></td>
                                    <td class="text-center"><?= $row['type_id'] ?></td>
                                    <td class="text-center"><?= $row['status'] ?></td>
	                                <td class="text-center">
		                                <?php
		                                echo $this->aauth->get_user($row['created_By'])->full_name
		                                ?>
	                                </td>
                                    <td class="text-center"><?= $row['options'] ?></td>
                                </tr>
                        <?php
                            }
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

<?php
$this->load->view('../../modules/App_Company_Clients/views/Model_CreateNewClient', $this->data, true);
?>

<script type="text/javascript">
    $(document).ready(function() {
        $('.data_table').DataTable({
            responsive: true,
	        searchDelay: 500,
	        lengthMenu: [5, 10, 25, 50],
	        pageLength: '<?= company_settings_system($LoginUser_Company,'Table_Data_page_Length') ?>',
	        language: {
		        'lengthMenu': 'Display _MENU_',
	        }

        });

    });
</script>