




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
			            <th class="text-center">المرسل</th>
			            <th class="text-center">التاريخ الوقت</th>
			            <th class="text-center">حالة الرسالة</th>
			            <th class="text-center">فئة الرسالة</th>
			            <th class="text-center">عرض</th>
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

				            ?>
				            <tr>
					            <td class="text-center"><?= ++$i ?></td>
					            <td class="text-center"><?= $row->title ?></td>
					            <td class="text-center"><?= $this->aauth->get_user($row->sender_id)->full_name ?></td>
					            <td class="text-center"><?= $row->date_sent ?></td>
					            <td class="text-center">
						            <?php
						            if($row->date_read == ''){
							           echo Create_Status_badge(array("key"=>'warning','value'=>'جديدة'));
						            }else{
							          echo  Create_Status_badge(array("key"=>'Success','value'=>$row->date_read.''));
						            }
						            ?>
					            </td>
					            <td class="text-center">
						            <?php
						            if($row->sender_id == $this->aauth->get_user()->id){
							            echo Create_Status_badge(array("key"=>'warning','value'=>'البريد الصادر'));
						            }else{
							            echo  Create_Status_badge(array("key"=>'Success','value'=>'البريد الوارد'));
						            }
						            ?>
					            </td>
					            <td class="text-center">
						            <?php
						            $options['view'] = array(
								            "class" => "", "id" => "",
								            "title" => 'عرض الرسالة',
								            "data-attribute" => '',
								            "href" => base_url(APP_NAMESPACE_URL.'/Email/views_archive_Message/'.$row->uuid)
						            );
						            echo Create_Options_Button($options)
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

            </div>
        </div>



<script type="text/javascript">
	$(document).ready(function() {

		$('.data_table').DataTable({
			responsive: true
		});

	});
</script>