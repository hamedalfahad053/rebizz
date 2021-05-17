<div class="card card-custom mb-10">
    <!--begin::Header-->
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">سجل المعاملة</h3>
        </div>
        <div class="card-toolbar">

        </div>
    </div>
    <!--begin::Header-->

    <!--begin::Body-->
    <div class="card-body">


	    <style>th.dt-center,.dt-center { text-align: center; }</style>
	    <table class="data_table table table-bordered table-hover display nowrap" width="100%">
		    <thead>
		    <tr>
			    <th class="text-center">#</th>
			    <th class="text-center">نوع العملية</th>
			    <th class="text-center">المستخدم</th>
			    <th class="text-center">التاريخ الوقت </th>
		    </tr>
		    </thead>
		    <tbody>
		    <?php
		    $i = 0;
		    foreach ($log_Transactions AS $R)
		    {
		    ?>
			    <tr>
				    <th class="text-center"><?= ++$i ?></th>
				    <th class="text-center"><?= $R->Action_Type ?></th>
				    <th class="text-center"><?=$this->aauth->get_user($R->Action_Userid)->full_name ?></th>
				    <th class="text-center"><?= date('Y-m-d h:i:s a',$R->Time_Activity) ?></th>
			    </tr>
		    <?php
		    }
		    ?>
		    </tbody>
	    </table>


    </div>
    <!--begin::Body-->


</div><!--<div class="card card-custom mt-10">-->

