
        <div class="card card-custom mb-5 ">

            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label"> فريق العمل  </h3>
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
                        <th class="text-center">الموظف</th>
                        <th class="text-center">القسم</th>
                        <th class="text-center">تاريخ الاضافة</th>
                        <th class="text-center">الحالة</th>
                        <th class="text-center">الخيارات</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;


                        if($assign != false)
                        {

                            foreach ($assign AS $R)
                            {
                            ?>
                            <tr>
                                <td class="text-center"><?= ++$i ?></td>
                                <td class="text-center"><?= $R['assign_userid'] ?></td>
                                <td class="text-center"><?= $R['Department'] ?></td>
                                <td class="text-center"><?= $R['assign_time'] ?></td>
                                <td class="text-center">
	                                <?php
	                                if($R['assign_type'] == 1) {
		                                echo Create_Status_badge(array("key"=>"Success","value"=> 'نشط'));
	                                }else{
		                                echo Create_Status_badge(array("key"=>"Danger", "value"=> 'غير نشط'));
	                                }
	                                ?>
                                </td>
                                <td class="text-center">
	                                <?php
	                                if($R['assign_type'] == 0) {
		                                $options['active'] = array("class"=>"","id"=>"","title" => lang('active_button'), "data-attribute" => '',
				                        "href" => base_url(APP_NAMESPACE_URL.'/Work_Team/Reset_Assign_Transaction/'.$R['uuid'].'/'.$this->uri->segment(4)) );
	                                }else{
		                                $options['disable'] = array("class"=>"","id"=>"","title" => lang('disable_button'), "data-attribute" => '',
				                        "href" => base_url(APP_NAMESPACE_URL.'/Work_Team/Unset_Assign_Transaction/'.$R['uuid'].'/'.$this->uri->segment(4)));
	                                }
	                                echo  Create_Options_Button($options);
	                                ?>
                                </td>
                            </tr>
                            <?php
                            } // foreach ($assign AS $R)

                        } // if($assign != false)
                        ?>
                    </tbody>
                </table>
            </div>
        </div>





