<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">
            <!--begin::Page Heading-->
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <!--begin::Page Title-->
                <h5 class="text-dark font-weight-bold my-1 mr-5"><?= $Page_Title ?></h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <?= $breadcrumbs ?>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page Heading-->
        </div>
        <!--end::Info-->
        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">

        </div>
        <!--end::Toolbar-->
    </div>
</div>
<!--end::Subheader-->


<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12 mt-5">

	            <div class="card card-custom mb-5">
		            <div class="card-body">

			            <table class="data_table table table-bordered table-hover display nowrap" width="100%">
				            <thead>
				            <tr>
					            <th class="text-center">اسم التقرير</th>
					            <th class="text-center"> نوع التقييم</th>
					            <th class="text-center"> تخصيص التقرير </th>
				            </tr>
				            </thead>
				            <tbody>
					            <tr>
						            <th class="text-center"><?= $Get_Reports->Reports_title_ar ?></th>
						            <th class="text-center"><?= Get_options_List_Translation($Get_Reports->Reports_TYPES)->item_translation ?></th>
						            <th class="text-center">
							            <?php
							            if($Get_Reports->Reports_Clint == 0){
								            echo  Create_Status_badge(array("key" => "Success", "value" => lang('عام')));
							            }else{
								            $Where_Get_Client = array("client_id"=>$Get_Reports->Reports_Clint);
								            $Get_Client       =  Get_Client_Company($Where_Get_Client)->row();
								            echo Create_Status_badge(array("key" => "Danger", "value" => $Get_Client->name));
							            }
							            ?>
						            </th>
					            </tr>
				            </tbody>
			            </table>

		            </div>
	            </div>


                <div class="card card-custom">



		                <!--begin::Header-->
		                <div class="card-header">
			                <div class="card-title">
				                <h3 class="card-label">محتوى التقرير</h3>
			                </div>
		                </div>
		                <!--begin::Header-->

	                <form class="form" id="Update_Transaction_Reports"  action="<?= base_url(APP_NAMESPACE_URL.'/Settings_Transaction_Reports/Update_Transaction_Reports') ?>" enctype="multipart/form-data" method="post">

		                <div class="card-body">
	                        <input type="hidden" name="Transaction_Reports_uuid" value="<?= $this->uri->segment(4) ?>">
	                        <div class="tinymce">
	                            <textarea id="kt-tinymce" name="Reports_content" class="tox-target">
                                   <?= $Get_Reports->Reports_content ?>
	                            </textarea>
	                        </div>
	                    </div>

		                <div class="card-footer">
			                <div class="row">
				                <div class="col-lg-6">
					                <button type="submit"  id="submit"  class="btn btn-primary mr-2">حفظ التقرير</button>
				                </div>
				                <div class="col-lg-6 text-lg-right">

				                </div>
			                </div>
		                </div>

	                </form>

                </div>
            </div><!--<div class="col-lg-12 mt-5">-->


        </div>

    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->



