<?php
class Transaction_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    ########################################################################
    function Get_Stages_Transaction()
    {
        $this->db->from('protal_stages_transaction  stages_Transaction');
        $this->db->join('protal_stages_transaction_translation  stages_Transaction_Translation', 'stages_Transaction.stages_id=stages_Transaction_Translation.item_id');
        $lang   = get_current_lang();
        $this->db->where('stages_Transaction_Translation.translation_lang',$lang);
        $query = $this->db->get();
        return $query;
    }
    ########################################################################

    ########################################################################
    function Create_Stages_Transaction($data)
    {
        $query = $this->db->insert('protal_stages_transaction',$data);
        if($query){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    ########################################################################



}