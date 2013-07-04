<table id="reject" class="table table-stripped table-hover table datatable dashboard_table data_grid1">
    <caption class="view_tables tb-header-custom"><h5>Rejected Material Requisitions</h5></caption>
    <thead class="tb-header-custom">
        <tr>
            <th></th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Description</th>
            <th>Date Created</th>
        </tr>
    </thead>
  
    <tbody>
       
        <?php if($rejected != "nothing"): ?>
            <?php $count = 0; // initialize a variable and set it to 0 ?> 
            <?php foreach($rejected as $d): // for each row data asign it to the variable $d ?>
                <?php $count++; // increment the count variable ?>
                <tr id="row_<?php echo $d->materialReqID; ?>">
                    <td class="row_num"><?php echo $count; // let the count variable shows the number of the table row ?></td>
                    <td><?php echo $d->itemName; ?></td>
                    <td><?php echo $d->mat_quantity; ?></td>
                    <td><?php echo $d->itemDescription; ?></td>
                    <?php $date = date("d/m/Y", strtotime($d->date)); ?>
                    <td><?php echo $date; ?></td>
                </tr>
                <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>