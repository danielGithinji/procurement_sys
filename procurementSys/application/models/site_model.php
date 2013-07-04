<?php
/**
 * Description of site_model
 * This class deals with issues related to how the user functions interact with the database
 * i.e how they select, update e.t.c data
 * 
 * @author GMAN
 */
class Site_model extends CI_Model{
  
        
    
 /***************************************************user Table Manipulation***************************************************************************************************************/   
     // this function gets the user id from the users table
    public function get_id($username){
        $this->db->select('userID')->from('user')->where('username', $username);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            $row = $query->row(0);
         
            return $row->userID;
        }
   
    }
    
    // gets all the system users data except for the administrator's data
    public function getAll_userData()
    {
        $this->db->where('status !=','admin');
        $q = $this->db->get('user');
        
        if($q->num_rows()>0)
        {
            foreach($q->result() as $row){
                $data[] = $row;
            }
           return $data;     
        }
        else
        {
            return "nothing";
        }
    }
    
    // gets the specific user details
    public function get_userDetails($id){
        
        $this->db->where('userID',$id);
        
        $query = $this->db->get('user');
        
        if($query->num_rows() > 0)
        {
            $row = $query->row(0);
         
            return $row;
        }
    }
    
    // gets the all the user rows from the users table depending on the user status
    public function getUser_by_status($status){
        $this->db->where('status',$status);
        $q = $this->db->get('user');
        
        if($q->num_rows()>0)
        {
            foreach($q->result() as $row){
                $data[] = $row;
            }
           return $data;     
        }
        else
        {
            return "nothing";
        }
    }
    
    // get all the names from the user table that are like the method's argument
    public function get_user_names($name){
        $this->db->select('firstName')->from('user')->like('firstName',$name);
        
        $q = $this->db->get();
        
        if($q->num_rows()>0)
        {
            foreach($q->result() as $row){
                $data[] = $row;
            }
           return $data;     
        }
        else
        {
            return "nothing";
        }
    }
    
      // gets the all the user rows from the users table depending on the user name
    public function getUser_by_firstName($name){
        $this->db->where('firstName',$name);
        $q = $this->db->get('user');
        
        if($q->num_rows()>0)
        {
            foreach($q->result() as $row){
                $data[] = $row;
            }
           return $data;     
        }
        else
        {
            return "nothing";
        }
    }


    public function insertUser_details($user_data){
        $this->db->insert('user',$user_data);
        return $this->db->insert_id();
    }
    
    
    public function updateUser_details($id,$update){
       $this->db->where('userID', $id);
       $this->db->update('user', $update);
       return $this->db->affected_rows();
    }
/***************************************************end of user Table Manipulation*****************************************************************************************************/  
 
 /***************************************************item transaction Table manipultation***************************************************************************************************/   
// gets the transaction id of the last record that was inserted
    public function get_last_transID($id){
        $this->db->select('transactionID ')->from('item_transaction')->where('transactionID', $id);
        $query = $this->db->get();
        
        if($query->num_rows() == 1)
        {
            $row = $query->row(0);
         
            return $row->transactionID;
        }
   
    }
    
    // checks whether a certain order number exits or not
    public function check_order_no($order_no){
        $this->db->select('order_no')->from('purchase_requisition')->where('order_no',$order_no);
        $query = $this->db->get();
        
        $msg = 1;
        
        if($query->num_rows() > 0)
        {
            return $msg;
        }
        else
        {
           $msg = 0;
           return $msg;
        }
        
    }
      
    // inserts the current transaction into the item_transaction table
    public function insert_trans($transaction){
        $this->db->insert('item_transaction', $transaction);
        return $this->db->insert_id();
    }
   
/***************************************************end of item transaction Table manipulation*********************************************************************************************/
    
