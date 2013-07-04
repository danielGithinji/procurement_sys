<div id="lpo_table">
    <table id="lpo_page" class="table table-stripped table-hover datatable dashboard_table lpo_data_grid">
        <thead class="tb-header-custom">
            <tr>
                <th></th>
                <th>Name</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Date Created</th>
                <th>Create LPO</th>
            </tr>
        </thead>

        <tbody style="border: 1px solid black;">

            <?php if ($lpo != "nothing"): ?>
                <?php $count = 0; // initialize a variable and set it to 0 ?> 
                <?php foreach ($lpo as $l): // for each row data asign it to the variable $d ?>
                    <?php $count++; // increment the count variable ?>
                    <tr id="row_<?php echo $l->purchaseReqID; ?>">
                        <td class="row_num"><?php echo $count; // let the count variable shows the number of the table row  ?></td>
                        <td><?php echo $l->itemName; ?></td>
                        <td><?php echo $l->itemDescription; ?></td>
                        <td><?php echo $l->quantity_ordered; ?></td>
                        <td><?php echo $l->pricePerUnit; ?></td>
                        <?php  $date = strftime("%b %d %Y",strtotime($l->date));?>
                        <td><?php echo $date; ?></td>
                        <td id="alink"><a href="#lpo" title="Create LPO"  rel="lpo_modal" id="<?php echo $l->purchaseReqID; ?>" class="btn btn-small"><i class="cus-application_form_edit"></i></a></td>
                    </tr>
                <?php endforeach; ?>
            
            <?php endif; ?>
        </tbody>
    </table>   
</div>
 

<!-------------------------------Modal Window------------------------------------------------->
      
       <div id="lpo" class="modal hide modalDim1 property">
			<div class="modal-header" style=" border-bottom: 0px; margin-bottom: 10px;">
                            <a href="#" class="btn btn-inverse" id="lpo_mail" ><i class="icon-envelope-alt"></i> Email to supplier</a>
                            <a href="#" class="btn btn-inverse" id="lpo_Bulkmail" style="display:none"><i class="icon-envelope-alt"></i> Email to supplier</a>
                            <a href="#" class="btn close" data-dismiss="modal" title="close window"><i class="icon-remove"></i></a> 
			</div>
                     <div class="modal-header" style=" border-bottom: 0px; ">
<!--				<a class="close" data-dismiss="modal">&times;</a>-->
				<h3> Local Purchase Order</h3>
			</div>
           
			<div class="modal-body" id="">
                            
                            <div>
                                <h5>Supplier Details</h5>
                                <table id="supplier_det_table" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Supplier Name</th>
                                            <th>Supplier Email</th>
                                        </tr>

                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <hr>
                            <div>
                                <h5>LPO Details</h5>
                                <table id="lpo_data" class="table table-bordered">
                                <thead>
                                    <tr>
                                        
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Quantity</th>
                                        <th>Price Per Unit (Ksh.)</th>
                                        <th>Total Cost (Ksh.)</th>
<!--                                        <th>Email</th>-->
     
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>	
                            </div>
                           
                              
			</div>
                    
			<div class="modal-footer" style="background-color: #fff; height: 10px;">
                           <span id="alert_msg"></span>
<!--                             <a href="#" class="btn btn-inverse" id="lpo_mail" ><i class="icon-envelope-alt"></i> Mail</a>
                             <a href="#" class="btn btn-inverse" id="lpo_Bulkmail" style="display:none"><i class="icon-envelope-alt"></i> Mail</a>
                             <a href="#" class="btn" data-dismiss="modal">Close</a>-->
			</div>
        </div>
<!-------------------------------End Modal Window------------------------------------------------->

<!-------------------------------Message Modal Window------------------------------------------------->
      
       <div id="email_msg" class="modal hide message" style="position: absolute; top: 150px; left: 800px;">
                     
        		<div class="modal-body">
                            
                         <div class="message_content" style="margin-bottom: 5px;"></div>
                            
		      </div>
                    <div class="modal-footer">
                        <a href="#" class="btn" data-dismiss="modal" style="float: right;">OK</a>
                    </div>
        </div>
<!-------------------------------End Message Modal Window------------------------------------------------->