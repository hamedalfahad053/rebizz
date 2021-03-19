<fieldset class="todos_labels">
    <div class="repeatable"></div>
    <div class="form-group row mt-10">
        <input type="button" value="اضف المزيد" class="btn btn-primary add" align="center">
    </div>
</fieldset>

<script type="text/template" id="todos_labels">
    <div class="field-group form-group row">

        <div class="col-lg-4 mt-5">
            <label for="NameFile_{?}">اسم الملف</label>
	        <input type="text" name="FILE_Name[]" id="FILE_Name[{?}]"  class="form-control">
        </div>

        <div class="col-lg-4 mt-5">
            <label for="File_{?}">الملف</label>
            <input type="file" name="FILE[]" id="FILE[{?}]" class="form-control-file">
        </div>

        <div class="col-lg-4 mt-5">
            <label for=""></label>
            <input type="button" class="btn btn-danger span-2 delete" value="حذف" />
        </div>

    </div>
</script>


<?= import_js(BASE_ASSET.'plugins/jquery.repeatable',''); ?>
<script>
	$(function() {
		$(".todos_labels .repeatable").repeatable({
			addTrigger: ".todos_labels .add",
			deleteTrigger: ".todos_labels .delete",
			template: "#todos_labels",
			startWith: 1,
			min:1,
			max:10
		});
	});
</script>