/***************************************************item category Table manipulation***************************************************************************************************/
    
    //gets all the details of the categories in the material category table
    public function getCategory_details(){
        $query = $this->db->get('material_category');
        
        if($query->num_rows()>0)
        {
            foreach($query->result() as $row){
                $data[] = $row;
            }
            
            return $data;
                
        }
        
    }
    
    public function getCategory(){
        $query = $this->db->get('material_category');
        
        if($query->num_rows()>0)
        {
            foreach($query->result() as $row){
                $data[] = $row;
            }
            
            return $data;
                
        }
        
    }
    
    
    public function get_Category_name(){
        $this->db->select('categoryName');
        $result = $this->db->get('material_category');
        return  $result->result_array();
    }
    
    // inserts the new category name into the material category table
    public function insert_category($categoryName, $insert_data){

//        $this->db->insert('material_category',$insert_data);
//        return $this->db->insert_id();
        
        foreach($insert_data as $ins=>$data){
            $cat = $data;
        }
        
        $query = "INSERT INTO material_category (categoryName) VALUES ('$cat')"; 
            
        
        $q = $this->db->query($query);
        return $this->db->insert_id();         
       
    }
 
     public function update_category($field,$data){
        $this->db->where('categoryID',$field);
        $this->db->update('material_category', $data);
        return $this->db->affected_rows();//$this->db->last_query();
         
    }
    
    
  
/***************************************************end item category Table manipulation***********************************************************************************************/
 
