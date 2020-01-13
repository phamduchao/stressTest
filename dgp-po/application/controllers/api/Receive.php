<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Receive extends Level0_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(['receive_m']);
    }

    public function index(){
        $text = $_REQUEST['data'];
        $data2save = ['jsonText' => $text];
        $this->receive_m->save($data2save);
    }


}