<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * TTUC PROCUREMENT SYSTEM
 */

//--------------------------------------------------------------------------------------------

/*
 * Description of site_nav
 *
 * This class is meant to redirect a user to the pages that they require
 * 
 * @author GMAN
 * 
 * 
 */


class Site_nav extends MY_Controller{
    
    // create a global variable that holds an array
    protected $role = array(); 
    
    
    // the constructor assigns values to the $role array
    public function __construct() { 
        parent::__construct();
       
        $this->role['role'] = $this->session->userdata('role');
        $this->role['department'] = $this->session->userdata('department');
        $this->role['name'] = $this->login_model->fullname($this->session->userdata('name'));        
    }
    
/***********************************************************User Department Pages*******************************************************************************************************************/  
    
    // redirects the user to their dashboard
    public function user_dash($year = null,$month = null){ 
        //checks to make sure that neither the year nor the month is empty
        if(!$year){$year = date('Y');}
        if(!$month){$month = date('m');}
        
        $name = $this->session->userdata('name');
        $user_id = $this->login_model->get_user_id($name);

        if($day = $this->input->post('day'))
        {
            $this->my_cal_model->add_calendar_data(
                    "$year-$month-$day",
                    $this->input->post('data'),
                    $user_id);
        }
        
        // make sure that this function is called in order to set the initial variables
        // correctly according to department
       $this->my_cal_model->initialize($this->role['department']);
        
       // generate the calendar using the generate function, given the year, month and user id
       $this->role['calendar'] = $this->my_cal_model->generate($year, $month,$user_id);
       $this->role['content'] = 'sysviews/user_dept/dashboard';
       $this->load->view('sysviews/template', $this->role);
    }
  
    // redirects a user to the material requisition form
    public function mat_req_form(){ 
       $this->role['items'] = $this->site_model->get_item_details();
       $this->role['content'] = 'sysviews/user_dept/material_requisition';
       $this->load->view('sysviews/template', $this->role);
    }
    
    public function view_mat_req(){
        $this->role['waiting'] = $this->site_model->get_waiting_mat($this->role['department']);
        $this->role['approved'] = $this->site_model->get_mat_App($this->role['department']);
        $this->role['rejected'] = $this->site_model->get_mat_Rej($this->role['department']);
       
       $this->role['content'] = 'sysviews/user_dept/view_mat_req';
       $this->load->view('sysviews/template', $this->role);
    }
    
    
 /***********************************************************End of User Department Pages*****************************************************************************************************/   
    
 /***********************************************************Procurement Pages***********************************************************************************************************************/   
  
    // redirects a user to the procurement dashboard 
    public function procure_dash($year = null,$month = null){ 
         //checks to make sure that neither the year nor the month is empty
        if(!$year){$year = date('Y');}
        if(!$month){$month = date('m');}
        
        $name = $this->session->userdata('name');
        $user_id = $this->login_model->get_user_id($name);

        if($day = $this->input->post('day'))
        {
            $this->my_cal_model->add_calendar_data(
                    "$year-$month-$day",
                    $this->input->post('data'),
                    $user_id);
        }
        
        // make sure that this function is called in order to set the initial variables
        // correctly according to department
       $this->my_cal_model->initialize($this->role['department']);
        
       // generate the calendar using the generate function, given the year, month and user id
       $this->role['calendar'] = $this->my_cal_model->generate($year, $month,$user_id);
       $this->role['content'] = 'sysviews/procurement/proc_dash';
       $this->load->view('sysviews/template', $this->role);
    }
    
    public function partial_load_cal($year = null,$month = null){
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
        
        // make sure that this function is called in order to set the initial variables
        // correctly according to department
       $this->my_cal_model->initialize($this->role['department']);
        
       // generate the calendar using the generate function, given the year, month and user id
       $this->role['calendar'] = $this->my_cal_model->generate($year, $month,$user_id);
 
       $this->load->view('sysviews/procurement/cal_view',$this->role);
        
    }
    
