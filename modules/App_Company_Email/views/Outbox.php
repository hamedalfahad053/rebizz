



        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="flaticon-layer text-primary"></i>
                    </span>
                    <h3 class="card-label"><?= $Page_Title ?></h3>
                </div>
                <div class="card-toolbar">
                </div>
            </div>
            <div class="card-body">


	            <style>th.dt-center,.dt-center { text-align: center; }</style>
	            <table class="data_table table table-bordered table-hover display nowrap" width="100%">
		            <thead>
		            <tr>
			            <th class="text-center">#</th>
			            <th class="text-center">عنوان الرسالة</th>
			            <th class="text-center">المرسل اليه</th>
			            <th class="text-center">التاريخ الوقت</th>
			            <th class="text-center">التاريخ الوقت</th>
		            </tr>
		            </thead>
		            <tbody>
		            <?php
		            $i = 0;

		            if($Student_Inbox->num_rows()==0){

			            $msg_result['key']   = 'Warning';
			            $msg_result['value'] = 'لا يوجد رسائل ';
			            echo Create_Status_Alert($msg_result);

		            }else{
			            foreach ($Student_Inbox->result() AS $row)
			            {
				            if($row->pm_deleted_sender ==  $this->aauth->get_user()->id){

				            }else{
					        ?>

				            <tr>
					            <td class="text-center"><?= ++$i ?></td>
					            <td class="text-center"><?= $row->title ?></td>
					            <td class="text-center"><?= $this->aauth->get_user($row->receiver_id)->full_name ?></td>
					            <td class="text-center"><?= $row->date_sent ?></td>
					            <td class="text-center">
						            <?php
						            $options['view'] = array(
								            "class" => "", "id" => "",
								            "title" => 'عرض الرسالة',
								            "data-attribute" => '',
								            "href" => base_url(ADMIN_NAMESPACE_URL.'/Email/View_Message_Outbox/'.$row->uuid)
						            );
						            $options['custom'] = array(
								            "class" => "", "id" => "",
								            "title" => 'ارشفة الرسالة',
								            "data-attribute" => '',
								            'icon' =>'flaticon-envelope',
								            'color'=> 'warning',
								            'href' => base_url(ADMIN_NAMESPACE_URL.'/Email/Transfer_archive_Message/'.$row->uuid.'/Outbox')
						            );
						            echo Create_Options_Button($options);
						            ?>
					            </td>
				            </tr>
				            <?php
				            }
			            }
		            }
		            ?>
		            </tbody>
	            </table>
	            <!--begin: Datatable -->

            </div>
        </div>





<script type="text/javascript">
	$(document).ready(function() {

		$('.data_table').DataTable({
			responsive: true
		});

	});
</script>