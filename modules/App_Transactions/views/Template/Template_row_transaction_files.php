<table class="data_table table table-bordered table-hover display nowrap" width="100%">
    <thead>
    <tr>
        <th class="text-center">اسم الملف</th>
        <th class="text-center">تحميل</th>
        <th class="text-center">بواسطة / التاريخ</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $i=0;
    foreach ($Get_Transaction_files as $File)
    {
        ?>
        <tr>
            <td class="text-center"><?= $File->raw_name ?></td>
            <td class="text-center"><?= $this->aauth->get_user($File->file_createBy)->full_name ?></td>
            <td class="text-center"><?= date('Y-m-d',$File->file_createDate) ?></td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>
