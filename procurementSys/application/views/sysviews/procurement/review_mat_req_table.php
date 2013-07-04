<table id="mat_data" class="table table-stripped table-hover datatable dashboard_table data_grid">
    <thead class="tb-header-custom">
        <tr>
            <th></th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Description</th>
            <th class="head_link">Action</th>
        </tr>
    </thead>

    <tbody>

        <?php if ($mat_data != "nothing"): ?>
            <?php $count = 0; // initialize a variable and set it to 0 ?> 
            <?php foreach ($mat_data as $d): // for each row data asign it to the variable $d ?>
                <?php $count++; // increment the count variable ?>
                <tr id="row_<?php echo $d->materialReqID; ?>">
                    <td class="row_num"><?php echo $count; // let the count variable shows the number of the table row     ?></td>
                    <td><?php echo $d->itemName; ?></td>
                    <td><?php echo $d->mat_quantity; ?></td>
                    <td><?php echo $d->itemDescription; ?></td>
                    <td id="alink"><a href="#material" title="view"  rel="mat_req_modal" id="<?php echo $d->materialReqID; ?>" class="btn"><i class="cus-book_open"></i></a></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>