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
    function Get_All_Countries($country_code='')
    {

        if($country_code){
            $this->db->where('country_code',$country_code);
        }

        $query = $this->db->get('portal_map_countries');
        return $query;
    }
    ########################################################################


    ########################################################################
    function Get_All_Regions($Region_id='')
    {

        if($Region_id){
            $this->db->where('region_id',$Region_id);
        }

        $query = $this->db->get('portal_map_regions');
        return $query;
    }
    ########################################################################


    ########################################################################
    function Get_All_Cities($Cities='')
    {

        if($Cities){
            $this->db->where('city_id',$Cities);
        }

        $query = $this->db->get('portal_map_cities');
        return $query;
    }
    ########################################################################

    ########################################################################
    function Get_All_Districts($Districts='')
    {

        if($Districts){
            $this->db->where('district_id',$Districts);
        }

        $query = $this->db->get('portal_map_districts');
        return $query;
    }
    ########################################################################



}