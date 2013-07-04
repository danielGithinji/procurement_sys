<p class="dash_head header_info">
   Material Requisition Form
</p>

<div class="alert alert-info" style="margin: 10px 20px 30px 50px; width:800px;">  
    <i class="icon-exclamation-sign" style=""></i>
    <p>  In order to create a material requisition form then please fill out the form above
    and <b>do not</b> leave any field empty before submitting.</p>
</div> 

<div class="out_form">
    <p class="head6 tb-header-custom">Fill out the form below</p>
    <div class=" proc_form">
        <form id="mat_items" >
            <label>Name</label>
            <select id="matItem_det" name="itemName">
                <option selected>Select an item</option>
                <?php foreach ($items as $t): ?>
                    <option value="<?php echo $t->itemName; ?>" id="<?php echo $t->itemID; ?>"> <?php echo $t->itemName; ?> </option>
                <?php endforeach; ?>
            </select>
            <label>Description</label><input type="text" name="description" disabled="true" />
            <label>Quantity</label><input type="text" name="quantity"/>
            <label>Date</label><input type="text" name="date" id="datepicker" disabled="true"/> 
            <div class="clear"></div>
            <button id="mat_submit_req" class="btn btn-small btn-success">Submit</button>
            
            <div id="alert_show_mat" class="alert alert-success hide" style="margin-top: 10px;">  

                <i class="icon-spinner icon-large icon-spin"></i> Submitting Data..
            </div>
            
        </form>
    </div>
</div>

<!-------------------------------Modal Window------------------------------------------------->
      
       <div id="matReq_message" class="modal hide message" style="position: absolute; top: 150px; left: 800px;">
                     
        		<div class="modal-body">
                            
                            <div class="message_content">
                                <p><i class="cus-accept"></i>Request Submitted</p>
                            </div>
                         <a href="#" class="btn" data-dismiss="modal" style="float: right;">OK</a>
			</div>
        </div>
<!-------------------------------End Modal Window------------------------------------------------->

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
<div id="user_error_message" class="modal hide error_message" style="position: fixed; top: 150px; left: 850px;">
                     
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
    
