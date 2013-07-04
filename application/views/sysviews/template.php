<!--this template loads the specific file plus the
variables that are needed to be displayed such as role, department etc-->

<?php $this->load->view('sysviews/header'); ?> <!--loads the header file of the page-->

<div id="main_page" class="container-fluid" >
    <div class="row-fluid" >
        
        <div  id="sidebar" class="span3">
           <?php $this->load->view('sysviews/sidebar'); ?> <!--loads the sidebar of the page--> 
        </div>
        <div id="content_main" class="span9 " >
            
            <div>
                <?php $this->load->view($content); ?>
            </div>
             <!--loads the main content of the page, e.g a form, or table of the page-->
            
        </div>
    
    </div>
</div>

<?php $this->load->view('sysviews/footer'); ?> <!--loads the footer of the page-->
