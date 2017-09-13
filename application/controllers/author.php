<?php
header('Access-Control-Allow-Origin', '*');
error_reporting(0);
class Author extends CI_Controller {

public function __construct() {
    parent::__construct();
    $this->load->database();
    $this->load->config();
    $this->load->library('session');
    $this->load->model('general_model',"gm");
    $this->load->model('author_model',"am");
    $this->load->helper('url', 'form');
  }

public function list_author($index){
    $limit  = $this->config->item('number_of_author_in_one_list');
        $offset = ($index - 1) * $this->config->item('number_of_author_in_one_list');
        if ($index == 0) {
            $limit  = 10000;
            $offset = 0;
        }
        // echo $limit;
        // echo $offset;
        $response_data  = $this->am->list_author($limit, $offset);
        // die;
        $response_count = $this->am->count_author();
        if ($index == 0) {
            for ($i = 0; $i < count($response_data); $i++) {
                $response[$i]['author_id']   = $response_data[$i]['author_id'];
                $response[$i]['author_name'] = $response_data[$i]['author_name'];
            }
        }
        if ($index == 0) {
            $result['data'] = $response;
        } else {
            $result['data'] = $response_data;
        }
        $result['count'] = $response_count;
        
        $this->gm->send_response(true, "List of Authors", $result, '');
}


public function add_author(){
    $data = json_decode(file_get_contents("php://input"), true); // decode json
    $session_data=$this->session->all_userdata();
    if($session_data['id']==null){
      $this->gm->send_response(false,"Session Expired",'','');
    }

    if($role==3){
      $this->gm->send_response(false,"Permission Denied",'','');
    }

    $insert_data = array(
        'author_name' => $data['author_name']
    );

 $check = $this->am->select_author($insert_data);
    if(count($check)){
    $this->gm->send_response(false,"author Alread Exist",$check[0]['author_id'],'');    
    }
    $response['author_id'] = $this->am->add_author($insert_data);
    $this->gm->send_response(true,"Success",$response,'');
}


public function edit_author(){
    $data = json_decode(file_get_contents("php://input"), true); // decode json
    $session_data=$this->session->all_userdata();
    if($session_data['id']==null){
      $this->gm->send_response(false,"Session Expired",'','');
    }

    if($role==3){
      $this->gm->send_response(false,"Permission Denied",'','');
    }

    $update_data = array(
        'author_id' => $data['author_id'],
        'author_name' => $data['author_name']
    );
    $where = array(
        'author_name'=>$data['author_name']
    );
    
$check = $this->am->select_author($where);
    if(count($check)){
    $this->gm->send_response(false,"author Alread Exist",$check[0]['author_id'],'');    
    }
    $response['author_id'] = $data['author_id'];
    $this->am->edit_author($update_data);
    $this->gm->send_response(true,"Success",$response,'');
}


public function delete_author($author_id){
    $data = json_decode(file_get_contents("php://input"), true); // decode json
    $session_data=$this->session->all_userdata();
    if($session_data['id']==null){
      $this->gm->send_response(false,"Session Expired",'','');
    }

    if($role==3){
      $this->gm->send_response(false,"Permission Denied",'','');
    }

    
    $this->am->delete_author($author_id);
    $this->gm->send_response(true,"Success",'','');
}



public function view_author($author_id){
    $where = array(
        'author_id' => $author_id,
        'author_status' => 1
    );

    $response = $this->am->select_author($where);
    if($response){
        $this->gm->send_response(true,"Success",$response[0],'');
    }   
    else{
        $this->gm->send_response(false,"Sorry Author Not Available",$response,'');
    }
}

}
