<!DOCTYPE html>
<html>
    <head>
		<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/cerulean.bootstrap.css"/>
		<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/cus-icons.css"/>
		<script src="<?php echo base_url(); ?>assets/js/jquery.1.8.2.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
	</head>
    <body>
        <?php
          echo "congrats you made it";
        ?>
        
    <li><a href="<?php echo base_url()?>login/logout" class="btn btn-success"><i class="icon-lock"></i> Logout</a></li>
    <p><?php echo $role; ?></p>
    <p><?php echo $department; ?></p>
    </body>
</html>
