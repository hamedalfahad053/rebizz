<div id="kt_quick_panel" class="offcanvas offcanvas-right pt-5 pb-10">
    <!--begin::Header-->
    <div class="offcanvas-header offcanvas-header-navs d-flex align-items-center justify-content-between mb-5">
        <ul class="nav nav-bold nav-tabs nav-tabs-line nav-tabs-line-3x nav-tabs-primary flex-grow-1 px-10" role="tablist">
	        <li class="nav-item">
		        <a class="nav-link active" data-toggle="tab" href="#kt_quick_panel_notifications">الاشعارات</a>
	        </li>
	        <li class="nav-item">
                <a class="nav-link " data-toggle="tab" href="#kt_quick_panel_logs">سجل النشاط</a>
            </li>
        </ul>
        <div class="offcanvas-close mt-n1 pr-5">
            <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_panel_close">
                <i class="ki ki-close icon-xs text-muted"></i>
            </a>
        </div>
    </div>
    <!--end::Header-->


    <!--begin::Content-->
    <div class="offcanvas-content px-10">
        <div class="tab-content">

	        <!--begin::Tabpane notifications-->
	        <div class="tab-pane fade show pt-2 pr-5 mr-n5 active" id="kt_quick_panel_notifications" role="tabpanel">
		        <!--begin::Nav-->
		        <div class="navi navi-icon-circle navi-spacer-x-0">





			        <?php
			        $Get_panel_notifications = $this->db->order_by('notifications_id','DESC');
			        $Get_panel_notifications = $this->db->limit(30);
			        $Get_panel_notifications = $this->db->where('type_read',0);
			        $Get_panel_notifications = $this->db->where('userid',$this->aauth->get_user()->id);
			        $Get_panel_notifications = $this->db->get('portal_user_notifications');
			        if($Get_panel_notifications->num_rows()>0){
			        ?>
				    <div class="d-flex flex-center mt-5 mb-5">
					  <a href="#" id="Read_Notifications" class="btn btn-light-primary font-weight-bold text-center">تعليم الكل كمقرؤة</a>
				    </div>
			        <?php
			        	foreach ($Get_panel_notifications->result() AS $GPNO){
			        ?>

				        <!--begin::Item-->
				        <a href="<?= $GPNO->notifications_url ?>" class="navi-item">
					        <div class="navi-link rounded">
						        <div class="symbol symbol-50 mr-3">
							        <div class="symbol-label">
								        <i class="flaticon-bell text-success icon-lg"></i>
							        </div>
						        </div>
						        <div class="navi-text">
							        <div class="font-weight-bold font-size-lg"><?= $GPNO->notifications_title ?></div>
							        <div class="text-muted"><?= time_elapsed_string($GPNO->time) ?></div>
						        </div>
					        </div>
				        </a>
				        <!--end::Item-->
			        <?php
				        } // foreach ($Get_panel_notifications->result() AS $GPNO)

			        }else{
				       echo  Create_Status_Alert(array("key"=>'Success',"value"=>"لا يوجد اشعارات جديدة"));
			        } // if($Get_panel_notifications->num_rows()>0)
			        ?>
		        </div>
		        <!--end::Nav-->
	        </div>
	        <!--end::Tabpane notifications-->

	        <script type="text/javascript">
		        $("#Read_Notifications").click(function(event) {
			        event.preventDefault();
			        $.ajax({
				        type: 'ajax',
				        method: 'get',
				        url: '<?= base_url(APP_NAMESPACE_URL . '/Profile/Ajax_Read_Notifications') ?>',
				        data: {},
				        async: false,
				        dataType: 'json',
				        success: function (response) {
					        swal.fire("نجاح",response.Message_result, "success");
					        location.reload(true);
				        },
				        error: function () {
					        swal.fire(" خطا ", response.Message_result, "error");

				        }
			        });
		        });
	        </script>




            <!--begin::Tabpane panel_logs -->
            <div class="tab-pane fade  pt-3 pr-5 mr-n5 " id="kt_quick_panel_logs" role="tabpanel">
                <!--begin::Section-->
                <div class="mb-15">
                    <h5 class="font-weight-bold mb-5">سجل الوصول بالنظام</h5>
	                <?php
	                $Action_Section_panel_logs = '';
	                $Action_Type_panel_logs    = '';
	                $Get_panel_log_system = $this->db->order_by('log_id','DESC');
	                $Get_panel_log_system = $this->db->limit(30);
	                $Get_panel_log_system = $this->db->where('Action_Userid',$this->aauth->get_user()->id);
	                $Get_panel_log_system = $this->db->get('protal_log_system');
	                foreach ($Get_panel_log_system->result() AS $LOGQ){

	                	if($LOGQ->Action_Section =='Transaction'){
			                $Action_Section_panel_logs = 'المعاملات';
		                }else{
			                $Action_Section_panel_logs ='';
		                }


		                if($LOGQ->Action_Type =='Create_Transaction'){
					      $Action_Type_panel_logs = 'تسجيل معاملة جديدة';
				        }elseif($LOGQ->Action_Type =='View' and $LOGQ->Action_Type =='View_Transaction'){
					      $Action_Type_panel_logs ='عرض معاملة ';
		                }elseif($LOGQ->Action_Type =='View_Transaction'){
			                $Action_Type_panel_logs =' استعلام لانشاء معاملة ';
		                }elseif($LOGQ->Action_Type =='Query_Transaction'){
			                $Action_Type_panel_logs ='عرض معاملة ';
		                }



	                ?>
                    <!--begin: Item-->
                    <div class="d-flex align-items-center flex-wrap mb-5">
                        <div class="symbol symbol-50 symbol-light mr-5">
                        </div>
                        <div class="d-flex flex-column flex-grow-1 mr-2">
                            <a href="#" class="font-weight-bolder text-dark-75 text-hover-primary font-size-lg mb-1">
	                            <?= $Action_Type_panel_logs ?>
                            </a>
                            <span class="text-muted font-weight-bold">
	                            <?= time_elapsed_string($LOGQ->Time_Activity)  ?>
                            </span>
                        </div>
                        <span class="btn btn-sm btn-light font-weight-bolder py-1 my-lg-0 my-2 text-dark-50"><?= $Action_Section_panel_logs ?></span>
                    </div>
                    <!--end: Item-->
	                <?php
	                }
	                ?>
                </div>
                <!--end::Section-->
            </div>
            <!--end::Tabpane panel_logs -->



        </div>
    </div>
    <!--end::Content-->
</div>