<p class="dash_head header_info">
    view receive note
</p>


<div id="edit">

    <div class="alert alert-info" style="margin: 10px 20px 30px 20px;">  
        <div><i class="icon-exclamation-sign" style="float:left; margin-right: 8px;"></i></div>
        <p>View the receive note details. Search for a receive note, by searching through the date received, name of item, supplier etc </p>
    </div> 

    <div class="table_header user tb-header-custom">
        <div>
            <p><span class="" type="button" id="refresh_user_table" title="refresh table"> <i class="icon-reorder"></i></span>Receive Note Details</p>
        </div>

    </div>
    
    <div id="edit_ui" class="proc_content">
        <div class="receive_details">
            <table id="receive_details" class="table table-stripped table-hover datatable dashboard_table data_grid">
                <thead class="tb-header-custom">
                    <tr>
                        <th></th>
                        <th>Order No</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Unit Price(Ksh.)</th>
                        <th>Total</th>
                        <th>Date Received</th>
                        <th>Received From</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if ($receive_note != "nothing"): ?>
                        <?php $count = 0; // initialize a variable and set it to 0 ?> 
                        <?php foreach ($receive_note as $r): // for each row data asign it to the variable $d ?>
                            <?php $count++; // increment the count variable ?>
                            <tr id="row_<?php echo $r->receiveID; ?>">
                                <td class="row_num"><?php echo $count; // let the count variable shows the number of the table row   ?></td>
                                <td><?php echo $r->order_no; ?></td>
                                <td><?php echo $r->itemName; ?></td>
                                <td><?php echo $r->itemDescription; ?></td>
                                <td><?php echo $r->quantity_received; ?></td>
                                <td><?php echo $r->pricePerUnit . ".00"; ?></td>
                                <?php $total = $r->quantity_received * $r->pricePerUnit; ?>
                                <td><?php echo $total . ".00"; ?></td>
                                <?php  $date = strftime("%b %d %Y",strtotime($r->date_received));?>
                                <td><?php echo $date; ?></td>
                                <td><?php echo $r->supplierName; ?></td>
            <!--                    <td><a href="#" title="save" rel="save_return" id="<?php echo $d->returnID; ?>" class="btn btn-small"><i class="cus-disk"></i></a></td>-->
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr id="empty_row"><td>No new requisitions made</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>