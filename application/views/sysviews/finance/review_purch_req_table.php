<table id="purch_data" class="table table-hover datatable dashboard_table data_grid" >
    <thead class="tb-header-custom" >
        <tr>
            <th></th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Date Created</th>
            <th>View</th>
        </tr>
    </thead> 

    <tbody >

        <?php if ($purch_data != "nothing"): ?>
            <?php $count = 0; // initialize a variable and set it to 0 ?> 
            <?php foreach ($purch_data as $d): // for each row data asign it to the variable $d ?>
                <?php $count++; // increment the count variable ?>
                <tr id="row_<?php echo $d->purchaseReqID; ?>">
                    <td class="row_num"><?php echo $count; // let the count variable shows the number of the table row     ?></td>
                    <td><?php echo $d->itemName; ?></td>
                    <td><?php echo $d->quantity_ordered; ?></td>
                    <?php $date = strftime("%b %d %Y", strtotime($d->date)); ?>
                    <td><?php echo $date; ?></td>
                    <td><a href="#purchase" title="view"  rel="purch_req_modal" id="<?php echo $d->purchaseReqID; ?>" class="btn"><i class="cus-book_open"></i></a></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td>No new requisitions made</td></tr>
        <?php endif; ?>
    </tbody>
</table>