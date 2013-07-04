<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Test extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        
         $this->load->model('test_model');
    }
    
    function index(){
        //$this->load->library('table');
        $this->load->view('login_view');
       
     }
     
    function confirmation(){
       $this->load->library('table');
       
       $username = $this->input->post('username');
       
       
       $data = "";
       $confirm = $this->test_model->checkUser($username);
       if($confirm){
          $data['info'] = "Uko ndani!";
       }
       else{
          $data['info'] = "Wewe ni fake";
           
       }
       $this->load->view('test_view', $data);
    }
    
    function getTable(){
  
        $username = $this->input->post('username');
        $this->load->model('test_model');
        $result['record'] = $this->test_model->getT($username);
        
//        $data="";
//       
//        if($result->num_rows()>0)
//        {
//           foreach($result->result() as $row)
//           {
//               $data[] = $row;
//           }
//        }
//        
//        $data['row'] = $data;
        $this->load->view('test_view', $result);
    }
    
    function generate(){
        $this->load->library('table');
          
        $username = $this->input->post('username');
       
        $data['record'] = $this->test_model->getT($username);
        
       
         $this->load->view('test_view', $data);
    }
    
    function tester(){
        $data = $this->input->post('test');
        echo $data;
    }
    
    
    function return_data(){
        $row_data = $this->test_model->user();
        
//        foreach($row_data as $r){
//            echo $r->department;
//        }
        echo $row_data->firstName." ".$row_data->secondName;;
        
    }
    
    function test_time(){
        echo date("d-m-Y");
    }
    
    
}

