

        <div class="form-group row">
            <div class="col-lg-6">
                <label>  اختر جدول البيانات المطلوب </label>
                <select name="Table_primary"  id="Table_primary" data-size="7"  class="form-control selectpicker" data-live-search="true">
                    <?php
                    foreach ($tables_db AS $table)
                    {
                        echo '<option value="'.$table.'">'.$table.'</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-lg-6">
                <label>  اختر حقل القيمة </label>
                <select name="primary_fields" id="Table_primary_fields" data-size="7"   class="form-control selectpicker" data-live-search="true"></select>
            </div>


	        <div class="col-lg-12 mt-5 row">
		        <div class="col-lg-6">
			        <label>  اختر جدول البيانات المطلوب </label>
			        <select name="Table_Join" data-size="7"  id="Table_Join" class="form-control selectpicker" data-live-search="true">
				        <?php
				        foreach ($tables_db AS $table)
				        {
					        echo '<option value="'.$table.'">'.$table.'</option>';
				        }
				        ?>
			        </select>
		        </div>
		        <div class="col-lg-6">
			        <label>  اختر حقل العنوان </label>
			        <select name="Join_fields" id="Table_Join_fields"  class="form-control selectpicker" data-live-search="true"></select>
		        </div>
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

                <label class="checkbox">
                    <input type="checkbox" value="1" name="join_table" class="join_table_Changed" onchange="join_table_Changed()" />
                    <span></span>
                    هل جدول الحقل الاساسي و العنوان مختلفة
                </label>
            </div>
        </div>

        <div class="form-group row mt-10">

	        <div class="col-lg-12 row mt-10 join_table_div" style="display:none">
	            <div class="col-lg-6">
	                <label>  حقل الجدول الاساسي </label>
	                <select name="primary_joining_fields" id="Table_primary_joining_fields" data-size="7"   class="form-control selectpicker" data-live-search="true"></select>
	            </div>
	            <div class="col-lg-6 ">
	                <label>  حقل الجدول الثانوي </label>
	                <select name="Join_joining_fields" id="Table_Join_joining_fields"  data-size="7"  class="form-control selectpicker" data-live-search="true"></select>
	            </div>
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
                        });
                        $("#Table_Join_fields").selectpicker('refresh');
                        $("#Table_Join_joining_fields").selectpicker('refresh');
                    },
                    error: function () {
                        swal.fire(" خطا ", "في ارسال الطلب ", "error");
                    }
                });
            });
        </script>



