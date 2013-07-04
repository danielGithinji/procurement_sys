<div  style="" class="filter filter_supp">

    <label style="float:left;">Filter By: </label>
    <select  id="supplier_status">
        <option  option="selected">Supplier Status</option> 
        <option  value="available">Available</option> 
        <option  value="suspended">Suspended</option> 
    </select>
</div>
<div id="edit_ui_table" class="new_size">
        
         <?php $this->load->view('sysviews/admin/edit_supplier_table') ?>
</div>