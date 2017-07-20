<?php
header('Access-Control-Allow-Origin', '*');
// error_reporting(0);
class Book_type extends CI_Controller {

public function __construct() {
    parent::__construct();
    $this->load->database();
    $this->load->library('session');
    $this->load->model('general_model',"gm");
    $this->load->model('book_type_model',"btm");
    $this->load->helper('url', 'form');
  }

public function list_book_type_filter(){
    $where = [];
    $response = $this->btm->list_book_type($where);
    foreach($response as $key => $item){
        $result[$key]['bt_id'] = $item['bt_id'];
        $result[$key]['bt_name'] = $item['bt_name'];
    }
    $this->gm->send_response(true,"Success",$result,'');
}
}