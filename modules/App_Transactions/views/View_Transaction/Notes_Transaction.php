
<?php
foreach ($Get_Note_Transactions->result() AS $R)
{
?>

    <div class="card card-custom mb-10">
        <!--begin::Header-->
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                  بواسطة :  <?= $this->aauth->get_user($R->createBy)->full_name ?>
                </h3>
            </div>
            <div class="card-toolbar">
                <?= date('Y-m-d h:i:s a',$R->createDate); ?>
            </div>
        </div>
        <!--begin::Header-->

        <!--begin::Body-->
        <div class="card-body">
          <?= $R->Note_Transaction ?>
        </div>
        <!--begin::Body-->

    </div>

<?php
}
?>