<?php

/**
 * Description of login_model
 * this class checks whether a user is available in the database
 * and validates their existence in the database
 * @author GMAN
 */
class Test_model extends CI_Model{
    
    function checkUser($username){
       
        $this->db->select('username, password');
        $this->db->where('username', $username);
        $query = $this->db->get('user');

        if($query->num_rows() == 1)
        {
            return true;
        }
        
 
    }
    
    function getT($username){
       
       // $this->db->select('username, password');
        $this->db->where('username', $username);
        $query = $this->db->get('user');
        
        
        if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
           {
                $data[] = $row;
           }
        
           return $data;
        }
        
        
        
    }
    
    function user(){
        $this->db->where('username', 'jane');
        $q = $this->db->get('user');
        if($q->num_rows() > 0)
        {
          $row = $q->row();
           return $row;
          
        }
        
    }
}

