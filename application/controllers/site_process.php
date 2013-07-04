<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of site_process
 *
 * This class deals with all user defined processes
 * @author GMAN
 * 
 */
class Site_process extends MY_Controller {

    
    /*     * ************************************************************User Department Processes********************************************************************************************************* */

    public function material_submit() {
        
      $this->form_validation->set_rules('description', 'Description', 'required|alpha');
      $this->form_validation->set_rules('quantity', 'Quantity', 'required|numeric');
      $this->form_validation->set_rules('date', 'Date', 'required');

      if($this->form_validation->run() != false)//if the form is successfully valdated
      {
            extract($this->input->post()); // turns all inputs(e.g textboxes) into variables that hold their respective values

            $userID = $this->site_model->get_id($this->session->userdata('name'));

            $department = $this->session->userdata('department');
            $itemID = $this->site_model->get_itemID($itemName);

            $date = date("Y-m-d", strtotime($date));
            
            $transaction = array(
                'userID' => $userID,
                'itemID' => $itemID,
                'date' => $date,
            );

            if($add = $this->site_model->insert_trans($transaction))
            {
                $transactionID = $this->site_model->get_last_transID($add);

                $data = array(
                 'mat_quantity' => $quantity,
                 'department' => $department,
                 'transactionID' => $transactionID
                );

                if($enter = $this->site_model->insertMaterial($data))
                {
                   // echo "1";
                     $return = array(
                               'status'  => '1',
                               "message" => "Request Submitted!"
                            );
                      echo json_encode($return);
                    
                }
                else
                {
                    //echo "2";
                     $return = array(
                               'status'  => '2',
                               "message" => "Requisition not submitted!"
                            );
                      echo json_encode($return);
                    echo "material requisition wasn't inserted";
                }
            }
            else 
            {
               // echo "3";
                 $return = array(
                               'status'  => '3',
                               'message' => 'Transaction Error!!'
                            );
                 echo json_encode($return);
            }
      }
      else
        {
         
             $return = array(
               'status'  => 'failed',
               'message' => validation_errors('','<br>')

            );
            echo json_encode($return);//return the error message
        }
//        
    }

    /*     * ************************************************************End of user Department Processes********************************************************************************************************* */

    /*     * ************************************************************Procurement Department Processes********************************************************************************************************* */

    // this function is used to show a table to a modal window in the procurement user interface
    public function show_matReq_details() {
        $id = $this->input->post('id');

        $row_data = $this->site_model->get_specificMat_waiting($id);

        $date = date("d/m/Y", strtotime($row_data->date));


        echo "<tr><td><strong>Name<strong></td><td>" . $row_data->itemName . "</td></tr>";
        echo "<tr><td><strong>Quantity</strong></td><td>" . $row_data->mat_quantity . "</td></tr>";
        echo "<tr><td><strong>Description</strong></td><td>" . $row_data->itemDescription . "</td></tr>";
        echo "<tr><td><strong>Date Created</strong></td><td>" . $date . "</td></tr>";
        echo "<tr><td><strong>Department</strong></td><td>" . $row_data->department . "</td></tr>";


        //echo "imefika";
    }

