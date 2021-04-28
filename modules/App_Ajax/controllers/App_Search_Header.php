<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Search_Header extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
    }
    ###################################################################

    ###################################################################
    public function index()
    {
        $query = $this->input->get('query',true);

        if($query==''){
            echo 'فضلا ضع رقم الصك , المعاملة,هوية الخ... لاستكمال عملية البحث';
        }else{
                ?>
                <div class="d-flex align-items-center flex-grow-1 mb-2">
                    <div class="symbol symbol-30  flex-shrink-0">
                        <div class="symbol-label">
                            <i class="flaticon2-user text-info"></i>
                        </div>
                    </div>
                    <div class="d-flex flex-column ml-3 mt-2 mb-2">
                        <a href="#" class="font-weight-bold text-dark text-hover-primary"></a>
                        <span class="font-size-sm font-weight-bold text-muted">
                        </span>
                    </div>
                </div>
                <?php
        } // if($query=='')
    }
    ###################################################################



}