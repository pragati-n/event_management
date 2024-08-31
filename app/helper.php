<?php

class helper
{

    static public function draw_view($params =array())
    {
        $folder = ($params['app_type'] =='admin') ? 'admin' : 'web';

        include_once(ROOT.'app/views/'. $folder.'/layout.php');
        
    }
}