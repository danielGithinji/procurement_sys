<p class="dash_head header_info">
     view item quantity in the store
</p>


<div id="edit">

    <div class="alert alert-info" style="margin: 10px 20px 30px 20px;">  
        <div><i class="icon-exclamation-sign" style="float:left; margin-right: 8px;"></i></div>
        <p>Create a Purchase Requisition by clicking the  " <i class="icon-wrench"></i> "  button. </p>
    </div> 

    <div class="table_header user tb-header-custom">
        <div>
            <p><span class="" type="button" id="refresh_user_table" title="refresh table"> <i class="icon-reorder"></i></span>Receive Note Details</p>
        </div>

    </div>

    <div id="edit_ui" class="item_content">
        <div id="lpo_table">
            <table id="edit_item_data" class="table datatable dashboard_table data_grid">
             <!--    <caption><h4>User Management</h4></caption>-->
                <thead class="tb-header-custom">
                    <tr>
                        <th></th>
                        <th>Item Name</th>
                        <th>Description</th>
                        <th>Unit Price</th>
                        <th>Quantity</th>
                        <th class="head_link">Action</th>
            <!--            <th class="head_link">
                            <a href="#" class="btn btn-info btn-small" style="" rel="add_item"><i class=" cus-add"></i> Add Item</a>
                        </th>-->
                    </tr>
                </thead>

                <tbody>

                    <?php if ($items != "nothing"): ?>
                        <?php $count = 0; // initialize a variable and set it to 0 ?> 
                        <?php foreach ($items as $item): // for each row data asign it to the variable $d ?>
                            <?php if ($item->quantity < $item->quantity_limit): ?>
                                <?php $count++; // increment the count variable ?>
                                <tr class="error_row" title="quantity below limit !" style="background: #fbcac5;">
                                    <th class="row_num" ><?php echo $count; // let the count variable shows the number of the table row      ?></th>
                                    <td><?php echo $item->itemName ?></td>
                                    <td><?php echo $item->itemDescription ?></td>
                                    <td><?php echo $item->pricePerUnit; ?></td>
                                    <td><?php echo $item->quantity; ?></td>
                                    <td id="alink">                      
                                        <a href="#" title="create requisition"  rel="purchReq_modal" id="<?php echo $item->itemID; ?>" class="btn btn-small"><i class="icon-wrench"></i></a>
                                    </td>

                                </tr>
                            <?php else: ?>
                                <?php $count++; // increment the count variable ?>
                                <tr style="background:#fbfcfd;">
                                    <th ><?php echo $count; // let the count variable shows the number of the table row      ?></th>
                                    <td><?php echo $item->itemName ?></td>
                                    <td><?php echo $item->itemDescription ?></td>
                                    <td><?php echo $item->pricePerUnit; ?></td>
                                    <td><?php echo $item->quantity; ?></td>
                                    <td id="alink">no action</td>

                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-------------------------------Modal Window---------------------------------------------------------------------------------->
<div id="purch_items" class="modal hide property edit_form purch_items">

    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h3>Create Purchase Requisition</h3>  
    </div>
    
    <div class="modal-body" >
        
    <label>Item Name: </label>
    <input type="text" name="itemName" disabled="true"/>
    
<!--    <select id="item_det" name="itemName">
        <option selected>Select an item</option>
        <?php foreach ($items as $t): ?>
            <option value="<?php echo $t->itemName; ?>" id="<?php echo $t->itemID; ?>"> <?php echo $t->itemName; ?> </option>
        <?php endforeach; ?>
    </select>-->
    
    <label>Description:</label>
    <input type="text" name="description" disabled="true"/>
    
    <label>Unit Price(Ksh.):</label>
    <input type="text" name="price" disabled="true"/>
    
    <label>Quantity:</label>
    <input type="text" name="quantity"/>
    
    <label>Supplier:</label>
    <select id="supplier_det" name="supplier_det">
        <option selected>Select a supplier</option>
        <?php foreach ($supplier as $s): ?>
            <option value="<?php echo $s->supplierName; ?>"> <?php echo $s->supplierName; ?> </option>
        <?php endforeach; ?>
    </select>
    
    <label>Date:</label>
    <input type="text" name="date" id="datepicker" disabled/> 
    
    </div>
    <div class="modal-footer">
        
        <div id="confirm" class="alert alert-info  alert_modal hide">  

              <i class="icon-spinner icon-large icon-spin"></i> Submitting Data..
         </div>
        
        <a href="#" class="btn btn-small" data-dismiss="modal" >Cancel</a>
        <a href="#"  id="submit_purch_requisition" class="btn btn-inverse btn-small "><i class="cus-database_edit"></i> Submit Requisition</a>
    </div>
</div>
<!-------------------------------Modal Window---------------------------------------------------------------------------------->

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
<!-------------------------------end of error message Modal Window-------------------------------------------------->

