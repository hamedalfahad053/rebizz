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
                <th class="text-center">اسم الموظف بالعربية</th>
                <th class="text-center">اسم الموظف بالانجليزية</th>
                <th class="text-center"> البريد الالكتروني </th>
                <th class="text-center">المجموعة / الصلاحيات</th>
                <th class="text-center">الحالة</th>
                <th class="text-center">الخيارات</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 0;
            foreach ($Users AS $row)
            {
            ?>
                <tr>
                    <td class="text-center"><?= $row['User_id'] ?></td>
                    <td class="text-center"><?= $row['User_Name_Ar'] ?></td>
                    <td class="text-center"><?= $row['User_Name_En'] ?></td>
                    <td class="text-center"><?= $row['User_Email'] ?></td>
                    <td class="text-center"><?= $row['User_Group'] ?></td>
                    <td class="text-center"><?= $row['User_status'] ?></td>
                    <td class="text-center"><?= $row['User_options'] ?></td>
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



