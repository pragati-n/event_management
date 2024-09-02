<?php

 

class jwt_auth
{

    public function __construct()
    {
        
    }

    // Middleware for JWT Authentication
    public function jwt_authenticate() 
    {
       
       // $http_token_arr = explode(" ",$_SERVER["HTTP_Authorization"]);
         $jwt = '';
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) 
        {
            $http_token_arr = explode(" ",$headers['Authorization']);
            $jwt = (strtolower($http_token_arr[0]) == 'bearer') ? trim($http_token_arr[1]) : '';
        }
        
        
        if (isset($jwt)) 
        {
           
            $user_arr = auth::verifyToken($jwt);
            
            if($user_arr) 
            {
                $is_admin = (strtolower($user_arr->userRole) == 'admin') ? 1 : 0; 
                $rdata = array();
                $rdata["is_admin"] =  $is_admin;
                $rdata["user_id"] = $user_arr->userId;
                return $rdata;
            }
        }
      
        http_response_code(401);
        echo json_encode(['message' => 'Unauthorized']);
        exit();
   
    }

    public function user_role()
    {
        
    }
}