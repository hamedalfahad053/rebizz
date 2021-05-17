<?php
$query_transaction_files = $this->db->order_by('files_sort','ASC');
$query_transaction_files = $this->db->where('file_isDeleted !=',1);
$query_transaction_files = $this->db->where('preview_id =',0);
$query_transaction_files = app()->db->where('transaction_id',$Transactions->transaction_id);
$query_transaction_files = app()->db->get('protal_transaction_files');
?>


<a href="<?= base_url(APP_NAMESPACE_URL . '/File_Transaction/View_File_Transaction/'.$Transactions->uuid) ?>" class="btn m-5 btn-success">
    <i class="flaticon-psd"></i>   تحميل جميع المرفقات
</a>

<?php
if(Check_Permissions(44)) {
?>
<a href="<?= base_url(APP_NAMESPACE_URL . '/File_Transaction/Upload_File_Transaction/'.$Transactions->uuid) ?>" class="btn m-5 btn-success">
    <i class="flaticon-psd"></i>   اضافة مرفقات اخرى
</a>
<?php
}
?>

<?php
if(Check_Permissions(45)) {
?>
<a href="<?= base_url(APP_NAMESPACE_URL . '/File_Transaction/Sort_File_Transaction/'.$Transactions->uuid) ?>" class="btn m-5 btn-success">
    <i class="flaticon-psd"></i> ترتيب المرفقات
</a>
<?php
}
?>

<style>th.dt-center,.dt-center { text-align: center; }</style>
<table class="data_file table table-bordered table-hover display nowrap" width="100%">
    <thead>
    <tr>
        <th class="text-center">#</th>
        <th class="text-center">اسم الملف</th>
        <th class="text-center">نوع الملف</th>
        <th class="text-center">بواسطة / الوقت</th>
        <th class="text-center">الخيارات</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $f = 0;
    foreach ($query_transaction_files->result() AS $RF)
    {
        ?>
        <tr>
            <th class="text-center"><?= ++$f; ?></th>
            <th class="text-center">
                <?php if($RF->File_Name_In){
                    echo $RF->File_Name_In;
                }else{
                    echo '-';
                } ?>
            </th>
            <th class="text-center">
                <?php if($RF->LIST_TRANSACTION_DOCUMENTS){
                    echo Get_options_List_Translation($RF->LIST_TRANSACTION_DOCUMENTS)->item_translation;
                }else{
                    echo '-';
                }
                ?>
            </th>
            <th class="text-center"><?= $this->aauth->get_user($RF->file_createBy)->full_name ?></th>
            <th class="text-center">
                <a href="<?= base_url(APP_NAMESPACE_URL . '/File_Transaction/Download_File_Transaction/'.$Transactions->uuid.'/'.$RF->uuid) ?>" class="btn btn-sm btn-primary">
                    <i class="flaticon-download-1"></i>
                </a>
	            <?php
	            if(Check_Permissions(46)) {
	            ?>
                <a href="<?= base_url(APP_NAMESPACE_URL . '/File_Transaction/Edit_File_Transaction/'.$Transactions->uuid.'/'.$RF->uuid) ?>" class="btn btn-icon btn-sm btn-warning">
                    <i class="flaticon2-edit"></i>
                </a>
	            <?php
	            }
	            if(Check_Permissions(47)) {
	            ?>
                <a href="<?= base_url(APP_NAMESPACE_URL . '/File_Transaction/Delete_File_Transaction/'.$Transactions->uuid.'/'.$RF->uuid) ?>" class="btn btn-icon btn-sm btn-danger">
                    <i class="flaticon2-delete"></i>
                </a>
	            <?php
	            }
	            ?>
            </th>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>