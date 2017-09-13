<?php

/**
*
*/
class publication_model extends CI_Model{

   /**************************************************************
  Function to list  publication from db
  ****************************************************************/
  public function list_publication($limit,$offset){
    $this->db->order_by("publication_id", "desc"); 
    $query= $this->db->get('publication',$limit,$offset)->result_array();
    // echo $this->db->last_query();
    return $query;
  }
/**************************************************************
  Function to list add publication in db
  ****************************************************************/
  public function add_publication($data){
    $this->db->insert('publication',$data);
    return $this->db->insert_id();
  }

  /**************************************************************
  Function to count total number of publication
  ****************************************************************/
  public function count_publication(){
    $query= $this->db->get('publication')->result_array();
    return count($query);
  }

  /**************************************************************
  Function to edit a particular publication
  ****************************************************************/
  public function edit_publication($data){
    $this->db->where('publication_id', $data['publication_id']);
    return $this->db->update('publication', $data); 
  }

    /**************************************************************
  Function to view a particular book
  ****************************************************************/
  public function select_publication($where){
    $this->db->where($where);
    $query= $this->db->get('publication')->result_array();
    return $query;
  }

    /**************************************************************
  Function to Delete a particular publication
  ****************************************************************/
  public function delete_publication($publication_id){
    $this->db->where('publication_id', $publication_id);
    $response=$this->db->delete('publication');
    return $response;
  }

  }

?>
