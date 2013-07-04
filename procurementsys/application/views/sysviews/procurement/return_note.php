<p class="dash_head header_info" >
    view return notes
</p>


<div id="edit">

    <div class="alert alert-info" style="margin: 10px 20px 30px 20px;">  
        <i class="icon-exclamation-sign" style="float:left; margin-right: 8px;"></i>
        <p>Create a a return note by clicking the " <i class="cus-disk"></i> " button. Filter through the return notes by choosing a specific supplier and then
         then click the "Create Return Note" button.</p>
    </div> 

    <div class="table_header user tb-header-custom">
        <div>
            <p><span class="" type="button" id="refresh_user_table" title="refresh table"> <i class="icon-reorder"></i></span>Return Note Report</p>
        </div>
    </div>
    <div id="edit_ui" class="proc_content">
        <div class="filter_lpo filter_lpo1">
            <label>Filter By: </label>
            <select id="returnNote_supplier" name="returnNote_supplier">
                <option selected ="selected">All</option>
                <?php foreach ($supplier as $s): ?>
                    <option value="<?php echo $s->supplierID; ?>" id="<?php echo $s->supplierName; ?>"> <?php echo $s->supplierName; ?> </option>
                <?php endforeach; ?>
            </select>
            <button id="create_returnNote" class="btn btn-info btn-small" disabled="true">Create Return Note</button>
        </div>
        <div id="load_content">
            <?php $this->load->view('sysviews/procurement/return_note_details'); ?> 
        </div>
    </div>
</div>

