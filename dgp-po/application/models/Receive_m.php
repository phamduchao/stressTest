<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Receive_m extends MY_Model
{
    protected $_table_name = 'api_data';

    function __construct()
    {
        parent::__construct();
    }
}