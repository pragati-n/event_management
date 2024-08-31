<?php


class event
{
	public function __construct()
    {
        
    }

    public  function get_data($params=array())
	{
       
       
         $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://'.API_DOC_ROOT.'events');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);


        if ($response) 
        {
            $decoded_response = json_decode($response, true);
           // var_dump( $decoded_response);
            if ($decoded_response['success']) 
            {
                return $decoded_response['data'];
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