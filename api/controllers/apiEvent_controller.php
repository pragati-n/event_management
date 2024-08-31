<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include API_ROOT.'models/apiEvent.php';  

class apiEvent_controller
{
    protected $model;

    public function __construct($db=array())
    {

        $this->model = new apiEvent($db);
        
    }

    public function events()
    {
        $data = $this->model->events();
        return $data;
    }
}