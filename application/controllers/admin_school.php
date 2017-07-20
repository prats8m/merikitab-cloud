<?php
header('Access-Control-Allow-Origin', '*');
// error_reporting(0);
class Admin_school extends CI_Controller {


  public function __construct() {
    parent::__construct();
    $this->load->database();
    $this->load->model("general_model",'gm');
    $this->load->model('admin_school_model','asm');
    $this->load->helper('url', 'form');
  }

  public function add_school(){
    $data = json_decode(file_get_contents("php://input"), true); // decode json
    $session_data=$this->session->all_userdata();
      if($session_data['id']==null){
      $this->gm->send_response(false,"Session Expired",'','');
    }

    if($role==3){
      $this->gm->send_response(false,"Permission Denied",'','');
    }

    $insert_data=array(
      'school_name'=>$data['name'],
      'school_city'=>$data['city'],
      'school_poc'=>$data['contact1'].",".$data['contact2'].",".$data['contact3'],
      'school_status'=>$data['status'],
      'school_address'=>$data['address']  
    );
    $msg="<strong>".$session_data['username']."<strong>"." added School ".$data['name'];
    $this->gm->add_notification($msg);
    $response=$this->asm->add_school($insert_data);
    $this->gm->send_response(true,"School Added Successfully",$response,'');
  }

  public function list_school($index){
    $limit=$this->config->item('number_of_school_in_one_list');
    $offset=($index-1)*$this->config->item('number_of_school_in_one_list');
    if($index == 0){
      $limit = 10000;
      $offset = 0;
    }

    $response_data=$this->asm->list_school($limit,$offset);
    $response_count=$this->asm->count_school();
    if($index == 0){
    for ($i=0; $i < count($response_data); $i++) {
      $response[$i]['id']=$response_data[$i]['school_id'];
      $response[$i]['name']=$response_data[$i]['school_name'];
    }  
    }
    for ($i=0; $i < count($response_data); $i++) {
      $contact=explode(",",$response_data[$i]['school_poc']);
      $response_data[$i]['school_poc']=$contact[0];
    }
    if($index == 0){
      $result['data']=$response;
    }
    else{
      $result['data']=$response_data;
    }
    $result['count'] = $response_count;

    $this->gm->send_response(true,"List of Schools ",$result,'');
  }

  public function edit_school(){
    $session_data=$this->session->all_userdata();
    if($session_data['id']==null){
      $this->gm->send_response(false,"Session Expired",'','');
    }

    $role=$session_data['role'];
    $user_id=$session_data['id'];
    $admin_name=$session_data['username'];

    if($role==3){
      $this->gm->send_response(false,"Permission Denied",'','');
    }

    $data = json_decode(file_get_contents("php://input"), true); // decode json
    $update_data=array(
      'school_id'=>$data['school_id'],
      'school_name'=>$data['name'],
      'school_city'=>$data['city'],
      'school_poc'=>$data['contact1'].",".$data['contact2'].",".$data['contact3'],
      'school_status'=>$data['status'],
      'school_address'=>$data['address']  
    );
    $msg="<strong>".$session_data['username']."<strong>"." edited School ".$data['name'];
    $this->gm->add_notification($msg);
    $response=$this->asm->edit_school($update_data);
    $this->gm->send_response(true,"School Edit Successfully",$response,'');
}


  public function view_school($school_id){
    $session_data=$this->session->all_userdata();
    if($session_data['id']==null){
      $this->gm->send_response(false,"Session Expired",'','');
    }

    $role=$session_data['role'];
    $user_id=$session_data['id'];
    $admin_name=$session_data['username'];

    $response=$this->asm->view_school($school_id);
    $contact=explode(",",$response['school_poc']);
    $response['contact1']=$contact[0];
    $response['contact2']=$contact[1];
    $response['contact3']=$contact[2];
    $this->gm->send_response(true,"School Edit Successfully",$response,'');
}

  public function delete_school($school_id){
    $session_data=$this->session->all_userdata();
    if($session_data['id']==null){
      $this->gm->send_response(false,"Session Expired",'','');
    }

    $role=$session_data['role'];
    $user_id=$session_data['id'];
    $admin_name=$session_data['username'];

    if($role==3){
      $this->gm->send_response(false,"Permission Denied",'','');
    }
    $school=$this->asm->view_school($school_id);

    $msg="<strong>".$session_data['username']."<strong>"." deleted School ".$school['school_name'];
    $this->gm->add_notification($msg);
    $response=$this->asm->delete_school($school_id);
    $this->gm->send_response(true,"School Deleted Successfully",$response,'');
}

}
?>
