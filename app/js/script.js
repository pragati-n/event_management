    
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

    
})