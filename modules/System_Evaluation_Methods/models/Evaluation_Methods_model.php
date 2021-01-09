<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Evaluation_Methods_model extends CI_Model
{


    public function __construct()
    {
        parent::__construct();
    }

    ########################################################################
    function Get_All_Evaluation_Methods($evaluation_methods_id='')
    {
        $this->db->from('portal_evaluation_methods             evaluation_methods');
        $this->db->join('portal_evaluation_methods_translation translation', 'evaluation_methods.evaluation_methods_id=translation.item_id');

        $lang   = get_current_lang();
        $this->db->where('translation.translation_lang',$lang);

        if(!empty($evaluation_methods_id)){
            $this->db->where('evaluation_methods.evaluation_methods_id',$evaluation_methods_id);
        }

        $query = $this->db->get();

        return $query;

    }
    ########################################################################

    ########################################################################
    function Create_Evaluation_Methods($data)
    {
        $query = $this->db->insert('portal_evaluation_methods',$data);

        if($query){
            return $this->db->insert_id();
        }else{
            return false;
        }

    }
    ########################################################################

}