    // this function changes the status of a material requistion to either approved or rejected
    public function change_matReq_status() {

        $status = $this->input->post('input_val');
        
        // this is the specific material requisition row id
        $mat_id = $this->input->post('mat_id');
        
        $date = date("Y-m-d");

        // get all the details of the specific waiting material requisition
        // which includes details of the item transaction and specific requested item material
        $mat_details = $this->site_model->get_specificMat_waiting($mat_id);
        //echo $mat_details->mat_quantity." ".$mat_details->quantity_limit;
        if ($status == "approved")
        {
            if ($mat_details->mat_quantity > $mat_details->quantity_limit)
            {
                //echo "Quantity in store is below the limit!";
                $return = array(
                    'status' => 'limit',
                    'message' => 'Quantity in the store is below limit!'
                );
                echo json_encode($return);
            }
            else
            {
                // get the new quantity by subtracting the quantity requested from the quantity approved
                $newQuantity = $mat_details->quantity - $mat_details->mat_quantity;

                $update_item = array('quantity' => $newQuantity);
               
                $update = $this->site_model->update_quantity($update_item, $mat_details->itemID);

                if ($update == 1) 
                {
                    // create the array that will be used to insert the data into the database
                    $insert_mat = array('materialReqID' => $mat_id, 'date_mat_approvd' => $date);
                    
                    if ($insert = $this->site_model->insert_approv_status($insert_mat)) 
                    {
                         $return = array(
                            'status' => 'success',
                            'message' => 'Requisition approved'
                        );
                        echo json_encode($return);
                    } 
                    else
                    {
                        $return = array(
                            'status' => 'error',
                            'message' => 'Requision submission error!'
                        );
                        echo json_encode($return);
                    }
                } 
                else
                {
                    $return = array(
                            'status' => 'error1',
                            'message' => 'Server Error!'
                        );
                        echo json_encode($return);
                }
            }
        }
        elseif ($status == "rejected") 
        {
            // create the array that will be used to insert the data into the database
            $insert_mat2 = array('materialReqID' => $mat_id, 'date_mat_rejectd' => $date);

            if ($insert = $this->site_model->insert_rej_status($insert_mat2)) 
            {
                 $return = array(
                        'status' => 'success',
                        'message' => 'Requisition rejected'
                    );
                    echo json_encode($return);
            } 
            else
            {
                $return = array(
                    'status' => 'error',
                    'message' => 'Requision submission error!'
                );
                echo json_encode($return);
            }
        } 

    }
    
    // passes the item description to the view
    public function display_desc(){
        $id = $this->input->post('item_id');
        
        // checks to see whether something has been inputed into the $description variable
        if($description = $this->site_model->get_item_desc($id))
        {
          echo $description->itemDescription .",".$description->pricePerUnit ;  
        }
        else
        {
            echo " ";
        }
 
    }
    
    // inserts data into the purchase requisition table
    public function purchase_submit() {
       
          $this->form_validation->set_rules('description', 'Description', 'required|alpha');
          $this->form_validation->set_rules('price', 'Unit Price', 'required|numeric');
          $this->form_validation->set_rules('quantity', 'Quantity', 'required|numeric');
          $this->form_validation->set_rules('date', 'Date', 'required');
          
          if($this->form_validation->run() != false)//if the form is successfully valdated
          {
                extract($this->input->post()); // turns all inputs(e.g textboxes) into variables that hold their respective values

                $supplierID = $this->site_model->get_supplier_id($supplier_det);
                $userID = $this->site_model->get_id($this->session->userdata('name'));

                $itemID = $this->site_model->get_itemID($itemName);

                $date = date("Y-m-d", strtotime($date));

                $transaction = array(
                     'userID' => $userID,
                     'itemID' => $itemID,
                     'date' => $date
                );
                if($add = $this->site_model->insert_trans($transaction))
                {
                    $transactionID = $this->site_model->get_last_transID($add);

                    $order_no = $this->create_random_orderNo();

                    $data = array(
                            'quantity_ordered' => $quantity,
                            'supplierID' => $supplierID,
                            'transactionID' => $transactionID,
                            'order_no' => $order_no
                        );


                     if ($enter = $this->site_model->insertPurchase($data)) 
                     {
                        //echo "1";
                         $return = array(
                             'status' => 'success'
                         );
                         echo json_encode($return);

                     } 
                     else
                     {
                         //echo "2";
                         $return = array(
                             'status' => 'error1'
                         );
                         echo json_encode($return);
                     }
                }

                else 
                {
                    //echo "3";
                     $return = array(
                             'status' => 'error2'
                         );
                     echo json_encode($return);

                }
          }
          else
          {
               $return = array(
                 'status'  => 'failed',
                 'message' => validation_errors('','<br>')
  
              );
              echo json_encode($return);//return the error message
          }
    }
   
    // gets the specific purchase requisition details that are to be placed in the LPO modal
    public function lpo_details() {
        $id = $this->input->post('id');

        $row_data = $this->site_model->get_purch_for_lpo($id);

        $supplier_data = $this->site_model->getSup_from_lpo($row_data->purchaseReqID);
//        echo $supplier_data->supplierName;
//        echo $supplier_data->email;
        
        $date = date("d/m/Y", strtotime($row_data->date));

        echo "<tr>";
        echo "<td>" . $row_data->itemName . "</td>";
        echo "<td>" . $row_data->itemDescription . "</td>";
        echo "<td>" . $row_data->quantity_ordered . "</td>";
        echo "<td>" . $row_data->pricePerUnit . "</td>";

        $total = $row_data->quantity_ordered* $row_data->pricePerUnit;

        echo "<td>" . $total . "</td>";
//        echo "<td>" .$supplier_data->email."</td>";
        echo "</tr>";

        echo "<input type='hidden' value='$supplier_data->email'/>";
        
        // this is to be displayed in the top part of the modal
        echo "<tr class='sup_data'>
                <td>".$supplier_data->supplierName."</td>
                <td>".$supplier_data->email."</td>
              </tr>"; 
         
        
    }
    
