<?php
class System_Forms_Model extends MY_Model
{

    ########################################################################
    public function __construct()
    {
        parent::__construct();
    }
    ########################################################################


    ########################################################################
    function Get_All_countries($country_code='')
    {

        if($country_code){
            $this->db->where('country_code',$country_code);
        }

        $query = $this->db->get('portal_map_countries');
        return $query;
    }
    ########################################################################





}