<div class="card card-custom mb-5">

    <div class="card-header">
        <div class="card-title">
            <span class="card-icon"><i class="flaticon-squares text-primary"></i></span>
            <h3 class="card-label">تقييم العقار</h3>
        </div>
        <div class="card-toolbar">

            <a href="<?= base_url(APP_NAMESPACE_URL.'/Evaluation/Add_New_Evaluation/'.$Transactions->uuid) ?>" class="btn btn-primary">
                <i class="flaticon2-line-chart"></i>  اضافة تقييم للمعاملة
            </a>


        </div>
    </div>
    <div class="card-body">


        <?php
        $query_Evluation_Transactions = $this->db->where('transaction_id',$Transactions->transaction_id);
        $query_Evluation_Transactions = $this->db->where('isDeleted',0);
        $query_Evluation_Transactions = app()->db->get('protal_evaluation_transactions');

        if ($query_Evluation_Transactions->num_rows() == 0) {

            echo Create_Status_Alert(array("key"=>"Danger","value"=>"لم يتم اضافة اي طريقة تقييم للمعاملة"));

        }else{

            ?>

            <style>th.dt-center,.dt-center { text-align: center; }</style>
            <table class="data_file table table-bordered table-hover display nowrap" width="100%">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">طريقة التقييم</th>
                    <th class="text-center">المقيم</th>
                    <th class="text-center">بواسطة / التاريخ</th>
                    <th class="text-center">الخيارات</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 0;
                foreach ($query_Evluation_Transactions->result() AS $QET)
                {

                    $Where_Evaluation_Methods  = array("evaluation_methods_id" => $QET->evaluation_methodid);
                    $Evaluation_Methods        = Get_Evaluation_Methods($Where_Evaluation_Methods)->row();
                    ?>
                    <tr>
                        <th class="text-center"><?= ++$i ?></th>
                        <th class="text-center"><?= $Evaluation_Methods->item_translation ?></th>
                        <th class="text-center"><?= $this->aauth->get_user($QET->evaluation_userid)->full_name ?></th>
                        <th class="text-center">
                            <?= $this->aauth->get_user($QET->Create_Byid)->full_name ?>
                            <?= date('Y-m-d ',$QET->Create_Date); ?>
                        </th>
                        <th class="text-center">
                            <?php
                            $options_Evaluation['view'] = array(
                                "class"             => '',
                                "id"                => '',
                                "title"             => 'عرض',
                                "data-attribute"    => '',
                                "href"              => base_url(APP_NAMESPACE_URL.'/Evaluation/Evaluation_Transactions/'.$Transactions->uuid.'/'.$QET->evaluation_uuid));

                            $options_Evaluation['edit'] = array(
                                "class"              => '',
                                "id"                 => '',
                                "title"              => 'تحرير ',
                                "data-attribute"     => '',"icon"  => '',
                                "href"               => "#");

                            echo Create_Options_Button($options_Evaluation);
                            ?>
                        </th>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>

            <?php
        }
        ?>

    </div>
</div>