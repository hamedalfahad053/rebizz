<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax_Map_Place extends Apps
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
        exit;
    }
    ###################################################################



    ###################################################################
    public function Get_Place()
    {

        $array_q    = array();
        $data_map   = array();


        $LATITUDE   = trim($this->input->get('LATITUDE'));
        $LONGITUDE  = trim($this->input->get('LONGITUDE'));



        $query_type_places = app()->db->where('type_places_status','1');
        $query_type_places = app()->db->get('protal_type_places_googlemap');

        foreach ($query_type_places->result() AS $PT)
        {
           $array_q[] =  $PT->type_places_key;
        }

        $place_array  = @explode(", ",$array_q);

        $url_api      = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?location='.$LATITUDE.','.$LONGITUDE.'&radius=300&name='.$place_array.'&key=AIzaSyDw_Thx2J7uq9eaqeb-WmZ2fBzUz7hZYGE';
        $json_api     = file_get_contents($url_api);
        $data_map_api = json_decode($json_api,true);


        foreach ($data_map_api['results']  AS $key => $vale)
        {


//            if(!is_string($vale)) {
//                echo "\n$vale contains:";
//                var_dump($vale);
//                die('as you can see, var is not a string');
//            }
//            elseif(stripos($vale,',') == FALSE) {
//                echo "\n$vale contains:";
//                var_dump($vale);
//                die('var is a string but has no commas');
//            }
//            else {
//                $vale = explode(',', $vale);
//                echo "\nnow $vale contains:";
//                var_dump($vale);
//                die();
//            }

            if($vale['types']){
                $types_status = implode(",",$vale['types']);
            }else{
                $types_status = '';
            }

            if(@$vale['business_status']){
                $business_status = $vale['business_status'];
            }else{
                $business_status = '';
            }

            $data_map[] = array( "geometry_lat" => $vale['geometry']['location']['lat'],
                "geometry_lng"      => $vale['geometry']['location']['lng'],
                "types"             => $types_status,
                "scope"             => $vale['scope'],
                "vicinity"          => $vale['vicinity'],
                "business_status"   => $business_status ,
                "name"              => $vale['name'] );
        }


        ?>

        <?php

        $msg['type']    = true;
        $msg['data']    = _array_p($data_map);
        $msg['success'] = true;

        echo json_encode($msg);


    }
    ###################################################################


    /*


A PHP Error was encountered

Severity: Warning

Message: explode() expects parameter 2 to be string, array given

Filename: controllers/Ajax_Map_Place.php

Line Number: 43

Backtrace:

File: D:\xampp\htdocs\rebizz\modules\App_Ajax\controllers\Ajax_Map_Place.php
Line: 43
Function: explode

File: D:\xampp\htdocs\rebizz\index.php
Line: 315
Function: require_once

stdClass Object
(
    [html_attributions] => Array
        (
        )

    [next_page_token] => ATtYBwITq5XsCIPtlRckPNYtKa5ErGtJpGiuDn1KvqcQyd2gJ1Ojthhzo4HbJLc90uLTrXgPI2rBju7Yx-PGnLdowDQvF-xBIRHZlhxDuq7nDc9DpILFlWkYCjsMOkqqjpy1HMl7SrxXLAdquTFbgO8yNhtl7_6EIh9vxf4D1k7hcvRDagW_4tnhzwBWnCJ5IlQ_XfuJXBRrMqfXuDsqQ515_pOVNAhwidvqDmnLMd8Ksx8vJqkXZoxCpwj4sREdoLC9vSk6vxwUUrbD-BefB07R7zBKwv55eIJcIwa6BMltKtrK8_XOKgbZYA-D1pRwf9a1NGFjELKtfBKA-preuN4INIDoja3IvMUjx-Uy44IL5s_HuogVMHR5TSKVSgGDfNg4Hb1mmhvDBWC6HCDsVYLNlO8xzfVy-HonyU7rgMn-4sT4eaNIy1r4SVGiP-u2ySRCPzJlUWB6_zvuSqDJPhXhwutylWrechxkWZK6Ig-Erd9rosp68mbU7RmNpVFd30U9wfHzLv2ETy1UtfAPRhYOk8IM8-V1PMga8FA-joQ7ExyGNQ6sd-nUcnvV3JfaXKre1VQDvoX_-C5XYEO2nqSPHYtvgdD-EF6nsnmA3myDSYAeqArGyvoiO5U3pxq4UxQ3HMa7ETKAJGq4wjQPo6hWUuBPmAx9jAy95-1r_uXSZRlhpV1X376wwxbnjHfkywL3Xicbyj90d9J19sydzhCgegQePwIgCvYA
    [results] => Array
        (
            [0] => stdClass Object
                (
                    [geometry] => stdClass Object
                        (
                            [location] => stdClass Object
                                (
                                    [lat] => 21.485811
                                    [lng] => 39.1925048
                                )

                            [viewport] => stdClass Object
                                (
                                    [northeast] => stdClass Object
                                        (
                                            [lat] => 21.904826256582
                                            [lng] => 39.392852864034
                                        )

                                    [southwest] => stdClass Object
                                        (
                                            [lat] => 20.995419636517
                                            [lng] => 39.029445539948
                                        )

                                )

                        )

                    [icon] => https://maps.gstatic.com/mapfiles/place_api/icons/v1/png_71/geocode-71.png
                    [name] => Jeddah
                    [photos] => Array
                        (
                            [0] => stdClass Object
                                (
                                    [height] => 468
                                    [html_attributions] => Array
                                        (
                                            [0] => Aa Bb
                                        )

                                    [photo_reference] => ATtYBwKl4l4l7j9ZrByCDOceAYYSg4MToNdofbuHQoL0MO3KgWYres9N9sGfuKzj21m5vyac1_BveNEf-BM_-thX5S9mGT53_1QhOPcHRfTVOF-x3MWhRuulhqViOGF-M7QTllbYgPzNcqjn3NACMOkQpW426yShk5HR4Ub4RthyGw8jkYDP
                                    [width] => 838
                                )

                        )

                    [place_id] => ChIJWX4TsR_QwxUR2xixN5dXWeA
                    [reference] => ChIJWX4TsR_QwxUR2xixN5dXWeA
                    [scope] => GOOGLE
                    [types] => Array
                        (
                            [0] => locality
                            [1] => political
                        )

                    [vicinity] => Jeddah
                )

            [1] => stdClass Object
                (
                    [business_status] => OPERATIONAL
                    [geometry] => stdClass Object
                        (
                            [location] => stdClass Object
                                (
                                    [lat] => 21.5200862
                                    [lng] => 39.2585089
                                )

                            [viewport] => stdClass Object
                                (
                                    [northeast] => stdClass Object
                                        (
                                            [lat] => 21.521570530291
                                            [lng] => 39.259826130292
                                        )

                                    [southwest] => stdClass Object
                                        (
                                            [lat] => 21.518872569708
                                            [lng] => 39.257128169709
                                        )

                                )

                        )

                    [icon] => https://maps.gstatic.com/mapfiles/place_api/icons/v1/png_71/shopping-71.png
                    [name] => Dukan
                    [opening_hours] => stdClass Object
                        (
                            [open_now] =>
                        )

                    [photos] => Array
                        (
                            [0] => stdClass Object
                                (
                                    [height] => 506
                                    [html_attributions] => Array
                                        (
                                            [0] => mustafa so
                                        )

                                    [photo_reference] => ATtYBwJakQj5D9YWlianR4eRfNwAshdfwLEzN23S6TsmSdD5_TeKiIPXziH8yDo6hJVkYxkT1taFLwIJf7Ix4CH0idrCCrBmE574X-ty0mZxNScdrgdXySwcWBloBSOb5jQ8GKKUU2w60wA74JL8dock3qNXdRwbg7VII6B7CT-HeXhtQAmg
                                    [width] => 900
                                )

                        )

                    [place_id] => ChIJe6Mb0ArSwxURzcjTiHnFTlg
                    [plus_code] => stdClass Object
                        (
                            [compound_code] => G7C5+2C Al Nakheel, Jeddah Saudi Arabia
                            [global_code] => 7GHXG7C5+2C
                        )

                    [rating] => 4.1
                    [reference] => ChIJe6Mb0ArSwxURzcjTiHnFTlg
                    [scope] => GOOGLE
                    [types] => Array
                        (
                            [0] => supermarket
                            [1] => grocery_or_supermarket
                            [2] => food
                            [3] => point_of_interest
                            [4] => store
                            [5] => establishment
                        )

                    [user_ratings_total] => 189
                    [vicinity] => ابراهيم بن محمد التميمي, Jeddah
                )

            [2] => stdClass Object
                (
                    [business_status] => OPERATIONAL
                    [geometry] => stdClass Object
                        (
                            [location] => stdClass Object
                                (
                                    [lat] => 21.5171928
                                    [lng] => 39.2615553
                                )

                            [viewport] => stdClass Object
                                (
                                    [northeast] => stdClass Object
                                        (
                                            [lat] => 21.518373530292
                                            [lng] => 39.262716530291
                                        )

                                    [southwest] => stdClass Object
                                        (
                                            [lat] => 21.515675569708
                                            [lng] => 39.260018569708
                                        )

                                )

                        )

                    [icon] => https://maps.gstatic.com/mapfiles/place_api/icons/v1/png_71/generic_business-71.png
                    [name] => Nahdi DC Sulaymaniyah
                    [place_id] => ChIJ5X_8h3XSwxURagLrAT1jeA4
                    [plus_code] => stdClass Object
                        (
                            [compound_code] => G786+VJ Al Nakheel, Jeddah Saudi Arabia
                            [global_code] => 7GHXG786+VJ
                        )

                    [reference] => ChIJ5X_8h3XSwxURagLrAT1jeA4
                    [scope] => GOOGLE
                    [types] => Array
                        (
                            [0] => point_of_interest
                            [1] => establishment
                        )

                    [vicinity] => 4432 King Abdullah Rd, An Nakhil District, Jeddah 23241 6432 King Abdullah Road, Jeddah
                )

            [3] => stdClass Object
                (
                    [business_status] => OPERATIONAL
                    [geometry] => stdClass Object
                        (
                            [location] => stdClass Object
                                (
                                    [lat] => 21.5194161
                                    [lng] => 39.259262
                                )

                            [viewport] => stdClass Object
                                (
                                    [northeast] => stdClass Object
                                        (
                                            [lat] => 21.520768080292
                                            [lng] => 39.260577280291
                                        )

                                    [southwest] => stdClass Object
                                        (
                                            [lat] => 21.518070119708
                                            [lng] => 39.257879319709
                                        )

                                )

                        )

                    [icon] => https://maps.gstatic.com/mapfiles/place_api/icons/v1/png_71/generic_business-71.png
                    [name] => تنسيق حفلات جدة
                    [opening_hours] => stdClass Object
                        (
                            [open_now] => 1
                        )

                    [photos] => Array
                        (
                            [0] => stdClass Object
                                (
                                    [height] => 4608
                                    [html_attributions] => Array
                                        (
                                            [0] => mohamed koraem
                                        )

                                    [photo_reference] => ATtYBwKrdfk-VjRCQ6FX2_vlqFXD8cDELNLsO3L4RFuS-0yrACyc7lU3ixkm3kmqb-LZdw52rY12uYHMUvKeR5t8ktYp323hwXAV7VFhl7tChr5_yzzqtuJyCrybFmgtC3MnTQ-sYF4Itco9byPMF4BI4_lTtwywI4XpcClo1BBrtd7j3XIn
                                    [width] => 3456
                                )

                        )

                    [place_id] => ChIJPbBxKKPTwxURojIvOvzQO6A
                    [plus_code] => stdClass Object
                        (
                            [compound_code] => G795+QP Al Nakheel, Jeddah Saudi Arabia
                            [global_code] => 7GHXG795+QP
                        )

                    [rating] => 4.8
                    [reference] => ChIJPbBxKKPTwxURojIvOvzQO6A
                    [scope] => GOOGLE
                    [types] => Array
                        (
                            [0] => point_of_interest
                            [1] => establishment
                        )

                    [user_ratings_total] => 4
                    [vicinity] => شارع عثمان بن الاسود، النخيل، جدة 23241،
                )

            [4] => stdClass Object
                (
                    [business_status] => OPERATIONAL
                    [geometry] => stdClass Object
                        (
                            [location] => stdClass Object
                                (
                                    [lat] => 21.5193864
                                    [lng] => 39.2588141
                                )

                            [viewport] => stdClass Object
                                (
                                    [northeast] => stdClass Object
                                        (
                                            [lat] => 21.520871880292
                                            [lng] => 39.260129330291
                                        )

                                    [southwest] => stdClass Object
                                        (
                                            [lat] => 21.518173919708
                                            [lng] => 39.257431369708
                                        )

                                )

                        )

                    [icon] => https://maps.gstatic.com/mapfiles/place_api/icons/v1/png_71/generic_business-71.png
                    [name] => Dr.Abdullah Flat
                    [place_id] => ChIJG6IyozfTwxUR23FXwA3E5JM
                    [plus_code] => stdClass Object
                        (
                            [compound_code] => G795+QG Al Nakheel, Jeddah Saudi Arabia
                            [global_code] => 7GHXG795+QG
                        )

                    [reference] => ChIJG6IyozfTwxUR23FXwA3E5JM
                    [scope] => GOOGLE
                    [types] => Array
                        (
                            [0] => point_of_interest
                            [1] => establishment
                        )

                    [vicinity] => 4105, An Nakhil District, Jeddah 23241 6797
                )

            [5] => stdClass Object
                (
                    [business_status] => OPERATIONAL
                    [geometry] => stdClass Object
                        (
                            [location] => stdClass Object
                                (
                                    [lat] => 21.5186391
                                    [lng] => 39.2582885
                                )

                            [viewport] => stdClass Object
                                (
                                    [northeast] => stdClass Object
                                        (
                                            [lat] => 21.519981880291
                                            [lng] => 39.259712180292
                                        )

                                    [southwest] => stdClass Object
                                        (
                                            [lat] => 21.517283919709
                                            [lng] => 39.257014219709
                                        )

                                )

                        )

                    [icon] => https://maps.gstatic.com/mapfiles/place_api/icons/v1/png_71/generic_business-71.png
                    [name] => بندر أبو مشاري
                    [opening_hours] => stdClass Object
                        (
                            [open_now] =>
                        )

                    [photos] => Array
                        (
                            [0] => stdClass Object
                                (
                                    [height] => 1040
                                    [html_attributions] => Array
                                        (
                                            [0] => أبو مشاري
                                        )

                                    [photo_reference] => ATtYBwL3RuUtMQylfgewY9eN1quhHUDp-QrWNLKq1pWRBrBQf3xiDOD2NfcFNM_Bo08H48p8M_so8OTRvdsZouXpvlGVnAoeQLVW5NqU0PSmkpNEJnetN_PWQvpXABaJxF5BSHgxq35wIL32x443LTiMonpcw1ZI3B3n7LvnGwMnH_I7Ubpf
                                    [width] => 520
                                )

                        )

                    [place_id] => ChIJf7Pm6vDTwxURhYFHE2zHSmU
                    [plus_code] => stdClass Object
                        (
                            [compound_code] => G795+F8 Al Nakheel, Jeddah Saudi Arabia
                            [global_code] => 7GHXG795+F8
                        )

                    [rating] => 3.8
                    [reference] => ChIJf7Pm6vDTwxURhYFHE2zHSmU
                    [scope] => GOOGLE
                    [types] => Array
                        (
                            [0] => point_of_interest
                            [1] => establishment
                        )

                    [user_ratings_total] => 4
                    [vicinity] => 6710، حي النخيل، جدة 23241, Jeddah
                )

            [6] => stdClass Object
                (
                    [business_status] => OPERATIONAL
                    [geometry] => stdClass Object
                        (
                            [location] => stdClass Object
                                (
                                    [lat] => 21.5181832
                                    [lng] => 39.260015
                                )

                            [viewport] => stdClass Object
                                (
                                    [northeast] => stdClass Object
                                        (
                                            [lat] => 21.519539980292
                                            [lng] => 39.261426730291
                                        )

                                    [southwest] => stdClass Object
                                        (
                                            [lat] => 21.516842019708
                                            [lng] => 39.258728769708
                                        )

                                )

                        )

                    [icon] => https://maps.gstatic.com/mapfiles/place_api/icons/v1/png_71/civic_building-71.png
                    [name] => The civil defense unit palm
                    [opening_hours] => stdClass Object
                        (
                            [open_now] => 1
                        )

                    [photos] => Array
                        (
                            [0] => stdClass Object
                                (
                                    [height] => 468
                                    [html_attributions] => Array
                                        (
                                            [0] => وليد الحربي
                                        )

                                    [photo_reference] => ATtYBwLdTwlSlkB31IGQWf1QVLYS6khwXXsTp1_uZ7vExADnamFWtregGGt-YHTX9SVQumm_Pf8oFaoF3KdPHAPNd0Qkv-ldKYI97bsgvLSLHZ8eFI1PGI6TaDpN4piBpgHTbdpE7EDcTrB8IRjZQA1ATrEoyLyfKsrllzI9U9FwspUhG727
                                    [width] => 700
                                )

                        )

                    [place_id] => ChIJA7K5ZnXSwxUR4FBXF6nnkxI
                    [plus_code] => stdClass Object
                        (
                            [compound_code] => G796+72 Al Nakheel, Jeddah Saudi Arabia
                            [global_code] => 7GHXG796+72
                        )

                    [rating] => 4.5
                    [reference] => ChIJA7K5ZnXSwxUR4FBXF6nnkxI
                    [scope] => GOOGLE
                    [types] => Array
                        (
                            [0] => fire_station
                            [1] => point_of_interest
                            [2] => establishment
                        )

                    [user_ratings_total] => 13
                    [vicinity] => حي, جدة
                )

            [7] => stdClass Object
                (
                    [business_status] => OPERATIONAL
                    [geometry] => stdClass Object
                        (
                            [location] => stdClass Object
                                (
                                    [lat] => 21.5195989
                                    [lng] => 39.259763
                                )

                            [viewport] => stdClass Object
                                (
                                    [northeast] => stdClass Object
                                        (
                                            [lat] => 21.520958580291
                                            [lng] => 39.261193730292
                                        )

                                    [southwest] => stdClass Object
                                        (
                                            [lat] => 21.518260619708
                                            [lng] => 39.258495769709
                                        )

                                )

                        )

                    [icon] => https://maps.gstatic.com/mapfiles/place_api/icons/v1/png_71/school-71.png
                    [name] => دار أجيال القرآن
                    [place_id] => ChIJT06VtTLTwxURDM8ka47AE1w
                    [plus_code] => stdClass Object
                        (
                            [compound_code] => G795+RW Al Nakheel, Jeddah Saudi Arabia
                            [global_code] => 7GHXG795+RW
                        )

                    [rating] => 1
                    [reference] => ChIJT06VtTLTwxURDM8ka47AE1w
                    [scope] => GOOGLE
                    [types] => Array
                        (
                            [0] => school
                            [1] => point_of_interest
                            [2] => establishment
                        )

                    [user_ratings_total] => 1
                    [vicinity] => 6816، حي النخيل، جدة 23241 4192،
                )

            [8] => stdClass Object
                (
                    [business_status] => OPERATIONAL
                    [geometry] => stdClass Object
                        (
                            [location] => stdClass Object
                                (
                                    [lat] => 21.5199425
                                    [lng] => 39.2588345
                                )

                            [viewport] => stdClass Object
                                (
                                    [northeast] => stdClass Object
                                        (
                                            [lat] => 21.521165980291
                                            [lng] => 39.260214480291
                                        )

                                    [southwest] => stdClass Object
                                        (
                                            [lat] => 21.518468019709
                                            [lng] => 39.257516519709
                                        )

                                )

                        )

                    [icon] => https://maps.gstatic.com/mapfiles/place_api/icons/v1/png_71/shopping-71.png
                    [name] => Krishna Limbu
                    [photos] => Array
                        (
                            [0] => stdClass Object
                                (
                                    [height] => 640
                                    [html_attributions] => Array
                                        (
                                            [0] => Krishna Limbu
                                        )

                                    [photo_reference] => ATtYBwJrz_e9b7ZGLm9PXSSuktVQKGZ3YcI1-nWsv9JDj95kKV-Z6lLWk80QR-2wUM9DEBTH7Fp1xKuxdCr1NUoWmMpSe01hSMGQGN4rXRqWVbst4fZePiVBUoDVuMxXEmwsv2JusKBXeRwkKNL_LKXRN4VSp8ieGpuDBkQ69hCUoDO1kfGK
                                    [width] => 1137
                                )

                        )

                    [place_id] => ChIJk004EzzTwxURtUU109yzaDE
                    [plus_code] => stdClass Object
                        (
                            [compound_code] => G795+XG Al Nakheel, Jeddah Saudi Arabia
                            [global_code] => 7GHXG795+XG
                        )

                    [rating] => 3
                    [reference] => ChIJk004EzzTwxURtUU109yzaDE
                    [scope] => GOOGLE
                    [types] => Array
                        (
                            [0] => grocery_or_supermarket
                            [1] => food
                            [2] => point_of_interest
                            [3] => store
                            [4] => establishment
                        )

                    [user_ratings_total] => 2
                    [vicinity] => Uqba ibn Amr Al Ansary‎, Jeddah
                )

            [9] => stdClass Object
                (
                    [business_status] => OPERATIONAL
                    [geometry] => stdClass Object
                        (
                            [location] => stdClass Object
                                (
                                    [lat] => 21.5172982
                                    [lng] => 39.2590092
                                )

                            [viewport] => stdClass Object
                                (
                                    [northeast] => stdClass Object
                                        (
                                            [lat] => 21.518647830291
                                            [lng] => 39.260346180291
                                        )

                                    [southwest] => stdClass Object
                                        (
                                            [lat] => 21.515949869708
                                            [lng] => 39.257648219708
                                        )

                                )

                        )

                    [icon] => https://maps.gstatic.com/mapfiles/place_api/icons/v1/png_71/generic_business-71.png
                    [name] => Workshop Islam is for cooling
                    [place_id] => ChIJP_ZapYrNwxURKoweWCZ6Cas
                    [plus_code] => stdClass Object
                        (
                            [compound_code] => G785+WJ Al Nakheel, Jeddah Saudi Arabia
                            [global_code] => 7GHXG785+WJ
                        )

                    [rating] => 5
                    [reference] => ChIJP_ZapYrNwxURKoweWCZ6Cas
                    [scope] => GOOGLE
                    [types] => Array
                        (
                            [0] => general_contractor
                            [1] => point_of_interest
                            [2] => establishment
                        )

                    [user_ratings_total] => 1
                    [vicinity] => شارع عثمان بن الاسود, Jeddah
                )

            [10] => stdClass Object
                (
                    [business_status] => OPERATIONAL
                    [geometry] => stdClass Object
                        (
                            [location] => stdClass Object
                                (
                                    [lat] => 21.5201084
                                    [lng] => 39.259112
                                )

                            [viewport] => stdClass Object
                                (
                                    [northeast] => stdClass Object
                                        (
                                            [lat] => 21.521446030292
                                            [lng] => 39.260572630291
                                        )

                                    [southwest] => stdClass Object
                                        (
                                            [lat] => 21.518748069709
                                            [lng] => 39.257874669708
                                        )

                                )

                        )

                    [icon] => https://maps.gstatic.com/mapfiles/place_api/icons/v1/png_71/generic_business-71.png
                    [name] => Dhl Zamil Bachelor Accommodarion
                    [place_id] => ChIJgcN7sXPTwxUR_5ia8mNmh9g
                    [plus_code] => stdClass Object
                        (
                            [compound_code] => G7C5+2J Al Nakheel, Jeddah Saudi Arabia
                            [global_code] => 7GHXG7C5+2J
                        )

                    [rating] => 5
                    [reference] => ChIJgcN7sXPTwxUR_5ia8mNmh9g
                    [scope] => GOOGLE
                    [types] => Array
                        (
                            [0] => point_of_interest
                            [1] => establishment
                        )

                    [user_ratings_total] => 1
                    [vicinity] => ابراهيم بن محمد التميمي،, Jeddah
                )

            [11] => stdClass Object
                (
                    [business_status] => OPERATIONAL
                    [geometry] => stdClass Object
                        (
                            [location] => stdClass Object
                                (
                                    [lat] => 21.5198704
                                    [lng] => 39.2600365
                                )

                            [viewport] => stdClass Object
                                (
                                    [northeast] => stdClass Object
                                        (
                                            [lat] => 21.521219780291
                                            [lng] => 39.261389130291
                                        )

                                    [southwest] => stdClass Object
                                        (
                                            [lat] => 21.518521819708
                                            [lng] => 39.258691169708
                                        )

                                )

                        )

                    [icon] => https://maps.gstatic.com/mapfiles/place_api/icons/v1/png_71/lodging-71.png
                    [name] => KAU Dormitory Family Section Gate
                    [opening_hours] => stdClass Object
                        (
                            [open_now] => 1
                        )

                    [photos] => Array
                        (
                            [0] => stdClass Object
                                (
                                    [height] => 3024
                                    [html_attributions] => Array
                                        (
                                            [0] => Indra Effendy
                                        )

                                    [photo_reference] => ATtYBwLRFYndmiBJpj2Cc6wmE3ANCS2_P2SFTNg_5TMyL0HDsCLetbEi0IA6r5cUh56ZpYEjNZE-orj8WCM9FrpNOL_FBGlUDtZfJ0pIeyRu1eqBnJDOPOlWvqDmGxQRKCKje7nh0u_hZEIh1mlitAsWaBMB7GC6_Yfb4J5eWy-2TzeEQfcx
                                    [width] => 4032
                                )

                        )

                    [place_id] => ChIJJTEHnEHTwxURsYZMfimwxxQ
                    [plus_code] => stdClass Object
                        (
                            [compound_code] => G796+W2 Al Nakheel, Jeddah Saudi Arabia
                            [global_code] => 7GHXG796+W2
                        )

                    [rating] => 4.6
                    [reference] => ChIJJTEHnEHTwxURsYZMfimwxxQ
                    [scope] => GOOGLE
                    [types] => Array
                        (
                            [0] => lodging
                            [1] => point_of_interest
                            [2] => establishment
                        )

                    [user_ratings_total] => 7
                    [vicinity] => خالد بن ساره المخزومي،, Jeddah
                )

            [12] => stdClass Object
                (
                    [business_status] => OPERATIONAL
                    [geometry] => stdClass Object
                        (
                            [location] => stdClass Object
                                (
                                    [lat] => 21.5196836
                                    [lng] => 39.2603329
                                )

                            [viewport] => stdClass Object
                                (
                                    [northeast] => stdClass Object
                                        (
                                            [lat] => 21.521129030292
                                            [lng] => 39.261734730292
                                        )

                                    [southwest] => stdClass Object
                                        (
                                            [lat] => 21.518431069708
                                            [lng] => 39.259036769709
                                        )

                                )

                        )

                    [icon] => https://maps.gstatic.com/mapfiles/place_api/icons/v1/png_71/generic_business-71.png
                    [name] => 黄晓工作室
                    [opening_hours] => stdClass Object
                        (
                            [open_now] =>
                        )

                    [photos] => Array
                        (
                            [0] => stdClass Object
                                (
                                    [height] => 810
                                    [html_attributions] => Array
                                        (
                                            [0] => 黄晓工作室
                                        )

                                    [photo_reference] => ATtYBwKtpuPRC4QPArBIZGWShF6pZ4Mkis7kdufGWIlBLdoiilyj8TLh7GJE-br46GZvsxLRetWpQ1Se5hqmDYzYyZKhYf9F2xmH6obnEJjvuwVvSV7jlQ7AdXUU2rFVRNiGjTzlggh-uOS6d60I1Dm_O5R4ZQQeNr7MGVN_Qb5VuYmUQ7fc
                                    [width] => 1440
                                )

                        )

                    [place_id] => ChIJ2dWuVKjTwxURFfXQ94kNlQI
                    [plus_code] => stdClass Object
                        (
                            [compound_code] => G796+V4 Al Nakheel, Jeddah Saudi Arabia
                            [global_code] => 7GHXG796+V4
                        )

                    [reference] => ChIJ2dWuVKjTwxURFfXQ94kNlQI
                    [scope] => GOOGLE
                    [types] => Array
                        (
                            [0] => travel_agency
                            [1] => point_of_interest
                            [2] => establishment
                        )

                    [vicinity] => حي, Jeddah
                )

            [13] => stdClass Object
                (
                    [business_status] => OPERATIONAL
                    [geometry] => stdClass Object
                        (
                            [location] => stdClass Object
                                (
                                    [lat] => 21.5200772
                                    [lng] => 39.2585062
                                )

                            [viewport] => stdClass Object
                                (
                                    [northeast] => stdClass Object
                                        (
                                            [lat] => 21.521565580292
                                            [lng] => 39.259822480291
                                        )

                                    [southwest] => stdClass Object
                                        (
                                            [lat] => 21.518867619709
                                            [lng] => 39.257124519708
                                        )

                                )

                        )

                    [icon] => https://maps.gstatic.com/mapfiles/place_api/icons/v1/png_71/shopping-71.png
                    [name] => Dukan
                    [opening_hours] => stdClass Object
                        (
                            [open_now] =>
                        )

                    [photos] => Array
                        (
                            [0] => stdClass Object
                                (
                                    [height] => 2988
                                    [html_attributions] => Array
                                        (
                                            [0] => ov7 l
                                        )

                                    [photo_reference] => ATtYBwKgulMssiV2sz5qgfe2Zxn9PdbQy3uFuNCHvS0Gt_EVpK9Jgkox8fhBn8aZeZZkuo8s3qUvx0KRBr5X5iU8BOGBL_stCBqq05IIf-yAURqYOLnZgDqtELujrHKVc86CAnTn7EEGcjvjplxlnvWuv6od8e0SJVTBAZePCKYKcZA76zLL
                                    [width] => 5312
                                )

                        )

                    [place_id] => ChIJEbemK3XSwxUR4RasvYOMRnw
                    [plus_code] => stdClass Object
                        (
                            [compound_code] => G7C5+2C Al Nakheel, Jeddah Saudi Arabia
                            [global_code] => 7GHXG7C5+2C
                        )

                    [rating] => 4
                    [reference] => ChIJEbemK3XSwxUR4RasvYOMRnw
                    [scope] => GOOGLE
                    [types] => Array
                        (
                            [0] => grocery_or_supermarket
                            [1] => food
                            [2] => point_of_interest
                            [3] => store
                            [4] => establishment
                        )

                    [user_ratings_total] => 52
                    [vicinity] => Jeddah
                )

            [14] => stdClass Object
                (
                    [business_status] => OPERATIONAL
                    [geometry] => stdClass Object
                        (
                            [location] => stdClass Object
                                (
                                    [lat] => 21.519679
                                    [lng] => 39.2604073
                                )

                            [viewport] => stdClass Object
                                (
                                    [northeast] => stdClass Object
                                        (
                                            [lat] => 21.521123780292
                                            [lng] => 39.261781680291
                                        )

                                    [southwest] => stdClass Object
                                        (
                                            [lat] => 21.518425819708
                                            [lng] => 39.259083719708
                                        )

                                )

                        )

                    [icon] => https://maps.gstatic.com/mapfiles/place_api/icons/v1/png_71/generic_business-71.png
                    [name] => 黄晓工作室
                    [place_id] => ChIJweIVO_7TwxURtadF6Zqj6Nw
                    [plus_code] => stdClass Object
                        (
                            [compound_code] => G796+V5 Al Nakheel, Jeddah Saudi Arabia
                            [global_code] => 7GHXG796+V5
                        )

                    [reference] => ChIJweIVO_7TwxURtadF6Zqj6Nw
                    [scope] => GOOGLE
                    [types] => Array
                        (
                            [0] => point_of_interest
                            [1] => establishment
                        )

                    [vicinity] => حي, Jeddah
                )

            [15] => stdClass Object
                (
                    [business_status] => OPERATIONAL
                    [geometry] => stdClass Object
                        (
                            [location] => stdClass Object
                                (
                                    [lat] => 21.5198714
                                    [lng] => 39.2601994
                                )

                            [viewport] => stdClass Object
                                (
                                    [northeast] => stdClass Object
                                        (
                                            [lat] => 21.521243730292
                                            [lng] => 39.261640380291
                                        )

                                    [southwest] => stdClass Object
                                        (
                                            [lat] => 21.518545769708
                                            [lng] => 39.258942419708
                                        )

                                )

                        )

                    [icon] => https://maps.gstatic.com/mapfiles/place_api/icons/v1/png_71/generic_business-71.png
                    [name] => سكن العائلات طلاب جامعه الملك عبدالعزيز
                    [place_id] => ChIJSYsuOXzTwxURmrfj6d4_Wdk
                    [plus_code] => stdClass Object
                        (
                            [compound_code] => G796+W3 Al Nakheel, Jeddah Saudi Arabia
                            [global_code] => 7GHXG796+W3
                        )

                    [reference] => ChIJSYsuOXzTwxURmrfj6d4_Wdk
                    [scope] => GOOGLE
                    [types] => Array
                        (
                            [0] => point_of_interest
                            [1] => establishment
                        )

                    [vicinity] => النخيل،, Jeddah
                )

            [16] => stdClass Object
                (
                    [business_status] => OPERATIONAL
                    [geometry] => stdClass Object
                        (
                            [location] => stdClass Object
                                (
                                    [lat] => 21.5174747
                                    [lng] => 39.2580857
                                )

                            [viewport] => stdClass Object
                                (
                                    [northeast] => stdClass Object
                                        (
                                            [lat] => 21.518747130292
                                            [lng] => 39.259449930292
                                        )

                                    [southwest] => stdClass Object
                                        (
                                            [lat] => 21.516049169708
                                            [lng] => 39.256751969709
                                        )

                                )

                        )

                    [icon] => https://maps.gstatic.com/mapfiles/place_api/icons/v1/png_71/worship_islam-71.png
                    [name] => Ahmad Al Saadi Mosque
                    [photos] => Array
                        (
                            [0] => stdClass Object
                                (
                                    [height] => 1920
                                    [html_attributions] => Array
                                        (
                                            [0] => HESHAM AL-SAGGAF
                                        )

                                    [photo_reference] => ATtYBwI2-FWmVphGXboH3VPsXWPEdwKYGKX5V9_Ovkiao1oNyxZ5va_-MUCr3QVqgzivf5_bZdkMDCsLKZ2IrQVBeG2r60iMqpbIbZ2TKDvjL6TfWYTXL49xSm7Ti9xP36t9QqHhJh4r_yAorU6JNZ6nyfJc6jpKxX1lWc6bMJ8mCnJ47IAK
                                    [width] => 2560
                                )

                        )

                    [place_id] => ChIJ81xXUvXNwxURvTtujesrzPA
                    [plus_code] => stdClass Object
                        (
                            [compound_code] => G785+X6 Al Nakheel, Jeddah Saudi Arabia
                            [global_code] => 7GHXG785+X6
                        )

                    [rating] => 4.6
                    [reference] => ChIJ81xXUvXNwxURvTtujesrzPA
                    [scope] => GOOGLE
                    [types] => Array
                        (
                            [0] => mosque
                            [1] => place_of_worship
                            [2] => point_of_interest
                            [3] => establishment
                        )

                    [user_ratings_total] => 147
                    [vicinity] => 6593 عبدالعزيز بن ابي الحسن - حي - 4020, Jeddah
                )

            [17] => stdClass Object
                (
                    [business_status] => OPERATIONAL
                    [geometry] => stdClass Object
                        (
                            [location] => stdClass Object
                                (
                                    [lat] => 21.5175792
                                    [lng] => 39.2579598
                                )

                            [viewport] => stdClass Object
                                (
                                    [northeast] => stdClass Object
                                        (
                                            [lat] => 21.518909530291
                                            [lng] => 39.259187230292
                                        )

                                    [southwest] => stdClass Object
                                        (
                                            [lat] => 21.516211569708
                                            [lng] => 39.256489269709
                                        )

                                )

                        )

                    [icon] => https://maps.gstatic.com/mapfiles/place_api/icons/v1/png_71/school-71.png
                    [name] => مركز السمو للعلوم الشرعية
                    [photos] => Array
                        (
                            [0] => stdClass Object
                                (
                                    [height] => 640
                                    [html_attributions] => Array
                                        (
                                            [0] => أبو صهيب
                                        )

                                    [photo_reference] => ATtYBwLIlUYLxjK026HnWdO3LWYM6VoP4BuOdthtf4DpUAHgml6i4moAktLJv31d68ziWWkc9FuarTMTjG85nvotP1ZnOdR714XojoBlO8soRzJHkscIJz7bLjiwQHn0lj2qRUnJdIUVERakmZpQ8B_lw6os8vCcS1UHB4xjnuhdumG0_r_-
                                    [width] => 640
                                )

                        )

                    [place_id] => ChIJx8y-T_XNwxUR-zOjgvzVv5M
                    [plus_code] => stdClass Object
                        (
                            [compound_code] => G795+25 Al Nakheel, Jeddah Saudi Arabia
                            [global_code] => 7GHXG795+25
                        )

                    [rating] => 4.6
                    [reference] => ChIJx8y-T_XNwxUR-zOjgvzVv5M
                    [scope] => GOOGLE
                    [types] => Array
                        (
                            [0] => school
                            [1] => point_of_interest
                            [2] => establishment
                        )

                    [user_ratings_total] => 5
                    [vicinity] => شارع الشيخ عبدالله خياط, Jeddah
                )

            [18] => stdClass Object
                (
                    [business_status] => OPERATIONAL
                    [geometry] => stdClass Object
                        (
                            [location] => stdClass Object
                                (
                                    [lat] => 21.5202233
                                    [lng] => 39.2586395
                                )

                            [viewport] => stdClass Object
                                (
                                    [northeast] => stdClass Object
                                        (
                                            [lat] => 21.521654230291
                                            [lng] => 39.259971880291
                                        )

                                    [southwest] => stdClass Object
                                        (
                                            [lat] => 21.518956269709
                                            [lng] => 39.257273919709
                                        )

                                )

                        )

                    [icon] => https://maps.gstatic.com/mapfiles/place_api/icons/v1/png_71/shopping-71.png
                    [name] => تموينات الامين
                    [opening_hours] => stdClass Object
                        (
                            [open_now] =>
                        )

                    [photos] => Array
                        (
                            [0] => stdClass Object
                                (
                                    [height] => 3968
                                    [html_attributions] => Array
                                        (
                                            [0] => علي محمد
                                        )

                                    [photo_reference] => ATtYBwIjDbkvKcsEScnQF6u5q2tIa8bv9AQCxWZvJby5eDWzgyhAtXyNyKTVAxhstPZpnLF_VZ6Co6nSOgMb74bfElnveMcakzIyzgsc9PTW956ATw5zU-p4VC5nivScA83H5i8Hu8OIxP3F0oNaQZj6aQJeYKuI9TBxB87Q5yqEgVcJ5vuk
                                    [width] => 2976
                                )

                        )

                    [place_id] => ChIJ25TgK3XSwxURrnmz2PQZzVA
                    [plus_code] => stdClass Object
                        (
                            [compound_code] => G7C5+3F Al Nakheel, Jeddah Saudi Arabia
                            [global_code] => 7GHXG7C5+3F
                        )

                    [rating] => 4.2
                    [reference] => ChIJ25TgK3XSwxURrnmz2PQZzVA
                    [scope] => GOOGLE
                    [types] => Array
                        (
                            [0] => grocery_or_supermarket
                            [1] => food
                            [2] => point_of_interest
                            [3] => store
                            [4] => establishment
                        )

                    [user_ratings_total] => 15
                    [vicinity] => حي النخيل، 6876, Jeddah
                )

            [19] => stdClass Object
                (
                    [geometry] => stdClass Object
                        (
                            [location] => stdClass Object
                                (
                                    [lat] => 21.5298949
                                    [lng] => 39.2576547
                                )

                            [viewport] => stdClass Object
                                (
                                    [northeast] => stdClass Object
                                        (
                                            [lat] => 21.546732192425
                                            [lng] => 39.284918393281
                                        )

                                    [southwest] => stdClass Object
                                        (
                                            [lat] => 21.512310717979
                                            [lng] => 39.23825885764
                                        )

                                )

                        )

                    [icon] => https://maps.gstatic.com/mapfiles/place_api/icons/v1/png_71/geocode-71.png
                    [name] => Al Nakheel
                    [photos] => Array
                        (
                            [0] => stdClass Object
                                (
                                    [height] => 1960
                                    [html_attributions] => Array
                                        (
                                            [0] => فؤاد الجهني
                                        )

                                    [photo_reference] => ATtYBwKI_TYMR77tNRvO4zavgyfXgbL2PSFP_XDsNmSzc-Gd7K3-2xeAk5ScvhTGCI35Ilm8jVkzcb-9hOqJYK6rPfyPBcLS4pMQdWBk58Wf2A6OUhnemAIuFJfhGSHNbd_Ig5Fb6dq7h6mpJW9hTtcqUkN4EfcEQjNdCS4poUfC95UpeweC
                                    [width] => 4032
                                )

                        )

                    [place_id] => ChIJaYLFQmzSwxURpNHfohJ4ARE
                    [reference] => ChIJaYLFQmzSwxURpNHfohJ4ARE
                    [scope] => GOOGLE
                    [types] => Array
                        (
                            [0] => sublocality_level_1
                            [1] => sublocality
                            [2] => political
                        )

                    [vicinity] => Al Nakheel
                )

        )

    [status] => OK
)

{"type":true,"data":"","success":true}
     */
}