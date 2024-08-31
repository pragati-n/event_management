<?php
include  ROOT.'/app/models/event.php';
class event_controller
{
	protected $model;
    public function __construct()
    {
        $this->model = new event();
    }

    public  function list($params=array())
	{
       // include ROOT.'/app/views/admin/login.php';
        $events_data = $this->model->get_data();
       
        echo "<pre>-";
        print_r( $events_data );
        exit;
        
    }
}