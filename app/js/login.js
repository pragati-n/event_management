    
jQuery(document).ready(function(){
    jQuery(document).on("click","#login_btn",function(e){
        e.preventDefault();

        $.ajax({
            url: '/events-management/index.php/api/login',
            type: 'POST',
            data: {
                email: jQuery("#email").val(),
                password: jQuery("#password").val(),
            },
            success: function(response) {
               
                if (response.success) {

                    jQuery(".error_msg").hide();
                    // Store the JWT token in local storage
                    localStorage.setItem('jwt_token', response.data['access_token']);
                    window.location.href = "/events-management/index.php/";

                } else {
                   
                    jQuery(".error_msg").show().html(data.message);
                }
            },
            error: function(xhr, status, error) {
               
                jQuery(".error_msg").show().html(xhr['responseJSON']['message']);
            },
            
        });
    });
    
});