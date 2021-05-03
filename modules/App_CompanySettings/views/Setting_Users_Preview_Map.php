

<div class="card card-custom mt-5">
	    <!--begin::Header-->
	    <div class="card-header">
	        <div class="card-title">
	            <h3 class="card-label">توزيع المعاينين على المناطق الجغرافية</h3>
	        </div>
	    </div>
	    <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body">

	        <?php echo  $this->session->flashdata('message'); ?>

	        <?php
	        if($Users_Preview == false){
		        $msg_result['key'] = 'Danger';
		        $msg_result['value'] = 'لا يوجد مستخدمين بصلاحيات معاين ';
		        $msg_result_view = Create_Status_Alert($msg_result);
		        echo $msg_result_view;
	        }else{
		        ?>

		        <style>th.dt-center,.dt-center { text-align: center; }</style>
		        <table class="data_table table table-bordered table-hover display nowrap" width="100%">
			        <thead>
			        <tr>
				        <th class="text-center">#</th>
				        <th class="text-center">المعاين</th>
				        <th class="text-center">المنطقة</th>
				        <th class="text-center">المدينة</th>
				        <th class="text-center">الخيارات</th>
			        </tr>
			        </thead>
			        <tbody>
			        <?php
			        $i = 0;

			        foreach ($Users_Preview AS $Row)
			        {

				        $where_Assignment = array(
						    "users_preview_id" => $Row->users_id,
						    "company_id"       => app()->aauth->get_user()->company_id
				        );
				        $Get_Assignment_Map_users_preview = Get_Assignment_Map_users_preview($where_Assignment);

				        if($Get_Assignment_Map_users_preview->num_rows()>0){

					        $Map_users_preview = $Get_Assignment_Map_users_preview->row();
					        $Get_Regions = Get_Regions(194,$Map_users_preview->regions_id)->row();
					        $Get_City    = Get_City(194,$Map_users_preview->regions_id,$Map_users_preview->city_id)->row();

				        }else{
					        $msg_result['key'] = 'Danger';
					        $msg_result['value'] = 'لم يتم تحديد النطاق الجغرافي للمستخدم ';
					        $msg_result_view = Create_Status_Alert($msg_result);
					        echo $msg_result_view;
				        }

				        ?>
				        <tr>
					        <td class="text-center"><?= ++$i ?></td>
					        <td class="text-center"><?= $Row->full_name ?></td>
					        <td class="text-center"><?= @$Get_Regions->name_ar ?></td>
					        <td class="text-center"><?= @$Get_City->name_ar ?></td>
					        <td class="text-center">
						        <?php
						        $options_transaction['Assignment'] = array(
								        "class"          => '',
								        "id"             => '',
								        "title"          => ' المنطقة الجغرافية',
								        "data-attribute" => '',
								        "icon"           => '',
								        "href"           => base_url(APP_NAMESPACE_URL.'/Settings/Form_Set_CRD_Users_Preview/'.$Row->users_id)
						        );
						        echo Create_Options_Button($options_transaction)
						        ?>
					        </td>
				        </tr>
				        <?php
			        }
			        ?>
			        </tbody>
		        </table>
		        <!--begin: Datatable -->
		        <?php
	        }
	        ?>

        </div>
	    <!--begin::Body-->
</div>
<!--end: Card-->




