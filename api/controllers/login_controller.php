<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include API_ROOT.'models/login.php';  

class login_controller
{
    protected $model;

    public function __construct($db=array())
    {

        $this->model = new login($db);
        
    }

    public function login($params=array())
    {
        $response['success'] = false;
        $response['status_code'] = 400;

		if( !isset($params['email']) || !filter_var($params['email'], FILTER_VALIDATE_EMAIL))
		{
			$response['message'] = "Enter valid email";		
		}
	    elseif(!isset($params['password'])  || $params['password'] == '' )
		{
			$response['message'] = "Password required";		
		}
        else
        {
           
            $s_data["email"] = $params['email'];
            $rdata = $this->model->user_login($s_data);
          
            if($rdata[0]["id"] && password_verify($params['password'] , $rdata[0]["password"]))
            {
                $jwt_arr['u_id'] = $rdata[0]["id"];
                $jwt_arr['role'] = $rdata[0]["role"];

                
                $jwt = auth::createToken($jwt_arr);

                $s_data = array(
                    "user_id" => $rdata[0]["id"],
                    "user_name" => $rdata[0]["name"],
                    "access_token" => $jwt,
               );

               $response["success"] = true;
               $response['status_code'] = 200;
               $response["message"] = "User loggged in";
			   $response["data"] = $s_data ;
				
            } 
            else
            {
                $response["status_code"] = 401;
                $response["message"] = "Invalid credentials";
            }

            
        }

		return $response;
        
    }

    
}