<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mycal
 *
 * @author G-MAN
 */
class Mycal extends MY_Controller{
   
    public function display($year = null,$month = null){
        
        if(!$year){$year = date('Y');}
        if(!$month){$month = date('m');}
        
        $this->load->model('my_cal_model');
        
        $name = $this->session->userdata('name');
        $user_id = $this->login_model->get_user_id($name);

        if($day = $this->input->post('day'))
        {
            $this->my_cal_model->add_calendar_data(
                    "$year-$month-$day",
                    $this->input->post('data'),
                    $user_id);
        }
//        
        $data['calendar'] = $this->my_cal_model->generate($year, $month,$user_id);
        
        $this->load->view('cal_test_view',$data);
      
    }
    
    
    
     public function display_test($year=null,$month=null){
       
        echo $this->input->post('day');
         echo $this->input->post('data');
         
//      $year = $this->input->post('year');
//      $month = $this->input->post('month');
      
//        $this->load->model('my_cal_model');
//        
//        $data['calendar'] = $this->my_cal_model->generate($year, $month);
//        
//        $this->load->view('cal_test_view',$data);
      
    }
    
}

?>
