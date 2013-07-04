<div class="filter filter_user">

    <label style="float:left;">Filter By: </label>
    <select  id="user_status">
        <option  option="selected">User Status</option> 
        <option  value="active">Active</option> 
        <option  value="leave">Leave</option> 
        <option  value="suspended">Suspended</option> 
    </select>
</div>

<div id="edit_ui_users" class="new_size">
        
         <?php $this->load->view('sysviews/admin/edit_users_table') ?>
</div>