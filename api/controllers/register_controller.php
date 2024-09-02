<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include API_ROOT.'models/register.php';  
include API_ROOT.'controllers/user_controller.php';  

class register_controller
{
    protected $model;
    protected $db;

    public function __construct($db=array())
    {

        $this->model = new register($db);
        $this->db = $db;
        
    }

    public function register($params=array())
    {
        $response['success'] = false;
        $response['status_code'] = 400;
        $pattern = "/^(?=.*\d)[A-Za-z\d]{8,}$/";

        if( !filter_var($params['email'], FILTER_VALIDATE_EMAIL))
		{
			$response['message'] = "Enter valid email";			
		}
		elseif( $params['name'] == "" || $params['password'] == "" || $params['c_password'] == ""  )
		{
			$response['message'] = "Please fill the mandatory fields";			
		}
		elseif( $params['password'] !== $params['c_password']  )
		{
			$response['message'] = "Password and confirm password fields do not match" ;			
		}
        elseif(!preg_match($pattern, $params['password']))
        {
            $response['message'] = "Password must contain atleast one number and must be atleast 8 characters long";
        }
        else
		{
           $u_obj = new user_controller($this->db);
           $id =  $u_obj->get_user_by_email($params["email"]);
           if($id > 0 )
           {
                $response['success'] = false;               
                $response['message'] = "User exists with same Email "; 
                return $response;
           }
            $s_data = array(
                    'columns' => array(
                        array(
                            "name" => $params["name"],
                            "email" => $params["email"],
                            "password" => password_hash($params['password'], PASSWORD_BCRYPT),
                            "created_at" => date('Y-m-d H:i:s'),
                            "updated_at" => date('Y-m-d H:i:s'),
                            "status" => 1,
                        )
                    )
                );
			
			$rdata = $this->model->register($s_data);
			
            if($rdata > 0)
			{
				$response["status_code"] = 201;
				$response["data"] = $rdata;
				$response["success"] = true;
				$response["message"] = "User created succesfully!";
			}
			else
			{
				$rdata['success'] = false;
                $rdata['status_code'] = 500;
                $rdata['message'] = "Failed to register. Please try again later";
        
			}
			
		}
        return $response;
        
    }

    
}