    // redirects a user to the review requisitions table after an ajax call
    public function partial_load_proc(){ 
       $this->role['mat_data'] = $this->site_model->get_material_waiting();
       $this->load->view('sysviews/procurement/review_mat_req_table', $this->role);
    }
    
    // redirects a user to the purchase requistion form
    public function purch_req_form(){
       $this->role['items'] = $this->site_model->get_item_details();
       $this->role['supplier'] = $this->site_model->get_supplier_det();
       $this->role['content'] = 'sysviews/procurement/purchase_requisition';
       $this->load->view('sysviews/template', $this->role); 
    }
    
    public function review_mat_req(){
       $this->role['mat_data'] = $this->site_model->get_material_waiting();
       $this->role['content'] = 'sysviews/procurement/review_mat_req';
       $this->load->view('sysviews/template', $this->role);
    }
    
    // redirects the user to the requisition status pages
    public function view_requisitions(){
       $this->role['approved'] = $this->site_model->get_purch_App();
       $this->role['rejected'] = $this->site_model->get_purch_Rej();
       $this->role['waiting'] = $this->site_model->get_purch_waiting();
       
       $this->role['content'] = 'sysviews/procurement/view_requisitions';
       $this->load->view('sysviews/template', $this->role);
    }
    
    // redirects the user to the lpo page
    public function view_lpo(){
       $this->role['lpo'] = $this->site_model->get_purch_App();
       $this->role['supplier'] = $this->site_model->get_supplier_det();
       $this->role['content'] = 'sysviews/procurement/lpo_page';
       $this->load->view('sysviews/template', $this->role);
    }
    
   // filters the LPOs and displays all the available LPOs from the database
    public function partial_load_lpo(){
       $this->role['lpo'] = $this->site_model->get_purch_App();
       $this->role['supplier'] = $this->site_model->get_supplier_det();
       //$this->role['content'] = 'sysviews/procurement/lpo_page';
       $this->load->view('sysviews/procurement/lpo_table', $this->role);
    }
    
    // filters the LPOs in the LPO page depending on the type of supplier selected
    public function partial_lpoSupp(){
       $val = $this->input->post('val');

       $this->role['lpo'] = $this->site_model->getLpo_from_supp($val);
//       $this->role['supplier'] = $this->site_model->get_supplier_det();
//       $this->role['content'] = 'sysviews/procurement/lpo_page';
       $this->load->view('sysviews/procurement/lpo_table', $this->role);
    }
   
    public function lpo_report(){
       $this->role['lpo'] = $this->site_model->get_purch_App();
       $this->role['supplier'] = $this->site_model->get_supplier_det();
       $this->role['content'] = 'sysviews/procurement/lpo_report_filter';
       $this->load->view('sysviews/template', $this->role);
    }
    
    public function partial_load_lpo_report(){
       $this->role['lpo'] = $this->site_model->get_purch_App();
       $this->role['supplier'] = $this->site_model->get_supplier_det();
       $this->load->view('sysviews/procurement/lpo_report', $this->role);
    }
    
    // filters the LPOs in the LPO page depending on the type of supplier selected
    public function partial_lpoSupp_report(){
       $val = $this->input->post('val');

       $this->role['lpo'] = $this->site_model->getLpo_from_supp($val);
       $this->load->view('sysviews/procurement/lpo_report', $this->role);
    }
    
    // loads the receive note form that is to filled by a procurement officer
    public function receive_form(){
       $this->role['items'] = $this->site_model->get_item_details();
       $this->role['supplier'] = $this->site_model->get_supplier_det();
       $this->role['content'] = 'sysviews/procurement/create_receiveNote';
       $this->load->view('sysviews/template', $this->role);
    }

    public function show_return_note(){
       $this->role['returns'] = $this->site_model->get_returnNote_details();
       $this->role['supplier'] = $this->site_model->get_supplier_det();
       $this->role['content'] = 'sysviews/procurement/return_note';
       $this->load->view('sysviews/template', $this->role);
    }
    