/***************************************************Items Table Manipulation***************************************************************************************************************/    
    
    // this function gets the item id from the items table
    public function get_itemID($itemName){ 
        $this->db->select('itemID')->from('items')->where('itemName', $itemName);
        $query = $this->db->get();
        
         if($query->num_rows() == 1)
         {
            $row = $query->row(0);

            return $row->itemID;
         }
    }
    
    // this function gets the quantity from the item table
    public function get_item_quantity($itemName){
        $this->db->select('quantity')->from('items')->where('itemName', $itemName);
        $query = $this->db->get();
        
        if($query->num_rows() == 1)
        {
            $row = $query->row(0);

            return $row->quantity;
        }
    }
    
    // gets the item_id and the corresponding item_name from the items table
    public function get_item_details(){
        //$this->db->select('itemID, itemName')->from('items');
        $query = $this->db->get('items');
        
         // returns the query as an array of objects
        if($query->num_rows()>0)
        {
            foreach ($query->result() as $row) {
            $data[] = $row; // equates the array of objects to an array variable
            }
             return $data;
        } 
        else
        {
            return "nothing";
        }
    }
    
    // get the item description depending on the item id
    public function get_item_desc($id){
        //$this->db->select('itemDescription, pricePerUnit')->from('items')->where('itemID', $id);
        $this->db->where('itemID', $id);
        $query = $this->db->get('items');
        
        if($query->num_rows() > 0)
        {
            $row = $query->row();
            return $row;
        }  
    }
    
    // get the item description depending on the item name
    public function get_item_des($name){
        $this->db->select('itemDescription, pricePerUnit')->from('items')->where('itemName', $name);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            $row = $query->row();
            return $row;
        }
    }
    
    // get all the item rows depending on a certain category
    public function getItemBy_category($id){
        $this->db->where('categoryID', $id);
        $query = $this->db->get('items');
        
         // returns the query as an array of objects
        if($query->num_rows()>0)
        {
            foreach ($query->result() as $row) {
            $data[] = $row; // equates the array of objects to an array variable
            }
             return $data;
        } 
        else
        {
            return "nothing";
        }
    }
    
     // get all the item rows depending on a certain category
    public function getAllDetailsBy_name($name){
        $this->db->where('itemName', $name);
        $query = $this->db->get('items');
        
         // returns the query as an array of objects
        if($query->num_rows()>0)
        {
            foreach ($query->result() as $row) {
            $data[] = $row; // equates the array of objects to an array variable
            }
             return $data;
        } 
        else
        {
            return "nothing";
        }
    }
    
     // get all the item rows depending on a certain category
    public function getItemBy_name($name){
        $this->db->select('itemName')->like('itemName', $name);
        $query = $this->db->get('items');
        
         // returns the query as an array of objects
        if($query->num_rows()>0)
        {
            foreach ($query->result() as $row) {
            $data[] = $row; // equates the array of objects to an array variable
            }
             return $data;
        } 
        else
        {
            return "nothing";
        }
    }
    
    // inserts a new item into the items table
    public function insert_item($insert_data){
        $this->db->insert('items', $insert_data);
        return $this->db->insert_id();
    }
    
     // this function updates the new quantity into the specific item row ID
    public function update_quantity($update, $id){
       $this->db->where('itemID', $id);
       $this->db->update('items', $update);
       return $this->db->affected_rows();
    }
    
    // update the quantity depending on the item name received and approved 
    public function update_item_quantity($itemName,$update_data){
        $this->db->where('itemName',$itemName);
        $this->db->update('items', $update_data);
        return $this->db->affected_rows();
    }

    // update the item table depending on a specific item row ID
    public function update_current_item($id,$item_details){
        $this->db->where('itemID',$id);
        $this->db->update('items',$item_details);
        return $this->db->affected_rows();
        
    }
    
 /***************************************************End of Items Table Manipulation*************************************************************************************************/ 
    
 /***************************************************Material Requisition Table Manipulation***************************************************************************************/
    
    // this function inserts materials requested into the material requisition table
    public function insertMaterial($materialdata){ 
        $this->db->insert('material_requisition', $materialdata);
        return $this->db->insert_id();
    }
    
    // gets the material requisition forms that are 'not approved' for approval or rejection thtat
    // don't exist in either the approv_mat_req table and rejectd_mat_req table
    public function get_material_waiting(){ 
         
        // this query gets all records from the material_requisition, item_requisition and items which are cascading
        $query = "SELECT * FROM material_requisition,item_transaction,items WHERE material_requisition.materialReqID NOT IN(SELECT materialReqID FROM approv_mat_req 
                    UNION
                    SELECT materialReqID FROM rejectd_mat_req) AND material_requisition.transactionID = item_transaction.transactionID 
		    AND item_transaction.itemID = items.itemID ORDER BY item_transaction.date DESC";
 
        $q = $this->db->query($query);
        
        if($q->num_rows() > 0)
        {
           foreach($q->result() as $row) // returns the query result as an array of objects which is taken as the $row variable
           {
                $data[] = $row; // for each row that's generated store the data of the row in the data array variable
           }
        
           return $data;
        }
        elseif($q->num_rows() == 0)
        { 
            return $data = "nothing";
            
        }
        else
        {
            return "error";
        }
    }
    
    // this function gets the specific material requisition form that are 'waiting' for approval or rejection
    // to be displayed in a modal window 
    public function get_specificMat_waiting($id){ 
        
        $query = "SELECT * FROM material_requisition,item_transaction,items WHERE material_requisition.materialReqID = '$id' AND material_requisition.transactionID = item_transaction.transactionID 
		  AND item_transaction.itemID = items.itemID";
        
        $q = $this->db->query($query);
        if($q->num_rows() > 0)
        {
           $row = $q->row();
           return $row;
        }
    }
    
    // gets the specific material requisition form that are 'not approved' for a specific department
    public function get_waiting_mat($dept){ 
           
        $query = "SELECT * FROM material_requisition,item_transaction,items WHERE material_requisition.materialReqID NOT IN(SELECT materialReqID FROM approv_mat_req 
                    UNION
                    SELECT materialReqID FROM rejectd_mat_req) AND material_requisition.transactionID = item_transaction.transactionID 
		    AND item_transaction.itemID = items.itemID  AND material_requisition.department = '$dept' ORDER BY item_transaction.date DESC";

        $q = $this->db->query($query);
        
        if($q->num_rows() > 0)
        {
           foreach($q->result() as $row) // returns the query result as an array of objects which is taken as the $row variable
           {
                $data[] = $row; // for each row that's generated store the data of the row in the data array variable
           }
        
           return $data;
        }
        elseif($q->num_rows() == 0)
        { 
            return $data = "nothing";
            
        }
        else
        {
            return "error";
        }
    }
    
    
     // gets the specific material requisition form that are 'approved' for a specific department
     public function get_mat_App($dept){ 

         // the following query looks for all the records in the material requisition table where the its ID exists in 
         // in the approv_mat_req
         $query = "SELECT * FROM material_requisition,item_transaction,items
                  WHERE materialReqID IN(SELECT materialReqID FROM approv_mat_req) 
                  AND material_requisition.transactionID = item_transaction.transactionID 
                  AND item_transaction.itemID = items.itemID  AND material_requisition.department = '$dept' ORDER BY item_transaction.date DESC";
         
         $q = $this->db->query($query);
        
        if($q->num_rows() > 0)
        {
           foreach($q->result() as $row) // returns the query result as an array of objects which is taken as the $row variable
           {
                $data[] = $row; // for each row that's generated store the data of the row in the data array variable
           }
        
           return $data;
        }
        elseif($q->num_rows() == 0)
        { 
            return $data = "nothing";
            
        }
        else
        {
            return "error";
        }
    }
    
    public function get_mat_Rej($dept){ // gets the specific material requisition form that are 'rejected' for a specific department
      
        // the following query looks for all the records in the material requisition table where the its ID exists in 
        // in the rejectd_mat_req
        $query = "SELECT * FROM material_requisition,item_transaction,items
                  WHERE materialReqID IN(SELECT materialReqID FROM rejectd_mat_req) 
                  AND material_requisition.transactionID = item_transaction.transactionID 
                  AND item_transaction.itemID = items.itemID  AND material_requisition.department = '$dept' ORDER BY item_transaction.date DESC";
         
        $q = $this->db->query($query);
        
        if($q->num_rows() > 0)
        {
           foreach($q->result() as $row) // returns the query result as an array of objects which is taken as the $row variable
           {
                $data[] = $row; // for each row that's generated store the data of the row in the data array variable
           }
        
           return $data;
        }
        elseif($q->num_rows() == 0)
        { 
            return $data = "nothing";
            
        }
        else
        {
            return "error";
        }
    }