    // this function gets the specific LPOs depending on the selected supplier to be shown on the modal
    public function get_lpoSupplier(){
        $id = $this->input->post('id');
        
        // get all the required LPO rows
        $row = $this->site_model->getLpo_from_supp($id);
        
        // get all the supplier data
        
        $supplier_data = $this->site_model->get_supplier_data($id);
        
        foreach($row as $row_data){
            echo "<tr>";
            echo "<td>" . $row_data->itemName . "</td>";
            echo "<td>" . $row_data->itemDescription . "</td>";
            echo "<td>" . $row_data->quantity_ordered . "</td>";
            echo "<td>" . $row_data->pricePerUnit . "</td>";

            $total = $row_data->quantity_ordered * $row_data->pricePerUnit;

            echo "<td>" . $total . "</td>";
//            echo "<td>" .$supplier_data->email."</td>";
            echo "</tr>";
        }
            echo "<input type='hidden' value='$supplier_data->email'/>";

            // this is to be displayed in the top part of the modal
            echo "<tr class='sup_data'>
                    <td>".$supplier_data->supplierName."</td>
                    <td>".$supplier_data->email."</td>
                  </tr>"; 
      
    }
    
    // checks whether the order number and renders it to the ajax function
    public function check_order_no(){
        $order_no = $this->site_model->check_order_no($this->input->post('order_no'));
        echo $order_no;
    }
    
     public function make_receive_note(){
         
         $this->form_validation->set_rules('description', 'Description', 'required|alpha');
         $this->form_validation->set_rules('price', 'Unit Price', 'required|numeric');
         $this->form_validation->set_rules('quantity_received', 'Quantity Received', 'required|numeric');
         $this->form_validation->set_rules('order_number', 'Order Number', 'required|numeric');
         $this->form_validation->set_rules('date', 'Date', 'required');

          if($this->form_validation->run() != false)//if the form is successfully valdated
          {
                extract($this->input->post());
                $date = date("Y-m-d", strtotime($date));
                
                // get the purchase approval id by using the order number
                $purch_id = $this->site_model->get_purchApprovID($order_number);
                
                // get the item quantity using the item name
                $actual_quantity = $this->site_model->get_item_quantity($itemName);

                $insert_data = array(
                    'quantity_received' => $quantity_received,
                    'date_received' => $date,
                    'purch_approvID' => $purch_id
                   
                );

              
                if($radio_val == "approved")
                { 
                    if($add = $this->site_model->insert_into_receive($insert_data))
                    {
                       
                        // data that is needed to be updated to the item table
                        $new_quantity = $quantity_received + $actual_quantity;
                        $update_data = array('quantity' => $new_quantity);
                        $update = $this->site_model->update_item_quantity($itemName,$update_data);
                        // if the 
                        if($update == 1)
                        {
                            //echo "approved,received, quantity updated";
                            $return = array(
                               'status'  => 'success',
                                'message' => 'Received goods approved'
                            );
                            echo json_encode($return);
                        }
                        else
                        {
                            //echo "quantity not updated";
                             $return = array(
                                'status'  => 'error1',
                                'message' => 'Receive note not created!'
                            );
                            echo json_encode($return);
                        }

                    }
                    else
                    {
                        //echo "goods not received";
                         $return = array(
                               'status'  => 'error2',
                                'message' => 'Record already exists!'
                            );
                          echo json_encode($return);
                    }
                }
                elseif($radio_val == "rejected")
                {
                    //echo "2";
                   
                    if($add = $this->site_model->insert_into_receive($insert_data))
                    {
                        
                        $receive_noteID = $this->site_model->get_last_receiveID($add);

                        $insert_det = array('receiveID' => $receive_noteID);
                         
                        if($insert_receive = $this->site_model->insert_return($insert_det))
                        {
                            //echo "2. Record was rejected, inserted & returned";
                             $return = array(
                               'status'  => 'success',
                                'message' => 'Received goods disapproved'
                            );
                            echo json_encode($return);
                        }
                       else
                       {
                           //echo "goods not returned";
                            $return = array(
                               'status'  => 'error1',
                                'message' => 'Receive note not created!'
                            );
                            echo json_encode($return);
                       }
                    }
                    else
                    {
                       //echo "goods not received";
                         $return = array(
                               'status'  => 'error2',
                               'message' => 'Record already exists!'
                            );
                            echo json_encode($return);
                    }
                } 
          }
          else
          {
               $return = array(
                 'status'  => 'failed',
                 'message' => validation_errors('','<br>')
  
              );
              echo json_encode($return);//return the error message
          }
    }
    
