<div class="card card-custom mb-5">

    <div class="card-header">
        <div class="card-title">
            <span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
            <h3 class="card-label">مراحل البناء الذاتي</h3>
        </div>
        <div class="card-toolbar">

            <a href="<?= base_url(APP_NAMESPACE_URL.'/Evaluation/Add_New_Evaluation/'.$Transactions->uuid) ?>" class="btn btn-primary">
                <i class="flaticon2-plus"></i>  اضافة  مرحلة
            </a>


        </div>
    </div>
    <div class="card-body">


        <style>th.dt-center,.dt-center { text-align: center; }</style>
        <table class="data_file table table-bordered table-hover display nowrap" width="100%">
            <thead>
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">رقم المرحلة</th>
                <th class="text-center">نص المرحلة</th>
                <th class="text-center">النسبة حسب معايير البنك </th>
                <th class="text-center">النسبة المنفذة</th>
                <th class="text-center"> المرحلة السابقة </th>
                <th class="text-center">الخيارات</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if($stages_self_construction->num_rows()>0){

            	$i = 0;

            	foreach ($stages_self_construction->result() AS $R)
	            {


	            ?>

		            <tr>
			            <th class="text-center"><?= ++$i ?></th>
			            <th class="text-center"><?= $R->stages_self_number ?></th>
			            <th class="text-center"><?= $R->stages_self_text ?></th>
			            <th class="text-center">%<?= $R->stages_self_rate ?></th>
			            <th class="text-center">%<?= $R->Completion_rate ?></th>
			            <th class="text-center"></th>
			            <th class="text-center"></th>
		            </tr>

                <?php
	            }

            }
            ?>

            </tbody>

        </table>


    </div>

</div>