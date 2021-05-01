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
            <?= Create_One_Button_Text(array('title'=> 'اضافة مرحلة' ,'href'=>base_url(APP_NAMESPACE_URL.'/Clients/Form_Stages_Self_Construction/'.$Client_Info->uuid.''))) ?>
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
	            <th class="text-center"> رقم المرحلة</th>
                <th class="text-center"> المرحلة</th>
	            <th class="text-center"> نسبة المرحلة</th>
                <th class="text-center">الحالة</th>
                <th class="text-center">الخيارات</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i=0;
            if ($stages_self_construction !== false) {
	            foreach ($stages_self_construction as $row) {
	            ?>
	            <tr>
	                <td class="text-center"><?= ++$i ?></td>
		            <td class="text-center"><?= $row['stages_self_number'] ?></td>
	                <td class="text-center"><?= $row['stages_self_title'] ?></td>
		            <td class="text-center">%<?= $row['stages_self_Percentage'] ?></td>
		            <td class="text-center"><?= $row['stages_self_status'] ?></td>
	                <td class="text-center"><?= $row['stages_self_options'] ?></td>
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