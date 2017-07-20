<?php

/**
*
*/
class Admin_model extends CI_Model{

  /**************************************************************
  Function to check valid login of admin
  ****************************************************************/
  public function admin_login($data){
    $where=array('admin_username'=>$data['username'],'admin_password'=>md5($data['password']));
    $query= $this->db->get_where('admin', $where)->result_array();
    return $query[0];
  }
  /**************************************************************
  Function to increment login count
  ****************************************************************/
  public function inc_login_count($data){
    $where=array('admin_id'=>$data['admin_id']);
    $this->db->where($where);
    $this->db->set('admin_total_login', 'admin_total_login+1', FALSE);
    $this->db->set('admin_last_login', time(), FALSE);
    $this->db->update('admin');
  }
}

?>
