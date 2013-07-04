<p class="dash_head header_info">
     create LPO reports
</p>

<div id="edit">

    <div class="alert alert-info" style="margin: 10px 20px 30px 20px;">  
        <div><i class="icon-exclamation-sign" style="float:left; margin-right: 8px;"></i></div>
        <p>Create Local Purchase Order report by clicking the " <i class="cus-page_white_edit"></i> " button. </p>
    </div> 

    <div class="table_header user tb-header-custom">
        <div>
            <p><span class="" type="button" id="refresh_user_table" title="refresh table"> <i class="icon-reorder"></i></span>LPO Reports</p>
        </div>

    </div>

    <div id="edit_ui" class="proc_content">
        <div class="filter_lpo filter_lpo1" style="margin-right:32px;">
            <label>Filter By: </label>
            <select id="lpo_report_supplier" name="lpo_report_supplier">
                <option selected ="selected">All</option>
                <?php foreach ($supplier as $s): ?>
                    <option value="<?php echo $s->supplierID; ?>" id="<?php echo $s->supplierName; ?>"> <?php echo $s->supplierName; ?> </option>
                <?php endforeach; ?>
            </select>
            <button id="create_lpo_report" class="btn btn-info btn-small" disabled="true">Create LPO Report</button>
        </div>
        
        <div id="load_lpo_report">
             <?php $this->load->view('sysviews/procurement/lpo_report'); ?>
        </div>
    </div>
</div>