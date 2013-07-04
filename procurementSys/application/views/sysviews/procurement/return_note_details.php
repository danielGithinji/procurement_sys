<div class="return_note_det">
    <table id="return_details" class="table table-stripped table-hover datatable dashboard_table lpo_data_grid">
    <!--    <caption><h4>Material Requisition Awaiting Approval</h4></caption>-->
        <thead class="tb-header-custom">
            <tr>
                <th></th>
                <th>Name</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Unit Price(Ksh.)</th>
                <th>Total</th>
                <th>Date</th>
                <th>Return To</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>

            <?php if ($returns != "nothing"): ?>
                <?php $count = 0; // initialize a variable and set it to 0 ?> 
                <?php foreach ($returns as $d): // for each row data asign it to the variable $d ?>
                    <?php $count++; // increment the count variable ?>
                    <tr id="row_<?php echo $d->returnID; ?>">
                        <td class="row_num"><?php echo $count; // let the count variable shows the number of the table row  ?></td>
                        <td><?php echo $d->itemName; ?></td>
                        <td><?php echo $d->itemDescription; ?></td>
                        <td><?php echo $d->quantity_received; ?></td>
                        <td><?php echo $d->pricePerUnit . ".00"; ?></td>
                        <?php $total = $d->quantity_received * $d->pricePerUnit; ?>
                        <td><?php echo $total . ".00"; ?></td>
                         <?php  $date = strftime("%b %d %Y",strtotime($d->date_received));?>
                        <td><?php echo $date; ?></td>
                        <td><?php echo $d->supplierName; ?></td>
                        <td><a href="#" title="save" rel="save_return" id="<?php echo $d->returnID; ?>" class="btn btn-small"><i class="cus-disk"></i></a></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
