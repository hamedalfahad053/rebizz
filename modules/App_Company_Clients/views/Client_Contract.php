<div class="card card-custom card-stretch gutter-b">


    <!--begin::Header-->
    <div class="card-header">
        <div class="card-title">
                    <span class="card-icon">
                        <i class="flaticon-squares text-primary"></i>
                    </span>
            <h3 class="card-label"><?= $Page_Title ?></h3>
        </div>
        <div class="card-toolbar">
            <?php $Client_id =  $this->uri->segment(4); ?>
            <?= Create_One_Button_Text(array('title'=> 'اضافة عقد' ,'href'=>base_url(APP_NAMESPACE_URL.'/Clients/Form_add_Contracts/'.$Client_id.''))) ?>
        </div>
    </div>
    <!--end::Header-->


    <!--begin::Body-->
    <div class="card-body">

        <?php echo  $this->session->flashdata('message'); ?>

        <table class="data_table table table-bordered table-hover display nowrap" width="100%">
            <thead>
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">رقم العقد</th>
                <th class="text-center">يبدا / ينتهي</th>
                <th class="text-center">الحالة</th>
                <th class="text-center">الخيارات</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($Contracts_Client !== false) {
            foreach ($Contracts_Client as $row) {
            ?>
            <tr>
                <td class="text-center"></td>
                <td class="text-center"><?= $row['Contracts_name'] ?></td>
                <td class="text-center"><?= date('Y-m-d',$row['Contracts_start_date']) ?> - <?= date('Y-m-d',$row['Contracts_end_date']) ?></td>
                <td class="text-center"><?= $row['Contracts_status'] ?></td>
                <td class="text-center"><?= $row['Contracts_options'] ?></td>
            </tr>
            <?php
            } // for
            } // if
            ?>
            </tbody>
        </table>
        <!--begin: Datatable -->

    </div>
    <!--end: Card Body-->


</div>
<!--end: Card-->