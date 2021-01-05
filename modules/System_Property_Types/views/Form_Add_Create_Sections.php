<div class="collapse" id="collapseFormAdd_sctions">


    <form class="form" id="FormCreateSections" name="FormCreateSections" action="#" method="get">

        <div class="card card-custom mb-10 mt-10">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
                    <h3 class="card-label">اضافة قسم جديد</h3>
                </div>
                <div class="card-toolbar"></div>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-lg-4 mt-5">
                        <label>العنوان بالعربية</label>
                        <input type="text" id="Sections_title_ar" name="Sections_title_ar" class="form-control" placeholder=""/>
                    </div>
                    <div class="col-lg-4 mt-5">
                        <label>العنوان بالانجليزية</label>
                        <input type="text" id="Sections_title_en" name="Sections_title_en" class="form-control" placeholder=""/>
                    </div>
                    <div class="col-lg-4 mt-5">
                        <label>الحالة</label>
                        <select name="Sections_Status" id="Sections_Status" class="form-control selectpicker" data-live-search="true"  data-title="اختر من فضلك ">
                            <?php
                            foreach ($options_status AS $key => $value)
                            {
                                echo '<option value="'.$key.'">'.$value.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-6">
                        <button type="button" id="buttonCreateSections" class="btn btn-primary mr-2"><?= lang('add_button') ?></button>
                    </div>
                    <div class="col-lg-6 text-lg-right">
                        <button   class="btn btn-danger"><?= lang('cancel_button') ?></button>
                    </div>
                </div>
            </div>
        </div>


    </form>


</div><!--<div class="collapse" id="collapseFormAdd">-->