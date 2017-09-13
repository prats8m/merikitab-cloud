<?php
header('Access-Control-Allow-Origin', '*');
error_reporting(0);
class publication extends CI_Controller {

public function __construct() {
    parent::__construct();
    $this->load->database();
    $this->load->config();
    $this->load->library('session');
    $this->load->model('general_model',"gm");
    $this->load->model('publication_model',"pm");
    $this->load->helper('url', 'form');
  }

public function list_publication($index){
    $limit  = $this->config->item('number_of_author_in_one_list');
        $offset = ($index - 1) * $this->config->item('number_of_author_in_one_list');
        if ($index == 0) {
            $limit  = 10000;
            $offset = 0;
        }
        // echo $limit;
        // echo $offset;
        $response_data  = $this->pm->list_publication($limit, $offset);
        // die;
        $response_count = $this->pm->count_publication();
        if ($index == 0) {
            for ($i = 0; $i < count($response_data); $i++) {
                $response[$i]['publication_id']   = $response_data[$i]['publication_id'];
                $response[$i]['publication_name'] = $response_data[$i]['publication_name'];
            }
        }
        if ($index == 0) {
            $result['data'] = $response;
        } else {
            $result['data'] = $response_data;
        }
        $result['count'] = $response_count;
        
        $this->gm->send_response(true, "List of publications", $result, '');
}


public function add_publication(){
    $data = json_decode(file_get_contents("php://input"), true); // decode json
    $session_data=$this->session->all_userdata();
    if($session_data['id']==null){
      $this->gm->send_response(false,"Session Expired",'','');
    }

    if($role==3){
      $this->gm->send_response(false,"Permission Denied",'','');
    }


    $insert_data = array(
        'publication_name' => $data['publication_name']
    );


    $check = $this->pm->select_publication($insert_data);
    if(count($check)){
    $this->gm->send_response(false,"Publication Alread Exist",$check[0]['publication_id'],'');    
    }
    
    $response['publication_id']=$this->pm->add_publication($insert_data);
    $this->gm->send_response(true,"Success",$response,'');
}


public function edit_publication(){
    $data = json_decode(file_get_contents("php://input"), true); // decode json
    $session_data=$this->session->all_userdata();
    if($session_data['id']==null){
      $this->gm->send_response(false,"Session Expired",'','');
    }

    if($role==3){
      $this->gm->send_response(false,"Permission Denied",'','');
    }

    $update_data = array(
        'publication_id' => $data['publication_id'],
        'publication_name' => $data['publication_name']
    );

    $where = array(
        'publication_name' => $data['publication_name']
    );
    $check = $this->pm->select_publication($where);
    if(count($check)){
    $this->gm->send_response(false,"Publication Alread Exist",$check[0]['publication_id'],'');    
    }
    $response['publication_id'] = $data['publication_id'];
    $this->pm->edit_publication($update_data);
    $this->gm->send_response(true,"Success",$response,'');
}


public function delete_publication($publication_id){
    $data = json_decode(file_get_contents("php://input"), true); // decode json
    $session_data=$this->session->all_userdata();
    if($session_data['id']==null){
      $this->gm->send_response(false,"Session Expired",'','');
    }

    if($role==3){
      $this->gm->send_response(false,"Permission Denied",'','');
    }

    
    $this->pm->delete_publication($publication_id);
    $this->gm->send_response(true,"Success",'','');
}


public function view_publication($publication_id){
    $where = array(
        'publication_id' => $publication_id,
        'publication_status' => 1
    );

    $response = $this->pm->select_publication($where);
    if($response){
        $this->gm->send_response(true,"Success",$response[0],'');
    }   
    else{
        $this->gm->send_response(false,"Sorry publication Not Available",$response,'');
    }
}
}