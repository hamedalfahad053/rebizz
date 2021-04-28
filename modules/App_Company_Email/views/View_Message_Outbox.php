


            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                            <span class="card-icon">
                                <i class="flaticon-chat text-primary"></i>
                            </span>
                        <h3 class="card-label"><?= $Page_Title ?></h3>
                    </div>
                    <div class="card-toolbar">
                    </div>
                </div>
                <div class="card-body">

                    <?php echo  $this->session->flashdata('message'); ?>

                    <div class="form-group row">
                        <div class="col-lg-6 mt-5">
                            <label>عنوان الرسالة :</label>
                            <p class="font-size-h6 text-primary"><?= $Message->title ?></p>
                        </div>
	                    <div class="col-lg-6 mt-5">
		                    <label>تاريخ الرسالة</label>
		                    <p class="font-size-h6 text-primary"><?= $Message->date_sent ?></p>
	                    </div>
                    </div>

	                <div class="form-group row">
	                    <div class="col-lg-6 mt-5">
		                    <label>المرسل</label>
		                    <p class="font-size-h6 text-primary"><?= $this->aauth->get_user($Message->sender_id)->full_name?></p>
	                    </div>
		                <div class="col-lg-6 mt-5">
			                <label>المستلم</label>
			                <p class="font-size-h6 text-primary"><?= $this->aauth->get_user($Message->receiver_id)->full_name ?></p>
		                </div>
                    </div>

	                <div class="separator separator-solid separator-border-2 separator-success"></div>
	                <div class="form-group row">
	                    <div class="col-lg-12 mt-5">
                            <label>نص الرسالة :</label>
	                        <p class="font-size-h6"><?= $Message->message ?></p>
                        </div>
                    </div>

	                <?php
	                if($Message->file_att != NULL){
		                ?>
		                <div class="separator separator-solid separator-border-2 separator-success"></div>
		                <div class="form-group row">
			                <div class="col-lg-12 mt-5">
				                <label>مرفق</label>
				                <?= Create_One_Button_Text(array('title'=> 'تحميل','href'=>base_url('uploads/Message/'.$Message->file_att))) ?>
			                </div>
		                </div>
		                <?php
	                }
	                ?>

                </div>

            </div>





