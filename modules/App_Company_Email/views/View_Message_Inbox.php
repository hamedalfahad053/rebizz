


	            <div class="card card-custom">
	                <div class="card-header">
	                    <div class="card-title">
	                            <span class="card-icon">
	                                <i class="flaticon-chat text-primary"></i>
	                            </span>
	                        <h3 class="card-label"><?= $Page_Title ?></h3>
	                    </div>
	                    <div class="card-toolbar">
		                    <?php
			                echo Create_One_Button_Text(array('title'=> ' العودة للبريد الوارد ' ,'href'=>base_url(APP_NAMESPACE_URL.'/Email/')));
		                    ?>
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


	            <?php
	            if($Message_reply !== false){
		            foreach ($Message_reply->result() AS $RP)
		            {
			            ?>
			            <div class="card card-custom mt-10 mb-10">
				            <div class="card-header">
					            <div class="card-title">
			                            <span class="card-icon">
			                                <i class="flaticon-chat text-primary"></i>
			                            </span>
						            <h3 class="card-label"> رد:<?= $this->aauth->get_user($RP->reply_userid)->full_name ?></h3>
					            </div>
					            <div class="card-toolbar">
						            <?= date('Y-m-d h:i:s a',$RP->reply_date) ?>
					            </div>
				            </div>
				            <div class="card-body">
					            <?= $RP->reply_text ?>
				            </div>
			            </div>
			            <?php
		            }
	            }
	            ?>
	            <div class="card card-custom mt-10 mb-10">
		            <div class="card-header">
			            <div class="card-title">
			                            <span class="card-icon">
			                                <i class="flaticon-chat text-primary"></i>
			                            </span>
				            <h3 class="card-label">الرد على الرسالة</h3>
			            </div>
			            <div class="card-toolbar">
			            </div>
		            </div>

		            <form class="form" name="" action="<?= base_url(APP_NAMESPACE_URL.'/Email/Reply_Message') ?>" method="post">
			            <?= CSFT_Form() ?>
			            <div class="card-body">
				            <input type="hidden" name="message_id" value="<?= $Message->id ?>">
				            <textarea  rows="10" name="message" class="form-control" required="required" placeholder="الرد على الرسالة" ></textarea>
			            </div>
			            <div class="card-footer">
				            <div class="row">
					            <div class="col-lg-6">
						            <button type="submit" class="btn btn-primary mr-2">ارسال </button>
					            </div>
					            <div class="col-lg-6 text-lg-right">
					            </div>
				            </div>
			            </div>
		            </form>
	            </div>









