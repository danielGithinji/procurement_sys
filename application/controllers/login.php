<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of login
 * This class enables a user to login into the system
 *
 * @author GMAN
 */
class Login extends CI_Controller{
   
  
    public function index(){ // loads the login view
        
        $this->load->view('login_view');
    }
    
    public function validate(){ // this function validates whether a user exists or not
        
        //the following validates the specific form fields ie. username and password
        $this->form_validation->set_rules('username', 'Username', 'required|trim|max_length[50]|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|max_length[200]|xss_clean');
        
        
        if($this->form_validation->run() == FALSE) // if the form validation function doesn't run
         {
                $this->load->view('login_view');
         }
         
         else
         {
                extract($this->input->post()); // get all values from the input fields

                $validate = $this->login_model->check_login($username, $password);
                $status = $this->login_model->user_login_data($username, $password);
                 //echo $validate->status;
                if(!$validate) // if the login failed
                     {  
                             if ($status == 'leave' || $status == 'suspended') 
                                 {

                                      $this->session->set_flashdata('suspended', TRUE);

                                      redirect('login');
                                 } 
                               else
                                 {
                                      $this->session->set_flashdata('login_error', TRUE);
                 
                                        redirect('login');
                                 }
                     }
               
                else // if the login worked
                     {                     
                        // set up a session and its relevant variables
  
                        $this->session->set_userdata(array(
                                'logged_in' => TRUE,
                                'name' =>  $this->input->post('username'),
                                'role' => $this->login_model->user_role($username),
                                'department' => $this->login_model->department($username)
                            ));

                            redirect('login/load_page');

                     }
         } 
    }
    
    public function load_page(){ // this function loads a page depending on the user's department

        if($this->session->userdata('logged_in')) // checks the session to see whether a user is logged in
        {
            // puts the current session's department info into the $dept variable
            $dept = $this->session->userdata('department'); 
            
            if( $dept == "maths and informatics") 
            {
               redirect('site_nav/user_dash'); 
            }
            elseif( $dept == "procurement")
            {
               redirect('site_nav/procure_dash'); 
            }
            elseif( $dept == "finance")
            {
               redirect('site_nav/finance_dash'); 
            }
            elseif($dept == "administrator") 
            {
                redirect('site_nav/admin_panel');
            }
        }
          
           //////////////////////////////////////  OLD CODE //////////////////////////////////////////////
//           $role['role'] = $this->session->userdata('role');
//           $role['department'] = $this->session->userdata('department');
//
//           $role['name'] = $this->login_model->fullname($this->session->userdata('name'));
//
//           if($role['department'] == "maths and informatics" )
//           {
//              
//              //aquires the specific kind of file to be displayed i.e mathsAndInfo
//              //then pass the role array to the template file so that the specific file can be displayed
//             // redirect('welcome');
//               $role['content'] = "sysviews/dashboard";
//               $this->load->view('sysviews/template');
//           }
//           elseif ($role['department'] == "procurement")
//           {
//               $role['content'] = "sysviews/procurement/proc_dash";
//               $this->load->view('sysviews/template',$role);
//           }
//           else
//           {
//               echo "NO DEPARTMENT";
//           }
//        }
        
        else
        {
           
           
            redirect('login');
        }
        
    }
    
    public function logout(){ // this function logs out the user and destroys their session
            
            $this->session->unset_userdata();
            $this->session->sess_destroy();

            redirect('login');
    }
        
       
}

?>
