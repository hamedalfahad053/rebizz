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
	        <a href="<?= base_url(APP_NAMESPACE_URL . '/Settings/Form_SMS_Email_Messages') ?>" class="btn btn-success">
		        <i class="flaticon2-envelope"></i> اضافة رسالة جديدة
	        </a>
        </div>
    </div>
    <!--end::Header-->


    <!--bgin::Body-->
    <div class="card-body">

	    <?php
	    if($Sms_Email_Messages != false)
	    {
	    ?>
	    <style>th.dt-center,.dt-center { text-align: center; }</style>
	    <table class="data_table table table-bordered table-hover display nowrap" width="100%">
		    <thead>
		    <tr>
			    <th class="text-center">#</th>
			    <th class="text-center">عنوان الرسالة</th>
			    <th class="text-center">نص الرسالة</th>
			    <th class="text-center">نوع الرسالة</th>
			    <th class="text-center">الخيارات</th>
		    </tr>
		    </thead>
		    <tbody>
		    <?php
		    $i = 0 ;
		    foreach ($Sms_Email_Messages->result() as $ROW)
		    {
		    ?>
			    <tr>
				    <td class="text-center"><?= ++$i ?></td>
				    <td class="text-center"><?= $ROW->messages_title ?></td>
				    <td class="text-center"><?= $ROW->messages_text ?></td>
				    <td class="text-center"><?= $ROW->messages_type ?></td>
				    <td class="text-center">
					    <?php
					    $options = array();

						$options['edit'] = array("class" => '',"id" => '',"title" => 'تعديل',"data-attribute" => '',"icon"  => '',"href"  => base_url(APP_NAMESPACE_URL . '/Transactions/Check_DataEntries/'.$ROW->messages_uuid));


					    ?>
				    </td>
			    </tr>
		    <?php
		    }
		    ?>
		    </tbody>
	    </table>
	    <?php
	    }else{
		 echo Create_Status_badge(array("key" => "Success", "value" => 'لا يوجد قائمة رسائل معدة'));
	    }
	    ?>

    </div>
    <!--end: Card Body-->


</div>
<!--end: Card-->

<script type="text/javascript">
	$('.data_table').DataTable({
		responsive: true,
	});
</script>