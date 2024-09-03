<?php
include  ROOT.'/app/models/event.php';
include  ROOT.'/app/helper.php';

class event_controller
{
	protected $model;
    public function __construct()
    {
        $this->model = new event();
    }

    public  function list($params=array()) 
	{
        
        //include ROOT.'/app/views/admin/event_list.php';
        helper::draw_view(['app_type'=>'admin','draw'=>'event_list']);

        
       
        /*  echo "<pre>-==";
        print_r( $events_data );          exit; */
        
    
    }

    public function add_event($params=array())
    {
       
    }

   
}