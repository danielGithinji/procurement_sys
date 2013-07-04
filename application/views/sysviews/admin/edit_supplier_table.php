<div id="edit_supp_data">
<table id="" class="table table-striped table-hover datatable admin">
 <!--    <caption><h4>User Management</h4></caption>-->
    <thead class="tb-header-custom">
        <tr>
            <th></th>
            <th>Supplier Name</th>
            <th>Location</th>
            <th>Items Supplied</th>
            <th>Telephone</th>
            <th>Email</th>
            <th>Date</th>
            <th>Status</th>
            <th >
                <a href="#" class="btn btn-info btn-small" style="" rel="add_supp" title="add new supplier"><i class="cus-building_add"></i> Add Supplier</a>
            </th>
        </tr>
    </thead>

    <tbody>

        <?php if ($supp_data != "nothing"): ?>
            <?php $count = 0; // initialize a variable and set it to 0 ?> 
            <?php foreach ($supp_data as $supp): // for each row data asign it to the variable $d ?>
                <?php $count++; // increment the count variable ?>
                <tr >
                    <th class="row_num"><?php echo $count; // let the count variable shows the number of the table row    ?></th>
                    <td><?php echo $supp->supplierName; ?></td>
                    <td><?php echo $supp->supplierLocation; ?></td>
                    <td><?php echo $supp->itemsSupplied; ?></td>
                    <td><?php echo $supp->phone_no; ?></td>
                    <td><?php echo $supp->email; ?></td>
                    <?php  $date = strftime("%b %d %Y",strtotime($supp->date));?>
                    <td><?php echo $date; ?></td>
                    <td><?php echo $supp->status; ?></td>
                    <td id="alink">
                       
                        <a href="#edit_form" title="update supplier details"  rel="edit_supp" id="<?php echo $supp->supplierID; ?>" class="btn btn-small"><i class=" cus-building_edit"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
</div>