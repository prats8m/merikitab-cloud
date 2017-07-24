<?php

/**
*
*/
class School_type_model extends CI_Model{

  /**************************************************************
  Function to list  school from db
  ****************************************************************/
  public function list_school_type($where){
   $this->db->where( $where);
   $query = $this->db->get('school_type')->result_array();
   return $query;
  }
  }

?>
