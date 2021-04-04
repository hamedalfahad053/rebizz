

<div class="form-group row">
	<div class="col-lg-12 mt-5">
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
	<div class="col-lg-6">
		<label>  اختر جدول البيانات المطلوب </label>
		<select name="Table_primary" required="required" id="Table_primary" data-size="7"  class="form-control selectpicker" data-live-search="true">
			<?php
			foreach ($tables_db AS $table)
			{
				echo '<option value="'.$table.'">'.$table.'</option>';
			}
			?>
		</select>
	</div>
	<div class="col-lg-6">
		<label>  اختر الحقل الاساسي </label>
		<select name="Table_primary_fields" required="required" title="اختر " id="Table_primary_fields" data-size="7"   class="form-control selectpicker" data-live-search="true"></select>

	</div>

</div>

<div class="form-group row">
	<div class="checkbox-list">
		<label class="checkbox">
			<input type="checkbox" value="1" name="linked_translation"/>
			<span></span>
			هل الجدول مرتبط بترجمة
		</label>
		<label class="checkbox">
			<input type="checkbox" value="1" name="linked_company_id"/>
			<span></span>
			هل البيانات  مرتبطة بحساب الشركة
		</label>
        <input type="hidden" name="Linking_table" value="1">
	</div>
</div>

<div class="form-group row mt-10">
	<div class="col-lg-4">
		<label>  اختر جدول البيانات المطلوب </label>
		<select name="Table_Join" data-size="7"  required="required" title="اختر "   id="Table_Join" class="form-control selectpicker" data-live-search="true">
			<?php
			foreach ($tables_db AS $table)
			{
				echo '<option value="'.$table.'">'.$table.'</option>';
			}
			?>
		</select>
	</div>
	<div class="col-lg-4">
		<label>  اختر حقل العنوان </label>
		<select name="Table_Join_fields" id="Table_Join_fields"   required="required" title="اختر "  class="form-control selectpicker" data-live-search="true"></select>
	</div>
	<div class="col-lg-4">
		<label> حدد الحقل الاساسي الذي يتصل به الجدول الاول </label>
		<select name="primary_fields_link_to_options" required="required" title="اختر "  id="primary_fields_link_to_options" data-size="7"   class="form-control selectpicker" data-live-search="true"></select>
	</div>
</div>


<div class="form-group row mt-10">
	<div class="col-lg-6">
		<label>  حقل الجدول الاساسي </label>
		<select name="Table_primary_joining_fields"  id="Table_primary_joining_fields" data-size="7"   class="form-control selectpicker" data-live-search="true"></select>
	</div>
	<div class="col-lg-6">
		<label>  حقل الجدول الثانوي </label>
		<select name="Table_Join_joining_fields" id="Table_Join_joining_fields"  data-size="7"  class="form-control selectpicker" data-live-search="true"></select>
	</div>
</div>




<script type="text/javascript">

	function join_table_Changed()
	{
		if ($('.join_table_Changed').is(":checked")) {
			$(".join_table_div").show();
		} else {
			$(".join_table_div").hide();
		}
	}

	$('#Table_primary').change(function(event){
		event.preventDefault();
		var table_data   = $('select[name=Table_primary]').val();
		$.ajax({
			type: 'ajax',
			method: 'get',
			async: false,
			dataType: 'json',
			url: '<?= base_url( ADMIN_NAMESPACE_URL.'/List_Data/Ajax_fields_Table_Database') ?>',
			data: {
				table_data:table_data
			},
			success: function (data) {
				$("#Table_primary_fields").empty();
				$.each(data, function (key, value) {
					$("#Table_primary_fields").append('<option value=' + value.id + '>' + value.Name + '</option>');
					$("#Table_primary_joining_fields").append('<option value=' + value.id + '>' + value.Name + '</option>');
				});
				$("#Table_primary_fields").selectpicker('refresh');
				$("#Table_primary_joining_fields").selectpicker('refresh');
			},
			error: function () {
				swal.fire(" خطا ", "في ارسال الطلب ", "error");
			}
		});
	});

	$('#Table_Join').change(function(event){
		event.preventDefault();
		var table_data   = $('select[name=Table_Join]').val();
		$.ajax({
			type: 'ajax',
			method: 'get',
			async: false,
			dataType: 'json',
			url: '<?= base_url( ADMIN_NAMESPACE_URL.'/List_Data/Ajax_fields_Table_Database') ?>',
			data: {
				table_data:table_data
			},
			success: function (data) {
				$("#Table_Join_fields").empty();
				$.each(data, function (key, value) {
					$("#Table_Join_fields").append('<option value=' + value.id + '>' + value.Name + '</option>');
					$("#Table_Join_joining_fields").append('<option value=' + value.id + '>' + value.Name + '</option>');
					$("#primary_fields_link_to_options").append('<option value=' + value.id + '>' + value.Name + '</option>');
				});
				$("#Table_Join_fields").selectpicker('refresh');
				$("#Table_Join_joining_fields").selectpicker('refresh');
				$("#primary_fields_link_to_options").selectpicker('refresh');
			},
			error: function () {
				swal.fire(" خطا ", "في ارسال الطلب ", "error");
			}
		});
	});
</script>



