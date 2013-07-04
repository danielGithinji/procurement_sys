/* 
 * This javascript file deals with how a user interacts
 * with the interface
 * 
 */

$(function(){
    
    var mat_id; // variable that holds the material item id
    var purch_id; // variable that holds the purchase item id
    var purchLpo_id; // variable that holds the lpo purchase id
    var supp_id; // variable that holds the supplier id
    var user_id; // variable that holds the specific user id
    var itemID  // variable that holds the specific item id
    var supplierID // variable that holds the specific supplier ID-> from the admin supplier management process
    var day_num // variable that holds the specific day for updating a note for the calendar
    var day_clicked // variable that holds the day of the week that the calendar was clicked
    
    
    //............................................................normal user department page handlers.............................................................................................................

    $(document).on("change","#matItem_det", function(){

            // captures the select box selected option
            var selected = $("select option:selected");

            var item_id = selected.attr('id');

            $.post(base_url+"site_process/display_desc",{"item_id":item_id}, function(data){

                // split the content of the data into an array which is assigned to the details variable
                var details = data.split(',');
                $("input[name=description]").val(details[0]);
               
            });


        });

    // this event handler handles the inserting of material requisition form details
    // into the database
    $('#mat_submit_req').click(function(){
       // create an array that is to used to store all the form data
        var data = {};
        var inputs = $('input[type="text"], select', $('#mat_items'));
        inputs.each(function(){
            var el = $(this);
            data[el.attr('name')] = el.val();
        });
      
       // show the alert just before the data is submited to the db
       $('#alert_show_mat').show();
        $.ajax({
            url: base_url+"site_process/material_submit",
            type: "POST",
            data: data,
            dataType: 'JSON',
            success: function(json){
                // hide the alert once the server responds
                 $('#alert_show_mat').hide();
               // alert(json.status);
                 
                 if(json.status=="1")
                    {
                        $('#user_message').modal({
                              keyboard: false,
                              backdrop: true
                           });
                            
                        $('.message_content').html("<i class='cus-tick'></i> "+json.message);
                        
                        inputs.each(function(){
                            $(this).val('');
                        });
                    }
                  else if(json.status=="2")
                    {
                         $('#user_message').modal({
                                keyboard: false,
                                backdrop: true
                             });

                          $('.message_content').html("<i class='cus-cross'></i> "+json.message);
                          
                          inputs.each(function(){
                            $(this).val('');
                          });
                    }
                  else if(json.status=="3")
                    {
                        $('#user_message').modal({
                                keyboard: false,
                                backdrop: true
                             });

                          $('.message_content').html("<i class='cus-error'></i> "+json.message);
                          
                           inputs.each(function(){
                            $(this).val('');
                          });
                    }
                  else if(json.status == "failed")
                     {
                      // show the message modal
                            $('#user_error_message').modal({
                                  keyboard: false,
                                  backdrop: true
                            });
                         $('.message_error_content').html(json.message);
                     } 
            }
        });

        return false;
   
    });



    //............................................................end normal user department page handlers.....................................................................................................................
   
    //............................................................procurement page handlers...................................................................................................................................................
   
   
    // the "on" function is used to bind the whole function 
    // because it will take care of current element and future element 
    // in case if you want to load the markup which contains the clicked linked dynamically
    $(document).on("click","a[rel=mat_req_modal]",function(){
  
        // when the link with relation of modal is clicked show modal
        $('#material').modal({
            keyboard: false,
            backdrop: true
        });
        
        var input = $("#material input[type='radio']"); // get the object of the selected radio button and put it into a variable   
        input.attr('checked', false); // turn the checked radio button into false
        $('#material p').html(' ');
     
        mat_id = $(this).attr('id'); // get the value of the id attribute this object which is the link a[rel=modal]

        $.ajax({
            url: base_url+"site_process/show_matReq_details",
            type: "POST",
            data: "id="+mat_id,
            success: function(msg){
                $('#detailed_data').html(msg); // display the table rows in the modal window
            // alert(msg);

            }
        });

    });
   
    // when the modal button Submit has been clicked the following function is carried out 
    $(document).on("click","#mat_req_submit",function(){
        
        var input = $("#material input[type='radio']"); // get the object of the selected radio button and put it into a variable   

        var input_val = $("#material input[type='radio']:checked").val();
            
        if(input.is(':checked'))
        {
            $('#confirm').show();
            
            $.ajax({
                url: base_url+"site_process/change_matReq_status",
                type: "POST",
                data: "input_val="+input_val+'&mat_id='+mat_id,
                dataType : 'json',
                success: function(data){
                    //hide the alert 
                    $('#confirm').hide();

                    if(data.status=='success')
                        {   
                            // the load function loads the exact section of a page and appends the select section
                            // to the selected id which in this case is #content_main
                            $(".datagrid_table").load(base_url+"site_nav/partial_load_proc",function(){
                                    // load the dataTable grid for this particular table
                                    $('.data_grid').dataTable( {
                                            "bPaginate": false,
                                            "bLengthChange": true,
                                            "bFilter": true,
                                            "bSort": false,
                                            "bInfo": false,
                                            "bAutoWidth": false,
                                            "sScrollY": "200px",
                                            "bScrollCollapse": true
                                    });
                            });
                            
                              $('#material').modal('hide');
                              $('#user_message').modal({
                                          keyboard: false,
                                          backdrop: true
                                    });

                              $('.message_content').html("<i class='cus-tick'></i> "+data.message);
                        }
                   else if(data.status='limit')
                       {
                             $('#material').modal('hide');
                             $('#user_message').modal({
                                          keyboard: false,
                                          backdrop: true
                                    });

                              $('.message_content').html("<i class='cus-error'></i> "+data.message);
                       }
                   else if(data.status=='error')
                       {    
                            $('#material').modal('hide');
                             $('#user_message').modal({
                                          keyboard: false,
                                          backdrop: true
                                    });

                              $('.message_content').html("<i class='cus-cross'></i> "+data.message);
                           
                       }
                    else if(data.status=='error2')
                       {    
                            $('#material').modal('hide');
                             $('#user_message').modal({
                                          keyboard: false,
                                          backdrop: true
                                    });

                              $('.message_content').html("<i class='cus-error'></i> "+data.message); 
                       }            
                },
                error: function(){
                     $('#material').modal('hide');
                     $('#user_message').modal({
                                  keyboard: false,
                                  backdrop: true
                            });

                      $('.message_content').html("<i class='cus-error'></i> Server Error, please contact admin!");
                }
            });
                    
                   
        }
        else
        {
            //alert('Please choose one of the radio buttons');
            $('#material p').html('Please approve or reject the requisition');
        }
                
        $("#material input[type='radio']").click(function(){  
            $('#material p').html(' ');
              
        });
         
    });
    
    $(document).on("change","#item_det", function(){
        
        // captures the select box selected option
        var selected = $("select option:selected");
       
        var item_id = selected.attr('id');
           
        $.post(base_url+"site_process/display_desc",{"item_id":item_id}, function(data){
        
            // split the content of the data into an array which is assigned to the details variable
            var details = data.split(',');
            $("input[name=description]").val(details[0]);
            $("input[name=price]").val(details[1]);
        });

        
    });
    
    // this event handler handles the inserting of purchase requisition form details
    // into the database
    $('#submit_purch_req').click(function(){
        //alert('clicked')
        $("#alert_show").show();
        // create a array will be used to present form input data
        var data = {};
        
        var inputs = $('input[type="text"], input[type="date"], select', $('#purch_items'));
        
        // capture only the form input values that are text boxes and dates
        var form_input = $('input[type="text"], input[type="date"]', $('#purch_items')).val();

        inputs.each(function(){
            var el = $(this);
            // put all the inputs into an associative array along with their values
            data[el.attr('name')] = el.val(); 
           
        });
         
        $.ajax({
            url: base_url+"site_process/purchase_submit",
            type: "POST",
            data: data,
            dataType: 'json',
            success: function(json){
             $("#alert_show").hide();
                //alert(json.status);
                
                if(json.status == "success")
                         {
                              // show the message modal
                                $('#user_message').modal({
                                      keyboard: false,
                                      backdrop: true
                                });
                             $('.message_content').html("<i class='cus-tick'></i> Request Submitted");
                             
                            // loop through each input and remove the values once the modal comes into view
                            inputs.each(function(){
                                 $(this).val("");
                             });

                         }
                 else if(json.status == "error1")
                         {

                              // show the message modal
                                $('#user_message').modal({
                                      keyboard: false,
                                      backdrop: true
                                });
                             $('.message_content').html("<i class='cus-cross'></i> Requisition wasn't submitted");
                             
                             // loop through each input and remove the values once the modal comes into view
                            inputs.each(function(){
                                 $(this).val("");
                             });

                         }
                  else if(json.status == "error2")
                         {

                              // show the message modal
                                $('#user_message').modal({
                                      keyboard: false,
                                      backdrop: true
                                });
                             $('.message_content').html("<i class='cus-error'></i> Transaction Error!");

                         }
                  else if(json.status == "failed")
                     {
                              // show the message modal
                                    $('#user_error_message').modal({
                                          keyboard: false,
                                          backdrop: true
                                    });
                                 $('.message_error_content').html(json.message);

                     } 
           }
        });
        
        return false;
    });
    
    // this event handler handles the inserting of purchase requisition form details
    // into the database
    $('#submit_purch_requisition').click(function(){
    
        // create a array will be used to present form input data
        var data = {};
        
        var inputs = $('input[type="text"], input[type="date"], select', $('#purch_items'));
        
        // capture only the form input values that are text boxes and dates
        var form_input = $('input[type="text"], input[type="date"]', $('#purch_items')).val();

        inputs.each(function(){
            var el = $(this);
            // put all the inputs into an associative array along with their values
            data[el.attr('name')] = el.val(); 
           
        });
         
        $('#confirm').show();
        
        $.ajax({
            url: base_url+"site_process/purchase_submit",
            type: "POST",
            data: data,
            dataType: 'json',
            success: function(json){
                
              $('#confirm').hide();
  
                if(json.status == "success")
                         {
                              // show the message modal
                                $('#user_message').modal({
                                      keyboard: false,
                                      backdrop: true
                                });
                             $('.message_content').html("<i class='cus-tick'></i> Request Submitted");
                             
                            // loop through each input and remove the values once the modal comes into view
                            inputs.each(function(){
                                 $(this).val("");
                             });

                         }
                 else if(json.status == "error1")
                         {

                              // show the message modal
                                $('#user_message').modal({
                                      keyboard: false,
                                      backdrop: true
                                });
                             $('.message_content').html("<i class='cus-cross'></i> Requisition wasn't submitted");
                             
                             // loop through each input and remove the values once the modal comes into view
                            inputs.each(function(){
                                 $(this).val("");
                             });

                         }
                  else if(json.status == "error2")
                         {

                              // show the message modal
                                $('#user_message').modal({
                                      keyboard: false,
                                      backdrop: true
                                });
                             $('.message_content').html("<i class='cus-error'></i> Transaction Error!");

                         }
                  else if(json.status == "failed")
                     {
                              // show the message modal
                                    $('#user_error_message').modal({
                                          keyboard: false,
                                          backdrop: true
                                    });
                                 $('.message_error_content').html(json.message);

                     } 
           }
        });
        
        return false;
    });
    
        
    // the "on" function is used to bind the whole function 
    // because it will take care of current element and future element 
    // in case if you want to load the markup which contains the clicked linked dynamically
    $(document).on("click","a[rel=lpo_modal]",function(){

        // when the link with relation of modal is clicked show modal
        $('#lpo').modal({
            keyboard: false,
            backdrop: true
        });
        
        // hide the button for the bulk mail and make visible the single mail button
        $('#lpo_mail').show();
        $('#lpo_Bulkmail').hide();
        
        //remove the "sending to mail message"
        $('#alert_msg').removeClass().html('');
       
        purchLpo_id = $(this).attr('id'); // get the value of the id attribute this object which is the link a[rel=modal]
        
        $.ajax({
            url: base_url+"site_process/lpo_details",
            type: "POST",
            data: "id="+purchLpo_id,
            success: function(msg){
                
                // display the table rows in the modal window
                $('#lpo_data tbody').html(msg); 
               
               // display some supplier details at the top of the modal
               $('#supplier_det_table tbody').html($('.sup_data').html());

            }
        });

    });
    
    // when the modal button Submit has been clicked the following function is carried out 
    $(document).on("click","#lpo_mail",function(){
//           window.open(base_url+"tut_pdf/single_lpo_row/"+purchLpo_id) ;
            $('#alert_msg').removeClass().addClass('load sending_mail').html('sending mail...');
            var address = $("#lpo input[type=hidden]").val();
 
            $.ajax({
                url: base_url+"tut_pdf/single_lpo_row",
                type: "POST",
                data: 'purchLpo_id='+purchLpo_id+'&address='+address,
                success: function(msg){

                   // alert(msg);
                    $('#lpo').modal('hide');
                    $('#alert_msg').removeClass().html('');
                    $('#email_msg').modal({
                        keyboard: false,
                        backdrop: true
                    });
                    if(msg == "1")
                    {
                       $('.message_content').html("<i class='cus-tick'></i> Email was sent successfully."); 
                       
                    }
                    else
                    {
                        $('.message_content').html("<i class='cus-error'></i> Email not sent!");     
                    }
                    
                     //window.open(base_url+"tut_pdf") ;
                     //$('#purchase').modal('hide');
//                               
//                    // the load function loads the exact section of a page and appends the select section
//                    // to the selected id which in this case is #content_main
//                    $("#content_main").load(base_url+"site_nav/partial_load_fin");
                              
                },
                error: function(){
                    //alert("The cow has refused!");
                    $('#lpo').modal('hide');
                    $('#alert_msg').removeClass();
                    $('#email_msg').modal({
                        keyboard: false,
                        backdrop: true
                    });
                    $('.message_content').html("Server Error!!");
                }
            });
   
    });
    
    // this handler handles the the select box that is found in the LPO page
    $(document).on("change","#supplier",function(){
  
        var name; 
        var val;
        var selected = $("select option:selected");
        
        selected.each(function(){
                    
            name = $(this).text(); // put the current text of the option into a variable name
            val = $(this).val(); // put the current value of the option into a variable name
        });
        
        if(name == "All")
        {
               
                
              $("#load_content").load(base_url+"site_nav/partial_load_lpo",function(){
                  
                   $('.lpo_data_grid').dataTable( {
                        "bPaginate": false,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": false,
                        "bInfo": false,
                        "bAutoWidth": false,
                        "sScrollY": "200px",
                        "bScrollCollapse": true
                 });
                 
                  $('#sendBulk').attr('disabled', 'disabled');
              });  
        }
        else
        {     
             // load the specific "LPO" supplier combo from the respective function, by passing the val variable to that function
              $("#load_content").load(base_url+"site_nav/partial_lpoSupp",{'val':val},function(){
                  
                    // load the dataTable plugin once the table has been reloaded
                    $('.lpo_data_grid').dataTable( {
                        "bPaginate": false,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": false,
                        "bInfo": false,
                        "bAutoWidth": false,
                         "sScrollY": "200px",
                        "bScrollCollapse": true               
                    });
                    
                  // get the row which contains the message of "no records from the database"
                   var lpo_table = $('#lpo_page tbody .odd');
                   
                   // get the exact <td> that contains the message and the message itself
                   // which is the first child of a particular 
                   var empty = $('td:nth-child(1)', lpo_table).html();
                  
                   
                   if(empty== "No data available in table")
                   {
                          $('#sendBulk').attr('disabled', 'disabled'); 
                   }
                   else
                   {
                         $('#sendBulk').removeAttr('disabled');
                         
                         // change the value 
                         $('#sendBulk').val(val);
                   }
                   
                  
              });           
        }
    });
    
    //opens the modal for the sending of specific LPO's to mail
    $(document).on("click","#sendBulk",function(){
        
       $('#alert_msg').removeClass().html('');
       //alert($(this).val());
       //alert('clicked');
       if($(this).disabled == false)
           {
               alert('it is false');
           }
           else
           {
                 supp_id = $(this).val();

                $('#lpo').modal({
                    keyboard: false,
                    backdrop: true
                });

                $('#lpo_mail').hide();
                $('#lpo_Bulkmail').show();

                $.ajax({
                    url: base_url+"site_process/get_lpoSupplier",
                    type:"POST",
                    data: "id="+supp_id,
                    success: function(msg){

                        // display some table data in the main table of the modal
                        $('#lpo_data tbody').html(msg);

                        // display some supplier details at the top of the modal
                        $('#supplier_det_table tbody').html($('.sup_data').html());

                    }

                });
           }
       

       
    });
    
    
    $(document).on("click","#lpo_Bulkmail",function(){
        
//         window.open(base_url+"tut_pdf/bulk_lpo/"+supp_id) ;
         var address = $("#lpo input[type=hidden]").val();
         
         // remove class and add a class to the span that shows that the image is actually being sent
         $('#alert_msg').removeClass().addClass('load sending_mail').html('sending mail...');

         
          $.ajax({
                url: base_url+"tut_pdf/bulk_lpo",
                type: "POST",
                data: 'supp_id='+supp_id+'&address='+address,
                success: function(msg){
                  
                  // alert(msg);
                    $('#lpo').modal('hide');
                    //$('#alert_msg').removeClass();
                    $('#email_msg').modal({
                        keyboard: false,
                        backdrop: true
                    });
                 
                    if(msg == 1)
                    {
                       $('.message_content').html("<i class='cus-tick'></i> Email was sent successfully.");    
                    }
                    else
                    {
                        $('.message_content').html("<i class='cus-error'></i> Email not sent!");     
                    }

                },
                error: function(){
                    //alert("The cow has refused!");
                    $('#lpo').modal('hide');
                    $('#alert_msg').removeClass();
                    $('#email_msg').modal({
                        keyboard: false,
                        backdrop: true
                    });
                    $('.message_content').html("Server Error!!");
                }
            });
     });
     
     // makes sure the right order number was the one that was in the database
     $('input[name=order_number]').on('blur',function(){
//            if(!$.trim($(this).val()).length)
//                {
//                  
//                }
//            else
//            {
                
                
                
                var order_no = $(this).val();
                
                 $.ajax({
                    url: base_url+"site_process/check_order_no",
                    type: "POST",
                    data: 'order_no='+order_no,
                    success: function(msg){
                        
                     //alert(msg);
                     if(msg==0)
                     {
                            $('#submit_receive_note').attr('disabled',true);
                            $('#received_items p#order_msg').html("<i class=' icon-warning-sign'></i> Doesn't exist!").css({"color":"#ff0012","font-size":"14px"});
                     }
                     else if(msg==1)
                     {
                            $('#received_items p#order_msg').html("<i class='cus-tick'></i>");
                            $('#submit_receive_note').attr('disabled',false);
                     }

                    }
                });  
            //}
           
     });
     
     
     $('#submit_receive_note').on('click', function(){
         // alert('clicked');
         $('#alert_show_purch').show();
         // create an array that is used to hold all the form values
         var data = {};
        
        // create a variable that will hold an object reference to all the form values
        var inputs = $('input[type="text"], input[type="date"], select', $('#received_items'));
        
        // get the object of the selected radio button and put it into a variable   
        var input = $("#received_items input[type='radio']"); 
        // capture the radio button value and put it into a variable
        var radio_val = $("#received_items input[type='radio']:checked").val();
        
       if(input.is(":checked"))
            {
                //alert(input_val);
                inputs.each(function(){
                    var el = $(this);
                    // put all the inputs into an associative array along with their values
                    data[el.attr('name')] = el.val();
                });
                
                // add the value of the checkbox to the data array
                data['radio_val'] = radio_val;
               
                
                 $.ajax({
                    url: base_url+"site_process/make_receive_note",
                    type: "POST",
                    data: data,
                    dataType: 'JSON',
                    success: function(json){
                        
                      $('#alert_show_purch').hide();
    
                     if(json.status == "success")
                         {
                              // show the message modal
                            $('#user_message').modal({
                                  keyboard: false,
                                  backdrop: true
                            });
                             $('.message_content').html("<i class='cus-tick'></i> "+json.message);
                             
                            // loop through each input and remove the values once the modal comes into view
                            inputs.each(function(){
                                 $(this).val("");
                             });
                             
                             $('#received_items p#order_msg').html("");

                         }
                      else if(json.status == "error1")
                         {

                              // show the message modal
                                $('#user_message').modal({
                                      keyboard: false,
                                      backdrop: true
                                });
                             $('.message_content').html("<i class='cus-cross'></i> "+json.message);
                             
                             // loop through each input and remove the values once the modal comes into view
                            inputs.each(function(){
                                 $(this).val("");
                             });
                             
                              $('#received_items p#order_msg').html("");

                         }

                        else if(json.status == "error2")
                           {
                                // show the message modal
                                  $('#user_message').modal({
                                        keyboard: false,
                                        backdrop: true
                                  });
                               $('.message_content').html("<i class='cus-error'></i> "+json.message);

                           }

                         else if(json.status == "failed")
                           {
                                    // show the message modal
                                          $('#user_error_message').modal({
                                                keyboard: false,
                                                backdrop: true
                                          });
                                       $('.message_error_content').html(json.message);

                           } 
                    }
                });  
            }
          else
              {
                $('#alert_show_purch').hide();
                   // show the message modal
                $('#user_error_message').modal({
                      keyboard: false,
                      backdrop: true
                });
                 $('.message_error_content').html("Please check one of the radio buttons!");
              }
       
        // turn the checked radio button into false
        input.attr('checked', false);
       // makes sure the form doesn't submit
        return false;
     });
    
     $(document).on("change","#returnNote_supplier",function(){
  
        var name; 
        var val;
        var selected = $("select option:selected");
        
        selected.each(function(){        
            name = $(this).text(); // put the current text of the option into a variable name
            val = $(this).val(); // put the current value of the option into a variable name
        });
        
        if(name == "All")
        {
              // call an ajax function called load to the specific page needed into a div tag that is defined as #load_content
              $("#load_content").load(base_url+"site_nav/partial_loadreturnNote",function(){
                  
                   $('.lpo_data_grid').dataTable( {
                        "bPaginate": false,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": false,
                        "bInfo": false,
                        "bAutoWidth": false,
                         "sScrollY": "200px",
                        "bScrollCollapse": true
                   });

                 $('#create_returnNote').attr('disabled', 'disabled');
                  
              });
        }
        else
        {     
             // load the specific return note supplier combo from the selected option,
             //  by passing the val variable to an ajax load function
              $("#load_content").load(base_url+"site_nav/returnNote_supp",{'val':val},function(){
                  
                  // load the dataTable plugin once the table has been reloaded
                   $('.lpo_data_grid').dataTable( {
                            "bPaginate": false,
                            "bLengthChange": true,
                            "bFilter": true,
                            "bSort": false,
                            "bInfo": false,
                            "bAutoWidth": false,
                             "sScrollY": "200px",
                            "bScrollCollapse": true
                     });

                   // get the row which contains the message of "no records from the database"
                   var return_note = $('#return_details tbody .odd');
                   
                   // get the exact <td> that contains the message and the message itself
                   // which is the first child of a particular 
                   var empty = $('td:nth-child(1)', return_note).html();
                   
                   if(empty == "No data available in table")
                   {
                          $('#create_returnNote').attr('disabled', 'disabled'); 
                   }
                   else
                   {
                         $('#create_returnNote').removeAttr('disabled');
                         
                         // change the value 
                         $('#create_returnNote').val(val);
                   }
                   

              });
           
        }
       
    });
    
     // when the button on the return note list is clicked and it leads to the creation of a pdf
     $(document).on("click","a[rel=save_return]",function(){
         //alert($(this).attr('id'));
         window.open(base_url+"tut_pdf/return_note/"+$(this).attr('id')) ;
     });
     
      $(document).on("click","#create_returnNote",function(){
          //alert($(this).val())
         window.open(base_url+"tut_pdf/return_noteSupp/"+$(this).val()) ;
     });
     
      // when an option in the lpo report select box is selected the following loads some data from the database
      // according to what was selected
       $(document).on("change","#lpo_report_supplier",function(){
  
        var name; 
        var val;
        var selected = $("select option:selected");
        
        selected.each(function(){        
            name = $(this).text(); // put the current text of the option into a variable name
            val = $(this).val(); // put the current value of the option into a variable name
        });
        
        if(name == "All")
        {
              // call an ajax function called load to the specific page needed into a div tag that is defined as #load_content
              $("#load_lpo_report").load(base_url+"site_nav/partial_load_lpo_report",function(){
                  
                   $('.data_grid').dataTable( {
                        "bPaginate": false,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": false,
                        "bInfo": false,
                        "bAutoWidth": false,
                         "sScrollY": "200px",
                        "bScrollCollapse": true
                   });

                 $('#create_lpo_report').attr('disabled', 'disabled');
                  
              });
        }
        else
        {     
             // load the specific return note supplier combo from the selected option,
             //  by passing the val variable to an ajax load function
              $("#load_lpo_report").load(base_url+"site_nav/partial_lpoSupp_report",{'val':val},function(){
                  
                  // load the dataTable plugin once the table has been reloaded
                   $('.data_grid').dataTable( {
                            "bPaginate": false,
                            "bLengthChange": true,
                            "bFilter": true,
                            "bSort": false,
                            "bInfo": false,
                            "bAutoWidth": false,
                             "sScrollY": "200px",
                            "bScrollCollapse": true
                     });

                   // get the row which contains the message of "no records from the database"
                   var return_note = $('#lpo_page tbody .odd');
                   
                   // get the exact <td> that contains the message and the message itself
                   // which is the first child of a particular 
                   var empty = $('td:nth-child(1)', return_note).html();
                   
                   if(empty == "No data available in table")
                   {
                          $('#create_lpo_report').attr('disabled', 'disabled'); 
                   }
                   else
                   {
                         $('#create_lpo_report').removeAttr('disabled');
                         
                         // change the value 
                         $('#create_lpo_report').val(val);
                   }
                   

              });
           
        }
       
    });
    
    // when the single link on the LPO report page is clicked and it leads to the creation of a pdf
     $(document).on("click","a[rel=lpo_report]",function(){
         //alert($(this).attr('id'));
         window.open(base_url+"tut_pdf/single_lpo_report/"+$(this).attr('id')) ;
     });
     
     // when the create report button on the LPO report page is clicked and it leads to the creation of a pdf
      $(document).on("click","#create_lpo_report",function(){
          //alert($(this).val())
         window.open(base_url+"tut_pdf/bulk_lpo_report/"+$(this).val()) ;
     });
     
     // deals with the view items page modal that is used to create a purchase requisiont
     $(document).on('click','a[rel=purchReq_modal]',function(){
         $('#purch_items').modal({
            keyboard: false,
            backdrop: true
        });
        
        // display the date when the modal comes into focus
          $("#date").datepicker({
            yearRange: "-30:+0",
            showOn: "button",
            buttonImage: "../assets/css/img/calendar_add.png",
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true
            
         });
        $('#ui-datepicker-div').wrap('<div style="font-size:11px;"></div>');
        
        var item_id = $(this).attr('id');
        
        $.ajax({
            url:base_url+'site_process/purchItemReq_details',
            type: 'POST',
            data: 'item_id='+item_id,
            success: function(data){
               // alert(data);
                var details = data.split(',');
                $("input[name=itemName]").val(details[0]);
                $("input[name=description]").val(details[1]);
                $("input[name=price]").val(details[2]);
            }
        })
     });

//............................................................ end procurement page handlers..................................................................................................................................................../


//..............................................................finance page handlers...................................................................................................................................................................../

    // the "on" function is used to bind the whole function 
    // because it will take care of current element and future element 
    // in case if you want to load the markup which contains the clicked linked dynamically
    $(document).on("click","a[rel=purch_req_modal]",function(){

        // when the link with relation of modal is clicked show modal
        $('#purchase').modal({
            keyboard: false,
            backdrop: true
        });
        
        var input = $("#purchase input[type='radio']"); // get the object of the selected radio button and put it into a variable   
        input.attr('checked', false); // turn the checked radio button into false
        $('#purchase p').html(' ');

        purch_id = $(this).attr('id'); // get the value of the id attribute this object which is the link a[rel=modal]

        $.ajax({
            url: base_url+'site_process/show_purchReq_details',
//             url: 'site_process/show_purchReq_details',
            type: "POST",
            data: "id="+purch_id,
            success: function(msg){
                $('#detailed_purchData').html(msg); // display the table rows in the modal window
            // alert(msg);

            }
        });

    });
   
    // when the modal button Submit has been clicked the following function is carried out 
    $(document).on("click","#purch_req_submit",function(){
        
        $('#confirm').show();
        // get the object of the selected radio button and put it into a variable   
        var input = $("#purchase input[type='radio']"); 
        var input_val = $("#purchase input[type='radio']:checked").val();
        
        // check whether a radio button(input) has been checked
        if(input.is(':checked'))
        { 
            $.ajax({
                url: base_url+"site_process/change_purchReq_status",
                type: "POST",
                data: "input_val="+input_val+'&purch_id='+purch_id,
                dataType: 'json', // let the data being returne be of type json
                success: function(data){
                    $('#confirm').hide();
                    
                    if(data.status==1)
                        {
                              // the load function loads the exact section of a page and appends the select section
                                // to the selected id which in this case is #content_main
                                $(".rev_purch_req").load(base_url+"site_nav/partial_load_fin",function(){
                                         // load the dataTable grid table
                                         $('.data_grid').dataTable( {
                                                "bPaginate": false,
                                                "bLengthChange": true,
                                                "bFilter": true,
                                                "bSort": false,
                                                "bInfo": false,
                                                "bAutoWidth": false,
                                                "sScrollY": "200px",
                                                "bScrollCollapse": true
                                        });
                                });
                                
                              $('#purchase').modal('hide');
                              $('#user_message').modal({
                                          keyboard: false,
                                          backdrop: true
                                    });

                              $('.message_content').html("<i class='cus-tick'></i> "+data.message);   
                        }
                     else if(data==2)
                        {
                              $('#purchase').modal('hide');
                              $('#user_message').modal({
                                          keyboard: false,
                                          backdrop: true
                                    });

                              $('.message_content').html("<i class='cus-cross'></i> "+data.message);
                        }
                                               
                },
                error: function(){
                     $('#purchase').modal('hide');
                     $('#user_message').modal({
                                          keyboard: false,
                                          backdrop: true
                                    });

                     $('.message_content').html("<i class='cus-error'></i> Server Error,please contact admin");
                }
            });
                    
                   
        }
        else
        {
            //alert('Please choose one of the radio buttons');
            $('#purchase p').html('Please approve or reject the requisition');
        }
                
        $("#purchase input[type='radio']").click(function(){  
            $('#purchase p').html(' ');
              
        });
         
    });
   
   
//.............................................................. end of finance page handlers.................................................................................................................................................................

//.............................................................. admin page handlers.................................................................................................................................................................

// when the user clicks on the view details button/link a modal appears that shows the user details
 $(document).on("click","a[rel=userDetails_modal]",function(){ 
         user_id = $(this).attr('id');
         
         $.ajax({
             url: base_url+'site_process/showUser_details',
             type: 'POST',
             data: 'user_id='+user_id,
             success: function(msg){
                 //alert(msg);
                  $('#user_form_details').modal({
                    keyboard: false,
                    backdrop: true
                  });
                  
                  $('#user_form_details .modal-body table').html(msg);   
             }
         });  
 });

 // when the user clicks the add new user button/link a dialog appears
   $(document).on("click","a[rel=add_users]",function(){ 
      
       $('#edit_form').modal({
            keyboard: false,
            backdrop: true
        });
        
        $('#edit_form .modal-header h3').html("Add New User");
        
        $("#update_user").hide();
        $('#add_user').show();
        
          // display the date when the modal comes into focus
          $("#date").datepicker({
            yearRange: "-30:+0",
            showOn: "button",
            buttonImage: "../assets/css/img/calendar_add.png",
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true 
         });
        $('#ui-datepicker-div').wrap('<div style="font-size:11px;"></div>');
        
         var inputs = $('input[type="text"], input[type="date"]', $('#edit_form .modal-body'));
         
         inputs.each(function(){
             $(this).val("");
         });
         
         $('select',$('#edit_form .modal-body')).each(function(){
             $(this).val('selected').is('option:selected');
         });

  });
  
  // when the admin creates a new user of the system
  $(document).on("click","#add_user",function(){
      
          // get all inputed data from the modal form
          var inputs = $('input[type="text"], input[type="date"], select', $('#edit_form .modal-body'));

        //create an array that will hold the all the input values
           var data = {};

           // for every input put the input's value into an array where the inputs name is array's index
           inputs.each(function(){
                 var el = $(this);
                 data[el.attr('name')] = el.val();
           });
           
           $('#confirm_user').show();
           
           $.ajax({
                     url: base_url+'site_process/insertUser_details',
                     type: 'POST',
                     data: data,
                     dataType: 'json', 
                     success: function(json){
                       
                        $('#confirm_user').hide();
     
                         if(json.status == "success")
                             {
                                 // load the specific page before the modal is loaded so that the page is updated
                                 $("#edit_ui_users").load(base_url+"site_nav/partial_load_editTable",function(){
                                            $('.admin').dataTable( {
                                                    "bPaginate": false,
                                                    "bLengthChange": true,
                                                    "bFilter": true,
                                                    "bSort": false,
                                                    "bInfo": false,
                                                    "bAutoWidth": false,
                                                    "bScrollCollapse": true,
                                                    "sScrollY": "200px" 
                                             });
                                 });
                                 // hide the user form modal
                                 $('#edit_form').modal('hide');
                                   // show the message modal
                                    $('#user_message').modal({
                                          keyboard: false,
                                          backdrop: true
                                    });

                                 $('.message_content').html("<i class='cus-tick'></i>The new user has been added");
                             }
                         else if(json.status == "error")
                             {
                                 $('#edit_form').modal('hide');
                                  // show the message modal
                                    $('#user_message').modal({
                                          keyboard: false,
                                          backdrop: true
                                    });
                                 $('.message_content').html("<i class='cus-error'></i> User has not been added!");
                                 
                             }
                          else if(json.status == "failed")
                             {
                                  // show the message modal
                                    $('#user_error_message').modal({
                                          keyboard: false,
                                          backdrop: true
                                    });
                                 $('.message_error_content').html(json.message);
                                 
                             }   
                     }
               });    
     // }
     
  });
  
  // when the user clicks the edit user button/link a dialog appears with editable user details
   $(document).on("click","a[rel=editUser_modal]",function(){
       
       $('#edit_form').modal({
            keyboard: false,
            backdrop: true
        });
        
       $('#edit_form .modal-header h3').html("Update User");
       
       $('#add_user').hide();
       $("#update_user").show();

       user_id = $(this).attr('id');
       
       $.ajax({
             url: base_url+'site_process/editUser_details',
             type: 'POST',
             data: 'user_id='+user_id,
             success: function(data){
                 
             // display the date when the modal is shown
                $("#date").datepicker({
                  yearRange: "-30:+0",
                  showOn: "button",
                  buttonImage: "../assets/css/img/calendar_add.png",
                  buttonImageOnly: true,
                  changeMonth: true,
                  changeYear: true

               });
              $('#ui-datepicker-div').wrap('<div style="font-size:11px;"></div>');
                   
            // split the content of the data into an array which is assigned to the details variable
                var details = data.split(',');
                $("input[name=firstName]").val(details[0]);
                $("input[name=secondName]").val(details[1]);
                $("input[name=username]").val(details[2]);
                $("input[name=dob]").val(details[3]);
                
                $("select[name=department]").val(details[4]).is("option:selected");
                
                $("input[name=role]").val(details[5]);
                $("input[name=national_id]").val(details[6]);
                
                $("select[name=gender]").val(details[7]).is("option:selected");
              
                $("input[name=email]").val(details[8]);
                
                $("select[name=user_status]").val(details[9]).is("option:selected");
                
                
            }
       });  
  });
 
 $(document).on("click","#update_user",function(){ 
          //alert('clicked');
          // get all inputed data from the modal form
          var inputs = $('input[type="text"], input[type="date"], select', $('#edit_form .modal-body'));

        //create an array that will hold the all the input values
           var data = {};

           // for every input put the input's value into an array where the inputs name is array's index
           inputs.each(function(){
                 var el = $(this);
                 data[el.attr('name')] = el.val();
           });
           
           // add the user id data to the id index of the data array
           data['id'] = user_id;
           
           $('#confirm_user').show();
           
           $.ajax({
                     url: base_url+'site_process/update_user_data',
                     type: 'POST',
                     data: data,
                     dataType: 'json', 
                     success: function(json){
                            
                          $('#confirm_user').hide();
                            
                         if(json.status == "success")
                             {   
                                  $("#edit_ui_users").load(base_url+"site_nav/partial_load_editTable",function(){
                                             $('.admin').dataTable( {
                                                        "bPaginate": false,
                                                        "bLengthChange": true,
                                                        "bFilter": true,
                                                        "bSort": false,
                                                        "bInfo": false,
                                                        "bAutoWidth": false,
                                                        "bScrollCollapse": true,
                                                        "sScrollY": "200px" 
                                             });

                                  });
                                  // hide the user form modal
                                 $('#edit_form').modal('hide');
                                   // show the message modal
                                $('#user_message').modal({
                                      keyboard: false,
                                      backdrop: true
                                });

                                 $('.message_content').html("<i class='cus-tick'></i> User data successfully updated"); 
                             }
                         else if(json.status == "error")
                             {
                                
                                  $('#edit_form').modal('hide');
                                  // show the message modal
                                    $('#user_message').modal({
                                          keyboard: false,
                                          backdrop: true
                                    });
                                 $('.message_content').html("<i class='cus-error'></i> User data not been updated!");
                             }
                        else if(json.status == "failed")
                         {
                              // show the message modal
                                $('#user_error_message').modal({
                                      keyboard: false,
                                      backdrop: true
                                });
                             $('.message_error_content').html(json.message);
                             // alert('validation error');
                         }     

                     }
               });    
     
 });
 
   // when a user selects a user  status
  $(document).on("change","#user_status",function(){
        var name;
        var val;
        var selected = $("#user_status option:selected");

        name = selected.text();
        val = selected.val();
     
        if(name == "User Status")
        { 
              // call an ajax function called load to the specific page needed into a div tag that is defined as #edit_ui_table
              $("#edit_ui_users").load(base_url+"site_nav/partial_load_all_users",function(){
                            // load the dataTable for this particular table
                            $('.admin').dataTable( {
                                        "bPaginate": false,
                                        "bLengthChange": true,
                                        "bFilter": true,
                                        "bSort": false,
                                        "bInfo": false,
                                        "bAutoWidth": false,
                                        "bScrollCollapse": true,
                                        "sScrollY": "200px"

                             });
                  
              });
        }
        else
        {    
             // load the specific suppluer depending on the status selected from a select box from the UI
             //  by passing the val variable to an ajax load function which passes it to a php script to process and return the required data
              $("#edit_ui_users").load(base_url+"site_nav/partial_load_userOn_status",{'val':val},function(){
                           // load the dataTable for this particular table
                            $('.admin').dataTable( {
                                        "bPaginate": false,
                                        "bLengthChange": true,
                                        "bFilter": true,
                                        "bSort": false,
                                        "bInfo": false,
                                        "bAutoWidth": false,
                                        "bScrollCollapse": true,
                                        "sScrollY": "200px"

                             });
              });
        }
    });
    
 
 // when the  add link/button is clicked a modal appears to enable the user to add a new item
 $(document).on('click','a[rel=add_item]',function(){
    
         $('#edit_form').modal({
                keyboard: false,
                backdrop: true
          });

          $('#edit_form .modal-header h3').html("Add New Item");

          $('#update_item').hide();
          $('#add_item').show();

          var inputs = $('input[type="text"], input[type="date"]', $('#edit_form .modal-body'));

         inputs.each(function(){
             $(this).val("");
         });

         $('select',$('#edit_form .modal-body')).each(function(){
             $(this).val('selected').is('option:selected');
         });
      
 })
 
 // add a new item to the database and gives feedback to the user
 $(document).on('click','#add_item',function(){
    
          // get all inputed data from the modal form
          var inputs = $('input[type="text"], select', $('#edit_form .modal-body'));

           //create an array that will hold the all the input values
           var data = {};

           // for every input put the input's value into an array where the inputs name is array's index
           inputs.each(function(){
                 var el = $(this);
                 data[el.attr('name')] = el.val();
           });
           
           $('#confirm').show();
           $.ajax({
                     url: base_url+'site_process/insert_new_item',
                     type: 'POST',
                     data: data,
                     dataType: 'json', 
                     success: function(json){
                         
                         $('#confirm').hide();
                         
                         if(json.status == "success")
                             {
                                 // load the specific page before the modal is loaded so that the page is updated
                                 $("#load_edit_itemTable").load(base_url+"site_nav/partial_load_items",function(){
                                               $('.admin').dataTable( {
                                                        "bPaginate": false,
                                                        "bLengthChange": true,
                                                        "bFilter": true,
                                                        "bSort": false,
                                                        "bInfo": false,
                                                        "bAutoWidth": false,
                                                        "bScrollCollapse": true,
                                                        "sScrollY": "200px" 
                                                 });
                                 });
                                 // hide the user form modal
                                 $('#edit_form').modal('hide');
                                   // show the message modal
                                    $('#user_message').modal({
                                          keyboard: false,
                                          backdrop: true
                                    });

                                 $('.message_content').html("<i class='cus-tick'></i>The new item has been added");
                             }
                         else if(json.status == "error")
                             {
                                 $('#edit_form').modal('hide');
                                  // show the message modal
                                    $('#user_message').modal({
                                          keyboard: false,
                                          backdrop: true
                                    });
                                 $('.message_content').html("<i class='cus-error'></i> Item has not been added!");
                                 
                             }
                          else if(json.status == "failed")
                             {
                                  // show the message modal
                                    $('#user_error_message').modal({
                                          keyboard: false,
                                          backdrop: true
                                    });
                                 $('.message_error_content').html(json.message);
                                 
                             }   

                     }
               });    
 });
 
 // when the  add link/button is clicked a modal appears to enable the user to edit a current item
 $(document).on('click','a[rel=editItems_modal]',function(){
    
     itemID = $(this).attr('id');
     
     $('#edit_form').modal({
            keyboard: false,
            backdrop: true
      });
      
      $('#edit_form .modal-header h3').html("Update Item");
      
      $('#add_item').hide();
      $('#update_item').show();
      
       $.ajax({
             url: base_url+'site_process/editItem_details',
             type: 'POST',
             data: 'item_id='+itemID,
             success: function(data){
                    
            // split the content of the data into an array which is assigned to the details variable
                var details = data.split(',');
                $("input[name=itemName]").val(details[0]);
                $("input[name=itemDescription]").val(details[1]);
                $("input[name=pricePerUnit]").val(details[2]);
                $("input[name=quantity]").val(details[3]);
                $("input[name=quantity_limit]").val(details[4]);
                $("select[name=category]").val(details[5]).is("option:selected"); 
            }
       }); 
 });
 
 // updates a current item to the database and gives feedback to the user
 $(document).on('click','#update_item',function(){
                 
          // get all inputed data from the modal form
          var inputs = $('input[type="text"], select', $('#edit_form .modal-body'));

           //create an array that will hold the all the input values
           var data = {};

           // for every input put the input's value into an array where the inputs name is array's index
           inputs.each(function(){
                 var el = $(this);
                 data[el.attr('name')] = el.val();
           });
           
           // assign the item ID to the data array with the index of id as its reference
           data['id'] = itemID;
           
           $('#confirm').show();
           
           $.ajax({
                     url: base_url+'site_process/update_item',
                     type: 'POST',
                     data: data,
                     dataType: 'json', 
                     success: function(json){
                         
                          $('#confirm').hide();
                          
                         if(json.status == "success")
                             {
                                 // load the specific page before the modal is loaded so that the page is updated
                                 $("#load_edit_itemTable").load(base_url+"site_nav/partial_load_items",function(){
                                     
                                            $('.admin').dataTable( {
                                                    "bPaginate": false,
                                                    "bLengthChange": true,
                                                    "bFilter": true,
                                                    "bSort": false,
                                                    "bInfo": false,
                                                    "bAutoWidth": false,
                                                    "bScrollCollapse": true,
                                                    "sScrollY": "200px" 
                                             });
                                 });
                                 // hide the user form modal
                                 $('#edit_form').modal('hide');
                                   // show the message modal
                                    $('#user_message').modal({
                                          keyboard: false,
                                          backdrop: true
                                    });

                                 $('.message_content').html("<i class='cus-tick'></i> Item has been updated");
                             }
                         else if(json.status == "error")
                             {
                               
                                 $('#edit_form').modal('hide');
                                  // show the message modal
                                    $('#user_message').modal({
                                          keyboard: false,
                                          backdrop: true
                                    });
                                 $('.message_content').html("<i class='cus-error'></i> Item has not been updated!");
                                 
                             }
                          else if(json.status == "failed")
                             {
                                
                                  // show the message modal
                                    $('#user_error_message').modal({
                                          keyboard: false,
                                          backdrop: true
                                    });
                                 $('.message_error_content').html(json.message);
                                 
                             }   

                     }
               });    
 });
 
 // when a user selects a certain item cateogry
  $(document).on("change","#category",function(){
        var name; 
        var val;
        var selected = $("#category option:selected");
//        selected.each(function(){        
//            name = $(this).text(); // put the current text of the option into a variable name
//            val = $(this).val(); // put the current value of the option into a variable name
//        });
        name = selected.text();
        val = selected.val();

        if(name == "Select a Category")
        {
              // call an ajax function called load to the specific page needed into a div tag that is defined as #load_edit_itemTable
              $("#load_edit_itemTable").load(base_url+"ite_nav/partial_load_items",function(){
                  
                        $('.admin').dataTable( {
                                "bPaginate": false,
                                "bLengthChange": true,
                                "bFilter": true,
                                "bSort": false,
                                "bInfo": false,
                                "bAutoWidth": false,
                                "bScrollCollapse": true,
                                "sScrollY": "200px" 
                         });
              });
        }
        else
        {    
             // load the specific item depending on the category selected from 
             //  by passing the val variable to an ajax load function which passes it to a db script to process and return the required data
              $("#load_edit_itemTable").load(base_url+"site_nav/partial_loadItem_category",{'val':val},function(){
                  
                         $('.admin').dataTable( {
                                "bPaginate": false,
                                "bLengthChange": true,
                                "bFilter": true,
                                "bSort": false,
                                "bInfo": false,
                                "bAutoWidth": false,
                                "bScrollCollapse": true,
                                "sScrollY": "200px" 
                         });
                  
              });
        }
    });
    
    // when the add new category button is clicked
    $(document).on('click','#add_category',function(){
       //alert('clicked');
       $('#add_edit_category').modal({
           keyboard: false,
           backdrop: true
       });
       
       $('#update_category').hide();
       $('#add_new_category').show();
      
       
       $('#add_edit_category .modal-header h3').html('Add New Category');
       $('#add_edit_category .modal-body').html('<label>Category Name:</label><input type="text" name="newCategory">');  
    });
    
    // when the add category button is clicked the new category name is added to the database through ajax request
    $(document).on('click','#add_new_category',function(){
       
          var input = $('#add_edit_category input[name=newCategory] ').val();
           
         $('#confirmation').show();
         
           $.ajax({
                     url: base_url+'site_process/insert_new_category',
                     type: 'POST',
                     data: 'newCategory='+input,
                     dataType: 'json', 
                     success: function(json){
                         
                      $('#confirmation').hide();
                       
                         if(json.status == "success")
                             {
                                  //load the specific page before the modal is loaded so that the page is updated
                                 $("#edit_ui").load(base_url+"site_nav/partial_loadCategory_list",function(){
                                     
                                            $('.admin').dataTable( {
                                                    "bPaginate": false,
                                                    "bLengthChange": true,
                                                    "bFilter": true,
                                                    "bSort": false,
                                                    "bInfo": false,
                                                    "bAutoWidth": false,
                                                    "bScrollCollapse": true,
                                                    "sScrollY": "200px" 
                                             });
                                 });
                                 // hide the user form modal
                                 $('#add_edit_category').modal('hide');
                                   // show the message modal
                                    $('#user_message').modal({
                                          keyboard: false,
                                          backdrop: true
                                    });

                                 $('.message_content').html("<i class='cus-tick'></i> Category has been added");
                             }
                         else if(json.status == "error")
                             {
                                 $('#add_edit_category').modal('hide');
                                  // show the message modal
                                    $('#user_message').modal({
                                          keyboard: false,
                                          backdrop: true
                                    });
                                 $('.message_content').html("<div><p style='background-color:#f7d48b;color:#c07a0b;border-radius: 3px;padding:3px; margin:0px 3px 3px 0px; '><i class='cus-error''></i> Category not added!</p>\n\
                                                            <p style='background-color:#9dcef0;color:#155d8d;border-radius: 3px;padding:3px;'> Please input another category name.<p/></div>");
  
                             }
                          else if(json.status == "failed")
                             {
                                  // show the message modal
                                    $('#user_error_message').modal({
                                          keyboard: false,
                                          backdrop: true
                                    });
                                 $('.message_error_content').html(json.message);
                                 
                             }   
                     }
               });    
        
    });
    
     // when the add new category button is clicked
    $(document).on('click','#edit_category',function(){
       //alert('clicked');
       $('#add_edit_category').modal({
           keyboard: false,
           backdrop: true
       });
       
        $('#update_category').show();
       $('#add_new_category').hide();
       
       $('#add_edit_category .modal-header h3').html('Edit Categories');
      
       $.ajax({
           url: base_url+'site_process/show_categoryTo_edit',
           type: 'POST',
           success: function(data){
              $('#add_edit_category .modal-body').html(data);
           }
       });
       
    });
    
    // when the category update button is clicked
    $(document).on('click','#update_category',function(){
        var inputs =  $('#add_edit_category input[type=text]') ;
        
        var input_val = {};
        
        inputs.each(function(){
            var el = $(this);
            input_val[el.attr('name')] = el.val();
             //alert(input_val[el.attr('name')]);
           
        });
        
        $('#confirmation').show();
        $.ajax({
                url: base_url+'site_process/updateEdited_catgory',
                type: 'POST',
                data: input_val,
                dataType: 'json',
                success: function(json){
                    
                  $('#confirmation').hide();
                  
                    if(json.status == "success")
                         {
                             //load the specific page before the modal is loaded so that the page is updated
                             $("#edit_ui").load(base_url+"site_nav/partial_loadCategory_list",function(){
                                 
                                    $('.admin').dataTable( {
                                            "bPaginate": false,
                                            "bLengthChange": true,
                                            "bFilter": true,
                                            "bSort": false,
                                            "bInfo": false,
                                            "bAutoWidth": false,
                                            "bScrollCollapse": true,
                                            "sScrollY": "200px" 
                                     });
                                 
                             });
                             // hide the user form modal
                             $('#add_edit_category').modal('hide');
                               // show the message modal
                                $('#user_message').modal({
                                      keyboard: false,
                                      backdrop: true
                                });

                             $('.message_content').html("<i class='cus-tick'></i> Category has been updated");
                         }
                     else if(json.status == "error")
                         {

                             $('#add_edit_category').modal('hide');
                              // show the message modal
                                $('#user_message').modal({
                                      keyboard: false,
                                      backdrop: true
                                });
                             $('.message_content').html("<i class='cus-error'></i> Category not been updated!");

                         }
                      else if(json.status == "failed")
                             {
                                  // show the message modal
                                    $('#user_error_message').modal({
                                          keyboard: false,
                                          backdrop: true
                                    });
                                 $('.message_error_content').html(json.message);
                                 
                             }     
                  }
            }); 
    });
    
      // when the add new category button is clicked
    $(document).on('click','a[rel=add_supp]',function(){
      // alert('clicked');
       $('#edit_form').modal({
           keyboard: false,
           backdrop: true
       });
       
       $('#add_supp').show();
       $('#update_supp').hide();
       
       $('#edit_form .modal-header h3').html('Add New Supplier');
       
          // display the date when the modal comes into focus
          $("#date").datepicker({
            yearRange: "-30:+0",
            showOn: "button",
            buttonImage: "../assets/css/img/calendar_add.png",
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true

         });
        $('#ui-datepicker-div').wrap('<div style="font-size:11px;"></div>');
        
        // get all the for inputs and represent them in a variable
         var inputs = $('input[type="text"]', $('#edit_form .modal-body'));
         // loop through each input and remove the values once the modal comes into view
          inputs.each(function(){
               $(this).val("");
           });
    });
    
    // in order to add the supplier to the database you click the #add_supp link/button
    $(document).on('click','#add_supp',function(){ 
          // get all inputed data from the modal form
          var inputs = $('input[type="text"], select', $('#edit_form .modal-body'));

           //create an array that will hold the all the input values
           var data = {};

           // for every input put the input's value into an array where the inputs name is array's index
           inputs.each(function(){
                 var el = $(this);
                 data[el.attr('name')] = el.val();
           });
           
           $('#confirm_supp').show();
           
           $.ajax({
                     url: base_url+'site_process/insert_new_supplier',
                     type: 'POST',
                     data: data,
                     dataType: 'json', 
                     success: function(json){
                            
                         $('#confirm_supp').hide();
                         
                         if(json.status == "success")
                             {
                                 // load the specific page before the modal is loaded so that the page is updated
                                 $("#edit_ui_table").load(base_url+"site_nav/partial_load_suppTable",function(){
                                            $('.admin').dataTable( {
                                                    "bPaginate": false,
                                                    "bLengthChange": true,
                                                    "bFilter": true,
                                                    "bSort": false,
                                                    "bInfo": false,
                                                    "bAutoWidth": false,
                                                    "bScrollCollapse": true,
                                                    "sScrollY": "200px" 
                                             });
                                 });
                                 // hide the user form modal
                                 $('#edit_form').modal('hide');
                                   // show the message modal
                                    $('#user_message').modal({
                                          keyboard: false,
                                          backdrop: true
                                    });

                                 $('.message_content').html("<i class='cus-tick'></i> New supplier data has been added");
                             }
                         else if(json.status == "error")
                             {
                                 $('#edit_form').modal('hide');
                                  // show the message modal
                                    $('#user_message').modal({
                                          keyboard: false,
                                          backdrop: true
                                    });
                                 $('.message_content').html("<i class='cus-error'></i> Supplier data has not been added!");
                                 
                             }
                          else if(json.status == "failed")
                             {
                                  // show the message modal
                                    $('#user_error_message').modal({
                                          keyboard: false,
                                          backdrop: true
                                    });
                                 $('.message_error_content').html(json.message);                                 
                             }   
                     }
               });    
    });
    
    // when the add new category button is clicked
    $(document).on('click','a[rel=edit_supp]',function(){
      
       $('#edit_form').modal({
           keyboard: false,
           backdrop: true
       });
       
       $('#add_supp').hide();
       $('#update_supp').show();
       
       $('#edit_form .modal-header h3').html('Edit Supplier');
       
         // display the date when the modal comes into focus
          $("#date").datepicker({
            yearRange: "-30:+0",
            showOn: "button",
            buttonImage: "../assets/css/img/calendar_add.png",
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true
            
         });
        $('#ui-datepicker-div').wrap('<div style="font-size:11px;"></div>');
       
        supplierID =  $(this).attr('id');
       
         $.ajax({
             url: base_url+'site_process/editSupplier_details',
             type: 'POST',
             data: 'supplierID='+supplierID,
             success: function(data){
                  
            // split the content of the data into an array which is assigned to the details variable
                var details = data.split(',');
                $("input[name=supplierName]").val(details[0]);
                $("input[name=supplierLocation]").val(details[1]);
                $("input[name=itemsSupplied]").val(details[2]);
                $("input[name=phone_no]").val(details[3]);
                $("input[name=email]").val(details[4]);
                $("input[name=date]").val(details[5]);
                $("select[name=status]").val(details[6]).is("option:selected"); 
            }
       }); 
      
     
    });

     // when the category update button is clicked
    $(document).on('click','#update_supp',function(){
       // alert(supplierID);
         // get all inputed data from the modal form
          var inputs = $('input[type="text"], select', $('#edit_form .modal-body'));

           //create an array that will hold the all the input values
           var data = {};

           // for every input put the input's value into an array where the inputs name is array's index
           inputs.each(function(){
                 var el = $(this);
                 data[el.attr('name')] = el.val();
           });
          
          // add the supplierID to the data array
          data['id'] = supplierID;
          
         $('#confirm_supp').show();
         
        $.ajax({
                url: base_url+'site_process/update_supplier_data',
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function(json){
                    
                   $('#confirm_supp').hide();
                   
                    if(json.status == "success")
                         {
                              // load the specific page before the modal is loaded so that the page is updated
                              $("#edit_ui_table").load(base_url+"site_nav/partial_load_suppTable",function(){
                                            $('.admin').dataTable( {
                                                    "bPaginate": false,
                                                    "bLengthChange": true,
                                                    "bFilter": true,
                                                    "bSort": false,
                                                    "bInfo": false,
                                                    "bAutoWidth": false,
                                                    "bScrollCollapse": true,
                                                    "sScrollY": "200px" 
                                             });
                              });
                             // hide the user form modal
                             $('#edit_form').modal('hide');
                               // show the message modal
                                $('#user_message').modal({
                                      keyboard: false,
                                      backdrop: true
                                });

                             $('.message_content').html("<i class='cus-tick'></i> Supplier data has been updated");
                         }
                     else if(json.status == "error")
                         {

                             $('#edit_form').modal('hide');
                              // show the message modal
                                $('#user_message').modal({
                                      keyboard: false,
                                      backdrop: true
                                });
                             $('.message_content').html("<i class='cus-error'></i> Supplier data has not been updated!");

                         }
                      else if(json.status == "failed")
                         {
                                  // show the message modal
                                    $('#user_error_message').modal({
                                          keyboard: false,
                                          backdrop: true
                                    });
                                 $('.message_error_content').html(json.message);
                                 
                         }     
                }
            });
    });
    
    // when a user selects a supplier status
  $(document).on("change","#supplier_status",function(){
        var name;
        var val;
        var selected = $("#supplier_status option:selected");

        name = selected.text();
        val = selected.val();
        
        if(name == "Supplier Status")
        { 
              // call an ajax function called load to the specific page needed into a div tag that is defined as #edit_ui_table
              $("#edit_ui_table").load(base_url+"site_nav/partial_load_suppTable",function(){
                         $('.admin').dataTable( {
                                "bPaginate": false,
                                "bLengthChange": true,
                                "bFilter": true,
                                "bSort": false,
                                "bInfo": false,
                                "bAutoWidth": false,
                                "bScrollCollapse": true,
                                "sScrollY": "200px" 
                         });
              });
        }
        else
        {    
             // load the specific suppluer depending on the status selected from a select box from the UI
             //  by passing the val variable to an ajax load function which passes it to a php script to process and return the required data
              $("#edit_ui_table").load(base_url+"site_nav/partial_load_statusSupp",{'val':val},function(){
                             $('.admin').dataTable( {
                                    "bPaginate": false,
                                    "bLengthChange": true,
                                    "bFilter": true,
                                    "bSort": false,
                                    "bInfo": false,
                                    "bAutoWidth": false,
                                    "bScrollCollapse": true,
                                    "sScrollY": "200px" 
                             });
              });
        }
    });
    
    //.......................search functions for users,items and suppliers...................................
    //.....................user search...................
    
    $('#user_typeahead').typeahead({
            source: function(query,process){
//              $.ajax({
//                    url: base_url+"site_process/search_user_names",
//                    type: "POST",
//                    data: "query="+query,
//                    dataType: "JSON",
//                    async:  false,
//                    success: function(data){
//                      return process(data);
//                       
//                    }
//                  });  

                $.post(base_url+'site_process/search_user_names', { query: query}, function(data) {
                      process(JSON.parse(data));
                  });
                  },
            updater: function(item){
                $('#edit_ui_users').load(base_url+"site_nav/partial_loadUser_on_firstName",{'name':item});
            }
    });
    
    // refreshes the user table ie shows all the table rows
    $(document).on('click','#refresh_user_table',function(){
        $('#edit_ui').load(base_url+"site_nav/reload_user_table",function(){
            
               // load the dataTable grid
                $('.admin').dataTable( {
                    "bPaginate": false,
                    "bLengthChange": true,
                    "bFilter": true,
                    "bSort": false,
                    "bInfo": false,
                    "bAutoWidth": false,
                    "bScrollCollapse": true,
                    "sScrollY": "200px" 
                });
        });
    }) ; 
    
    //..............end user search..............
    
    //...............item search.................
    
     $('#item_typeahead').typeahead({
            source: function(query,process){

                $.post(base_url+'site_process/search_item_names', { query: query}, function(data) {
                      process(JSON.parse(data));
                  });
                  },
               updater: function(item){
                    $('#load_edit_itemTable').load(base_url+"site_nav/partial_load_itemBy_Name",{'name':item});
                }
    });
    
    // refreshes the items table ie shows all the table rows
    $(document).on('click','#refresh_items_table',function(){
        $('#edit_ui').load(base_url+"site_nav/partial_loadCategory_list",function(){
              // load the dataTable grid on refresh
                 $('.admin').dataTable( {
                "bPaginate": false,
                "bLengthChange": true,
                "bFilter": true,
                "bSort": false,
                "bInfo": false,
                "bAutoWidth": false,
                "bScrollCollapse": true,
                "sScrollY": "200px" 
         });
        });
    }) ; 
    
     //...............end item search..............
     //...............supplier search.............
     
      $('#supplier_typeahead').typeahead({
            source: function(query,process){

                $.post(base_url+'site_process/search_supplier_names', { query: query}, function(data) {
                      process(JSON.parse(data));
                  });
                  },
               updater: function(item){
                    $('#edit_ui_table').load(base_url+"site_nav/partial_load_suppBy_name",{'name':item},function(){
                          $('.datatable').dataTable( {
                            "bPaginate": false,
                            "bLengthChange": false,
                            "bFilter": false,
                            "bSort": false,
                            "bInfo": false,
                            "bAutoWidth": false,
                             "sScrollY": "600px",
                            "bScrollCollapse": true

                    });
                    });
                }
    });
    
    // refreshes the items table ie shows all the table rows
    $(document).on('click','#refresh_supplier_table',function(){
        $('#edit_ui').load(base_url+"site_nav/reload_supp_table",function(){
               $('.admin').dataTable( {
                    "bPaginate": false,
                    "bLengthChange": true,
                    "bFilter": true,
                    "bSort": false,
                    "bInfo": false,
                    "bAutoWidth": false,
                    "bScrollCollapse": true,
                    "sScrollY": "200px" 
             });
        });
    }) ; 
    
    
     //...............end supplier search......... 

   //........................end if search functions............................

//.............................................................. end of admin page handlers.................................................................................................................................................................

//...............................extra stuff............................................
//.................dataTable Functions...............................

        // found in the LPO table
        $('.lpo_data_grid').dataTable( {
                "bPaginate": false,
                "bLengthChange": true,
                "bFilter": true,
                "bSort": false,
                "bInfo": false,
                "bAutoWidth": false,
                 "sScrollY": "200px",
                "bScrollCollapse": true
 
         });
        
         $('.admin').dataTable( {
                "bPaginate": false,
                "bLengthChange": true,
                "bFilter": true,
                "bSort": false,
                "bInfo": false,
                "bAutoWidth": false,
                "bScrollCollapse": true,
                "sScrollY": "200px" 
         });
         
           
        $('.data_grid').dataTable( {
                "bPaginate": false,
                "bLengthChange": true,
                "bFilter": true,
                "bSort": false,
                "bInfo": false,
                "bAutoWidth": false,
                "sScrollY": "200px",
                "bScrollCollapse": true
        });

         $('.data_grid1').dataTable( {
                "bPaginate": false,
                "bLengthChange": true,
                "bFilter": true,
                "bSort": false,
                "bInfo": false,
                "bAutoWidth": false,
                 "sScrollY": "100px",
                "bScrollCollapse": true
        });
             
  //.................end of dataTable Functions.......................
  //.............................calendar.............................
   //$('.calendar .day').click(function(){
       $(document).on("click",'.day',function(){
        day_clicked = $(this);
        
        day_num = $(this).find('.day_num').html();
       
          if(day_num != null)
                {
                     $('#edit_form.cal_modal').modal({
                                    keyboard: false,
                                    backdrop: false
                     });
                     
                      // make sure that there is no value in the text area when its loaded
                    $('textarea[name=activity]').val('');
                     // if there's a value in the '.content' let it be shown in the calendar
                    $('textarea[name=activity]').val($(this).find('.content').html());
                                        
                    $('span#remain').text($('textarea[name=activity]').attr('maxlength'));
                    //get the length of the text area and put it into a variable
                    var text_len = $('textarea[name=activity]').val().length;
                    //take the content of the span and turn it into an integer
                    var int_remain = parseInt($('span#remain').text());
                     //subtract the text length from the integer in the span
                    var new_len = int_remain - text_len;
                     //append the text to the span
                    $('span#remain').text(new_len) ; 
                }
          else
              {
                  alert('please enter content in the dates shown');
              }

     });
     
     // whenever the a key is clicked in the text area
     $('textarea[name=activity]').keyup(function(e){

            // check whether there is something has been inputed in the text area
            if($.trim($(this).val()).length)
                {
                 // alert($('textarea[name=activity]').val())
                  var int_remain = parseInt($('span#remain').text());
//                  
                  var new_remain = int_remain - 1;
                 
                   
                  
                  if(new_remain != -1)
                  {
                       $('span#remain').text(new_remain);
 
                  }
                }  
                
            if(e.which == 8 ){

                   var old_remain = 1;

                    $('span#remain').text(int_remain + old_remain);
                    if(isNaN($('span#remain').text())) 
                    {
                        $('span#remain').text("80");
                    }
               }
     });
     
    
     $(document).on('click','#add_plan',function(e){
         e.preventDefault();
         
         $('#edit_form.cal_modal').modal('hide');
        
         // show the message alert showing that the note
         // is being added
          $('#add_note_alert').show();
         
         var day_data = $('textarea[name=activity]').val();
       
         if(day_data != null){
              
                $.ajax({
                    url: base_url+'mycal/display',
                    type: 'POST',
                    data: {day:day_num,data:day_data}
                }).done(function(){
                        //$('#add_note_alert').hide();
                        
                        $("#load_calendar").load(base_url+'site_nav/partial_load_cal');
                });
        }
         
     });
   //..........................end of calendar.............................
//......................................................................................

}); // end of jquery $ object call
//...............other functions...........................
//adds a new line to a specified text
//function add_line(str){
//     var result = '';
//     while(str.length>0){
//         result += str.substring(0,14)+'\n';
//         str = str.substring(14);
//     }
//     return result;
// }

/*** End of File **/