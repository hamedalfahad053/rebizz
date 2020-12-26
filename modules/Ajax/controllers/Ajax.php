<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends Base_Ajax
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
       die;
    }
    ###################################################################

    ###################################################################
    public function Get_Nationality()
    {
        header('Content-Type: application/json');

        $Nationality_data = array();

        $Nationality_id = $this->input->get('Nationality_id');

        $Nationality = Get_Countries($Nationality_id);

        $lang = get_current_lang();

        foreach ($Nationality->result() as $row)
        {
            if($lang=='arabic'){
                $Nationality_Name = $row->country_arNationality;
            }else{
                $Nationality_Name = $row->country_enNationality;
            }

            $Nationality_data[] = array(
                "id"   => $row->countries_id,
                "Name" => $Nationality_Name
            );
        }

        echo json_encode($Nationality_data);

    }
    ###################################################################



    ###################################################################
    public function Get_Countries()
    {
          header('Content-Type: application/json');

          $Countries_data = array();

          $Countries_id = $this->input->get('Countries_id');

          $Countries = Get_Countries($Countries_id);

          $lang = get_current_lang();

          foreach ($Countries->result() as $row)
          {
              if($lang=='arabic'){
                 $country_Name = $row->country_arName;
              }else{
                 $country_Name = $row->country_enName;
              }

              $Countries_data[] = array(
                  "id"   => $row->countries_id,
                  "Name" => $country_Name
              );
          }

          echo json_encode($Countries_data);

    }
    ###################################################################

    ###################################################################
    public function Get_Regions()
    {
        header('Content-Type: application/json');

        $Regions_data = array();

        $Countries_id = $this->input->get('Country_id');
        $Regions_id   = $this->input->get('Regions_id');

        $Regions = Get_Regions($Countries_id,$Regions_id);

        $lang = get_current_lang();

        foreach ($Regions->result() as $row)
        {
            if($lang=='arabic'){
                $Regions_Name = $row->name_ar;
            }else{
                $Regions_Name = $row->name_en;
            }

//            $point_map = $row->Point;
//            $point_map = str_replace("POINT","",$point_map);
//            $point_map = str_replace("(","",$point_map);
//            $point_map = str_replace(")","",$point_map);
//
//            $point_map = explode(" ",$point_map);

            $Regions_data[] = array(
                "id"        => $row->region_id,
                "Name"      => $Regions_Name,
                //"point_map_lat" => $point_map[1],
                //"point_map_lng" => $point_map[0],
            );

        }
        echo json_encode($Regions_data);
    }
    ###################################################################


    ###################################################################
    public function Get_Cites()
    {
        header('Content-Type: application/json');

        $Cites_data = array();

        $Countries_id = $this->input->get('Country_id');
        $Regions_id   = $this->input->get('Region_id');
        $Cites_id     = $this->input->get('Cites_id');

        $Cites = Get_City($Countries_id,$Regions_id,$Cites_id);

        $lang = get_current_lang();

        foreach ($Cites->result() as $row)
        {
            if($lang=='arabic'){
                $Cites_Name = $row->name_ar;
            }else{
                $Cites_Name = $row->name_en;
            }

            $Cites_data[] = array(
                "id"        => $row->city_id,
                "Name"      => $Cites_Name,
            );
        }
        echo json_encode($Cites_data);

    }
    ###################################################################


    ###################################################################
    public function Get_Districts()
    {
        header('Content-Type: application/json');

        $Cites_data = array();

        $Countries_id = $this->input->get('Country_id');
        $Regions_id   = $this->input->get('Region_id');
        $Cites_id     = $this->input->get('City_id');
        $Districts_id = $this->input->get('Districts_id');

        $Districts = Get_Districts($Countries_id,$Regions_id,$Cites_id,$Districts_id);

        $lang = get_current_lang();

        foreach ($Districts->result() as $row)
        {
            if($lang=='arabic'){
                $Districts_Name = $row->name_ar;
            }else{
                $Districts_Name = $row->name_en;
            }

            $Cites_data[] = array(
                "id"        => $row->district_id,
                "Name"      => $Districts_Name,
            );
        }

        echo json_encode($Cites_data);

    }
    ###################################################################




}