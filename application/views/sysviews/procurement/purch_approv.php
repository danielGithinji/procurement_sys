<table id="purchApprov" class="table table-stripped table-hover datatable dashboard_table data_grid1">
    <caption class="view_tables tb-header-custom">
        <h5>Approved Purchase Requisitions</h5>
    </caption>
    <thead class="tb-header-custom" >
        <tr>
            <th></th>
            <th>Name</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Price Per Unit</th>
            <th>Date Created</th>
            <th>Order Number</th>
        </tr>
    </thead>
  
    <tbody>
       
        <?php if($approved != "nothing"): ?>
            <?php $count = 0; // initialize a variable and set it to 0 ?> 
            <?php foreach($approved as $d): // for each row data asign it to the variable $d ?>
                <?php $count++; // increment the count variable ?>
                <tr id="row_<?php echo $d->purchaseReqID; ?>">
                    <td class="row_num"><?php echo $count; // let the count variable shows the number of the table row ?></td>
                    <td><?php echo $d->itemName; ?></td>
                   <td><?php echo $d->itemDescription; ?></td>
                    <td><?php echo $d->quantity_ordered; ?></td>
                    <td><?php echo $d->pricePerUnit; ?></td>
                    <?php  $date = strftime("%b %d %Y",strtotime($d->date));?>
                    <td><?php echo $date; ?></td>
                    <td><?php echo $d->order_no; ?></td>
<!--                    <td><a href="#lpo" title="Create LPO"  rel="lpo_modal" id="<?php echo $d->purchaseReqID; ?>"><i class="cus-application_form_edit"></i></a></td>-->
                </tr>
                <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<!-------------------------------Modal Window------------------------------------------------->
      
       <div id="lpo" class="modal hide fade modalDim1 property">
			<div class="modal-header" style=" border-bottom: 0px;">
				<a class="close" data-dismiss="modal">&times;</a>
				<h3>Local Purchase Order</h3>  
			</div>
			<div class="modal-body" id="">
                            <table id="lpo_data" class="table table-bordered">
                                <thead>
                                    <tr>
                                        
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Quantity</th>
                                        <th>Price Per Unit (Ksh.)</th>
                                        <th>Total Cost (Ksh.)</th>
     
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>	
                              
			</div>
                    
			<div class="modal-footer">
                           
                             <a href="#" class="btn btn-inverse" id="lpo_mail" ><i class="icon-envelope-alt"></i> Mail</a>
                             <a href="#" class="btn" data-dismiss="modal">Close</a>
			</div>
        </div>
<!-------------------------------End Modal Window------------------------------------------------->