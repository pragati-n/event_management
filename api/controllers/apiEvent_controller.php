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

    public function events($params=array())
    {
        
        $data = $this->model->events($params);
        if($data["success"] == true)
        {
            $rdata['success'] = true;
            $rdata['data'] = $data['data'];
            //$rdata['message'] = "Event created sucessfully";
        }
        else
        {
            $rdata['success'] = false;
            $rdata['status_code'] = 400;
            $rdata['message'] =  $data['message'];
        }
       
        return $data;
    }

    public function add_event($params)
    {
      
        $ret_arr = array();

        $event_time = new DateTime($params['event_date']);
        $current_time = new DateTime();

        if(trim($params['event_title']) == "" && trim($params['event_date'])  == "" && trim($params['event_description']) =="")
        {
            $ret_arr["message"] = "please complete the mandatory fields";
            $ret_arr["status_code"] = 400;
            return $ret_arr;
        }
        elseif($current_time > $event_time)
        {
            $ret_arr["message"] = "please select future event date ";
            $ret_arr["status_code"] = 400;
            return $ret_arr;
        }

        if (isset($_FILES['img_uploader']) && $_FILES['img_uploader']['error'] === 0) 
        {
            $file_tmp_name = $_FILES['img_uploader']['tmp_name'];
            $file_name = basename($_FILES['img_uploader']['name']);
            $file_name_arr =explode(".", $file_name);
            $file_name = $file_name_arr[0].'_'.time().'.'. $file_name_arr[1];

            $dir =  ROOT.'public/uploads/images/';
            $uploadFile = $dir  . $file_name;
            move_uploaded_file($file_tmp_name, $uploadFile);
        }
        
        $image_path = isset($file_name) ? 'public/uploads/images/'.$file_name : '';
        $data = array(
            'columns' => array(
                array(
                    'event_name'     	=>   $params['event_title'],  
                    'even_description'	=>   $params['event_description'],  
                    'event_date'		=>   date("Y-m-d H:i:s",strtotime($params['event_date'])),
                    'created_at'		=>   date('Y-m-d H:i:s'),    
                    'updated_at'		=>   date('Y-m-d H:i:s'),    
                    'created_by'		=>   1,
                    'image_path'		=>   $image_path,
                ),
            ),
        );
        
       
        $id =  $this->model->add_event($data);
        
        if($id>0)
        {
            $rdata['success'] = true;
            $rdata['status_code'] = 201;
            $rdata['data'] = $id;
            $rdata['message'] = "Event created sucessfully";
        }
        else
        {
            $rdata['success'] = false;
            $rdata['status_code'] = 500;
            $rdata['message'] = "Please try again later";
        }
        return $rdata;

    }
}