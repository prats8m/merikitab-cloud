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



public function list_book_type($index){
    $limit  = $this->config->item('number_of_author_in_one_list');
        $offset = ($index - 1) * $this->config->item('number_of_author_in_one_list');
        if ($index == 0) {
            $limit  = 10000;
            $offset = 0;
        }
        // echo $limit;
        // echo $offset;
        $response_data  = $this->btm->list_book_type($limit, $offset);
        // die;
        $response_count = $this->btm->count_book_type();
        if ($index == 0) {
            for ($i = 0; $i < count($response_data); $i++) {
                $response[$i]['bt_id']   = $response_data[$i]['bt_id'];
                $response[$i]['bt_name'] = $response_data[$i]['bt_name'];
            }
        }
        if ($index == 0) {
            $result['data'] = $response;
        } else {
            $result['data'] = $response_data;
        }
        $result['count'] = $response_count;
        
        $this->gm->send_response(true, "List of Book types", $result, '');
}

}