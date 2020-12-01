<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Web extends Front
{




    public function __construct()
    {
        parent::__construct();
        $this->load->library('parser');

    }




	public function index()
	{


        $data0 = array(
            'blog_title'   => 'My Blog Title',
            'blog_heading' => 'My Blog Heading',
            'blog_entries' => array(
                array('title' => 'Title 1', 'body' => 'Body 1'),
                array('title' => 'Title 2', 'body' => 'Body 2'),
                array('title' => 'Title 3', 'body' => 'Body 3'),
                array('title' => 'Title 4', 'body' => 'Body 4'),
                array('title' => 'Title 5', 'body' => 'Body 5')
            )
        );

        $this->data['PageContent'] = '';// $this->parser->parse_string('../../modules/Auth/views/test', $data0,true);

        Layout_Admin($this->data['PageContent']);


	}



}
