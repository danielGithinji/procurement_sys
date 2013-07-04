<p class="dash_head header_info">
     edit supplier's data
</p>

<div id="edit" class="su_table">

    <div class="alert alert-info" style="margin: 10px 20px 30px 20px;">  
        <i class="icon-exclamation-sign" style="float:left; margin-right: 8px;"></i>
        <p>Manage suppliers by editing and updating their  data. You are also able to add a new supplier to the system </p>
    </div> 
    
    <div class="table_header user supp_size tb-header-custom">
       <div>
              <p><button class="btn" type="button" id="refresh_supplier_table" title="refresh table"> <i class="icon-refresh"></i></button> Manage Suppliers</p>
        </div>
        
<!--        <div class="input-append new_search" >
          <input  type="text" placeholder="Search By Supplier Name" id="supplier_typeahead" data-provide="typeahead">
        </div>-->
    </div>
    
    <div id="edit_ui" class="new_size">
         <?php $this->load->view('sysviews/admin/edit_supp_filter') ?>
    </div>
</div>

<!------------------------------- add/update user details Modal Window----------------------------------------------->

<div id="edit_form" class="modal hide property edit_form supp_modal">

    <div class="modal-header ">
        <a class="close" data-dismiss="modal">&times;</a>
        <h3>Add New User</h3>  
    </div>
    
    <div class="modal-body" >

        <label>Supplier Name:</label>
        <input type="text" name="supplierName"/>

        <label>Location:</label>
        <input type="text" name="supplierLocation">

        <label>Items Supplied:</label>
        <input type="text" name="itemsSupplied">

        <label>Telephone:</label>
        <input type="text" name="phone_no"/>

      
        <label>Email:</label>
        <input type="text" name="email">

        <label>Date:</label>
        <input type="text" name="date" id="date" disabled/>


        <label>Status:</label>
        <select name="status">
            <option value="selected" selected="selected">Select a status</option> 
            <option value="available">Available</option>
            <option value="suspended">Suspended</option>
        </select>

    </div>
    <div class="modal-footer">
        
        <div id="confirm_supp" class="alert alert-info  alert_modal hide">  

              <i class="icon-spinner icon-large icon-spin"></i> Submitting Data..
         </div>
        
        <a href="#" class="btn btn-small" data-dismiss="modal" >Cancel</a>
        <a href="#" id="update_supp" class="btn btn-inverse btn-small"><i class="cus-database_edit"></i> Update Supplier</a>
        <a href="#" id="add_supp" class="btn btn-inverse btn-small"><i class="cus-database_save"></i> Add Supplier</a>
    </div>
</div>

<!-------------------------------end of add/update user details Modal Window------------------------------------------>

<!-------------------------------confirmation message details Modal Window--------------------------------------------->
      
       <div id="user_message" class="modal hide message" style="position: absolute; top: 150px; left: 850px;">
                     
        		<div class="modal-body">
                            
                         <div class="message_content" style="margin-bottom: 5px;"></div>
                            
		      </div>
                    <div class="modal-footer">
                        <a href="#" class="btn" data-dismiss="modal" style="float: right;">OK</a>
                    </div>
        </div>
<!-------------------------------end confirmation message details Modal Window------------------------------------------>

<!-------------------------------error message Modal Window----------------------------------------------------------->
<div id="user_error_message" class="modal hide error_message" style="position: absolute; top: 60px; left: 830px;">
                     
        		<div class="modal-body">
                         <div class="message_error_content" 
                              style="margin-bottom: 5px; background-color: #feb7ba; border-radius: 3px; padding: 4px;color: #cc0008;">                             
                         </div>
		      </div>
                    <div class="modal-footer">
                        <a href="#" class="btn" data-dismiss="modal" style="float: right;">OK</a>
                    </div>
</div>
<!-------------------------------end of error message Modal Window-------------------------------------------------->