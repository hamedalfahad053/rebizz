<div class="card card-custom card-stretch gutter-b">

    <!--begin::Header-->
    <div class="card-header">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon-squares text-primary"></i>
            </span>
            <h3 class="card-label"><?= $Page_Title ?></h3>
        </div>
        <div class="card-toolbar"></div>
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="card-body">

        <style>th.dt-center,.dt-center { text-align: center; }</style>
        <table class="data_table table table-bordered table-hover display nowrap" width="100%">
            <thead>
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">المجموعة</th>
                <th class="text-center">عدد المستخدمين</th>
                <th class="text-center">الحالة</th>
                <th class="text-center">الخيارات</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 0;
            foreach ($Group_Users AS $row)
            {
                ?>
                <tr>
                    <td class="text-center"><?= $row['Group_id'] ?></td>
                    <td class="text-center"><?= $row['group_translation'] ?></td>
                    <td class="text-center"></td>
                    <td class="text-center"><?= $row['Group_status'] ?></td>
                    <td class="text-center"><?= $row['Group_options'] ?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
        <!--begin: Datatable -->

    </div>
    <!--end: Card Body-->


</div>
<!--end: Card-->



