
<style>th.dt-center,.dt-center { text-align: center; }</style>
<table class="data_table table table-bordered table-hover display nowrap" width="100%">
    <thead>
    <tr>
        <th class="text-center">معاملة رقم</th>
        <th class="text-center">طالب التقييم / مالك العقار</th>
        <th class="text-center">بواسطة / الوقت</th>
        <th class="text-center">الحالة</th>
        <th class="text-center">الخيارات</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if($Transaction_data == false){

    }else{
        $i = 0;
        foreach ($Transaction_data AS  $Row)
        {

            ?>
            <tr>
                <td class="text-center">
	                <img src="
	                <?php
	                $path = $LoginUser_Company_Path_Folder.'/'.FOLDER_FILE_Company_client_logo.'/';
	                echo Get_Client_Logo($LoginUser_Company_Path_Folder,$this->aauth->get_user()->company_id,Transaction_data_by_key($Row['transaction_id'],1,1,'LIST_CLIENT'));
	                ?>"  height="35" width="35" >
	                <br>
	                <?= date('Ymd',$Row['Create_Transaction_Date']).$Row['transaction_id'];?>
                </td>
                <td class="text-center">
	                المالك : <?= Transaction_data_by_key($Row['transaction_id'],13,4,'OWNER_REAL_ESTATE') ?>
	                <?= Transaction_data_by_key($Row['transaction_id'],13,4,'OWNERS_MOBILE_NUMBER') ?>
	                <br>
	                طالب التقييم :<?= Transaction_data_by_key($Row['transaction_id'],13,4,'OWNER_APPLICANT_EVALUATION') ?>
	                <?= Transaction_data_by_key($Row['transaction_id'],13,4,'OWNER_MOBILE_EVALUATION') ?>
                </td>
                <td class="text-center">
	                <?= $this->aauth->get_user($Row['Create_Transaction_By_id'])->full_name ?>
	                <?= date('Y-m-d h:i:s a',$Row['Create_Transaction_Date']);?>
                </td>
                <td class="text-center"></td>
                <td class="text-center">
	                <?php
	                $options_transaction['view'] = array(
			                "class"          => '',
			                "id"             => '',
			                "title"          => 'استعراض المعاملة',
			                "data-attribute" => '',
			                "icon"           => '',
			                "href"           => base_url(APP_NAMESPACE_URL.'/Transactions/View_Transaction/'.$Row['transaction_uuid'])
	                );
	                echo Create_Options_Button($options_transaction)
	                ?>
                </td>
            </tr>
            <?php
        }
    }
    ?>
    </tbody>
</table>
<!--begin: Datatable -->