/********************** approve_mat_req and reject_mat_req table manipulations **************************************************************************/
    
    // this function inserts the relevant data into the approv_mat_req table
    public function insert_approv_status($insert_array){
        $this->db->insert('approv_mat_req',$insert_array);
            return $this->db->insert_id();
    }
    
    // this function inserts the relevant data into the rejectd_mat_req table
    public function insert_rej_status($insert_array){
        $this->db->insert('rejectd_mat_req', $insert_array);
             return $this->db->insert_id();
    }
    
/************************end of approve_mat_req and reject_mat_req table manipulation*******************************************************************/
    
/***************************************************End Material Requisition Table Manipulation********************************************************************************/
    
/***************************************************Purchase Requisition Table Manipulation*************************************************************************************/     
    
    // inserts data into the purchase requisition table
    public function insertPurchase($purchasedata){ 
        $this->db->insert('purchase_requisition', $purchasedata);
        return $this->db->insert_id();
    }
    
    // in the finance dashboard this function
    // gets the purchase requisition forms that are 'waiting' for approval or rejection thtat
    // don't exist in either the approv_purch_req table and rejectd_purch_req table
    public function get_purch_waiting(){ 

        
        $query = "SELECT * FROM purchase_requisition,item_transaction,items
                 WHERE purchaseReqID NOT IN(SELECT purchaseReqID FROM approv_purch_req 
                 UNION
                 SELECT purchaseReqID FROM rejectd_purch_req) AND purchase_requisition.transactionID = item_transaction.transactionID 
		 AND item_transaction.itemID = items.itemID ORDER BY item_transaction.date DESC";
  
        $q = $this->db->query($query);
        if($q->num_rows() > 0)
        {
           foreach($q->result() as $row) // returns the query result as an array of objects which is taken as the $row variable
           {
                $data[] = $row; // for each row that's generated store the data of the row in the data array variable
           }
        
           return $data;
        }
        elseif($q->num_rows() == 0)
        { 
            return $data = "nothing";
            
        }
        else
        {
            return "error";
        }
    }
    
    // this function gets the specific material requisition form that are 'waiting' for approval or rejection
    // to be displayed in a modal window 
    public function get_specificPurch_waiting($id){

        $query = "SELECT * FROM purchase_requisition,item_transaction,items WHERE purchase_requisition.purchaseReqID ='$id' 
                   AND purchase_requisition.transactionID = item_transaction.transactionID 
		   AND item_transaction.itemID = items.itemID";
        
        $q = $this->db->query($query);
        
        if($q->num_rows() > 0)
        {
           $row = $q->row();
           return $row;
        }
    }
    
    // this function gets the approved purchase requisitions, from a specific department
    public function get_purch_App(){ 

         // the following query looks for all the records in the material requisition table where the its ID exists in 
         // in the approv_purch_req
         $query = "SELECT * FROM purchase_requisition,item_transaction,items 
                  WHERE purchase_requisition.purchaseReqID IN(SELECT purchaseReqID FROM approv_purch_req) 
                  AND purchase_requisition.transactionID = item_transaction.transactionID 
                  AND item_transaction.itemID = items.itemID ORDER BY item_transaction.date DESC   ";
                 
         
        $q = $this->db->query($query);
        
        if($q->num_rows() > 0)
        {
           foreach($q->result() as $row) // returns the query result as an array of objects which is taken as the $row variable
           {
                $data[] = $row; // for each row that's generated store the data of the row in the data array variable
           }
        
           return $data;
        }
        elseif($q->num_rows() == 0)
        { 
            return $data = "nothing";
            
        }
        else
        {
            return "db error";
        }
    }
    
     // gets the specific purchase requisitions that have been 'rejected', from a specific department
     public function get_purch_Rej(){ 

        $query = "SELECT * FROM purchase_requisition,item_transaction,items WHERE purchase_requisition.purchaseReqID IN(SELECT purchaseReqID FROM rejectd_purch_req) 
                  AND purchase_requisition.transactionID = item_transaction.transactionID 
                  AND item_transaction.itemID = items.itemID ORDER BY item_transaction.date DESC   ";
         
        $q = $this->db->query($query);
        
        if($q->num_rows() > 0)
        {
           foreach($q->result() as $row) // returns the query result as an array of objects which is taken as the $row variable
           {
                $data[] = $row; // for each row that's generated store the data of the row in the data array variable
           }
        
           return $data;
        }
        elseif($q->num_rows() == 0)
        { 
            return $data = "nothing";
            
        }
        else
        {
            return "error";
        }
    }
    
    // get the supplier id that is available from the purchase requistion table
    public function get_purchSupp_id($purch_id){
        $this->db->select('supplierID')->from('purchase_requisition')->where('purchaseReqID', $purch_id);
        $query = $this->db->get();
        if($query->num_rows()>0)
        {
            $row = $query->row();
            return $row->supplierID; 	
        }
        
    }
    
    // use the approved request table to get values from the purchase requisition table
    public function get_specifcPurchApp($id){
        $this->db->select('*')->from('approv_purch_req, purchase_requisition');
        $this->db->where('approv_purch_req.purchaseReqID', $id);
        $this->db->where('purchase_requisition.purchaseReqID', $id);
        $query = $this->db->get();
        
        $row = $query->row();
        return $row;
        
    }
    
    // get the specific purchase approved that is to be showed in the lpo modal
     public function get_purch_for_lpo($id){
//        $this->db->where('purchaseReqID', $id);
//        $query = $this->db->get('purchase_requisition');
          $query = "SELECT * FROM purchase_requisition,item_transaction,items WHERE purchase_requisition.purchaseReqID = '$id'
                  AND purchase_requisition.transactionID = item_transaction.transactionID 
                  AND item_transaction.itemID = items.itemID ORDER BY item_transaction.date DESC";
          
          $query = $this->db->query($query);
          
        if($query->num_rows() == 1)
        {
            $row = $query->row();
            return $row;
        }
        
    }
    
     // gets the specific approved purchase requisition depending on the type of supplier
     public function getLpo_from_supp($supplierID){
         //$query = "SELECT * FROM purchase_requisition, approv_purch_req WHERE supplierID = '$supplierID' AND purchase_requisition.purchaseReqID = approv_purch_req.purchaseReqID";
        
        $query = "SELECT * FROM purchase_requisition, approv_purch_req,item_transaction,items WHERE supplierID = '$supplierID' AND purchase_requisition.purchaseReqID = approv_purch_req.purchaseReqID
                 AND purchase_requisition.transactionID = item_transaction.transactionID 
                 AND item_transaction.itemID = items.itemID ORDER BY item_transaction.date DESC";
        
        $q = $this->db->query($query);
        
         if($q->num_rows() > 0)
         {
           foreach($q->result() as $row) // returns the query result as an array of objects which is taken as the $row variable
           {
                $data[] = $row; // for each row that's generated store the data of the row in the data array variable
           }
        
           return $data;
        }
        elseif($q->num_rows() == 0)
        { 
            return $data = "nothing";
            
        }
        else
        {
            return "db error";
        }
    }
 
    public function get_order_no(){
        
    }
            
    /********************** approve_purch_req and reject_purch_req table manipulations **************************************************************************/
      // this function inserts the relevant data into the approv_mat_req table
    public function insert_purchApprov_status($insert_array){
        $this->db->insert('approv_purch_req',$insert_array);
            return $this->db->insert_id();
    }
    
    // gets last purch_approvID from the approve_purch_req table depending on the order number
    public function get_purchApprovID($order_no){
        $query = "SELECT purch_approvID FROM approv_purch_req WHERE purchaseReqID = 
                 (SELECT purchaseReqID FROM purchase_requisition WHERE order_no = '$order_no')";

        $q = $this->db->query($query);
        
        if ($q->num_rows() > 0)
        {
            $row = $q->row(); 
        }
        
        return $row->purch_approvID;
    }
        
    // this function inserts the relevant data into the rejectd_mat_req table
    public function insert_purchRej_status($insert_array){
        $this->db->insert('rejectd_purch_req', $insert_array);
        return $this->db->insert_id();
    }
    
     /******************end of approve_purch_req and reject_purch_req table manipulations **********************************************************************/
    
