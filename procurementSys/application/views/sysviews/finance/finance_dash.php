<p class="dash_head header_info">
    <?php echo $department; ?> department dashboard
</p>

<div class="alert alert-info" style="margin: 10px 20px 30px 20px; width:91%;">  
    <i class="icon-exclamation-sign" style=""></i>
    <p>This is the finance department dashboard. Below is the quick access panel. Click any of the
       tabs to access a certain functionality.</p>
</div> 


<div class="table_header user proc_dash_head tb-header-custom">
        <div>
            <p>Quick Access Navigation</p>
        </div>

</div>
<div id="edit_ui" class="proc_dash" >
    
    <div id="site_nav">

        <a href="<?php echo base_url(); ?>site_nav/review_purch_req" class="metro-tile" style="background-color:#66d0bf"><i class="icon-tasks icon-size"></i><br/>Review Requisitions</a>
          
    </div>
</div>



<div>
    <div class="table_header user proc_dash_head tb-header-custom">
        <div>
            <p><i></i>Monthly Calendar Planner</p>
        </div>
            
    </div>
    <div id="edit_ui" class="proc_dash" style="background-color: #e9f6f4;">
         <div class="alert alert-info" style="margin: 10px 20px 10px 20px; width:91%;">  
            <i class="icon-exclamation-sign" style=""></i>
            <p>To add an activity click on any of the date tab, enter an activity then click "add note".</p>
        </div> 
        
        <div id="load_calendar">
            <?php $this->load->view('sysviews/finance/cal_view'); ?>
        </div>
    </div>
</div>

<div id="edit_form" class="modal hide property edit_form cal_modal">
    
    <div class="modal-body" >
        <textarea rows="3" cols="50" maxlength="80" name="activity" placeholder="Enter Activity"></textarea>
    </div>
    
    <div class="modal-footer">
        <div id="confirm_supp" class="alert alert-info  alert_modal hide">  
            <i class="icon-spinner icon-large icon-spin"></i> Submitting Data..
        </div>
        <p style="float: left;font-size:13px;">Remaining:<span id="remain"></span></p>
        <a href="#" class="btn btn-small" data-dismiss="modal" >Close</a>
        <a href="#" id="add_plan" class="btn btn-inverse btn-small"><i></i>Add Note</a>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/tileJs.js"></script>