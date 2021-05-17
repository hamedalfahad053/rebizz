
<?php
if(Check_Permissions(12) or Check_Permissions(9)) {
?>
<div class="card card-custom">
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
                <a href="<?= base_url(APP_NAMESPACE_URL.'/Transactions/Create_Transaction/Create/'.$INSTRUMENT_NUMBER) ?>" class="btn btn-primary mr-2">انشاء معاملة جديدة</a>
            </div>
            <div class="col-lg-6 text-lg-right">
            </div>
        </div>
    </div>
</div>
<?php
}else{
	echo  Create_Status_Alert(array('key'=>'Danger','value'=>'لا يوجد لديك صلاحيات لانشاء معاملة جديدة'));
}
?>