<?= import_js(BASE_ASSET.'plugins/custom/tinymce/tinymce.bundle',''); ?>
<script type="text/javascript">
	tinymce.init({

		selector: '#kt-tinymce',
		height: '1000px',
		toolbar: ['undo redo | bold italic underline strikethrough |  fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons |  preview  print |  image  link | rtl'],
		plugins : 'code print preview powerpaste casechange importcss  searchreplace autolink directionality advcode visualblocks visualchars fullscreen image link media mediaembed  codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists checklist wordcount tinymcespellchecker a11ychecker imagetools textpattern noneditable  formatpainter permanentpen pageembed charmap  quickbars linkchecker  advtable',
		menubar: 'file edit view insert format tools table tc help  menu_company menu_client menu_transaction_data menu_preview_data menu_Evaluation_final menu_Text_Static',
		toolbar_sticky: true,
		extended_valid_elements : "data_app",
		custom_elements: "data_app",
		language: 'ar',
		language_url: '<?= base_url('Assets/tinymce_languages/langs/ar.js'); ?>',

		menu: {
			menu_transaction_data:  { title: 'بيانات المعاملات', items: 'menu_transaction_data' },
			menu_client:            { title: 'بيانات العميل',   items: 'menu_client'  },
			menu_company:           { title: 'بيانات المنشأة',  items: 'menu_company' },
			menu_preview_data :     { title: 'بيانات المعاينة',  items: 'menu_preview_data menu_preview_data_com menu_preview_map menu_preview_photo  menu_preview_Comparisons' },
		    menu_Evaluation_final : { title: 'بيانات التقييم النهائي',  items: 'menu_Evaluation_final' },
			menu_Text_Static      : { title: 'نصوص و تعريفات',  items: 'menu_Text_Static'}
		},


		setup: function (editor) {
			var toggleState = false;

			editor.ui.registry.addNestedMenuItem('menu_transaction_data', {
				text: 'البيانات الاساسية ',
				getSubmenuItems: function () {
					return [

						<?php
						$Get_All_Form = app()->db->where('Forms_id',1);
						$Get_All_Form = app()->db->get('portal_forms_components_fields');
						foreach ($Get_All_Form->result() AS $Ro)
					    {
							if($Ro->Fields_Type == 'Fields'){
								$Get_Fields   = Get_Fields(array("Fields_id" => $Ro->Fields_id))->row();
								?>
								{
									type: 'menuitem',
									text: '<?= $Get_Fields->item_translation ?>',
									onAction: function () {
										editor.insertContent('{Value_TD_<?= $Ro->Fields_key ?>}');
									}
								},
					            <?php
							}elseif($Ro->Fields_Type == 'List'){
								$Get_Fields   = Get_All_List(array("list_id"=> $Ro->Fields_id))->row();
								?>
								{
									type: 'menuitem',
									text: 'القيمة : <?= $Get_Fields->item_translation ?>',
									onAction: function () {
										editor.insertContent('{Value_TD_<?= $Ro->Fields_key ?>}');
									}
								},
								{
									type: 'menuitem',
									text: ' الجميع  : <?= $Get_Fields->item_translation ?>',
									onAction: function () {
										editor.insertContent('{All_TD_<?= $Ro->Fields_key ?>}');
									}
								},
					            <?php
							}

						}
						?>



						<?php
						# Done
						$Get_All_Form_2 = app()->db->where('Forms_id',13);
						$Get_All_Form_2 = app()->db->get('portal_forms_components_fields');
						foreach ($Get_All_Form_2->result() AS $Ro_2)
						{

							if($Ro_2->Fields_Type == 'Fields'){
								$Get_Fields   = Get_Fields(array("Fields_id" => $Ro_2->Fields_id))->row();
							?>
								{
									type: 'menuitem',
									text: '<?= $Get_Fields->item_translation ?>',
									onAction: function () {
										editor.insertContent('{Value_TD_<?= $Ro_2->Fields_key ?>}');
									}
								},
							<?php
							}elseif($Ro_2->Fields_Type == 'List'){
								$Get_Fields   = Get_All_List(array("list_id"=> $Ro_2->Fields_id))->row();
							?>
								{
									type: 'menuitem',
									text: 'القيمة : <?= $Get_Fields->item_translation ?>',
									onAction: function () {
										editor.insertContent('{Value_TD_<?= $Ro_2->Fields_key ?>}');
									}
								},
								{
									type: 'menuitem',
									text: ' الجميع  : <?= $Get_Fields->item_translation ?>',
									onAction: function () {
										editor.insertContent('{All_TD_<?= $Ro_2->Fields_key ?>}');
									}
								},
							<?php
							}

						}
						?>
					];
				}
			});



			/* */
			editor.ui.registry.addNestedMenuItem('menu_preview_data_com', {
				text: ' بيانات المعاينة - مكونات العقار ',
				getSubmenuItems: function () {
					return [
						<?php

						$Get_All_Form_3 = app()->db->where('Forms_id',14);
						$Get_All_Form_3 = app()->db->get('portal_forms_components_fields');
						foreach ($Get_All_Form_3->result() AS $Ro_3)
						{

						if($Ro_3->Fields_Type == 'Fields'){

						    $Get_Fields   = Get_Fields(array("Fields_id" => $Ro_3->Fields_id))->row();
						?>
							{
								type: 'menuitem',
								text: '<?= @$Get_Fields->item_translation ?>',
								onAction: function () {
									editor.insertContent('{Value_TP_<?= $Ro_3->Fields_key ?>}');
								}
							},

						<?php
						}elseif($Ro_3->Fields_Type == 'List'){
						    $Get_Fields   = Get_All_List(array("list_id"=> $Ro_3->Fields_id))->row();
						?>
							{
								type: 'menuitem',
								text: 'القيمة : <?= $Get_Fields->item_translation ?>',
								onAction: function () {
									editor.insertContent('{Value_TP_<?= $Ro_3->Fields_key ?>}');
								}
							},
							{
								type: 'menuitem',
								text: ' الجميع  : <?= $Get_Fields->item_translation ?>',
								onAction: function () {
									editor.insertContent('{All_TP_<?= $Ro_3->Fields_key ?>}');
								}
							},
						<?php
						}

						} // foreach ($Get_All_Form_3->result() AS $Ro_3)
						?>
					];
				}
			});
			editor.ui.registry.addNestedMenuItem('menu_preview_map', {
				text: ' بيانات المعاينة - الموقع  ',
				getSubmenuItems: function () {
					return [
						{
							type: 'menuitem',
							text: 'خط الطول',
							onAction: function () {
								editor.insertContent('{Value_MAP_}');
							}
						},
						{
							type: 'menuitem',
							text: 'خط العرض',
							onAction: function () {
								editor.insertContent('{Value_MAP_}');
							}
						},
						{
							type: 'menuitem',
							text: 'خط الطول - صيغة الوقت',
							onAction: function () {
								editor.insertContent('{Value_MAP_}');
							}
						},
						{
							type: 'menuitem',
							text: 'خط العرض - صيغة الوقت',
							onAction: function () {
								editor.insertContent('{Value_MAP_}');
							}
						},
						{
							type: 'menuitem',
							text: ' صورة الأقمار الصناعية',
							onAction: function () {
								editor.insertContent('{Value_MAP_}');
							}
						},
						{
							type: 'menuitem',
							text: ' صورة الخريطة',
							onAction: function () {
								editor.insertContent('{Value_MAP_}');
							}
						},
						{
							type: 'menuitem',
							text: ' محيط العقار',
							onAction: function () {
								editor.insertContent('{Value_MAP_}');
							}
						},
					];
				}
			});
			editor.ui.registry.addNestedMenuItem('menu_preview_photo', {
				text: ' بيانات المعاينة - الصور  ',
				getSubmenuItems: function () {
					return [
						{
							type: 'menuitem',
							text: ' صور داخل العقار ',
							onAction: function () {
								editor.insertContent('{PHOTO_TP_IN}');
							}
						},
						{
							type: 'menuitem',
							text: ' صور خارج العقار ',
							onAction: function () {
								editor.insertContent('{PHOTO_TP_OUT}');
							}
						},
						{
							type: 'menuitem',
							text: ' صور الملاحظات ',
							onAction: function () {
								editor.insertContent('{PHOTO_TP_COMMENT}');
							}
						},
					];
				}
			});



			editor.ui.registry.addNestedMenuItem('menu_preview_Comparisons', {
				text: ' بيانات المعاينة - مقارنات الاراضي و المباني   ',
				getSubmenuItems: function () {
					return [
						{
							type: 'menuitem',
							text: '  مقارنات الاراضي و المباني   ',
							onAction: function () {
								editor.insertContent('{Value_TP_COMPARISONS}');
							}
						},
					];
				}
			});

			editor.ui.registry.addNestedMenuItem('menu_Evaluation_final', {
				text: ' بيانات التقييم النهائي ',
				getSubmenuItems: function () {
					return [

					];
				}
			});

			editor.ui.registry.addNestedMenuItem('menu_Text_Static', {
				text: ' نصوص و تعريفات ',
				getSubmenuItems: function () {
					return [

					];
				}
			});


			/* */
			editor.ui.registry.addNestedMenuItem('menu_company', {
				text: 'بيانات المنشأة',
				getSubmenuItems: function () {
					return [
						{
							type: 'menuitem', text: 'شعار المنشأة',onAction: function () { editor.insertContent('{Company_Logo}'); }
						},
						{
							type: 'menuitem', text: ' اسم المنشأة ',onAction: function () { editor.insertContent('{Company_Name}'); }
						},
						{
							type: 'menuitem', text: 'رقم السجل التجاري ',onAction: function () { editor.insertContent('{Company_CRN}'); }
						},
						{
							type: 'menuitem', text: 'رقم عضوية الهيئة ',onAction: function () { editor.insertContent('{Company_AMN}'); }
						},
						{
							type: 'menuitem', text: ' الختم الرسمي ',onAction: function () { editor.insertContent('{Company_Stamp}'); }
						},
					];
				}
			});
			editor.ui.registry.addNestedMenuItem('menu_client', {
				text: 'بيانات العميل',
				getSubmenuItems: function () {
					return [
						{
							type: 'menuitem', text: 'شعار العميل',onAction: function () { editor.insertContent('{Client_Logo}'); }
						},
						{
							type: 'menuitem', text: 'اسم العميل',onAction: function () { editor.insertContent('{Client_Name}'); }
						},
					];
				}
			});
			/* */

		},
		font_css:"<?= base_url("Assets/fonts/font_arabic.css") ?>",
		content_style: "",
	});
</script>