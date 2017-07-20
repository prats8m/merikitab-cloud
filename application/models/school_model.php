<?php

/**
*
*/
class School_model extends CI_Model{

  /**************************************************************
  Function to list  school from db
  ****************************************************************/
  public function list_school($where){
   $this->db->where( $where);
   $query = $this->db->get('school')->result_array();
   return $query;
  }
  }

?>
