
<div class="form-group row">
    <div class="col-lg-3 mt-5">
        <label>  القائمة المرتبطة بها </label>
        <select name="List_Target" id="List_Target" required="required" class="form-control selectpicker" data-size="7" data-live-search="true">
            <?php
            $Get_All_List  = Get_All_List()->result();
            foreach ($Get_All_List AS $Row_List)
            {
                echo '<option value="'.$Row_List->list_id.'">'.$Row_List->item_translation.'</option>';
            }
            ?>
        </select>
    </div>
</div>

<div class="form-group row">
    <?php
    $ix = 0;
    foreach ($list_options->result() as $x) {

	   ++ $ix;
    ?>
        <div class="col-lg-4 mt-5">
            <label>خيارات القائمة</label>
            <select name="options_id[]" class="form-control required="required" selectpicker" title="" data-size="5" data-live-search="true">
                <?php
                foreach ($list_options->result() as $row) {
                   echo '<option value="' . $row->list_options_id . '">' . $row->item_translation . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="col-lg-4 mt-5">
            <label>العناصر المرتبطة بها</label>
            <select name="parent_id[<?= $x->list_options_id ?>][]" required="required"  id="parent_id_<?= $x->list_options_id ?>" class="form-control  selectpicker" title="اختر" multiple="multiple" data-size="5" data-live-search="true">

            </select>
        </div>

        <div class="col-lg-4 mt-5">


        </div>

	    <script type="text/javascript">
		    $('#List_Target').change(function(event){
			    event.preventDefault();
			    var List_Target = $('select[name=List_Target]').val();
			    $.ajax({
				    type: 'ajax',
				    method: 'get',
				    async: false,
				    dataType: 'json',
				    url: '<?= base_url(ADMIN_NAMESPACE_URL . '/List_Data/Ajax_options_List') ?>',
				    data: {
					    List_id: List_Target
				    },
				    success: function (data) {
					    $.each(data, function (key, value) {
						    $("#parent_id_<?= $x->list_options_id ?>").append('<option value=' + value.options_id + '>' + value.options_title + '</option>');
					    });
					    $('#parent_id_<?= $x->list_options_id ?>').selectpicker('refresh');
				    },
				    error: function () {
					    swal.fire(" خطا ", "في ارسال الطلب ", "error");
				    }
			    });
		    });
	    </script>

    <?php
    }
    ?>

</div>




            