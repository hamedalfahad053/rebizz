<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Web extends Front
{

    public function __construct()
    {
        parent::__construct();


    }


	public function index()
	{

        $this->data['PageContent'] = $this->data;
        Layout_Admin($this->data['PageContent']);
	}



}
