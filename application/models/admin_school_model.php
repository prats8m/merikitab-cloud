<?php

/**
*
*/
class Admin_school_model extends CI_Model{

  /**************************************************************
  Function to add school in db
  ****************************************************************/
  public function add_school($data){

    $this->db->insert('school',$data);
return $this->db->insert_id();
  }

  /**************************************************************
  Function to list  school from db
  ****************************************************************/
  public function list_school($limit,$offset){
    $this->db->order_by("school_id", "desc"); 
    $query= $this->db->get('school',$limit,$offset)->result_array();
    return $query;
  }

  /**************************************************************
  Function to list  school from db
  ****************************************************************/
  public function count_school(){
    $query= $this->db->get('school')->result_array();
    return count($query);
  }

  /**************************************************************
  Function to edit a particular school
  ****************************************************************/
  public function edit_school($data){
    $this->db->where('school_id', $data['school_id']);
    return $this->db->update('school', $data); 
  }

  /**************************************************************
  Function to view a particular school
  ****************************************************************/
  public function view_school($school_id){
    $this->db->where('school_id', $school_id);
    $query= $this->db->get('school')->result_array();
    return $query[0];
  }

  /**************************************************************
  Function to Delete a particular school
  ****************************************************************/
  public function delete_school($school_id){
    $this->db->where('school_id', $school_id);
    $response=$this->db->delete('school');
    return $response;
  }
}

?>
