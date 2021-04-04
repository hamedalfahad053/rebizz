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




    ###################################################################
    public function Get_Property_Types_Of_CATEGORY()
    {
        header('Content-Type: application/json');

        $Property_Types_data = array();

        $CATEGORY_ID = $this->input->get('CATEGORY_ID');

        $Property_Types = Get_Property_Types_Of_Categories($CATEGORY_ID);

        $lang = get_current_lang();

        foreach ($Property_Types->result() as $row)
        {
            $Property_Types_data[] = array(
                "Property_Types_id"        => $row->Property_Types_id,
                "Property_Types_Name"      => $row->item_translation,
                "Property_Types_key"       => $row->Property_Types_key
            );
        }

        echo json_encode($Property_Types_data);

    }
    ###################################################################

    ###################################################################
    public function Get_FORM_Client_Company()
    {

    }
    ###################################################################


    ###################################################################
    public function Ajax_Filter_CUSTOMER_CATEGORY()
    {
        header('Content-Type: application/json');

        $CUSTOMER_CATEGORY_ID = $this->input->get('CUSTOMER_CATEGORY');
        $Company_id           = $this->data['UserLogin']['Company_User'];

        $data = array();

        $Client_Company       = App_Get_Client_Company_By_CATEGORY($Company_id,$CUSTOMER_CATEGORY_ID);

        if($Client_Company->num_rows()>0){

            foreach ($Client_Company->result() AS $ROW_CLI)
            {
                $data[] = array(
                    "Client_id"   =>  $ROW_CLI->client_id,
                    "Client_name" =>  $ROW_CLI->name
                );
            }

            $msg['type'] = true;
            $msg['data'] = $data;

        }else{
            $msg['type'] = false;
        }

        $msg['success'] = true;

        echo json_encode($msg);
    }
    ###################################################################

    ###################################################################
    public function Ajax_Select_Contract_Client()
    {
        $Company_id      = $this->data['UserLogin']['Company_User'];
        $Client_ID       = $this->input->get('Client_id');
        $data            = array();

        $Client_Contract = App_Client_Contract_Company($Company_id,$Client_ID);

        if($Client_Contract->num_rows()>0){

            foreach ($Client_Contract->result() AS $ROW_CLI)
            {
                $data[] = array(
                    "Contracts_id"         =>  $ROW_CLI->contract_id,
                    "Contracts_name"       =>  $ROW_CLI->Contracts_name,
                    "Contracts_start_date" => $ROW_CLI->Contracts_start_date,
                    "Contracts_end_date"   => $ROW_CLI->Contracts_end_date,
                    "Code_Transaction"     => $ROW_CLI->Code_Transaction
                );
            }

            $msg['type'] = true;
            $msg['data'] = $data;

        }else{
            $msg['type'] = false;
        }

        echo json_encode($msg);

    }
    ###################################################################






}