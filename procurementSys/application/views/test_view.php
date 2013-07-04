<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
         <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.dataTables.css"/>
         
         
        <title></title>
        <style>
            
table{
/*   width: 100px;*/
   margin-bottom: 10px;
   margin-top: 10px;
   border: 1px solid lightgray;
   border-left-radius: 6px;
   border-right-radius: 4px;
   box-shadow:  1px 1px 7px;
}

td{
  border-right: 1px solid #aaaaaa; 
  border-top: 1px solid #D0D0D0;
  padding: 10px;
  
}

td:last-child{
  border-right: none;  
}

th{  
    text-align: left;
    padding-left: 1em;
    background: #cac9c9;
    border-bottom: 1px solid white;
    border-right: 1px solid #aaaaaa;
}


tr:nth-child(even){
    background-color: #dce8ee;
}
tr:hover{
    background-color: #bbc7cd;
    cursor: pointer;
}
        </style>
        <script src="<?php echo base_url(); ?>assets/js/jquery.1.8.2.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script> 
        <script>
            $(function(){
                $('#submit').click(function(){
                    var test = $('input[name=test]').val();
                    
                   $.post("/procurementSys/test/tester", {test:test},
                        function(data){
                            alert(data);
                   });
                    
                });
                
                $('#example').dataTable( {
                        "bPaginate": false,
                        "bLengthChange": false,
                        "bFilter": true,
                        "bSort": false,
                        "bInfo": false,
                        "bAutoWidth": false,
                        "sScrollY": "200px",
                        "bScrollCollapse": true
                    });
            });
        </script>
    </head>
    <body>
                
        <?php //echo form_open('test/generate'); ?>
<!--        <input type="text" name="username" />-->
        <!--<input type ="password" name="password" />-->
            
        <?php //echo form_submit(array('name' => 'submit'), 'Login');?>
        <?php //echo form_close(); ?>
       
       

        <div style="width: 500px;">
            <table id="example" >
                <thead>
                    <th>User ID</th>
                    <th>First Name</th>
                    <th>Role</th>
                    <th>Status</th>
                </thead>
                <tbody>
               
                    <?php foreach ($record as $r):?>
                        <tr>
                         <td><?php echo $r->userID; ?></td>
                         <td><?php echo $r->firstName; ?></td>
                         <td><?php echo $r->role; ?></td>
                         <td><?php echo $r->status; ?></td>
                        </tr>
                    <?php endforeach; ?>
            
                </tbody>
             </table>
        </div>
        
<!--        <div>
            <form id="form_test">
            <input type="text" name="test" />
            <input type ="password" name="password" />

            
            </form>
            <button id="submit">Click Me</button>
        </div>-->
        <?php //echo date("d-m-Y"); ?>
    </body>
</html>
