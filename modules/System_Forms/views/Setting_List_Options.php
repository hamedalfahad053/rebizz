




    <div class="form-group">
        <div class="checkbox-list">
            <label class="checkbox">
                <input type="checkbox" value="1"  name="customs_company"/>
                <span></span>
                تخصيص من قبل الشركة
            </label>
            <label class="checkbox">
                <input type="checkbox" value="1"  name="customs_company_client"/>
                <span></span>
                تخصيص الشركة لعميل
            </label>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-lg-4 mt-5">
            <label>خيارات القائمة</label>
	              <?php
	              foreach ($list_options->result() AS $Row)
	              {
		              echo '<span class="label label-info label-inline mr-2">'.$Row->item_translation.'</span>';
	              }
	              ?>
        </div>
    </div>

    <script type="text/javascript">
	    $('.selectpicker').selectpicker('refresh');
    </script>