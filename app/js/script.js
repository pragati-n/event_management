window.onload = function() {
    check_url();


};

jQuery(document).ready(function(){
    
   
    jQuery('#events-link').on("click",function(){
        jQuery('#events-section').removeClass('d-none');
        jQuery('#add-event-form').addClass('d-none');
    })

    jQuery('#add-event-btn').on("click",function(){
        jQuery('#add-event-form').removeClass('d-none');
        jQuery('#events-section').addClass('d-none');
        jQuery("#form_save_event")[0].reset();
        jQuery("#form_save_event").find(".error_msg").hide();
        jQuery('#save_event').text("Save event") ; 
        jQuery('#save_event').removeAttr('event_id');
        jQuery('#add-event-form').find('.event_title').html('<h3>Add Event</h3>');
    })

    jQuery('#cancel-btn').on("click",function(){
        jQuery('#events-section').removeClass('d-none');
        jQuery('#add-event-form').addClass('d-none');
    });

    jQuery(document).on("click","#save_event",function(e){
        e.preventDefault();
        jQuery(".error_msg").hide();
        var form = jQuery('#form_save_event')[0];
        var actionUrl = '/events-management/index.php/api/events/create';

        var form = jQuery('#form_save_event')[0] // Get the form element
        var formData = new FormData(form) // Create a FormData 
        var event_id = jQuery(this).attr("event_id");
       
        if(event_id > 0)
        {
            formData.append("id",event_id);
            var actionUrl = '/events-management/index.php/api/events/update_events';
          
        }
      
       const token = get_token();
        $.ajax({
            type:"POST",
            url:actionUrl,
            headers:{
                "Authorization":`Bearer ${token}`
            },
            data:formData,
            contentType: false, // Important: Don't process the data
            processData: false, // Important: Don't convert to query string

            success:function(data)
            {
                if(data.success == true)
                {
                    jQuery(".error_msg").removeClass("alert-danger").addClass("alert-primary").show().html(data['message']);
                    setTimeout(() => {
                                jQuery('#cancel-btn').trigger("click");

                                load_events();
                      }, "1000");
                   
                    
                }
                else
                {
                    jQuery(".error_msg").removeClass("alert-primary").addClass("alert-danger").show().html(xhr['responseJSON']['message']);
                }
                
            },
            error: function(xhr, status, error) {
               
                jQuery(".error_msg").removeClass("alert-primary").addClass("alert-danger").show().html(xhr['responseJSON']['message']);
            },


        })
    });

    
    
    
});

function check_url()
{
    const path = window.location.pathname;

    if (window.location.href.indexOf('event_list') >0)
    {
        load_events();

       
    }
}


