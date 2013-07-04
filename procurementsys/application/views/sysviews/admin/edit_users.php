<p class="dash_head header_info">
     edit users personal data
</p>

<div id="edit">

    <div class="alert alert-info" style="margin: 10px 20px 30px 20px;">  
        <i class="icon-exclamation-sign" style="float:left; margin-right: 8px;"></i>
        <p>Manage users by editing and updating their personal data. You are also able to add a new user to the system </p>
    </div> 
    
    <div class="table_header user tb-header-custom">
        <div>
              <p><button class="btn" type="button" id="refresh_user_table" title="refresh table"> <i class="icon-refresh"></i></button> Manage Users</p>
        </div>
   
<!--        <div class="input-append new_search" >
          <input  type="text" placeholder="Search By First Name" id="user_typeahead" data-provide="typeahead">
        </div>-->
  
    </div>
    
    <div id="edit_ui">
        
         <?php $this->load->view('sysviews/admin/edit_user_filter'); ?>
    </div>
</div>

<!------------------------------- add/update user details Modal Window----------------------------------------------->

<div id="edit_form" class="modal hide property edit_form">
    
    <form id="edit_form1">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h3>Add New User</h3>  
    </div>
    
    <div class="modal-body" >

        <label>First Name:</label>
        <input type="text" name="firstName"/>

        <label>Second Name:</label>
        <input type="text" name="secondName">

        <label>Username:</label>
        <input type="text" name="username">

        <label>DOB:</label>
        <input type="text" name="dob" class="date" id="date" disabled "/>

        <label>Department:</label>
        <select name="department" selected="selected">
            <option value="selected">Select A Department</option>
            <option value="maths and informatics">Maths and Informatics</option>
            <option value="procurement">Procurement</option>
            <option value="finance">Finance</option>
        </select>

        <label>Role:</label>
        <input type="text" name="role">

        <label>National ID:</label>
        <input type="text" name="national_id">

        <label>Gender:</label>
        <select name="gender">
            <option value="selected"  selected="selected">Select a gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>

        <label>Email:</label>
        <input type="text" name="email">

        <label>Status:</label>
        <select name="user_status">
            <option value="selected" selected="selected">Select a status</option> 
            <option value="active">Active</option>
            <option value="leave">Leave</option>
            <option value="suspended">Suspended</option>
        </select>

    </div>
    <div class="modal-footer">
        
        <div id="confirm_user" class="alert alert-info  alert_modal hide">  

              <i class="icon-spinner icon-large icon-spin"></i> Submitting Data..
         </div>
        
        <a href="#" class="btn btn-small" data-dismiss="modal" >Cancel</a>
        <a href="#" id="update_user" class="btn btn-inverse btn-small" ><i class="cus-database_edit"></i> Update Item</a>
        <a href="#" id="add_user" class="btn btn-inverse btn-small" ><i class="cus-database_save"></i> Add User</a>
    </div>
    </form>
</div>

<!-------------------------------end of add/update user details Modal Window------------------------------------------>

<!-------------------------------view user details Modal Window------------------------------------------------------->

<div id="user_form_details" class="modal hide property ">

    <div class="modal-header" >
        <a class="close" data-dismiss="modal">&times;</a>
        <h3>User Details</h3>  
    </div>
    
    <div class="modal-body" >
        <table class="table table-bordered">
            
        </table>

    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-small" data-dismiss="modal" >Cancel</a>
    </div>
</div>

<!-------------------------------end of view user details Modal Window------------------------------------------------->

<!-------------------------------Message Modal Window------------------------------------------------------------------>
      
       <div id="user_message" class="modal hide message" style="position: absolute; top: 150px; left: 850px;">
                     
        		<div class="modal-body">
                            
                         <div class="message_content" style="margin-bottom: 5px;"></div>
                            
		      </div>
                    <div class="modal-footer">
                        <a href="#" class="btn" data-dismiss="modal" style="float: right;">OK</a>
                    </div>
        </div>

          <div id="user_error_message" class="modal hide error_message" style="position: absolute; top: 30px; left: 850px;">
                     
        		<div class="modal-body">
                            
                         <div class="message_error_content" 
                              style="margin-bottom: 5px; background-color: #feb7ba; border-radius: 3px; padding: 4px;color: #cc0008;">
                             
                         </div>
                            
		      </div>
                    <div class="modal-footer">
                        <a href="#" class="btn" data-dismiss="modal" style="float: right;">OK</a>
                    </div>
        </div>
<!-------------------------------End Message Modal Window--------------------------------------------------------------->