      // takes all the values from the items table and passes them to a form where they are edited
    public function purchItemReq_details(){
        $id = $this->input->post('item_id');
        $details = $this->site_model->get_item_desc($id);
        
        // pass all the details of a specific item to the js file in order to be rendered to a modal in the ui
        echo $details->itemName.",".$details->itemDescription.",".$details->pricePerUnit;
                
    }

    /*     * ************************************************************End Procurement Department Processes************************************************************************************************* */

    /*     * ************************************************************Finance Department Processes************************************************************************************************************** */

    // this function is used to show a table to a modal window in the finance user interface
    public function show_purchReq_details() {
        $id = $this->input->post('id');

        $row_data = $this->site_model->get_specificPurch_waiting($id);
        
        $supplier_id = $this->site_model->get_purchSupp_id($id);
        $supplier_name = $this->site_model->get_supplier_data($supplier_id);

        $date = date("d/m/Y", strtotime($row_data->date));


        echo "<tr><td><strong>Name<strong></td><td>" . $row_data->itemName . "</td></tr>";
        echo "<tr><td><strong>Quantity</strong></td><td>" . $row_data->quantity_ordered . "</td></tr>";
        echo "<tr><td><strong>Price Per Unit (Ksh.)</strong></td><td>" . $row_data->pricePerUnit . "</td></tr>";
        
        $total = $row_data->quantity_ordered * $row_data->pricePerUnit;
        
        echo "<tr><td><strong>Total Cost (Ksh.)</strong></td><td>" . $total . "</td></tr>";
        echo "<tr><td><strong>Supplier</strong></td><td>" . $supplier_name->supplierName. "</td></tr>";
        
        echo "<tr><td><strong>Date Created</strong></td><td>" . $date . "</td></tr>";
        
        
    }

    // this function changes the status of a purchase requistion to either approved or rejected
    public function change_purchReq_status() {

        $status = $this->input->post('input_val');
        $purch_id = $this->input->post('purch_id');
        $date = date("Y-m-d");

        $insert_purch = array('purchaseReqID' => $purch_id, 'date_purch_approvd' => $date);
        $insert_purch2 = array('purchaseReqID' => $purch_id, 'date_purch_rejectd' => $date);

        if ($status == "approved")
        {
            if ($insert = $this->site_model->insert_purchApprov_status($insert_purch)) 
            {
                  $array = array('insert' => $purch_id);
                  // put the $purch_id into a session variable
                  $this->session->set_userdata($array);
                  
                  $return = array(
                    'status' => '1',
                    'message' => 'Requisition approved.'
                );
                echo json_encode($return);

            } 
            else
            {
                  $return = array(
                    'status' => '2',
                    'message' => 'Submission Error!'
                );
                echo json_encode($return);
            }
        } 
        elseif ($status == "rejected")
        {
            if ($insert = $this->site_model->insert_purchRej_status($insert_purch2))
            {
                $return = array(
                    'status' => '1',
                    'message' => 'Requisition rejected.'
                );
                echo json_encode($return);
            } 
            else
            {
                 $return = array(
                    'status' => '2',
                    'message' => 'Submission Error!'
                );
                echo json_encode($return);
            }
        }
    }

    /*     * ************************************************************End Finance Department Processes******************************************************************************************************* */
    
     /*     * ************************************************************admin Processes*********************************************************************************************************************** */
    
