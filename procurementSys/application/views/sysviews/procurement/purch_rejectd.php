<table id="purchRej" class="table table-stripped table-hover datatable dashboard_table data_grid1">
    <caption class="view_tables tb-header-custom"><h5>Rejected Purchase Requisitions</h5></caption>
    <thead class="tb-header-custom">
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
       
        <?php if($rejected != "nothing"): ?>
            <?php $count = 0; // initialize a variable and set it to 0 ?> 
            <?php foreach($rejected as $d): // for each row data asign it to the variable $d ?>
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
                </tr>
                <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>