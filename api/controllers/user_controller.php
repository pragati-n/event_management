<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include API_ROOT.'models/user.php';  

class user_controller
{
    protected $model;

    public function __construct($db=array())
    {

        $this->model = new user($db);
        
    }

    public function get_user($params=array())
    {
       
        $g_data["limit"] = (int)$params["limit"] ?? 0;
        $g_data["offset"] =  (int)$params["offset"] ?? 0;
        
        $where_cond = '';
       
        if($params['is_admin'] != 1 && ( isset($params['id']) && $params["user_id"] != $params['id'] ))
        {
            $rdata['success'] = false;
            $rdata['status_code'] = 403;
            $rdata["message"] = "You are not authorise to access the user";
            return $rdata;
        }

        if($params['is_admin'] != 1)
        {
            $where_cond .= "  id =:ID";
            $g_data["bind_params"][':ID'] = $params["user_id"];
        }
    
        elseif($params['is_admin'] == 1 && isset($params['id']))
        {
            $where_cond .= "  id =:ID";
            $g_data["bind_params"][':ID'] = $params['id'];
        }
        $g_data["where"] = ($where_cond ) !='' ? $where_cond :1;

        $data = $this->model->get_user($g_data);

        if($data['data'][0]["id"])
        {
            $rdata['success'] = true;           
            $rdata['status_code'] = 200;
            $rdata["message"] = "user fetched";            
            $rdata['data'] = $data['data'];          
        }
        else
        {
            $rdata['success'] = false;
            $rdata['status_code'] = 400;
            $rdata["message"] = "No users found for your request";
        }     
        return $rdata;
    }

    public function update_user($params=array())
    {
        $pattern = "/^(?=.*\d)[A-Za-z\d]{8,}$/";
       
        $rdata['success'] = false;
        $rdata['status_code'] = 403;
        $rdata['message'] = "You are not authorised to edit this user";

        if($params['is_admin'] == 1 ||  $params['id'] == $params['user_id'])
        {
            if(($params['name'] =='' &&  isset($params['name'] ))|| ( $params['email'] =='' && isset($params['email'])))
            {
                $rdata["message"] = "Name and Email are mandatory fields";
                $rdata["status_code"] = 400;
                
            }
            elseif (!filter_var(trim($params['email']), FILTER_VALIDATE_EMAIL))
            {
                $rdata["message"] = "Enter Valid Email address";
                $rdata["status_code"] = 400;
                
            }        
            elseif(isset( $params['password']) && !preg_match($pattern, $params['password']))
            {
                $rdata['message'] = "Password must contain atleast one number and must be atleast 8 characters long";
                $rdata["status_code"] = 400;
            }
            else
            {
                $columns = ['name','email','password'];

                foreach( $columns as $key => $val)
                {
                    if($params[$val])
                    {
                        $u_data['columns'][$val] = $params[$val];
                        if($val == "password")
                        {
                            $u_data['columns']['password'] = password_hash($params['password'], PASSWORD_BCRYPT);
                        }
                        
                    }
                }
                $u_data['columns']['updated_at'] = date('Y-m-d H:i:s'); 

                $u_data['where'] = ["id"=>$params['id'] ];
               

                $result = $this->model->update_user($u_data);
                if($result == true)
                {
                    $rdata['success'] = true;
                    $rdata['status_code'] = 200;
                    $rdata['message'] = "user updated successfully";               
                    
                }
                else
                {
                    $rdata['success'] = false;
                    $rdata['status_code'] = 500;
                    $rdata['message'] = "Please try again later";
                }
            }
        }

        return $rdata;
    }

    public function delete_user($params = array())
    {
        $rdata['success'] = false;
        $rdata['status_code'] = 403;
        $rdata['message'] = "You are not authorised to delete this user";
       
        if($params['is_admin'] == 1 )
        {
            $d_data = [];
            $d_data['where'] = ["id"=>$params['id'] ];
            $result = $this->model->delete_user($d_data);
            if($result == true)
            {
                $rdata['success'] = true;
                $rdata['status_code'] = 200;
                $rdata['message'] = "User deleted successfully";             
               
            }
            else
            {
                $rdata['success'] = false;
                $rdata['status_code'] = 500;
                $rdata['message'] = " User could not be deleted. Please try again later";
            }
        }
        return $rdata;
    }

    public function get_user_by_email($email)
    {

        $where_cond = "  email =:EMAIL";
        $g_data["where"] = $where_cond;
        $g_data["bind_params"][':EMAIL'] = $email;

        $rdata = $this->model->get_user($g_data);       
        return $rdata['data'][0]["id"];
    }
}