    // inserts the user details into the database
    public function insertUser_details(){
          // set validation rules
          $this->form_validation->set_rules('firstName', 'First Name', 'required');
          $this->form_validation->set_rules('secondName', 'Second Name', 'required');
          $this->form_validation->set_rules('username', 'Username', 'required');
//          $this->form_validation->set_rules('dob', 'Date of birth(DOB)', 'required');
          $this->form_validation->set_rules('role', 'Role', 'required');
          $this->form_validation->set_rules('national_id', 'Role', 'required');
          $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
          
          
          if($this->form_validation->run() != false)//if the form is successfully valdated
          {
                // extract all the form values and put them into variables
                extract($this->input->post());

                $password = sha1($username);
                $dob = date('Y-m-d', strtotime($dob));

                $user_details = array(
                    'username' => $username,
                    'password' => $password,
                    'role' => $role,
                    'department' => $department,
                    'firstName' => $firstName,
                    'secondName' => $secondName,
                    'national_id' => $national_id,
                    'gender' => $gender,
                    'email' => $email,
                    'dob' => $dob,
                    'status' => $user_status
                );
              

                $add_user = $this->site_model->insertUser_details($user_details);

                if($add_user)
                {
                     $return = array( // set the output status, message and table row html
                           'status'  => 'success'   
                     );
                     
                     echo json_encode($return);//print out the JSON encoded output
                }
                else
                {
                    $return = array( // set the output status, message and table row html
                           'status'  => 'error'   
                    );
                    
                     echo json_encode($return);//print out the JSON encoded output
                }
          }
          else
          {
               $return = array(
                 'status'  => 'failed',
                 'message' => validation_errors('','<br>')
               );
               
              echo json_encode($return);//return the error message
          }
    }
    
    // shows the user details into the specified modal
    public function showUser_details(){
        $id = $this->input->post('user_id');
        
        $user_details = $this->site_model->get_userDetails($id);
        
          echo "<tr><th>First Name</th><td>" .$user_details->firstName. "</td></tr>";
          echo "<tr><th>Second Name</th><td>" .$user_details->secondName. "</td></tr>";
          echo "<tr><th>Username<td>" .$user_details->username. "</td></tr>";
          echo "<tr><th>Department</th><td>" .$user_details->department. "</td></tr>";
          echo "<tr><th>Role<strong></th><td>" .$user_details->role. "</td></tr>";
          echo "<tr><th>National ID</th><td>" .$user_details->national_id. "</td></tr>";
          echo "<tr><th>Gender</th><td>" .$user_details->gender. "</td></tr>";
          echo "<tr><th>Email</th><td>" .$user_details->email. "</td></tr>";
          $dateOfBirth = date('d/m/Y',  strtotime($user_details->dob));
          echo "<tr><th>D.O.B</th><td>" .$dateOfBirth . "</td></tr>"; 
          echo "<tr><th>Status</th><td>" .$user_details->status. "</td></tr>";
    }
    
    // takes all the values from the user table and passes them to a form where they are edited
    public function editUser_details(){
        $id = $this->input->post('user_id');
        $details = $this->site_model->get_userDetails($id);
        // change the date of birth details to a readable form
        $dateOfBirth = date('d/m/Y',  strtotime($details->dob));
        
        // pass all the details of a specific user to the js file in order to be rendered to a modal in the ui
        echo $details->firstName.",".$details->secondName.",".$details->username.",".
             $dateOfBirth.",".$details->department.",".$details->role.",".$details->national_id.",".
             $details->gender.",".$details->email.",".$details->status;
    }
    
    public function update_user_data(){
         // set validation rules
          $this->form_validation->set_rules('firstName', 'First Name', 'required');
          $this->form_validation->set_rules('secondName', 'Second Name', 'required');
          $this->form_validation->set_rules('username', 'Username', 'required');
          $this->form_validation->set_rules('dob', 'Date of birth(DOB)', 'required');
          $this->form_validation->set_rules('role', 'Role', 'required');
          $this->form_validation->set_rules('national_id', 'National ID', 'required');
          $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
          
          if($this->form_validation->run() != false)//if the form is successfully valdated
          {
                extract($this->input->post());

                $password = sha1($username);
                $dob = date('Y-m-d', strtotime($dob));

                $user_details = array(
                    'username' => $username,
                    'password' => $password,
                    'role' => $role,
                    'department' => $department,
                    'firstName' => $firstName,
                    'secondName' => $secondName,
                    'national_id' => $national_id,
                    'gender' => $gender,
                    'email' => $email,
                    'dob' => $dob,
                    'status' => $user_status
                );

                
                $update_user = $this->site_model->updateUser_details($id,$user_details);

                if($update_user ==1)
                {
                     $return = array( // set the output status, message and table row html
                           'status'  => 'success'   
                     );
                     echo json_encode($return);//print out the JSON encoded output
                }
                else
                {
                     $return = array( // set the output status, message and table row html
                           'status'  => 'error'   
                     );
                     echo json_encode($return);//print out the JSON encoded output
                }
          }
           else
          {
               $return = array(
                 'status'  => 'failed',
                 'message' => validation_errors('','<br>')
  
              );
              echo json_encode($return);//return the error message
          }
        
    }
    
