<p class="dash_head header_info">
     edit, create and update items
</p>

<div id="edit">

    <div class="alert alert-info" style="margin: 10px 20px 30px 20px;">  
        <i class="icon-exclamation-sign"></i>
        <p>Manage items by editing and updating each items data. You are also able to add a new item to the system and or a new category</p>
    </div> 
    
    <div class="table_header user tb-header-custom">
         <div>
              <p><button class="btn" type="button" id="refresh_items_table" title="refresh table"> <i class="icon-refresh"></i></button> Manage Items</p>
        </div>
        
<!--         <div class="input-append new_search">
          <input type="text" placeholder="Search By Item Name" id="item_typeahead" data-provide="typeahead" >
        </div>-->
    </div>
    
    <div id="edit_ui" class="item_ui">
        <?php $this->load->view('sysviews/admin/edit_itemCat_list'); ?>
    </div>
</div>


<!-------------------------------add/edit category modal window--------------------------------------------------------------->

<div id="add_edit_category" class="modal hide message" style="">
                     
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h3>Add New User</h3>  
    </div>
    <div class="modal-body">
      
    </div>
    <div class="modal-footer">
        
        <div id="confirmation" class="alert alert-info  alert_modal hide">  

              <i class="icon-spinner icon-large icon-spin"></i> Submitting Data..
         </div>
        
        <a href="#" id="add_new_category" class="btn btn-small btn-inverse"  style="float: right;"><i class="cus-database_save"></i> Add Category</a>
        <a href="#" id="update_category" class="btn btn-small btn-inverse"  style="float: right;"><i class="cus-database_edit"></i> Update Categories</a>
    </div>
    
</div>
<!-------------------------------End add/edit category modal window--------------------------------------------------------------->

<!-------------------------------Message Modal Window------------------------------------------------------------------>
      
       <div id="user_message" class="modal hide message" style="position: absolute; top: 150px; left: 850px;">
                     
        		<div class="modal-body">
                            
                         <div class="message_content" style="margin-bottom: 5px;" ></div>
                            
		      </div>
                    <div class="modal-footer">
                        <a href="#" class="btn" data-dismiss="modal" style="float: right;">OK</a>
                    </div>
        </div>

          <div id="user_error_message" class="modal hide error_message" style="position: absolute; top: 90px; left: 850px;">
                     
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

