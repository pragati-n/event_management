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
        'limit':1,
        'offset':1,
    };
    console.log('load_events'); 
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
                $('#events_table').DataTable({
                    data: response.data,
                    columns: [                        
                        { data: 'event_name' },
                        { data: 'even_description' },
                        { 
                            data: 'event_date',
                            render: function(data, type, row) {
                                console.log("type")
                                console.log(type)
                                console.log("row")
                                console.log(row)
                                return formatEventDate(data);
                            }
                        },
                        { 
                            data: 'event_date',
                            render: function(data, type, row) {
                                console.log(row)
                                return  '<button type="button" class="btn btn-primary" data-attr="'+row.id+'">Edit</button>              <button type="button" class="btn btn-danger" data-attr="'+row.id+'">Delete</button>';
                            }
                        },

                        
                    ],
                   // order: [[3, 'desc']] 
            
                });
                /* $str = '<tbody>';
                response["data"].forEach(rdata=>{
                        console.log(rdata.id)
                        console.log(rdata.event_name)
                        console.log(rdata.even_description)

                        $str += '<tr>';
                        $str += '<td>';
                        $str += rdata.event_name
                        $str += '</td>';
                        $str += '<td>';
                        $str += rdata.even_description
                        $str += '</td>';
                        $str += '<td>';
                        $str += rdata.event_date
                        $str += '</td>';
                        $str += '</tr>';
                })
                $str += '<tbody>'; */
                
                jQuery(".events_table").append($str);
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