    // grabs the post inputs validates them and passes them to a model that adds them to the database
    // inserts the user details into the database
    public function insert_new_item(){
          // set validation rules
          $this->form_validation->set_rules('itemName', 'Item Name', 'required');
          $this->form_validation->set_rules('itemDescription', 'Item Description', 'required');
          $this->form_validation->set_rules('pricePerUnit', 'Unit Price', 'required');
          $this->form_validation->set_rules('quantity', 'Quantity', 'required');
          $this->form_validation->set_rules('quantity_limit', 'Quantity Limit', 'required');
          
          if($this->form_validation->run() != false)//if the form is successfully valdated
          {
                // extract all the form values and put them into variables
                extract($this->input->post());

                $item_details = array(
                    'itemName' => $itemName,
                    'itemDescription' => $itemDescription,
                    'pricePerUnit' => $pricePerUnit,
                    'quantity' => $quantity,
                    'quantity_limit' => $quantity_limit,
                    'categoryID' => $category
                );

                $add_user = $this->site_model->insert_item($item_details);

                if($add_user)
                {
                     $return = array( // set the output status, message and table row html
                           'status'  => 'success'   
                     );
                     echo json_encode($return);//print out the JSON encoded output
                }
                else
                {
                    $return = array( // set the output status, message and table row html
                           'status'  => 'error'   
                     );
                     echo json_encode($return);//print out the JSON encoded output
                }
          }
          else
          {
               $return = array(
                 'status'  => 'failed',
                 'message' => validation_errors('','<br>')
  
              );
              echo json_encode($return);//return the error message
          }
    }
    
     // takes all the values from the items table and passes them to a form where they are edited
    public function editItem_details(){
        $id = $this->input->post('item_id');
        $details = $this->site_model->get_item_desc($id);
        
        // pass all the details of a specific item to the js file in order to be rendered to a modal in the ui
        echo $details->itemName.",".$details->itemDescription.",".$details->pricePerUnit.",".
             $details->quantity.",". $details->quantity_limit.",".$details->categoryID;      
    }
    
     // grabs the post inputs validates them and passes them to a model that adds them to the database
    // inserts the user details into the database
    public function update_item(){
          // set validation rules
          $this->form_validation->set_rules('itemName', 'Item Name', 'required');
          $this->form_validation->set_rules('itemDescription', 'Item Description', 'required');
          $this->form_validation->set_rules('pricePerUnit', 'Unit Price', 'required');
          $this->form_validation->set_rules('quantity', 'Quantity', 'required');
          $this->form_validation->set_rules('quantity_limit', 'Quantity Limit', 'required');

          if($this->form_validation->run() != false)//if the form is successfully valdated
          {
                // extract all the form values and put them into variables
                extract($this->input->post());
                //echo $id;
                $item_details = array(
                    'itemName' => $itemName,
                    'itemDescription' => $itemDescription,
                    'pricePerUnit' => $pricePerUnit,
                    'quantity' => $quantity,
                    'quantity_limit' => $quantity_limit,
                    'categoryID' => $category
                );

               
                $update_item = $this->site_model->update_current_item($id,$item_details);
               
                if($update_item=1)
                {
                     $return = array( // set the output status, message and table row html
                           'status'  => 'success'   
                     );
                     echo json_encode($return);//print out the JSON encoded output
                }
                else
                {
                    $return = array( // set the output status, message and table row html
                           'status'  => 'error'   
                     );
                     echo json_encode($return);//print out the JSON encoded output
                }
          }
          else
          {
               $return = array(
                 'status'  => 'failed',
                 'message' => validation_errors('','<br>')
  
              );
              echo json_encode($return);//return the error message
          }
    }
    
