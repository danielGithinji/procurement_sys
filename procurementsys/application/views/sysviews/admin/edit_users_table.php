<div id="edit_user_data">
    <table id="" class="table table-striped table-hover datatable admin">
     <!--    <caption><h4>User Management</h4></caption>-->
        <thead class="tb-header-custom">
            <tr>
                <th></th>
                <th>First Name</th>
                <th>Second Name</th>
                <th>Department</th>
                <th>Role</th>
                <th>Status</th>
                <th>Email</th>
                <th >
                    <a href="#" class="btn btn-info btn-small" style="" rel="add_users"><i class="cus-group_add"></i> Add User</a>
                </th>
            </tr>
        </thead>

        <tbody>

            <?php if ($user_data != "nothing"): ?>
                <?php $count = 0; // initialize a variable and set it to 0 ?> 
                <?php foreach ($user_data as $user): // for each row data asign it to the variable $d ?>
                    <?php $count++; // increment the count variable ?>
                    <tr >
                        <th class="row_num"><?php echo $count; // let the count variable shows the number of the table row     ?></th>
                        <td><?php echo $user->firstName; ?></td>
                        <td><?php echo $user->secondName; ?></td>
                        <td><?php echo $user->department; ?></td>
                        <td><?php echo $user->role; ?></td>
                        <td><?php echo $user->status; ?></td>
                        <td><?php echo $user->email; ?></td>
                        <td id="alink">
                            <a href="#" title="view details"  rel="userDetails_modal"  id="<?php echo $user->userID; ?>" class="btn btn-small"><i class=" icon-eye-open"></i></a>
                            <a href="#user_form" title="update"  rel="editUser_modal" id="<?php echo $user->userID; ?>" class="btn btn-small"><i class=" cus-user_edit"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

