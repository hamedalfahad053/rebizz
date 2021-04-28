<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Map extends Apps
{
    ###################################################################
    public function __construct()
    {
        parent::__construct();
        $this->data['controller_name'] = 'نظام الخرائط الجغرافية';
    }
    ###################################################################

    ###################################################################
    public function index()
    {
        $this->data['Page_Title']  = '  الخرائط الجغرافية ';

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Company_Locations'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_Map/views/Map', $this->data, true);

        Layout_Apps($this->data);



//        $Get_Query = app()->db->query("SELECT  ST_Y(center)  AS Latitude,ST_X(center) AS Longitude,
//        astext(center) AS Center_Point ,
//        name_ar,name_en,city_id,center,region_id,countries_id From `portal_map_cities` limit 1 ");
//
//        foreach ($Get_Query->result() as $c)
//        {
//
//            $name_ar = 'غير مسمى';
//
//
//
//            app()->db->query(" INSERT INTO `portal_map_districts` (city_id,region_id,countries_id,name_ar,name_en,boundaries)
//            VALUES ('$c->city_id','$c->region_id','$c->countries_id','$name_ar','Unnamed',ST_PolygonFromText($c->Center_Point) )  ");
//
//        }


    }
    ###################################################################

    ###################################################################
    public function Regions()
    {
        $this->data['Page_Title']  = ' المناطق ';


        $this->data['Get_Regions'] = Get_Regions(194);

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Company_Locations'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');


        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_Map/views/Regions', $this->data, true);

        Layout_Apps($this->data);
    }
    ###################################################################

    ###################################################################
    public function cities()
    {
        $this->data['Page_Title']  = '  المدن ';

        $Regions_id =  $this->uri->segment(4);


        $query = app()->db->where('region_uuid',$Regions_id);
        $query = app()->db->get('portal_map_regions');

        $Get_City = Get_City(194,$query->row()->region_id);

        $this->data['Get_City'] = $Get_City;


        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Company_Locations'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_Map/views/Cities', $this->data, true);

        Layout_Apps($this->data);
    }
    ###################################################################


    ###################################################################
    public function districts()
    {

        $cities_id =  $this->uri->segment(4);

        $query = app()->db->where('city_uuid',$cities_id);
        $query = app()->db->get('portal_map_cities');

        $Districts = app()->db->where('city_id',$query->row()->city_id);
        $Districts = app()->db->where('region_id',$query->row()->region_id);
        $Districts = app()->db->get('portal_map_districts');


        $this->data['Get_Districts'] = $Districts;


        $this->data['Page_Title']  = ' الاحياء ';

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Company_Locations'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');

        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'plugins/custom/datatables/datatables.bundle',$this->data['direction']);
        $this->data['Lode_file_Js']  = import_js(BASE_ASSET.'plugins/custom/datatables/datatables.bundle','');

        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_Map/views/districts', $this->data, true);

        Layout_Apps($this->data);

    }
    ###################################################################

    ###################################################################
    public function View_Map()
    {
        $this->data['Page_Title']  = ' الخريطة ';

        $region_uuid =  $this->uri->segment(5);





//        if($this->db->version() > 8){
//
//        }else{
//
//        }
        $Get_Regions_query = app()->db->query("SELECT  ST_Y(center)  AS Latitude,ST_X(center) AS Longitude,
        astext(center) AS Center_Point , astext(boundaries) AS Point_Boundaries,
        region_uuid,code,name_ar,name_en,capital_city_id,region_id From `portal_map_regions` where `region_uuid` = ('$region_uuid') ");


        $this->data['Get_Regions'] = $Get_Regions_query->row();

        $this->mybreadcrumb->add(lang('Dashboard'), base_url(APP_NAMESPACE_URL.'/Dashboard'));
        $this->mybreadcrumb->add($this->data['controller_name'], base_url(APP_NAMESPACE_URL.'/Company_Locations'));
        $this->mybreadcrumb->add($this->data['Page_Title'],'#');


        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['PageContent'] = $this->load->view('../../modules/App_Company_Map/views/View_Map', $this->data, true);

        Layout_Apps($this->data);
    }
    ###################################################################



}