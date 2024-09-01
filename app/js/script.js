    
jQuery(document).ready(function(){
    

   if(window.location.href.indexOf('event_list') >0)
   {
        load_events();
   }


    jQuery('#events-link').on("click",function(){
        jQuery('#events-section').removeClass('d-none');
        jQuery('#add-event-form').addClass('d-none');
    })

    jQuery('#add-event-btn').on("click",function(){
        jQuery('#add-event-form').removeClass('d-none');
        jQuery('#events-section').addClass('d-none');
    })

    jQuery('#cancel-btn').on("click",function(){
        jQuery('#events-section').removeClass('d-none');
        jQuery('#add-event-form').addClass('d-none');
    });

    jQuery(document).on("click","#save_event",function(e){
        e.preventDefault();
        var form = jQuery('#form_save_event')[0];
        var actionUrl = '/events-management/index.php/api/events/create';

/*         $.ajaxSetup({
            headers: {
               'X-CSRF-TOKEN': jQuery(form).find('input[name="_token"]').val()
            }
        }); */

        /* data = {
            'title':jQuery('#event_title').val(),
            'event_date':jQuery('#event_date').val(),
            'event_description':jQuery('#event_description').val(),
            'img_uploader':jQuery('#img_uploader').val(),
        } */

        var form = jQuery('#form_save_event')[0] // Get the form element
        var formData = new FormData(form) // Create a FormData 
       
        
        $.ajax({
            type:"POST",
            url:actionUrl,
            data:formData,
            contentType: false, // Important: Don't process the data
            processData: false, // Important: Don't convert to query string

            success:function(data)
            {
                if(data.success == true)
                {
                    jQuery("#error_div").removeClass("alert-danger").addClass("alert-success").html(data.message);

                    jQuery('#cancel-btn').trigger("click");
                    load_events();
                }
                else
                {
                    jQuery("#error_div").removeClass("alert-success").addClass("alert-danger").html(data.message);
                }
                
            },
            error:function(data){
                jQuery("#error_div").removeClass("alert-success").addClass("alert-danger").html(data.message);
            }


        })
    });

    
})

function load_events()
{
    
    var actionUrl = '/events-management/index.php/api/events';
    formData ={
        'columns':'all',
        'table_name':'tbl_events',
        'limit':1,
        'offset':1,
    };
    console.log('load_events'); 
    $.ajax({
        type:"GET",
        url:actionUrl,
        data:formData,
        contentType: 'application/json',

        success:function(response)
        {
           console.log(response); 
           r1 = response;
            if(response)
            {
                jQuery(".events_table").append(
                    "<tbody> <tr>   <td>"+response['data'][0]['event_name']+"</td> <td>"+response['data'][0]['image_path']+"</td></tr></table>");
            }
            else
            {
               
            }
            
        },
        error:function(data){
            //jQuery("#error_div").removeClass("alert-success").addClass("alert-danger").html(data.message);
        }


    })
}