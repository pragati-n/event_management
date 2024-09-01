<?php
include  ROOT.'/app/helper.php';
class authentication_controller
{
	


    public  function login($params=array())
	{
        
        include ROOT.'/app/views/admin/login.php';
        
         exit;
    }

    public  function dahsboard($params=array())
	{
        
        helper::draw_view(['app_type'=>'admin','draw'=>'dashboard_content']);
        exit;
        
    }
}