    // validate the insert category input boxes and pass the data to the model to insert to the database
    public function insert_new_category(){
        
       $this->form_validation->set_rules('newCategory', 'Category Name', 'required');
 
       if($this->form_validation->run() != false)//if the form is successfully validated
          {
               
              $new_category = $this->input->post('newCategory');
              //echo $new_category;
              $insert_array = array("categoryName" => $new_category);
              
                if($insert_new = $this->site_model->insert_category($new_category,$insert_array))
                {
                     $return = array( // set the output status, message and table row html
                           'status'  => 'success',  
                           'message' => $insert_new 
                     );
                     echo json_encode($return);//print out the JSON encoded output
                }
                else
                {
                    $return = array( // set the output status, message and table row html
                           'status'  => 'error' ,
                         'message' => $insert_new 
                     );
                     echo json_encode($return);//print out the JSON encoded output
                }
         }
          else
          {
               $return = array(
                 'status'  => 'failed',
                 'message' => validation_errors('','<br>')
  
              );
              echo json_encode($return);//return the error message
          }
    }
    
    // show all the categories that are to be edited
    public function show_categoryTo_edit(){
        $cat_details = $this->site_model->getCategory();
        
        foreach($cat_details as $d){
            //echo $d->categoryName;
            echo "<label>Edit Category:</label><input type='text' value='".$d->categoryName."' name='".$d->categoryID."' id='".$d->categoryName."'/>";
        }
        
    }
    
    public function updateEdited_catgory(){

        $update_data = $this->input->post();
        //print_r($update_data);
        $confirm = true;
        foreach($update_data as $index=>$data){
             if(empty($data))
             {  
                $confirm = false;
             }
        }
       // echo $confirm;

     //if the array is not empty which means that the inputs have some data 
       if($confirm)
        {
         
               foreach($update_data as $u=>$up){

                    $field = $u;
                    $field_data = $up; 
                    $data = array('categoryName' => $field_data);
                    $update_resp = $this->site_model->update_category($field,$data);
               }
                if($update_resp=1)
                 {
                      $return = array( // set the output status, message and table row html
                            'status'  => 'success'   
                      );
                      echo json_encode($return);//print out the JSON encoded output
                 }
                 else
                 {
                     $return = array( // set the output status, message and table row html
                            'status'  => 'error'   
                      );
                      echo json_encode($return);//print out the JSON encoded output
                 }
                }
        else
          {
            
               $return = array(
                 'status'  => 'failed',
                 'message' => "Please fill in all the form fields!"
  
              );
              echo json_encode($return);//return the error message
          }
        
                
    }
    
    public function insert_new_supplier(){
          // set validation rules
           
          $this->form_validation->set_rules('supplierName', 'Supplier Name', 'required');
          $this->form_validation->set_rules('supplierLocation', 'Location', 'required');
          $this->form_validation->set_rules('itemsSupplied', 'Items Supplied', 'required');
          $this->form_validation->set_rules('phone_no', 'Telephone No.', 'required');
          $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
          $this->form_validation->set_rules('date', 'Date', 'required');
          
          if($this->form_validation->run() != false)//if the form is successfully valdated
          {
                // extract all the form values and put them into variables
                extract($this->input->post());
                // change the date format to a database friendly format
                $supp_date = date('Y-m-d', strtotime($date));
                
                $supplier_details = array(
                    'supplierName' => $supplierName,
                    'supplierLocation' => $supplierLocation,
                    'phone_no' => $phone_no,
                    'email' => $email,
                    'itemsSupplied' => $itemsSupplied,
                    'date' => $supp_date,
                    'status' => $status
                );

                $add_supplier = $this->site_model->insert_new_supplier($supplier_details);

                if($add_supplier)
                {
                     $return = array( // set the output status, message and table row html
                           'status'  => 'success'   
                     );
                     echo json_encode($return);//print out the JSON encoded output
                }
                else
                {
                    $return = array( // set the output status, message and table row html
                           'status'  => 'error'   
                     );
                     echo json_encode($return);//print out the JSON encoded output
                }
          }
          else
          {
               $return = array(
                 'status'  => 'failed',
                 'message' => validation_errors('','<br>')
  
              );
              echo json_encode($return);//return the error message
          }
    }
    
