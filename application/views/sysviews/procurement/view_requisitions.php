<p class="dash_head header_info">
     view requisitions status
</p>

<div>
      
<div class="dashboard">
     <div class="alert alert-info view_alert_req1" >  
        <i class="icon-exclamation-sign"></i>
        <p>View the Approved Purchase Requisitions </p>
    </div> 
    <div class="datagrid_table1">
         <?php $this->load->view('sysviews/procurement/purch_approv'); ?>
    </div>
</div>

<div class="dashboard">
    <div class="alert alert-info view_alert_req1" >  
        <i class="icon-exclamation-sign"></i>
        <p>View the Rejected Purchase Requisitions  </p>
    </div> 
    <div class="datagrid_table1">
        <?php $this->load->view('sysviews/procurement/purch_rejectd'); ?>
    </div>
</div>

<div class="dashboard">
    <div class="alert alert-info view_alert_req1" >  
        <i class="icon-exclamation-sign"></i>
        <p>View the Rejected Purchase Requisitions </p>
    </div> 
    <div class="datagrid_table1">
        <?php $this->load->view('sysviews/procurement/purch_waiting'); ?>
    </div>
</div>
