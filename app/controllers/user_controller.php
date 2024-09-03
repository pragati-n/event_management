<?php
include  ROOT.'/app/models/user.php';
include  ROOT.'/app/helper.php';

class user_controller
{
	protected $model;
    public function __construct()
    {
        $this->model = new user();
    }

    public  function user_list($params=array()) 
	{
        helper::draw_view(['app_type'=>'admin','draw'=>'user_list']);
    }

    
}