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


	    <div class="card card-custom">
		    <!--begin::Header-->
		    <div class="card-header">
			    <div class="card-title">
				    <h3 class="card-label">خيارات النموذج</h3>
			    </div>
			    <div class="card-toolbar">
	                <?=  Create_One_Button_Text_Without_tooltip(array('id'=>'','class'=>'','title' => 'اضافة قسم', 'data_attribute' => 'data-toggle="modal" data-target="#Model_FormCreate_Sections_Form_Components"', 'href' => "javascript:void(0);")); ?>
			    </div>
		    </div>
		    <!--end::Header-->
		    <!--begin::Body-->
		    <div class="card-body">
		    </div>
		    <!--end: Card Body-->
	    </div>
	    <!--end: Card-->


        <div id="Data_Sections_Components">
            <div class="lod_spinner spinner hidden spinner-primary mr-15"></div>
        </div>

    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->

<?= $this->load->view('../../modules/System_Forms/views/Model_Form_Add_SctionComponents',$status); ?>
<?= $this->load->view('../../modules/System_Forms/views/Model_Form_Add_Fields',$Fields_All_Data); ?>
<?= $this->load->view('../../modules/System_Forms/views/Model_Form_Create_List',$Get_All_List); ?>


<script type="text/javascript">
    $(document).ready(function() {


        // ------------------------------------------------------------------------------- //
        function Sections_Components() {
            var Forms_id    = <?= $this->uri->segment(4) ?>;
            $.ajax({
                type: 'ajax',
                method: 'get',
                beforeSend: function() {
                    $('.lod_spinner').show();
                },
                url: '<?= base_url(ADMIN_NAMESPACE_URL . '/Forms/Ajax_Sections_Components/') ?>',
                data: {Forms_id:Forms_id },
                async: false,
                dataType: 'html',
                success: function(data){
                    $('.lod_spinner').hide();
                    $('#Data_Sections_Components').html(data);
                },
                error: function(){
                    swal.fire("خطا بالارسال",'', "error");
                }
            });
        }
        Sections_Components();
        // ------------------------------------------------------------------------------- //

        // ------------------------------------------------------------------------------- //
        $('#FormCreateSections').on('click', '#buttonCreateSections', function (event) {

            event.preventDefault();

            var Sections_title_ar    = $('input[name=Sections_title_ar]').val();
            var Sections_title_en    = $('input[name=Sections_title_en]').val();
            var Sections_Status      = $('select[name=Sections_Status]').val();
            var Forms_id             = <?= $this->uri->segment(4) ?>

            $.ajax({
                type: 'ajax',
                method: 'get',
                url: '<?= base_url(ADMIN_NAMESPACE_URL . '/Forms/Create_Sections_Form_Components/') ?>',
                data: { Forms_id:Forms_id ,  Sections_title_ar:Sections_title_ar,Sections_title_en:Sections_title_en,Sections_Status:Sections_Status },
                async: false,
                dataType: 'json',
                success: function(data){
                    if(data.Type_result=='success'){
                        swal.fire("تمت الاضافة بنجاح",data.Message_result,"success");
                        Sections_Components();
                    }else{
                        swal.fire("حدث خطا ",data.Message_result, "error");
                    }
                },
                error: function(){
                    swal.fire("خطا بالارسال",'', "error");
                }
            });

        });
        // ------------------------------------------------------------------------------- //

	    // ------------------------------------------------------------------------------- //
		$('#Data_Sections_Components').on('click', '.Deleted_Sections_Components', function (event) {

			event.preventDefault();

			var Sections_Components_id  = $(this).attr('data-components-id');
			var Forms_id                = <?= $this->uri->segment(4) ?>;

			Swal.fire({
				    title: "هل انت متاكد من اجراء الحذف",
				    text: "",
			        icon: "warning",
					showCancelButton: true,
					confirmButtonText: "تأكيد الحذف",
					cancelButtonText: "الغاء الامر",
					reverseButtons: true
		    }).then(function(result) {
				    if (result.value) {

					    $.ajax({
						    type: 'ajax',
						    method: 'get',
						    url: '<?= base_url(ADMIN_NAMESPACE_URL . '/Forms/Deleted_Sections_Form_Components/') ?>',
						    data: { Forms_id:Forms_id ,  Sections_Components_id:Sections_Components_id },
						    async: false,
						    dataType: 'json',
						    success: function(data){
							    if(data.Type_result=='success'){
								    swal.fire("تمت الاضافة بنجاح",data.Message_result,"success");
								    Sections_Components();
							    }else{
								    swal.fire("حدث خطا ",data.Message_result, "error");
							    }
						    },
						    error: function(){
							    swal.fire("خطا بالارسال",'', "error");
						    }
					    });

				    } else if (result.dismiss === "cancel") {
					    Swal.fire("تم الغاء العملية", "تم الغاء عملية الحذف", "error");
				    }
			});
		});
	    // ------------------------------------------------------------------------------- //


	    $(document).on('show.bs.modal','#Model_FormAddFields', function (event) {
		    var button    = $(event.relatedTarget)
		    var recipient = button.data('components-id')
		    var modal     = $(this);
		    modal.find('.card-body input[name="Fields_Components_id"][type="hidden"]').val(recipient);
	    });

	    // ------------------------------------------------------------------------------- //
        $('#FormAddFields').on('click', '#buttonAddFieldsSections', function (event) {

            event.preventDefault();
            var Forms_id         = <?= $this->uri->segment(4) ?>;
            var Components_id    = $('input[name=Fields_Components_id]').val();
            var Fields_id        = $('select[name=Fields_Add]').val();

            $.ajax({
                type: 'ajax',
                method: 'get',
                url: '<?= base_url(ADMIN_NAMESPACE_URL . '/Forms/Create_Fields_To_Sections_Form_Components/') ?>',
                data: { Forms_id:Forms_id , Components_id:Components_id , Fields_id:Fields_id},
                async: false,
                dataType: 'json',
                success: function(data){
                    if(data.Type_result=='success'){
                        swal.fire("تمت الاضافة بنجاح",data.Message_result,"success");
                        Sections_Components();
                    }else{
                        swal.fire("حدث خطا ",data.Message_result, "error");
                    }
                },
                error: function(){
                    swal.fire("خطا بالارسال",'', "error");
                }
            });

        });
        // ------------------------------------------------------------------------------- //


	    // ------------------------------------------------------------------------------- //
	    $('#Data_Sections_Components').on('click', '.DeletedFieldsSections', function (event) {

		    event.preventDefault();

		    var Forms_id         = <?= $this->uri->segment(4) ?>;
		    var Components_id    = $(this).attr('data-components-id');
		    var Fields_id        = $(this).attr('data-Fields-id');

		    $.ajax({
			    type: 'ajax',
			    method: 'get',
			    url: '<?= base_url(ADMIN_NAMESPACE_URL . '/Forms/Deleted_Fields_To_Sections_Form_Components') ?>',
			    data: { Forms_id:Forms_id , Components_id:Components_id , Fields_id:Fields_id},
			    async: false,
			    dataType: 'json',
			    success: function(data){
				    if(data.Type_result=='success'){
					    swal.fire("تمت الحذف بنجاح",data.Message_result,"success");
					    Sections_Components();
				    }else{
					    swal.fire("حدث خطا ",data.Message_result, "error");
				    }
			    },
			    error: function(){
				    swal.fire("خطا بالارسال",'', "error");
			    }
		    });
	    });
	    // ------------------------------------------------------------------------------- //



	    $(document).on('show.bs.modal','#Model_FormCreateList', function (event) {
		    var button    = $(event.relatedTarget)
		    var recipient = button.data('components-id')
		    var modal     = $(this);
		    modal.find('.card-body input[name="List_Components_id"][type="hidden"]').val(recipient);
	    });


	    // ------------------------------------------------------------------------------- //
	    $('#FormListSections').on('click', '#buttonListSections', function (event) {

		    event.preventDefault();

		    var Forms_id              = <?= $this->uri->segment(4) ?>;
		    var List_Components_id    = $('input[name=List_Components_id]').val();
		    var List_id               = $('select[name=List_id]').val();

		    $.ajax({
			    type: 'ajax',
			    method: 'get',
			    url: '<?= base_url(ADMIN_NAMESPACE_URL . '/Forms/Create_List_To_Sections_Form_Components/') ?>',
			    data: { Forms_id:Forms_id , List_Components_id:List_Components_id , List_id:List_id},
			    async: false,
			    dataType: 'json',
			    success: function(data){
				    if(data.Type_result=='success'){
					    swal.fire("تمت الاضافة بنجاح",data.Message_result,"success");
					    Sections_Components();
				    }else{
					    swal.fire("حدث خطا ",data.Message_result, "error");
				    }
			    },
			    error: function(){
				    swal.fire("خطا بالارسال",'', "error");
			    }
		    });

	    });
	    // ------------------------------------------------------------------------------- //



    });
</script>
