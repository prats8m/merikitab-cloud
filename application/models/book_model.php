<?php

/**
*
*/ 
class Book_model extends CI_Model{

  /**************************************************************
  Function to list  school from db
  ****************************************************************/
  public function list_book($where,$limit,$offset){
  $this->db->select('*')
  ->join('school_book', 'book.book_id = school_book.book_id','left')
  ->join('author', 'book.book_author = author.author_id','left')
  ->join('class', 'book.book_class = class.class_id','left');

  $this->db->where($where);
  $this->db->group_by('book.book_id');
  $result = $this->db->get('book',$limit,$offset)->result_array();
  // echo $this->db->last_query();
  return $result;
  }


   /**************************************************************
  Function to count  school from db
  ****************************************************************/
  public function count_book($where){
  $this->db->select('*')
  ->join('school_book', 'book.book_id = school_book.book_id');
  $this->db->where($where);
  $this->db->group_by('book.book_id');
  $result = $this->db->get('book',$limit,$offset)->result_array();
   return count($result);
  }


   public function select_book($select,$where){
    $this->db->select($select);
    $this->db->where($where);
    $query= $this->db->get('book')->result_array();
    return $query[0];
  }
  }

?>
