<div id="edit_item_data">
    <table id="" class="table table-striped table-hover datatable dashboard_table admin">
     <!--    <caption><h4>User Management</h4></caption>-->
        <thead class="tb-header-custom">
            <tr>
                <th></th>
                <th>Item Name</th>
                <th>Description</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th>Quantity Limit</th>

                <th class="head_link">
                    <a href="#" class="btn btn-info btn-small" style="" rel="add_item"><i class=" cus-add"></i> Add Item</a>
                </th>
            </tr>
        </thead>

        <tbody>

            <?php if ($items != "nothing"): ?>
                <?php $count = 0; // initialize a variable and set it to 0 ?> 
                <?php foreach ($items as $item): // for each row data asign it to the variable $d ?>
                    <?php $count++; // increment the count variable ?>
                    <tr >
                        <th class="row_num"><?php echo $count; // let the count variable shows the number of the table row     ?></th>
                        <td><?php echo $item->itemName ?></td>
                        <td><?php echo $item->itemDescription ?></td>
                        <td><?php echo $item->pricePerUnit; ?></td>
                        <td><?php echo $item->quantity; ?></td>
                        <td><?php echo $item->quantity_limit; ?></td>

                        <td id="alink">                      
                            <a href="#user_form" title="update"  rel="editItems_modal" id="<?php echo $item->itemID; ?>" class="btn btn-small"><i class=" cus-page_edit"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>