<?php

/**
*
*/
class City_model extends CI_Model{

  /**************************************************************
  Function to list  school from db
  ****************************************************************/
  public function list_city($where){
   $this->db->where( $where);
   $query = $this->db->get('city')->result_array();
   return $query;
  }
  }

?>