/***************************************************End Purchase Requisition Table Manipulation*******************************************************************************/     
    
    
/***************************************************Supplier Table Manipulation*******************************************************************************************************/ 
    
    // gets all the supplier id and supplier names available in the database
    public function get_supplier_det(){
        $this->db->select('supplierID, supplierName')->from('supplier');
        $query = $this->db->get();
        
        // returns the query as an array of objects
        if($query->num_rows()>0)
        {
            foreach ($query->result() as $row) {
            $data[] = $row; // equates the array of objects to an array variable
            }
        }
        return $data; 
    }
    
    // gets the specific supplier id from a give supplier name
    public function get_supplier_id($supplierName){
        $this->db->select('supplierID')->from('supplier')->where('supplierName', $supplierName);
        $query = $this->db->get();
        if($query->num_rows()>0)
        {
            $row = $query->row();
            return $row->supplierID; 	
        }
 
    }
    
    // get the specific supplier details that is found in the supplier table
    public function get_supplier_data($id){
        $this->db->where('supplierID', $id);
        $query = $this->db->get('supplier');
        if($query->num_rows() == 1)
        {
            $row = $query->row();
            return $row;
        }
    }
    
    // get the specific supplier details that is found in the supplier table depending on the purchase requisition ID
    public function getSup_from_lpo($id){
        
        $query = "SELECT * FROM supplier WHERE supplierID = (SELECT supplierID FROM purchase_requisition
                  WHERE purchaseReqID = '$id')";
        
        $q = $this->db->query($query);
        
        if($q->num_rows() == 1)
        {
            $row = $q->row();
            return $row;
        }
    }
    
    // get all the data that is related to the supplier
    public function get_all_supp_details(){
         $query = $this->db->get('supplier');
        
        // returns the query as an array of objects
        if($query->num_rows()>0)
        {
            foreach ($query->result() as $row) {
                $data[] = $row; // equates the array of objects to an array variable
            }
            return $data; 
        }
        else
        {
            return "nothing";
        }
       
    }
    
    public function getSupplierBy_status($status){
        $this->db->where('status', $status);
        $query = $this->db->get('supplier');
        
         // returns the query as an array of objects
        if($query->num_rows()>0)
        {
            foreach ($query->result() as $row) {
                $data[] = $row; // equates the array of objects to an array variable
            }
            return $data; 
        }
        else
        {
            return "nothing";
        }
    }
    
      // get all the item rows depending on a certain category
    public function getSupplierBy_name($name){
        $this->db->select('supplierName')->like('supplierName', $name);
        $query = $this->db->get('supplier');
        
         // returns the query as an array of objects
        if($query->num_rows()>0)
        {
            foreach ($query->result() as $row) {
            $data[] = $row; // equates the array of objects to an array variable
            }
             return $data;
        } 
        else
        {
            return "nothing";
        }
    }
    
    // gets all the supplier details depending on their name or related name
    public function getSupplier_Details_By_name($name){
        $this->db->where('supplierName', $name);
        $query = $this->db->get('supplier');
        
         // returns the query as an array of objects
        if($query->num_rows()>0)
        {
            foreach ($query->result() as $row) {
            $data[] = $row; // equates the array of objects to an array variable
            }
             return $data;
        } 
        else
        {
            return "nothing";
        }
    }


        // insert new supplier details
     public function insert_new_supplier($insert_data){
         $this->db->insert('supplier',$insert_data);
          return $this->db->insert_id();
     }
     
     // update the specific supplier's data depending on the specific supplierID
     public function update_supplier_details($id,$update_data){
         $this->db->where('supplierID',$id);
         $this->db->update('supplier',$update_data);
         return $this->db->affected_rows();
         
     }
