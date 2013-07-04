$(function(){
     $('.calendar .day').click(function(){
        $('#alert_box').show();
        var day_num = $(this).find('.day_num').html();
        var day_data = prompt('Enter activity');
        
        if(day_data != null){
            $.ajax({
                url: base_url+'mycal/display',
                type: 'POST',
                data: {day:day_num,data:day_data}
            }).done(function(){
                      $('#alert_box').hide();
                    $('body').load(base_url+'mycal/display');
            });
        }
     });
});

// $(document).on("click","a[rel=previous]",function(e){
//         $('#alert_box').show();
//        e.preventDefault();
//        //alert("clicked") ;
//        var link = ($(this).attr('href'));
//        var link_array = link.split("/");
//        
//       $('#alert_box').show();
//        // alert(link);
//        $.ajax({
//            type: 'POST',
//            url: base_url+'mycal/display_test',
//            data: {"year":link_array[6],"month":link_array[7]},
//          
//        }).done(function(data){
//            $('#alert_box').hide();
//             $("#load_calendar").html(data);
//        });
//
////        $("#load_calendar").load(base_url+'mycal/display_test',{"year":link_array[6],"month":link_array[7]},function(){
////            
////        }) ;
//
//    });