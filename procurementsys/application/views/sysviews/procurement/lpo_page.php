<p class="dash_head header_info">
    send local purchase order to mail
</p>

<div id="edit">

    <div class="alert alert-info" style="margin: 10px 20px 30px 20px;">  
        <i class="icon-exclamation-sign" style="float:left; margin-right: 8px;"></i>
        <p>Create an LPO by clicking the " <i class="cus-application_form_edit"></i> " button. After you create one send it to the specific supplier.</p>
    </div> 

    <div class="table_header user tb-header-custom">
        <div>
            <p><span class="" type="button" id="refresh_user_table" title="refresh table"> <i class="icon-reorder"></i></span>LPO Table</p>
        </div>
    </div>

    <div id="edit_ui" class="proc_content">

        <div class="filter_lpo">
            <label>Filter By:</label>
            <select id="supplier" name="supplier">
                <option selected ="selected">All</option>
                <?php foreach ($supplier as $s): ?>
                    <option value="<?php echo $s->supplierID; ?>" id="<?php echo $s->supplierName; ?>"> <?php echo $s->supplierName; ?> </option>
                <?php endforeach; ?>
            </select>
            <button id="sendBulk" class="btn btn-info btn-small" disabled="true">Send All</button>
        </div>
        <div id="load_content">
            <?php $this->load->view('sysviews/procurement/lpo_table'); ?> 
        </div> 

    </div>
</div>