///***************************************************End Supplier Table Manipulation************************************************************************************************/

//***************************************************receive note table Manipulation************************************************************************************************/

    // gets the last inserted receive note ID
    public function get_last_receiveID($id){
        $this->db->select('receiveID')->from('receive_note')->where('receiveID', $id);
        $q = $this->db->get();
        
        if ($q->num_rows() > 0)
        {
            $row = $q->row(); 
        }
        
        return $row->receiveID;
    }
    
    // gets all the return note details as well as their respective details
    public function get_all_returnNotes()
    {
        $query = "SELECT * FROM receive_note,approv_purch_req,purchase_requisition,supplier,item_transaction,items 
            WHERE receive_note.purch_approvID = approv_purch_req.purch_approvID 
            AND approv_purch_req.purchaseReqID = purchase_requisition.purchaseReqID AND purchase_requisition.supplierID = supplier.supplierID
            AND purchase_requisition.transactionID = item_transaction.transactionID AND item_transaction.itemID = items.itemID ORDER BY receive_note.date_received";
        
        $query = $this->db->query($query);
        if($query->num_rows>0)
        {
            foreach($query->result() as $row){
                $data[] = $row;
            }
            return $data;
        }
        elseif($q->num_rows() == 0)
        { 
            return $data = "nothing";
            
        }
        else
        {
            return "error";
        }
        
    }
    
    
    // inserts data into the receive note table  
    public function insert_into_receive($insert_array){
        $this->db->insert('receive_note', $insert_array);
        return $this->db->insert_id();
    }
    
    

