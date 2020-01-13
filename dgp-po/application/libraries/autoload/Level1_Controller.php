<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Level1_Controller extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        // only logged in user can access this level
        if (!$this->session->userdata('logged_in')) {
            header('Location: '.base_url('user/login'));die();
        }
    }
}