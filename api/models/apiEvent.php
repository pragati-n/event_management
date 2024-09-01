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
       try
       {

           // $rdata = $this->db->get_data(['columns'=>'all','table_name'=>'tbl_events','limit'=>1,'offset'=>1]); 
            $rdata['data']= $this->db->get_data($params); 
            $rdata["success"] = true;           
            return $rdata;
       }
       catch(Exception $e)
       {
            return ['message' => $e->getMessage()];
           
       }
    }

    public function add_event($params=array())
    {
        $params['table_name'] = $this->table;
        return $this->db->insert_data($params);
       
    }
}