<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }


    ########################################################################
    function Transaction_Insert($data)
    {
        $query     = $this->db->insert('protal_transaction',$data);
        $insert_id = $this->db->insert_id();


//        $query_contract     = $this->db->where('Clients_id',$data['Client_id']);
//        $query_contract     = $this->db->where('Company_id',$data['company_id']);
//        $query_contract     = $this->db->select_max('contract_id');
//        $query_contract     = $this->db->get('portal_app_client_contract')->row();

        //$transaction_number = $query_contract->Code_Transaction.''.$insert_id;

        $this->db->set('transaction_number',$insert_id);
        $this->db->where('transaction_id', $insert_id);
        $this->db->update('protal_transaction');

    }
    ########################################################################

}