<!--<p>Navigation</p>-->
<ul>
    <!-- if the department is maths and informatics then it will show the following list of links-->
    <?php if($department == "maths and informatics"): ?>
            
              
     <li><a href="<?php echo base_url(); ?>site_nav/user_dash" class="btn" ><i class="icon-dashboard"></i> Dashboard</a></li>         
     <li><a href="<?php echo base_url(); ?>site_nav/mat_req_form" class="btn"><i class="icon-edit"></i> Create Requisiton</a></li>
     <li><a href="<?php echo base_url(); ?>site_nav/view_mat_req" class="btn"><i class="icon-eye-open"></i> View Requisitions</a></li>

    <!-- if the department is procurement then it will show the following list of links-->
     <?php elseif($department == "procurement"): ?>
              
       <li><a href="<?php echo base_url(); ?>site_nav/procure_dash" class="btn"><i class="icon-dashboard"></i> Dashboard</a></li>
       <li><a href="<?php echo base_url(); ?>site_nav/review_mat_req" class="btn"><i class=" icon-tasks"></i> Review Requisitions</a></li>
       <li><a href="<?php echo base_url(); ?>site_nav/purch_req_form" class="btn"><i class="icon-edit"></i> Create Requisition</a></li>
       <li><a href="<?php echo base_url(); ?>site_nav/view_requisitions" class="btn"><i class="icon-folder-open"></i> Views Requisitions</a></li>
       <li><a href="<?php echo base_url(); ?>site_nav/view_lpo" class="btn"><i class=" icon-envelope-alt"></i> Send LPOs</a></li>
       <li><a href="<?php echo base_url(); ?>site_nav/lpo_report" class="btn"><i class=" icon-list-alt"></i> LPO Reports</a></li>
       <li><a href="<?php echo base_url(); ?>site_nav/receive_form" class="btn"><i class=" icon-pencil"></i> Create Receive Note</a></li>
       <li><a href="<?php echo base_url(); ?>site_nav/showAll_receive_notes" class="btn"><i class="icon-eye-open"></i> View Receive Notes</a></li>
       <li><a href="<?php echo base_url(); ?>site_nav/show_return_note" class="btn"><i class="icon-desktop"></i> View Return Notes</a></li>
       <li><a href="<?php echo base_url(); ?>site_nav/show_items" class="btn"><i class="icon-cog"></i> Check Inventory</a></li>
      
     <?php elseif($department == "finance"): ?>
       <li><a href="<?php echo base_url(); ?>site_nav/finance_dash" class="btn"><i class="icon-dashboard"></i> Dashboard</a></li>
       <li><a href="<?php echo base_url(); ?>site_nav/review_purch_req" class="btn"><i class=" icon-tasks"></i> Review Requisitions</a></li>
     
     <?php elseif($department == "administrator"): ?>
       <li><a href="<?php echo base_url(); ?>site_nav/admin_panel" class="btn"><i class="icon-dashboard"></i> Dashboard</a></li>
       <li><a href="<?php echo base_url(); ?>site_nav/edit_users" class="btn"><i class="icon-list-alt"></i> User Management</a></li>
       <li><a href="<?php echo base_url(); ?>site_nav/edit_items_page" class="btn"><i class="icon-th"></i> Manage Items</a></li>
       <li><a href="<?php echo base_url(); ?>site_nav/view_supp_info" class="btn"><i class=" icon-paste"></i> Supplier Management</a></li>
       
     <?php endif; ?>
</ul>
   
