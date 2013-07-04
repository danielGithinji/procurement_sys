<?php
/**
 * Description of login_model
 *This model queries the database and 
 * checks whether a certain user exits or not
 * @author GMAN
 */

class Login_model extends CI_Model {
    
    //this function checks whether the username and the password is in the database or not
    public function check_login($username, $password){
        
        $this->db->select('username, password, status');
        $array = array('username' => $username, 'password' => sha1($password),'status' => 'active');
        $this->db->where($array);
        $query = $this->db->get('user');
        
        if($query->num_rows() == 1) // if the affected number of rows is one
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    //this function returns the status of the user to be used in authentication
    public function user_login_data($username, $password){
        
        $this->db->select('status');
        $array = array('username' => $username, 'password' => sha1($password));
        $this->db->where($array);
        $query = $this->db->get('user');
        
        if($query->num_rows() == 1) // if the affected number of rows is one
        {
             $row = $query->row();
             return $row->status;
        }
//        else
//        {
//            return false;
//        }
    }
    
    
    public function user_role($username){ // this function gets the user's role from the database
         $this->db->select('role');
         $this->db->where('username', $username);
         $query = $this->db->get('user');
         $row = $query->row(0);
         
         return $row->role;
    }
    
    public function department($username){ // this function gets the user's department from the database
         $this->db->select('department');
         $this->db->where('username', $username);
         $query = $this->db->get('user');
         $row = $query->row(0); // returns the first row with an array of objects that is stored in the row variable
        
         return $row->department;
    }
    
    public function get_user_id($username){ // this function gets the user's department from the database
         $this->db->select('userID');
         $this->db->where('username', $username);
         $query = $this->db->get('user');
         $row = $query->row(0); // returns the first row with an array of objects that is stored in the row variable
        
         return $row->userID ;
    }
    
    public function fullname($username){
         $this->db->select('firstName, secondName');
         $this->db->where('username', $username);
         $query = $this->db->get('user');
         $row = $query->row(0);
         return $row;
         
//            foreach($query->result() as $row) // returns the query as an array of objects
//           {
//                $data[] = $row; // equates the array of objects to an array variable
//           }
//        
//           return $data;
       // }
    }
   
}

?>
