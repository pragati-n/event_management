<?php
include  ROOT.'/app/helper.php';
class authentication_controller
{
	


    public  function draw_login($params=array())
	{
        include ROOT.'/app/views/admin/login.php';
        
        exit;
    }

    public function login($params=array())
	{
        $this->draw_login();
       
    }
    public function register($params=array())
	{
        include ROOT.'/app/views/admin/register.php';        
        exit;       
    }
    
    public function login_user($params=array())
	{
        $response = helper::make_curl_request(['path'=>'login']);
        return $response ;
     
    }

    public function logout($params=array())
	{
        session_start();
        session_unset(); 
        session_destroy();
        return['success' => true, 'message' => 'User logged out successfully'];
    }

    public  function dahsboard($params=array())
	{
        if($_SESSION['user_id'])
        {
            helper::draw_view(['app_type'=>'admin','draw'=>'dashboard_content']);
            exit;
           
        }
        else
        {
            header("location: http://".$_SERVER['SERVER_NAME']."/events-management/index.php/login");

            exit;
        }
        
        
    }
}