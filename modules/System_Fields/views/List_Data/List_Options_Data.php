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
                    <?= Create_One_Button_Text(array('title'=> 'عنصر جديد' ,'href'=>base_url(ADMIN_NAMESPACE_URL.'/List_Data/Form_Add_New_Options/'.$List_id.''))) ?>
                </div>
            </div>
            <div class="card-body">


                <?php echo  $this->session->flashdata('message'); ?>

                <style>th.dt-center,.dt-center { text-align: center; }</style>
                <table class="data_table table table-bordered table-hover display nowrap" width="100%">
                    <thead>
                    <tr>
                        <th class="text-center">#</th>
	                    <th class="text-center">ID</th>
	                    <th class="text-center">key</th>
	                    <th class="text-center">العنوان</th>
	                    <th class="text-center">مخصص لـ</th>
                        <th class="text-center">الحالة</th>
                        <th class="text-center">الخيارات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 0;
                    foreach ($options_List AS  $ROW)
                    {
                    ?>
                        <tr>
                            <td class="text-center"><?= ++$i ?></td>
	                        <td class="text-center"><?= $ROW['options_id'] ?></td>
                            <td class="text-center"><?= $ROW['options_key'] ?></td>
                            <td class="text-center"><?= $ROW['options_translation'] ?></td>
	                        <td class="text-center"><?= $ROW['options_company_id'] ?></td>
	                        <td class="text-center"><?= $ROW['options_status'] ?></td>
                            <td class="text-center"><?= $ROW['options_status_system'] ?></td>
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