<?php

/**
*
*/
class Class_model extends CI_Model{

  /**************************************************************
  Function to list  school from db
  ****************************************************************/
  public function list_Class($where){
   $this->db->where( $where);
   $query = $this->db->get('class')->result_array();
   return $query;
  }
  }

?>
