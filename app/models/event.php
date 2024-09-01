<?php


class event
{
	public function __construct()
    {
        
    }

    public  function get_data($params=array())
	{
       
       $response = helper::make_curl_request(['path'=>'events']);
       return $response ;


    }

    public function add_event($params=array())
    {

    }
}