<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Authorization
{

    ###############################################################################################
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');

    }
    ###############################################################################################

    ###############################################################################################
	public function index()
	{



	    $this->data['Page_Title']    = lang('Auth_Pages');
        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'css/pages/login/login-1',$this->data['direction']);
        $this->data['PageContent']   = $this->load->view('../../modules/Auth/views/Form_Login',$this->data,true);
        Layout_Auth($this->data);

	}
    ###############################################################################################


    ###############################################################################################
    public function Login()
    {
        $this->form_validation->set_rules('username', 'Username', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == FALSE) {

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect('Auth', 'refresh');

        } else {

            $username = $this->input->post('username', true);
            $password = $this->input->post('password', true);
            $remember = $this->input->post('remember', true);

            if($this->aauth->login($username, $password, $remember)) {

                if($this->aauth->is_member('Admin')){
                    redirect(ADMIN_NAMESPACE_URL.'/Dashboard', 'refresh');
                }else{

                    if(Get_Company($this->aauth->get_user()->company_id)->companies_Status == 0){

                        $msg_result['key']   = 'Danger';
                        $msg_result['value'] = '???? ?????????? ???????????? ???????? ?????????????? ???? ?????????? ??????????';
                        $msg_result_view     = Create_Status_Alert($msg_result);
                        set_message($msg_result_view);
                        redirect('Auth', 'refresh');

                    }else {
                        $userdata = array();
                        $userid = $this->aauth->get_user();

                        $userdata['Info_User']         = $this->aauth->get_user();
                        $userdata['User_Group_login']  = Get_Group_User($this->aauth->get_user()->id);
                        $userdata['Company_User']      = $this->aauth->get_user()->company_id;
                        $userdata['Company_Locations'] = $this->aauth->get_user()->locations_id;
                        $userdata['Company_Domain']    = Get_Company($this->aauth->get_user()->company_id)->companies_Domain;
                        $userdata['time_User_login']   = time();
                        $userdata['ip_User_login']     = get_real_ip();

                        Create_Logs_User('Login User', '', 'Login', 'Login');

                        $this->session->set_userdata('UserCompany', $userdata);
                        redirect(APP_NAMESPACE_URL . '/Dashboard', 'refresh');
                    }

                } // if($this->aauth->is_member())

            }else{
                $msg_result['key']   = 'Danger';
                $msg_result['value'] = lang('Auth_error_password_or_email');
                $msg_result_view     = Create_Status_Alert($msg_result);
                set_message($msg_result_view);
                redirect('Auth', 'refresh');
            }

        } // if($this->form_validation->run()==FALSE)

    }
    ###############################################################################################

    ###############################################################################################
    public function Reset()
    {
        $this->data['Page_Title']    = lang('Auth_Pages');
        $this->data['Lode_file_Css'] = import_css(BASE_ASSET.'css/pages/login/login-1',$this->data['direction']);
        $this->data['PageContent']   = $this->load->view('../../modules/Auth/views/Form_Reset',$this->data,true);
        Layout_Auth($this->data);
    }
    ###############################################################################################

    ###############################################################################################
    public function forgot_password()
    {
        $this->form_validation->set_rules('email', lang('Global_email'), 'trim|required|valid_email');

        if ($this->form_validation->run() == FALSE) {

            $msg_result['key']   = 'Danger';
            $msg_result['value'] = validation_errors();
            $msg_result_view     = Create_Status_Alert($msg_result);
            set_message($msg_result_view);
            redirect('Auth', 'refresh');

        } else {

            $email = $this->input->post('email', true);


        } // if($this->form_validation->run()==FALSE)

    }
    ###############################################################################################





}
