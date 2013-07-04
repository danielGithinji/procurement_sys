<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * TTUC PROCUREMENT SYSTEM
 *
 * 
 **/

//--------------------------------------------------------------------------

/*
 * Description of MY_Controller
 *
 * inherits all of the methods from the CI_Controller class
 * sets headers from the output class which makes sure that the pages are not cached by the browser
 * checks whether a user is logged in and redirects them to another page
 * 
 * @author GMAN
 * 
 * 
 */


class MY_Controller extends CI_Controller {
    
    function __construct(){
        parent::__construct();
   
        // fix the page caching problem
        $this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        $this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
        $this->output->set_header('Pragma: no-cache');
        
        $this->is_logged_in();
    }
    
    //Check if this user is logged in.
    function is_logged_in(){
        
        $is_logged_in = $this->session->userdata('logged_in');
        
        if(!isset($is_logged_in) || $is_logged_in != true)
        {
            redirect('login');  
        }
//        else{
//            $data['is_logged_in'] = TRUE;
//        }
        
        //Set a global var so this can be used in views.
        //$this->load->vars($data);
        
        //Set a return so this can be used as a function calls in controllers.
       // return $data['is_logged_in'];
    }

}  