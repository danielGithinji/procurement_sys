<div id="lpo_table" style="margin-top: 20px;">
    <table id="lpo_page" class="table table-striped table-hover datatable dashboard_table report data_grid">
        <thead class="tb-header-custom">
            <tr>
                <th></th>
                <th>Name</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Date Created</th>
                <th>Create Report</th>
            </tr>
        </thead>

        <tbody>

            <?php if ($lpo != "nothing"): ?>
                <?php $count = 0; // initialize a variable and set it to 0 ?> 
                <?php foreach ($lpo as $l): // for each row data asign it to the variable $d ?>
                    <?php $count++; // increment the count variable ?>
                    <tr id="row_<?php echo $l->purchaseReqID; ?>">
                        <td class="row_num"><?php echo $count; // let the count variable shows the number of the table row    ?></td>
                        <td><?php echo $l->itemName; ?></td>
                        <td><?php echo $l->itemDescription; ?></td>
                        <td><?php echo $l->quantity_ordered; ?></td>
                        <td><?php echo $l->pricePerUnit; ?></td>
                        <?php $date = strftime("%b %d %Y", strtotime($l->date)); ?>
                        <td><?php echo $date; ?></td>
                        <td id="alink"><a href="" title="Create LPO report"  rel="lpo_report" id="<?php echo $l->purchaseReqID; ?>" class="btn btn-small"><i class="cus-page_white_edit"></i></a></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr id="empty_row"><td>No new local purchase orders</td></tr>
            <?php endif; ?>
        </tbody>
    </table>   
</div>








