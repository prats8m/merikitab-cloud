<?php
error_reporting(0);
/**
*
*/
class General_model extends CI_Model{

/**************************************************************
Function to send response to GUI
****************************************************************/
  public function send_response($status,$msg,$data,$error){
    $response['status']=$status;
    $response['message']=$msg;
    $response['data']=$data;
    $response['error']=$error;
    echo json_encode($response); // encode json
    die();
  }

  public function add_notification($msg){
    $insert_data=array(
      'notification'=>$msg,
      'created_on'=>time()
    );
    return $this->db->insert('notification',$insert_data);
  }

}

?>
