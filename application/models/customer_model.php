<?php

/**
*
*/
class Customer_model extends CI_Model{

  /**************************************************************
  Function to add a customer
  ****************************************************************/
  public function add_customer($data){
    $this->db->insert('customer',$data);
  }
  /**************************************************************
  Function to increment login count
  ****************************************************************/
  public function select_customer($select,$where){
    $this->db->select($select);
    $this->db->where($where);
    $query= $this->db->get('customer')->result_array();
    return $query;
  }
}

?>