function get_token()
{
   return  localStorage.getItem('jwt_token');
}
function load_events()
{
    const token =  get_token();// Retrieve the token
    var actionUrl = '/events-management/index.php/api/events';
    formData ={
        'columns':'all',
        'table_name':'tbl_events',
//'limit':0,
       // 'offset':5,
    };
   
    $.ajax({
        type:"GET",
        url:actionUrl,
        headers:{
            "Authorization":`Bearer ${token}`
        },
        data:formData,
        contentType: 'application/json',
        

        success:function(response)
        {
           console.log(response['data']); 
           r1 = response;
            if(response)
            {
                response["data"].forEach(rdata=>{
                    console.log(rdata.event_date)
                })
                if ($.fn.DataTable.isDataTable('#events_table')) {
                    $('#events_table').DataTable().clear().destroy();
                }
                $('#events_table').DataTable({
                    data: response.data,
                    columns: [                        
                        { data: 'event_name' },
                        { 
                            data: 'even_description' ,
                            render:function(data){
                                console.log(`data = ${data}`)
                                if(data.length > 50)
                                {
                                 return data.substring(0,50)+"...";
                                }
                                else
                                {
                                    return data;
                                }
                            }
                    
                        },
                        { 
                            data: 'event_date',
                            render: function(data, type, row) {
                                return formatEventDate(data);
                            }
                        },
                        { 
                            data: 'event_id',
                            render: function(data, type, row) {
                                return  '<button type="button" class="btn btn-primary event_edit_btn" data-id="'+row.id+'" > Edit</button>              <button type="button" class="btn btn-danger event_delete_btn " data-id="'+row.id+'" data-bs-toggle="modal" data-bs-target="#deleteEventModal" >Delete</button> ';
                            }
                        },

                        
                    ],
                    order: [[3, 'desc']],
                    lengthMenu: [5, 10, 25, 50, 100], 
            
                });
               
                
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


function formatEventDate(dateString) {
    const date = new Date(dateString);
    
    // Options for date formatting
    const optionsDate = { day: '2-digit', month: '2-digit', year: 'numeric' };
    const optionsTime = { hour: '2-digit', minute: '2-digit', hour12: true };

    const formattedDate = date.toLocaleDateString('en-GB', optionsDate); // "DD/MM/YYYY"
    const formattedTime = date.toLocaleTimeString('en-GB', optionsTime); // "HH:mm AM/PM"

    return `${formattedDate} ${formattedTime}`;
}



$('#deleteEventModal').on('show.bs.modal', function (event) {
    console.log("eventtt");
    console.log(event)
    var button = $(event.relatedTarget);
    var eventId = button.data('id');
    $(this).data('id', eventId);
    console.log('tihiss')
    console.log($(this))
});


jQuery(document).on("click",".event_delete_btn",function(){
    var eventId = $(this).data('id');

    // Pass the data to the modal by setting a data attribute
    $('#deleteModal').modal('show');
    $("#deleteModal").find(".error_msg").hide()
    $('#deleteModal').find("#confirmDeleteBtn").attr('event-id', eventId);
});

jQuery(document).on("click","#confirmDeleteBtn",function(){
  console.log("=====deleteeee")
  console.log($(this).parents("#deleteModal").find(".error_msg"))
    
    const token =  get_token();// Retrieve the token
    var eventId = $('#confirmDeleteBtn').attr('event-id');
    var actionUrl = '/events-management/index.php/api/events/delete';

    console.log("=====eventId"+eventId)
    $.ajax({
        url: actionUrl,
        contentType: 'application/json',
        headers:{
            "Authorization":`Bearer ${token}`
        },
        type: 'DELETE',
        data: JSON.stringify({ id: eventId }),
        success: function(response) 
        {
            $('#deleteModal').modal('hide');
            load_events()
        },
        error: function(xhr, status, error) {
            $("#deleteModal").find(".error_msg").show()
            jQuery(".error_msg").removeClass("alert-primary").addClass("alert-danger").show().html(xhr['responseJSON']['message']);
        }
    });
});

jQuery(document).on("click",".event_edit_btn",function(){
   
    jQuery('#add-event-form').removeClass('d-none');
    jQuery('#events-section').addClass('d-none');
    jQuery('#add-event-form').find('.event_title').html('<h3>Edit Event</h3>');
    jQuery("#form_save_event")[0].reset();
    jQuery("#form_save_event").find(".error_msg").hide();

    var event_id = $(this).attr('data-id');
    const token =  get_token();// Retrieve the token
    var actionUrl = '/events-management/index.php/api/events';
    formData ={
        'columns':'all',
        'table_name':'tbl_events',
        "id":event_id,
    }
        
    $.ajax({
        type:"GET",
        url:actionUrl,
        headers:{
            "Authorization":`Bearer ${token}`
        },
        data:formData,
        contentType: 'application/json',
        success:function(response)
        {
            jQuery('#event_name').val(response['data'][0]['event_name']) ;  
            jQuery('#even_description').val(response['data'][0]['even_description'])   ;
            jQuery('#event_date').val(response['data'][0]['event_date']) ; 
            jQuery('#save_event').text("Update event") ; 
            jQuery('#save_event').attr("event_id",event_id) ; 
        },
        error:function(xhr, status, error){
            jQuery(".error_msg").removeClass("alert-primary").addClass("alert-danger").show().html(xhr['responseJSON']['message']);
        }
    })

    
})
