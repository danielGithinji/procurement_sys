<p class="dash_head header_info">
     view requisitions
</p>


<div class="dashboard">
    <div class="alert alert-info view_alert_req" >  
        <i class="icon-exclamation-sign"></i>
        <p>View the Approved Material Requisitions </p>
    </div> 
    <div class="datagrid_table">
        <?php $this->load->view('sysviews/user_dept/req_appr'); ?>
    </div>
</div><!--

--><div class="dashboard">
    <div class="alert alert-info view_alert_req" >  
        <i class="icon-exclamation-sign"></i>
        <p>View the Rejected Material Requisitions </p>
    </div> 
    <div class="datagrid_table">
        <?php $this->load->view('sysviews/user_dept/req_reject'); ?>
    </div>
</div>

<div class="dashboard">
    <div class="alert alert-info view_alert_req" >  
        <i class="icon-exclamation-sign"></i>
        <p>View the Waiting Material Requisitions </p>
    </div>
    <div class="datagrid_table">
        <?php $this->load->view('sysviews/user_dept/req_waiting'); ?>
    </div>
</div>


