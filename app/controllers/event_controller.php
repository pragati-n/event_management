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

    public function fetch_events($params=array())
    {
       /*  $events_data = $this->model->get_data();
        print_r($events_data);
        ob_start();
        $events_data = [1,2,3];
       print_r($events_data);
        include  ROOT.'app/views/admin/dashboard_content.php';
        $output = ob_get_clean();
       // $output ="hello";
       
       
       echo  $output;
       //echo  $events_data = '<strong>hello</strong>';
       //return $output; */
       
    }
}