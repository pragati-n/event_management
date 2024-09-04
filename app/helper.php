<?php

class helper
{

    static public function draw_view($params =array())
    {
        $folder = ($params['app_type'] =='admin') ? 'admin' : 'web';
        if($folder == 'web')
        {
            include_once(ROOT.'app/views/'. $folder.'/'.$params["draw"].'.php');
        }
        else
        {
            include_once(ROOT.'app/views/'. $folder.'/layout.php');
        }
        

    }


    static public function make_curl_request($params=array())
    {
        if($params['path'])
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://'.API_DOC_ROOT.$params['path']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($ch);
            curl_close($ch);
    
    
            if ($response) 
            {
                
                $decoded_response = json_decode($response, true);
               // var_dump( $decoded_response);
                if ($decoded_response['success']) 
                {
                    return $decoded_response;
                } 
                else 
                {
    
                    throw new Exception($decoded_response);
                }
            } 
            else 
            {
                throw new Exception('No response from API');
            }
        }
    }
}