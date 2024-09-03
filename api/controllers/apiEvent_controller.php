<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

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
       
       /* echo "params"; 
        print_r($params);   */
        $g_data["order_column"] = "event_date";
        $g_data["order_by"] = "desc";
        if(isset($params["offset"]) && $params["offset"] > 0)
        {
            if($g_data["limit"]>=0)
            {
                $g_data["offset"] =  $params["offset"];
                $g_data["limit"] = (int)$params["limit"];
            }            
        } 
       
     
        $where_cond = '';
        $bindparams ='';
        if($params['id'])
        {
            $where_cond = " id=:ID ";
            $g_data["bind_params"][":ID"] = $params["id"];
        
        }
        if($params['is_admin'] != 1 )//IF user is not administrator
        {
            if($where_cond != '')
            {
                $where_cond .= " and ";
            }
            $where_cond .= "  created_by =:USER_ID";
            $g_data["bind_params"][':USER_ID'] = $params["user_id"];
        }
        /* print_r($g_data["bind_params"]);exit; */
        $g_data["where"] = ($where_cond ) !='' ? $where_cond :1;
       

        $data = $this->model->events($g_data);
       
        if($data['data'][0]["id"])
        {
           
            $rdata['success'] = true;
           
            $rdata['status_code'] = 200;
            $rdata["message"] = "Event fetched";            
            $rdata['data'] = $data['data'];
          
        }
        else
        {
           
            $rdata['success'] = false;
            $rdata['status_code'] = 400;
            $rdata["message"] = "No events found for your request";
        }
     
        return $rdata;
    }

    public function event_validator($params,$flag)
    {

        $current_time = new DateTime();
        
        $event_time = isset($params['event_date']) ? new DateTime($params['event_date']) : $current_time;
      
        if($flag=="add" && (!isset($params['event_name']) || !isset($params['event_date']) || !isset($params['even_description']) ))
        {
           
            $ret_arr["message"] = "please complete the mandatory fields1";
            $ret_arr["status_code"] = 400;
            $ret_arr["error"] = 1;
            return $ret_arr;
        }

        if($flag=="add" && (trim($params['event_name']) == "" || trim($params['event_date'])  == "" || trim($params['even_description']) =="") )
        {
           
            $ret_arr["message"] = "please complete the mandatory fields2";
            $ret_arr["status_code"] = 400;
            $ret_arr["error"] = 1;
            return $ret_arr;
        }
        elseif($current_time > $event_time)
        {
            
            $ret_arr["message"] = "please select future event date ";
            $ret_arr["status_code"] = 400;
            $ret_arr["error"] = 1;
            return $ret_arr;
        }

        
    }

    public function add_event($params)
    {
      
        $ret_arr = array();
        $validator_result = $this->event_validator($params,'add');
        if( $validator_result["error"])
        {
            return $validator_result;
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
                    'event_name'     	=>   $params['event_name'],  
                    'even_description'	=>   $params['even_description'],  
                    'event_date'		=>   date("Y-m-d H:i:s",strtotime($params['event_date'])),
                    'created_at'		=>   date('Y-m-d H:i:s'),    
                    'updated_at'		=>   date('Y-m-d H:i:s'),    
                    'created_by'		=>   $params['user_id'],
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

    public function update_event($params = array())
    {
        
        $event_owner_id = $this->model->get_event_owner($params["id"]); 
        
        if($params['is_admin']== 1 ||  $event_owner_id == $params['user_id'])
        {
            $validator_result = $this->event_validator($params,'edit');
            if( $validator_result["error"])
            {
                return $validator_result;
            }
            
            if(isset($params['event_name']) && trim($params['event_name'] =='') )
            {
                $ret_arr["message"] = "please add event name ";
                $ret_arr["status_code"] = 400;
                return $ret_arr;
            }
            if(isset($params['even_description']) &&  trim($params['even_description'] ==''))
            {
               
                $ret_arr["message"] = "please add event description ";
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

            $columns = ['event_name','even_description','event_date','updated_at','image_path'];
            foreach( $columns as $key => $val)
            {
                if($params[$val])
                {
                    $u_data['columns'][$val] = $params[$val];
                    if($val == 'event_date' &&   $params['event_date'] !='')
                    {
                        $u_data['columns'][$val] = date("Y-m-d H:i:s",strtotime($params['event_date']));
                    }
                    
                    if($val == 'image_path' &&   $params['image_path'] !='')
                    {
                        $u_data['columns'][$val] = $image_path;  
                    }

                }
                
            }
            $u_data['updated_at'] = date('Y-m-d H:i:s'); 
           
            $u_data['where'] = ["id"=>$params['id'] ];

        
            $result = $this->model->update_data($u_data);
            if($result == true)
            {
                $rdata['success'] = true;
                $rdata['status_code'] = 200;
                $rdata['message'] = "Event updated successfully";
                
               
            }
            else
            {
                $rdata['success'] = false;
                $rdata['status_code'] = 500;
                $rdata['message'] = "Please try again later";
            }
             return $rdata;
        }
        else
        {

            $rdata['success'] = false;
            $rdata['status_code'] = 403;
            $rdata['message'] = "You are not authorised to edit this event";
            
            return $rdata;
        }
    }

    public function delete_event($params = array())
    {
        
        $event_owner_id = $this->model->get_event_owner($params["id"]); 
      
        if($params['is_admin'] == 1 ||  $event_owner_id == $params['user_id'])
        {
           
            $d_data = [];
            $d_data['where'] = ["id"=>$params['id'] ];
            $result = $this->model->delete_event($d_data);
            if($result == true)
            {
                $rdata['success'] = true;
                $rdata['status_code'] = 200;
                $rdata['message'] = "Event deleted successfully";
                
               
            }
            else
            {
                $rdata['success'] = false;
                $rdata['status_code'] = 500;
                $rdata['message'] = " Event could not be deleted. Please try again later";
            }
            return $rdata;

        }
        else
        {
            $rdata['success'] = false;
            $rdata['status_code'] = 403;
            $rdata['message'] = "You are not authorised to edit this event";
            
            return $rdata;

        }
    }
}