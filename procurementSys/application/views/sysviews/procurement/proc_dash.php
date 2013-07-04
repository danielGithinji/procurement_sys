<p class="dash_head header_info">
    <?php echo $department; ?> department dashboard
</p>

<div class="alert alert-info" style="margin: 10px 20px 30px 20px; width:91%;">  
    <i class="icon-exclamation-sign" style=""></i>
    <p>This is the procurement department dashboard. Below is the quick access panel. Click any of the
       tabs to access a certain functionality.</p>
</div> 

<div>
    <div class="table_header user proc_dash_head tb-header-custom">
        <div>
            <p>Quick Access Navigation</p>
        </div>
            
    </div>
    <div id="edit_ui" class="proc_dash" style="width:95.5%;">
        
        <div id="site_nav">
            
            <a href="<?php echo base_url(); ?>site_nav/review_mat_req" class="metro-tile" ><i class="icon-file icon-size"></i><br/>Review Requisitions</a>
            <a href="<?php echo base_url(); ?>site_nav/purch_req_form" class="metro-tile" style="background-color: #33A99C"><i class="icon-edit icon-size" ></i><br/>Create Requisition</a>
            <a href="<?php echo base_url(); ?>site_nav/view_requisitions" class="metro-tile" style="background-color: #AFC467"><i class="icon-folder-open icon-size"></i><br/>Views Requisitions</a>
            <a href="<?php echo base_url(); ?>site_nav/view_lpo" class="metro-tile" style="background-color: #4DBCC6"><i class=" icon-envelope icon-size"></i><br/>Send LPOs</a>
            <a href="<?php echo base_url(); ?>site_nav/lpo_report" class="metro-tile" style="background-color: #B97E89 "><i class="icon-list-alt icon-size"></i><br/>LPO Reports</a>
            <a href="<?php echo base_url(); ?>site_nav/receive_form" class="metro-tile" style="background-color: #D77D65"><i class="icon-pencil icon-size" ></i><br/>Create Receive Note</a>
            <a href="<?php echo base_url(); ?>site_nav/showAll_receive_notes" class="metro-tile" style="background-color: #8874D1"><i class="icon-eye-open icon-size"></i><br/>View Receive Notes</a>
            <a href="<?php echo base_url(); ?>site_nav/show_return_note" class="metro-tile" style="background-color: #F2B26C"><i class=" icon-desktop icon-size"></i><br/>View Return Notes</a>
            <a href="<?php echo base_url(); ?>site_nav/show_items" class="metro-tile" style="background-color: #a4dded"><i class=" icon-cog icon-size"></i><br/>View Item Status</a>
                
        </div>
    </div>
</div>
    


<script src="<?php echo base_url(); ?>assets/js/tileJs.js"></script>

<div>
    <div class="table_header user proc_dash_head tb-header-custom view_calendar">
        <div>
            <p><i></i>Monthly Calendar Planner</p>
        </div>
            
    </div>
        
        
        
    <div id="edit_ui" class="proc_dash" style="width:95.5%; padding-top: 0px;background-color: #e9f6f4;">
        <div class="alert alert-info" style="margin: 10px 20px 10px 20px; width:91%;">  
            <i class="icon-exclamation-sign" style=""></i>
            <p>To add an activity click on any of the date tab, enter an activity then click "add note".</p>
        </div> 
            
        <div id="load_calendar">
            <?php $this->load->view('sysviews/procurement/cal_view'); ?>       
        </div>
    </div>
</div>

<div id="edit_form" class="modal hide property edit_form cal_modal">
    
    <div class="modal-body" >
        <textarea rows="3" cols="50" maxlength="80" name="activity" placeholder="Enter Activity"></textarea>
    </div>
    
    <div class="modal-footer">
        
        <p style="float: left;font-size:13px;">Remaining:<span id="remain"></span></p>
        <a href="#" class="btn btn-small" data-dismiss="modal" >Close</a>
        <a href="#" id="add_plan" class="btn btn-inverse btn-small"><i></i>Add Note</a>
    </div>
</div>