    // loads the specific return note page only
    public function partial_loadreturnNote(){
       $this->role['returns'] = $this->site_model->get_returnNote_details();
       $this->role['supplier'] = $this->site_model->get_supplier_det();
       $this->load->view('sysviews/procurement/return_note_details', $this->role);
    }

    public function showAll_receive_notes(){
       $this->role['receive_note'] = $this->site_model->get_all_returnNotes();
       $this->role['content'] = 'sysviews/procurement/view_receive_notes';
       $this->load->view('sysviews/template', $this->role);
    }
    
    public function returnNote_supp(){
       $val = $this->input->post('val');
       $this->role['returns'] = $this->site_model->get_returnSupplier($val);
       $this->load->view('sysviews/procurement/return_note_details', $this->role);
    }
    
    public function show_items(){
       $this->role['items'] = $this->site_model->get_item_details();
       $this->role['supplier'] = $this->site_model->get_supplier_det();
       $this->role['content'] = 'sysviews/procurement/view_item_details';
       $this->load->view('sysviews/template', $this->role);
    }
    /***********************************************************End of Procurement Page Pages*******************************************************************************************/ 
    
/***********************************************************Finance Pages*******************************************************************************************************************/  
    
    // redirects a user to the finance dashboard/homepage
    public function finance_dash($year = null,$month = null){
         //checks to make sure that neither the year nor the month is empty
        if(!$year){$year = date('Y');}
        if(!$month){$month = date('m');}
        
        $name = $this->session->userdata('name');
        $user_id = $this->login_model->get_user_id($name);

        if($day = $this->input->post('day'))
        {
            $this->my_cal_model->add_calendar_data(
                    "$year-$month-$day",
                    $this->input->post('data'),
                    $user_id);
        }
        
        // make sure that this function is called in order to set the initial variables
        // correctly according to department
       $this->my_cal_model->initialize($this->role['department']);
       
       // generate the calendar using the generate function, given the year, month and user id
       $this->role['calendar'] = $this->my_cal_model->generate($year, $month,$user_id);
       
       $this->role['content'] = 'sysviews/finance/finance_dash';
       $this->load->view('sysviews/template', $this->role);
    }
    
    public function review_purch_req(){
       $this->role['purch_data'] = $this->site_model->get_purch_waiting();
       $this->role['content'] = 'sysviews/finance/review_purch_req';
       $this->load->view('sysviews/template', $this->role);
    }
    
     
   
    // redirects a user to the finance dashboard after an ajax call
    public function partial_load_fin(){ 
       $this->role['purch_data'] = $this->site_model->get_purch_waiting();
       $this->load->view('sysviews/finance/review_purch_req_table', $this->role);
    }
/***********************************************************End of Finance Pages*******************************************************************************************************************/
    
/*********************************************************** admin Pages***************************************************************************************************************************/
    public function admin_panel($year = null,$month = null){
         //checks to make sure that neither the year nor the month is empty
        if(!$year){$year = date('Y');}
        if(!$month){$month = date('m');}
        
        $name = $this->session->userdata('name');
        $user_id = $this->login_model->get_user_id($name);

        if($day = $this->input->post('day'))
        {
            $this->my_cal_model->add_calendar_data(
                    "$year-$month-$day",
                    $this->input->post('data'),
                    $user_id);
        }
       
        // make sure that this function is called in order to set the initial variables
        // correctly according to department
       $this->my_cal_model->initialize($this->role['department']);
       // generate the calendar using the generate function, given the year, month and user id
       $this->role['calendar'] = $this->my_cal_model->generate($year, $month,$user_id);
       
        $this->role['content'] = 'sysviews/admin/admin_panel';
        $this->load->view('sysviews/template',$this->role);
    }
   /**************************edit users page***************************************************/ 
    public function edit_users(){
        $this->role['user_data'] = $this->site_model->getAll_userData();
        $this->role['content'] = 'sysviews/admin/edit_users';
        $this->load->view('sysviews/template',$this->role);
    }
    