    // takes all the values from the user table and passes them to a form where they are edited
    public function editSupplier_details(){
        $id = $this->input->post('supplierID');
        
        $details = $this->site_model->get_supplier_data($id);
        // change the date of birth details to a readable form
        $supp_date = date('d/m/Y',  strtotime($details->date));
        
        // pass all the details of a specific user to the js file in order to be rendered to a modal in the ui
        echo $details->supplierName.",".$details->supplierLocation.",".$details->itemsSupplied.",".
             $details->phone_no.",".$details->email.",". $supp_date.",".$details->status;
            
    }
    
    public function update_supplier_data(){
            // set validation rules
          $this->form_validation->set_rules('supplierName', 'Supplier Name', 'required');
          $this->form_validation->set_rules('supplierLocation', 'Location', 'required');
          $this->form_validation->set_rules('itemsSupplied', 'Items Supplied', 'required');
          $this->form_validation->set_rules('phone_no', 'Telephone No.', 'required|numeric');
          $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
          $this->form_validation->set_rules('date', 'Date', 'required');
          
          if($this->form_validation->run() != false)//if the form is successfully valdated
          {
                // extract all the form values and put them into variables
                extract($this->input->post());
                // change the date format to a database friendly format
                $supp_date = date('Y-m-d', strtotime($date));
                
                $newSupp_details = array(
                    'supplierName' => $supplierName,
                    'supplierLocation' => $supplierLocation,
                    'phone_no' => $phone_no,
                    'email' => $email,
                    'itemsSupplied' => $itemsSupplied,
                    'date' => $supp_date,
                    'status' => $status
                );

              
                $update_supplier = $this->site_model->update_supplier_details($id,$newSupp_details);
                
                if($update_supplier=1)
                {
                     $return = array( // set the output status, message and table row html
                           'status'  => 'success'   
                     );
                     echo json_encode($return);//print out the JSON encoded output
                }
                else
                {
                    $return = array( // set the output status, message and table row html
                           'status'  => 'error'   
                     );
                     echo json_encode($return);//print out the JSON encoded output
                }
          }
          else
          {
               $return = array(
                 'status'  => 'failed',
                 'message' => validation_errors('','<br>')
  
              );
              echo json_encode($return);//return the error message
          }
    }
    
    // gets the various users from the databases loops through them and passes the data to an ajax function call 
    public function search_user_names(){
        $name = $this->input->post('query');
        $data = $this->site_model->get_user_names($name);
        foreach ($data as $name)
        {
            //$typeahead_array[] = $name['firstName'];
            $typeahead_array[] = $name->firstName;
        }

        echo json_encode($typeahead_array);
      
    }
    
     // gets the various users from the databases loops through them and passes the data to an ajax function call 
    public function search_item_names(){
        
        $name = $this->input->post('query');
        $data = $this->site_model->getItemBy_name($name);
        foreach ($data as $name)
        {
            //$typeahead_array[] = $name['firstName'];
            $typeahead_array[] = $name->itemName;
        }

        echo json_encode($typeahead_array);
      
    }
    
     // gets the various users from the databases loops through them and passes the data to an ajax function call 
    public function search_supplier_names(){
        
        $name = $this->input->post('query');
        $data = $this->site_model->getSupplierBy_name($name);
        foreach ($data as $name)
        {
            //$typeahead_array[] = $name['firstName'];
            $typeahead_array[] = $name->supplierName;
        }

        echo json_encode($typeahead_array);
      
    }

    /*     * ************************************************************End admin Processes******************************************************************************************************************** */

    // creates random numbers
    public function create_random_orderNo(){
      //Under the string $Caracteres you write all the characters you want to be used to randomly generate the code.
        //$characters = 'ABCDEFGHIJKLMOPQRSTUVXWYZ0123456789';
        $characters = '0123456789';
        $newCharacters = strlen($characters);
        $newCharacters--;

        $Hash = NULL;
        for ($x = 1; $x <=4; $x++)
		{
            $randomNo= rand(0, $newCharacters);
            $Hash .= substr($characters, $randomNo, 1);
        }

        return $Hash;
    }

    public function test() {
        extract($this->input->post());
        echo $itemName;
//
//         foreach (explode('&', $query) as $chunk) {
//            $param = explode("=", $chunk);
// 
//            if ($param) {
//                //printf("Value for parameter \"%s\" is \"%s\"<br/>\n", urldecode($param[0]), urldecode($param[1]));     
//               
//            }
//           }
//         foreach($query as $input){
//             echo $input;
//         }
    }

}

/***********end of file*********/