//***************************************************End receive note table Manipulation************************************************************************************************/

    
//***************************************************return note table Manipulation************************************************************************************************/

    // inserts data into the return note table
    public function insert_return($data){
        $this->db->insert('return_note', $data);
        return $this->db->insert_id();
    }
    
    public function get_returnNote_details()
    {
        $query = "SELECT * FROM return_note,receive_note,approv_purch_req,purchase_requisition,supplier,item_transaction,items 
                WHERE return_note.receiveID = receive_note.receiveID AND receive_note.purch_approvID = approv_purch_req.purch_approvID 
                AND approv_purch_req.purchaseReqID = purchase_requisition.purchaseReqID AND purchase_requisition.supplierID = supplier.supplierID
                AND purchase_requisition.transactionID = item_transaction.transactionID AND item_transaction.itemID = items.itemID";
        
        $query = $this->db->query($query);
        if($query->num_rows>0)
        {
            foreach($query->result() as $row){
                $data[] = $row;
            }
            return $data;
        }
        elseif($query->num_rows() == 0)
        { 
            return $data = "nothing";
            
        }
        else
        {
            return "error";
        }
        
    }
    
     // gets a specific return note depending on the returnID
    public function get_specific_returnNote($id){
        $query = "SELECT * FROM return_note,receive_note,approv_purch_req,purchase_requisition,supplier,item_transaction,items 
                WHERE  return_note.returnID = '$id' AND return_note.receiveID = receive_note.receiveID AND receive_note.purch_approvID = approv_purch_req.purch_approvID 
                AND approv_purch_req.purchaseReqID = purchase_requisition.purchaseReqID AND purchase_requisition.supplierID = supplier.supplierID
                AND purchase_requisition.transactionID = item_transaction.transactionID AND item_transaction.itemID = items.itemID";
        
        $query = $this->db->query($query);
        if ($query->num_rows() > 0)
        {
            $row = $query->row(); 
        }
        
        return $row;
    }
    
    // get the return note depending on the supplier
    public function get_returnSupplier($suppID){
        $query = "SELECT * FROM return_note,receive_note,approv_purch_req,purchase_requisition,supplier,item_transaction,items 
                WHERE purchase_requisition.supplierID = '$suppID' AND  return_note.receiveID = receive_note.receiveID 
                AND receive_note.purch_approvID = approv_purch_req.purch_approvID AND approv_purch_req.purchaseReqID = purchase_requisition.purchaseReqID 
                AND purchase_requisition.supplierID = supplier.supplierID AND purchase_requisition.transactionID = item_transaction.transactionID 
                AND item_transaction.itemID = items.itemID";

        $query = $this->db->query($query);
        if($query->num_rows>0)
        {
            foreach($query->result() as $row){
                $data[] = $row;
            }
            return $data;
        }
        elseif($query->num_rows() == 0)
        { 
            return $data = "nothing";
            
        }
        else
        {
            return "error";
        }
    }
    
//***************************************************End return note table Manipulation************************************************************************************************/

}

/***********end of file*********/