    public function partial_load_all_users(){
        $this->role['user_data'] = $this->site_model->getAll_userData();
        $this->load->view('sysviews/admin/edit_users_table',$this->role);
    }
    
    public function partial_load_userOn_status(){
        $user_status = $this->input->post('val');
        $this->role['user_data'] = $this->site_model->getUser_by_status($user_status);
        $this->load->view('sysviews/admin/edit_users_table',$this->role);
    }
    
    public function partial_loadUser_on_firstName(){
        $firstName = $this->input->post('name');
        $this->role['user_data'] = $this->site_model->getUser_by_firstName($firstName);
        $this->load->view('sysviews/admin/edit_users_table',$this->role);
    }
    
    public function reload_user_table(){
        $this->role['user_data'] = $this->site_model->getAll_userData();
        $this->load->view('sysviews/admin/edit_user_filter',$this->role);
    }
    
    /********************************end of edit users page****************************************/ 
    
    /******************************edit items page*************************************************/ 
    public function partial_load_editTable(){
        $this->role['user_data'] = $this->site_model->getAll_userData();
        $this->load->view('sysviews/admin/edit_users_table',$this->role);
    }

     public function edit_items_page(){
        $this->role['items'] = $this->site_model->get_item_details();
        $this->role['categoryDetails'] = $this->site_model->getCategory_details();
        $this->role['content'] = 'sysviews/admin/edit_items';
        $this->load->view('sysviews/template',$this->role);
    }
    
    public function partial_load_items(){
        $this->role['items'] = $this->site_model->get_item_details();
        $this->load->view('sysviews/admin/edit_items_table',$this->role);
    }

    // load the items in the items table according to the category selected
    public function partial_loadItem_category(){
        $id = $this->input->post('val');
        $this->role['items'] = $this->site_model->getItemBy_category($id);
        $this->load->view('sysviews/admin/edit_items_table',$this->role);
    }
    
    // load the items in the items table according to the category selected
    public function partial_loadCategory_list(){
        $this->role['items'] = $this->site_model->get_item_details();
        $this->role['categoryDetails'] = $this->site_model->getCategory_details();
        $this->load->view('sysviews/admin/edit_itemCat_list',$this->role);
    }
    
    public function partial_load_itemBy_Name(){
        $name = $this->input->post('name');
        $this->role['items'] = $this->site_model->getAllDetailsBy_name($name);
        $this->load->view('sysviews/admin/edit_items_table',$this->role);
    }
   
    /******************************end of edit items*********************************************/ 
    
    /******************************edit supplier data pages**************************************/ 
    public function view_supp_info(){
        $this->role['supp_data'] = $this->site_model->get_all_supp_details();
        $this->role['content'] = 'sysviews/admin/edit_suppliers';
        $this->load->view('sysviews/template',$this->role);
    }
    
    public function partial_load_suppTable(){
        $this->role['supp_data'] = $this->site_model->get_all_supp_details();
        $this->load->view('sysviews/admin/edit_supplier_table',$this->role);
    }
    
    public function reload_supp_table(){
         $this->role['supp_data'] = $this->site_model->get_all_supp_details();
         $this->load->view('sysviews/admin/edit_supp_filter',$this->role);
    }
    
    public function partial_load_statusSupp(){
        $status = $this->input->post('val');
        $this->role['supp_data'] = $this->site_model->getSupplierBy_status($status);
        $this->load->view('sysviews/admin/edit_supplier_table',$this->role);
    }
    
     public function partial_load_suppBy_name(){
        $name = $this->input->post('name');
        $this->role['supp_data'] = $this->site_model->getSupplier_Details_By_name($name);
        $this->load->view('sysviews/admin/edit_supplier_table',$this->role);
    }
            
    /******************************end of edit supplier data pages*******************************/
  

    /***********************************************************End admin Pages*******************************************************************************************************************/    
}
/***********end of file*********/
