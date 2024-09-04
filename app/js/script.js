window.onload = function() {
    check_url();

    const jwtToken = localStorage.getItem('jwt_token');
    if (jwtToken) {
        const payload = JSON.parse(atob(jwtToken.split('.')[1]));
        const expTime = payload.exp * 1000; 
        const currentTime = new Date().getTime();
        const timeoutDuration = expTime - currentTime;

        if (timeoutDuration > 0) {
            setTimeout(() => {
                logoutUser();
            }, timeoutDuration);
        } else {
            logoutUser(); // If the token has already expired
        }
    }

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


    jQuery('#user-link').on("click",function(){
        jQuery('#user-section').removeClass('d-none');
        jQuery('#add-user-form').addClass('d-none');
    })

    jQuery('#add-user-btn').on("click",function(){
        jQuery('#add-new-user').removeClass('d-none');
        jQuery('#user-section').addClass('d-none');
        jQuery('#add-user-form').addClass('d-none');
        jQuery("#form_save_new_user")[0].reset();
        jQuery("#form_save_new_user").find(".error_msg").hide();
        jQuery('#save_new_user').text("Save user") ; 
        jQuery('#save_new_user').removeAttr('user_id');
    })

    jQuery('#cancel-btn , #cancel-btn1').on("click",function(){
        jQuery('#user-section').removeClass('d-none');
        jQuery('#add-new-user').addClass('d-none');
        jQuery('#add-user-form').addClass('d-none');
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

    
    

    /* jQuery(document).on("click","#save_user",function(e){
        e.preventDefault();
        jQuery(".error_msg").hide();
        var form = jQuery('#form_save_event')[0];
        var actionUrl = '/events-management/index.php/api/events/create';

        var form = jQuery('#form_save_event')[0] // Get the form element
        var formData = new FormData(form) // Create a FormData 
        formData.append("status",1);
        formData.append("status",1);
        formData.append("updated_at",getCurrentDateTime());
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
    }); */

    
    
    

    
});

function check_url()
{
    const path = window.location.pathname;

    if (window.location.href.indexOf('event_list') >0)
    {
        load_events();
    }
    else if(window.location.href.indexOf('user_list') >0)
    {
             load_users();
    }
    else if(path === '/events-management/index.php/' || path === '/events-management/index.php') 
    {
       fetch_statistics();
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
            if(response)
            {
                jQuery(".error_msg").hide();
                $('#events_table').show();
                response["data"].forEach(rdata=>{
                   
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
        error:function(xhr, status, error){
            $('#events_table').hide()
            jQuery(".error_msg").show().removeClass("alert-success").addClass("alert-danger").html(xhr['responseJSON']['message']);
        }


    })


   
}

function load_users()
{
    const token =  get_token();// Retrieve the token
    var actionUrl = '/events-management/index.php/api/user';
    formData ={
        //'columns':'all',
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
            if(response)
            {
               
                if ($.fn.DataTable.isDataTable('#users_table')) {
                    $('#users_table').DataTable().clear().destroy();
                }
                $('#users_table').DataTable({
                    data: response.data,
                    columns: [                        
                        { data: 'name' },
                        { data: 'email' },
                        { data: 'role' },
                        { 
                            data: 'id',
                            render: function(data, type, row) {
                                return  '<button type="button" class="btn btn-primary user_edit_btn" data-id="'+row.id+'" > Edit</button>              <button type="button" class="btn btn-danger user_delete_btn " data-id="'+row.id+'" data-bs-toggle="modal" data-bs-target="#deleteModalUser" >Delete</button> ';
                            }
                        },

                        
                    ],
                    order: [[1, 'desc']],
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
   
    var button = $(event.relatedTarget);
    var eventId = button.data('id');
    $(this).data('id', eventId);
    
});


jQuery(document).on("click",".event_delete_btn",function(){
    var eventId = $(this).data('id');

    // Pass the data to the modal by setting a data attribute
    $('#deleteModal').modal('show');
    $("#deleteModal").find(".error_msg").hide()
    $('#deleteModal').find("#confirmDeleteBtn").attr('event-id', eventId);
});

jQuery(document).on("click","#confirmDeleteBtn",function(){
 
    const token =  get_token();// Retrieve the token
    var eventId = $('#confirmDeleteBtn').attr('event-id');
    var actionUrl = '/events-management/index.php/api/events/delete';

  
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
            load_events();
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


jQuery(document).on("click","#save_user",function(e){
 
        e.preventDefault();
        jQuery(".error_msg").hide();
        var form = jQuery('#form_save_user')[0];
        var formData = new FormData(form) // Create a FormData 
        var user_id = jQuery(this).attr("user_id");
       
        var actionUrl = '/events-management/index.php/api/user/update';     
        const token = get_token();
        var name = jQuery(form).find("#user_name").val();
        var email = jQuery(form).find("#user_email").val();
        $.ajax({
            type:"PUT",
            url:actionUrl,
            headers:{
                "Authorization":`Bearer ${token}`
            },
            data:JSON.stringify({ id: user_id ,name:name,email:email }),
            contentType: 'application/json',
           

            success:function(data)
            {
                if(data.success == true)
                {
                    jQuery(".error_msg").removeClass("alert-danger").addClass("alert-primary").show().html(data['message']);
                   setTimeout(() => {
                                jQuery('#cancel-btn').trigger("click");
                                load_users();
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


jQuery(document).on("click","#save_new_user",function(e){
    e.preventDefault();

    $.ajax({
        url: '/events-management/index.php/api/register',
        type: 'POST',
        data: {
            name: jQuery("#user_new_name").val(),
            email: jQuery("#user_new_email").val(),
            password: jQuery("#user_new_password").val(),
            c_password: jQuery("#user_new_c_password").val(),
        },
        success: function(response) {
          
            if (response.success) {
               


                jQuery(".error_msg").removeClass("alert-danger").addClass("alert-primary").show().html(response['message']);
                setTimeout(() => {
                             jQuery('#cancel-btn').trigger("click");
                             load_users();
                   }, "1000");
                 
                

            } else {
               
                jQuery(".error_msg").removeClass("alert-primary").addClass("alert-danger").show().html(xhr['responseJSON']['message']);
            }
        },
        error: function(xhr, status, error) {
           
            jQuery(".error_msg").removeClass("alert-primary").addClass("alert-danger").show().html(xhr['responseJSON']['message']);
        },
        
    });
});


jQuery(document).on("click",".user_delete_btn",function(){
    var user_id = $(this).attr('data-id');

    
    $('#deleteModalUser').modal('show');
    $("#deleteModalUser").find(".error_msg").hide()
    $('#deleteModalUser').find("#confirmDeleteUSerBtn").attr('user_id', user_id);

});

jQuery(document).on("click","#confirmDeleteUSerBtn",function(){
    
      
      const token =  get_token();// Retrieve the token
      var user_id = $(this).attr('user_id');
      var actionUrl = '/events-management/index.php/api/user/delete';
  
      $.ajax({
          url: actionUrl,
          contentType: 'application/json',
          headers:{
              "Authorization":`Bearer ${token}`
          },
          type: 'DELETE',
          data: JSON.stringify({ id: user_id }),
          success: function(response) 
          {
              $('#deleteModalUser').modal('hide');
              load_users()
          },
          error: function(xhr, status, error) {
              $("#deleteModalUser").find(".error_msg").show()
              jQuery(".error_msg").removeClass("alert-primary").addClass("alert-danger").show().html(xhr['responseJSON']['message']);
          }
      });
  });

jQuery(document).on("click",".user_edit_btn",function(){
   
    jQuery('#add-user-form').removeClass('d-none');
    jQuery('#user-section').addClass('d-none');
    jQuery('#add-new-user').addClass('d-none');
    jQuery("#form_save_user")[0].reset();
    jQuery("#form_save_user").find(".error_msg").hide();

    var user_id = $(this).attr('data-id');
    const token =  get_token();// Retrieve the token
    var actionUrl = '/events-management/index.php/api/user';
    formData ={
        "id":user_id,
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
            jQuery('#user_name').val(response['data'][0]['name']) ;  
            jQuery('#user_email').val(response['data'][0]['email'])   ;
            jQuery('#user_role').text(response['data'][0]['role']) ; 
            jQuery('#save_user').attr('user_id',user_id) ; 
             
        },
        error:function(xhr, status, error){
            jQuery(".error_msg").removeClass("alert-primary").addClass("alert-danger").show().html(xhr['responseJSON']['message']);
        }
    }) 

    
})

jQuery(document).on("click","#logout_link",function(e){
   e.preventDefault();
    logoutUser();
});

function logoutUser() 
{
    $.ajax({
        url: '/events-management/index.php/logout',
        type: 'POST',
        success: function () {
            // Clear local storage and redirect to login page
            localStorage.removeItem('jwt_token');
            window.location.href = '/events-management/index.php/login';
        }
    });
}

function getCurrentDateTime() {
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0'); // Months are zero-based
    const day = String(now.getDate()).padStart(2, '0');
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');

    return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
}



function fetch_statistics()
{
    
    const token =  get_token();// Retrieve the token
    var actionUrl = '/events-management/index.php/api/upcoming_events';
    $.ajax({
        type:"GET",
        url:actionUrl,
        headers:{
            "Authorization":`Bearer ${token}`
        },
        //data:formData,
        contentType: 'application/json',
        success:function(response)
        {
          
            upcoming_str = `Upcoming Events: No future are present `;
            if(response.data['total_events'])
            {
                
                upcoming_str = `Upcoming Events: ${response.data['total_events']} `;
            }
            jQuery('#up_events').html(upcoming_str) ; 
        },
        error:function(xhr, status, error){
           // jQuery(".error_msg").removeClass("alert-primary").addClass("alert-danger").show().html(xhr['responseJSON']['message']);
        }
    });

    


    var actionUrl = '/events-management/index.php/api/user/total_active_users';
    $.ajax({
        type:"GET",
        url:actionUrl,
        headers:{
            "Authorization":`Bearer ${token}`
        },
        //data:formData,
        contentType: 'application/json',
        success:function(response)
        {
           
            total_users = `Total active users: - `;
            if(response.data)
            {
               
                total_users = `Total active users:  ${response.data} `;
            }
            jQuery('#total_users').html(total_users) ; 
        },
        error:function(xhr, status, error){
           // jQuery(".error_msg").removeClass("alert-primary").addClass("alert-danger").show().html(xhr['responseJSON']['message']);
        }
    });
}