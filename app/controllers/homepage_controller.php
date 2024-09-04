<?php
include  ROOT.'/app/models/homepage.php';
include  ROOT.'/app/helper.php';

class homepage_controller
{
	protected $model;
    public function __construct()
    {
        $this->model = new homepage();
    }

    public  function homepage($params=array()) 
	{
        
        //include ROOT.'/app/views/admin/event_list.php';
        helper::draw_view(['app_type'=>'web','draw'=>'homepage']);
        exit;
        
    
    }

    public function add_event($params=array())
    {
       
    }

   
}