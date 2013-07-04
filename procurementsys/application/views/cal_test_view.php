<html>
    <head>
        
       
        <style>
            .calendar{
                font-family: Arial; font-size: 12px;
            }
            table.calendar{
                margin: auto; border-collapse: collapse;
            }
            .calendar .days td {
                width: 80px;height: 80px; padding: 4px;
                border: 1px solid #999;
                vertical-align: top;
                background-color: #def;
                    
            }
            .calendar .days td:hover{
                background-color: #fff;
            }
            .calendar .highlight{
                font-weight: bold; color: #oof;
            }
            #alert_box{
                position: absolute;
                top: 200px;
                left: 590px;
                width: 150px;
                color: #007299;
                font-family: Arial;
                background-color: #84e0ff;
                padding: 5px;
                border-radius: 4px;
                display: none;
            }
        </style>
            <script src="<?php echo base_url(); ?>assets/js/jquery.1.7.2.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/test.js"></script>
        <script>
               var base_url = "<?php echo base_url(); ?>";
        </script>
        
        
    </head>
    <body>
        <div id="load_calendar">
            <?php echo $calendar;?> 
        </div>
        
          <div id="alert_box">  

                loading..
            </div>
    </body>
</html> 


 
 
 