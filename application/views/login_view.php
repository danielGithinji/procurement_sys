<!DOCTYPE html>
<html>
	<head>
	    <title>Procurement System Login</title>
		<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css"/>
               <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css"/>
		<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/cus-icons.css"/>
		<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/login.css"/>
		<script src="<?php echo base_url(); ?>assets/js/jquery.1.7.2.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
		
	</head>
	<body>
		<div id="header" class="row">
			<h1 class="small">TTUC PROCUREMENT SYSTEM</h1>
		</div>

		<div id="container" class="">
                    
<!-- -------------------------------------------------------------------------------------------------------------</form>------------------------------------------------------------------------------------------>					
<!--			 <form class="form-inline span5 loginForm" style="">-->
                         <?php $attributes  =  array('class' => 'form-inline loginForm', 'id' => 'form_login'); ?>
                         <?php echo form_open('login/validate', $attributes);?>
                             <fieldset >    
                                 <label class="loginFormLabel">Sign In</label>
                                 
                                <div class="clearfix space" >
                                    <label class="float">Username</label>
                                    <div class="input">
                                         <input type="text" id="username"   name="username" value="<?php echo set_value('username'); ?>" autocomplete="off">
                                         <div style="color: #e74a56;"><?php echo form_error('username'); ?></div>
                                     </div>
                                </div>

                                <div class="clearfix space" >
                                    <label class="float">Password</label>
                                    <div class="input">
                                         <input type="password" id="inputPassword" name="password" value="<?php echo set_value('password'); ?>">
                                         <div style="color: #e74a56;"><?php echo form_error('password'); ?></div>
                                     </div>
                                </div>

                                <div class="controls">  
                                       
                                    <button type="submit" class="btn btn-info" ><i class="icon-unlock"></i> Sign in</button>
                                    <label class="checkbox" style="margin-left: 2%;">  
<!--                                         <input type="checkbox" id="optionsCheckbox" value="option1">  
                                         Remember me-->
                                       </label> 
                               </div> 
                             </fieldset>
                           <div style="color: #e74a56; margin-left: 23px; margin-top: 10px;">
                                <?php
                                    if($this->session->flashdata('login_error'))
                                    {
                                        echo 'You entered an incorrect username or password';
                                    }
                                    elseif($this->session->flashdata('suspended'))
                                    {
                                        echo 'Your account has been suspended';
                                    }
                                ?>
                           </div>
                            <?php echo form_close(); ?>
<!-- -------------------------------------------------------------------------------------------------------------</form>------------------------------------------------------------------------------------------>


                    
                   <div id ="info" class="" style="padding-top: 10px;">
                       <p class="headersmall" >TTUC PROCUREMENT SYS</p>
                       <p >The procurement system meant to aid a growing university.</p>
                       
                       <div class=" infoBlock">
                           <div class="image"> </div>
                           <div class="marginTop"> 
                               <p class="pheader"> Become organized</p>
                               <p>It puts everything you need in one place by implementing a straight forward user interface.</p>
                           </div>
                           
                           
                       </div>
                       
                       <div class=" infoBlock">
                           <div class="image1"> </div>
                           <div  class="marginTop"> 
                               <p class="pheader"> Send to Mail</p>
                               <p> Easens the work of sending LPOs to their respective suppliers by sending it to their email account at the click of a button.</p>
                           </div>
                           
                           
                       </div>
                       	
                        <div class="infoBlock">
                           <div class="image2" > </div>
                           <div class="marginTop"> 
                               <p class="pheader"> Be on Time</p>
                               <p> Be able to meet procurement deadlines by easily following up on all transactions.</p>
                           </div>
                           
                           
                       </div>
                    
		   </div>
                   <div class="clearboth"></div>
		</div>
            
<!--            <div id="footer" class="tb-header-custom ">
                <p>Copyright @GMANTech 2013</p>
            </div>-->
   
	</body>
</html>