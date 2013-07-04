<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.dataTables.css"/>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jqueryUI/jqueryUI.css"/>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css"/>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css"/>
	 <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/cus-icons.css"/>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/sysview.css"/>
        <script src="<?php echo base_url(); ?>assets/js/jquery.1.7.2.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery-ui-1.8.15.custom.min.js"></script>
	 <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/process.js"></script> 
        <script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script> 
        <script>
            
            var base_url = "<?php print base_url(); ?>";
            $(function() {
                //alert('<?php echo $name->firstName;?>');
                $('#sidebar ul li a').each(function() {

                         var site_url = $(this).attr('href').split('/');
                         var window_url = window.location.pathname.split('/');
//                        if ($(this).attr('href')  ===  window.location.protocol+"//"+window.location.host+window.location.pathname) 
//                        {
//                            $(this).addClass('click');
//                            //alert($(this).attr('href'));
//                             //alert(site_url[5]);
//                             alert(window_url[3]);
//                           
//                        }
                         
                        if ("/"+site_url[4]+"/"+site_url[5]  === "/"+window_url[2]+"/"+window_url[3] ) 
                        {
                            $(this).addClass('click');
                           // alert($(this).attr('href'));
                             //alert(site_url[4]);
                           
                        }
                });
                 
                 // find a '.calendar' class in the body and its only one element
                $('body').find('.calendar').each(function(){
                    // get the position of '.calendar' in the document body using offset()
                     var off = $(this).offset()
                     
                     // in the document with the '.calendar' class check a link that has the class 'click''
                    if( $('#sidebar ul li a').hasClass('click'))
                    {
                        // split this links href attr into an array
                        var url_array = $('#sidebar ul li a').attr('href').split('/');
                       
                       // join certain parts of the 'url_array' in order to form a certain string
                        var site_url = "/"+url_array[3]+"/"+url_array[4]+"/"+url_array[5];
                       
                       // compare the length of the link ur and the window url
                       if(site_url.length < window.location.pathname.length ){
                         
                          // scroll the document to the specified cordinates ie off.top then subtract 134 from it
                           $(document).scrollTop(off.top-134);
                         
                       }
                      
                       
                    }
                });
                
                   
                    $( "#datepicker" ).datepicker({
                            showOn: "button",
                            buttonImage: "../assets/css/img/calendar_add.png",
                            buttonImageOnly: true
                    });
                    $('#ui-datepicker-div').wrap('<div style="position:absolute;top:0px;left:0px;font-size:11px;"></div>');
                    
                    $(".error_row").tooltip({'placement':'left', 'trigger':'hover'});
                    
                   

              });
                
              
               
        </script>
        <style>

            input[type=text]{
                height: 14px;
                border-radius: 2px;
            }
            label{
                font-size: 13px;
            }
            select{
                height: 25px;
            }
           
            

        </style>
    </head>
    <body>
        <div id="header" class="row">
		<h1 class="small">TTUC PROCUREMENT SYSTEM</h1>
                
   <!---------------------------------- Login user details e.g their full name, department e.t.c ----------------------------------------------->
     
     
                <div class="headerDetails">   
 
                                <ul>
                                    <li><i class="icon-user"></i> 
<!--                                    <li><i class="cus-user_suit"></i> -->
                                        <?php

                                           // foreach($name as $n){
                                                 echo $name->firstName." ";
                                                 echo $name->secondName."<br />";

                                            // }
                                        ?>
                                    </li>
<!--                                    <li><i class="cus-house"></i> <?php echo $department;?> </li>-->
                                    <li><i class="icon-circle-arrow-right"></i> <?php echo $role; ?> </li>
                                    <li><a href="<?php echo base_url()?>login/logout"><i class="icon-lock"></i> Log out</a></li>
                                </ul>
 
                </div>
     
     
      <!----------------------------------------------end of user details-------------------------------------------------------------------------------------------------------------------------->
        </div>



