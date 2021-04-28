<div class="modal fade" id="Modal_Form_Comparisons" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">اضافة عرض مقارنة </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>

            <form id="Form_Comparisons"  action="#">

                <input type="hidden" name="Transaction_id"  value="<?= $Transactions->transaction_id ?>">
	            <input type="hidden" name="Coordination_id" value="<?= $Coordination->Coordination_id ?>">

                <div class="modal-body">
	                <div class="form-group row">
		                <label>الفئة</label>
		                <select name="Comparisons_type" id="Comparisons_type" class="form-control selectpicker" data-live-search="true"  data-title="اختر من فضلك ">
						    <option value="Land">ارض</option>
			                <option value="Building">مبنى</option>
		                </select>
	                </div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label>نوع العقار</label>
	                        <select name="property_types_id" id="property_types_id" class="form-control selectpicker" data-live-search="true"  data-title="اختر من فضلك ">
		                        <?php
		                        $Get_Property_Types = Get_Property_Types(array("Property_Types_status"=>1));
		                        foreach ($Get_Property_Types->result() as $roP){
		                        ?>
		                        <option value="<?= $roP->Property_Types_id ?>"><?= $roP->item_translation ?></option>
		                        <?php
		                        }
		                        ?>
	                        </select>
                        </div>
                        <div class="col-lg-4">
                            <label>مساحة الأرض</label>
                            <input type="text" name="Land_area" id="Land_area" class="form-control"  placeholder="مساحة الأرض"/>
                        </div>
                        <div class="col-lg-4">
                            <label>سعر المتر المربع</label>
                            <input type="text" name="Price_per_square_meter" id="Price_per_square_meter" class="form-control"  placeholder="سعر المتر المربع"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label>إجمالي قيمة العقار</label>
                            <input type="text" name="total_value_property" id="total_value_property" class="form-control"  placeholder="إجمالي قيمة العقار"/>
                        </div>
                        <div class="col-lg-4">
                            <label>المكتب</label>
                            <input type="text" name="office" id="office" class="form-control"  placeholder="المكتب"/>
                        </div>
                        <div class="col-lg-4">
                            <label>رقم الهاتف</label>
                            <input type="text" name="office_tel" id="office_tel" class="form-control" placeholder="رقم الهاتف"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-lg-12">
                            <button  type="button" id="Form_Comparisons_Submit"  class="btn btn-primary font-weight-bold">حفظ</button>
                            <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">الغاء الامر</button>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>


<script type="text/javascript">
	$('#Land_area,#Price_per_square_meter').keyup(function() {
		var Land_area  = $('#Land_area').val();
		var Price_per_square_meter  = $('#Price_per_square_meter').val();
		$('#total_value_property').val(Land_area * Price_per_square_meter);
	});


	function Get_Ajax_Data_Table_Land_Comparisons() {
		var Transactions_id        = <?= $Transactions->transaction_id ?>;
		var Coordination_id        = <?= $Coordination->Coordination_id ?>;
		$.ajax({
			url : "<?= base_url(APP_NAMESPACE_URL . '/Transactions/Ajax_Comparisons_Land_Comparisons') ?>",
			type:'get',
			data: {
				Transactions_id:Transactions_id,Coordination_id:Coordination_id
			},
			dataType: 'html',
			beforeSend: function(){
				$('#Ajax_Data_Table_Land_Comparisons').append("<div style='text-align: center;'><i class='fa fa-spinner fa-spin fa-5x fa-fw'></i></div>")
			},
			success: function(response) {
				$("#Ajax_Data_Table_Land_Comparisons").empty();
				$("#Ajax_Data_Table_Land_Comparisons").html(response);
			},
			error: function(){

			}
		});
	} // Get_All_Data_Ajax()


	Get_Ajax_Data_Table_Land_Comparisons();


	// ------------------------------------------------------------------------------- //
	// Form Add Land Comparisons
	$('#Form_Comparisons').on('click', '#Form_Comparisons_Submit', function (event) {
		event.preventDefault();

		var Transactions_id        = <?= $Transactions->transaction_id ?>;
		var Coordination_id        = <?= $Coordination->Coordination_id ?>;
		var Comparisons_type       = $('select[name=Comparisons_type]').val();
		var property_types_id       = $('select[name=property_types_id]').val();
		var Land_area              = $('input[name=Land_area]').val();
		var Price_per_square_meter = $('input[name=Price_per_square_meter]').val();
		var total_value_property   = $('input[name=total_value_property]').val();
		var office                 = $('input[name=office]').val();
		var office_tel             = $('input[name=office_tel]').val();

		$.ajax({
			type: 'ajax',
			method: 'get',
			url: '<?= base_url(APP_NAMESPACE_URL . '/Transactions/Create_Ajax_Comparisons_Comparisons') ?>',
			data: {
				Transactions_id: Transactions_id,Coordination_id:Coordination_id,Comparisons_type:Comparisons_type,
				Land_area:Land_area,Price_per_square_meter:Price_per_square_meter,property_types_id:property_types_id,
				total_value_property:total_value_property,office:office,office_tel:office_tel
			},
			async: false,
			dataType: 'json',
			success: function (response) {
				if (response.Type_result == 'success') {
					swal.fire("نجاح",response.Message_result, "success");
					Get_Ajax_Data_Table_Land_Comparisons();
				} else {
					swal.fire(" خطا ", response.Message_result, "error");
					Get_Ajax_Data_Table_Land_Comparisons();
				}
				$('#Modal_Form_Comparisons').modal('hide');
			},
			error: function () {
				swal.fire(" خطا ", "في ارسال الطلب ", "error");
				$('#Modal_Form_Comparisons').modal('hide');
			}
		});
	});
	// ------------------------------------------------------------------------------- //

</script>


