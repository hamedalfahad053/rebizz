<div class="card card-custom mb-5 mt-5">
    <!--begin::Header-->
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">تحويل الطلب الى </h3>
        </div>
    </div>
    <!--begin::Header-->
    <!--begin::Body-->
    <div class="card-body">
        <select name="Assignment_userid" class="form-control selectpicker" data-live-search="true"  data-title="اختر من فضلك ">
            <?php
            $t = 'عدد المعاملات الحالية :';
            foreach ($Stages_Transaction AS $key_user)
            {
                echo '<option  data-subtext="  '.$t.$key_user['Assignment_Num'].'" value="'.$key_user['userid'].'">'.$key_user['full_name'].'</option>';
            }
            ?>
        </select>
    </div>
    <!--begin::Body-->
</div>

