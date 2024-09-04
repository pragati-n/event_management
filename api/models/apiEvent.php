<?php


class apiEvent
{
    protected $db;
    protected $table = 'tbl_events';
    public function __construct($db)
    {

        $this->db = $db;
      
    }
    public function events($params=array())
    {
      
        $params['table_name'] = $this->table;
        $rdata['data'] = $this->db->get_data($params); 
        return $rdata;
       
    }

    public function add_event($params=array())
    {
        $params['table_name'] = $this->table;
        return $this->db->insert_data($params);
       
    }

    public function update_data($params=array())
    {
        $params['table_name'] = $this->table;
        return $this->db->update_data($params);
       
    }

    public function delete_event($params=array())
    {
        $params['table_name'] = $this->table;
        return $this->db->delete_data($params);
       
    }

    public function get_event_owner($event_id)
    {
        $params['table_name'] = $this->table;

       
        $rdata = $this->db->get_data(['columns'=>'all','table_name'=>'tbl_events', 'where' => "id= :ID",'bind_params'=>[":ID"=>$event_id]]); 
         
        return $rdata[0]['created_by'];
       
    }

    public function upcoming_events($params=array())
    {
         $params["sql"] = " SELECT * FROM tbl_events where event_date > NOW() order by event_date asc  LIMIT ".$params['offset']." , ".$params['limit']." ";
            //$params["bind_params"][":limit"] = $params['limit'];
         //$params["bind_params"][":offset"] = $params['offset'];
        //print_r($params);exit;
       
        $result = $this->db->run_sql($params);

        $t_param["sql"] = "SELECT COUNT(*) as total  FROM tbl_events where event_date > NOW() ";
        $total_arr = $this->db->run_sql($t_param);
        
       /*  print_r($result);
        echo "===";
        print_r($total_arr);exit; */
        $rdata = ["events "=>$result ,"total_events" =>$total_arr[0]["total"]];

        return $rdata ;
    }
}