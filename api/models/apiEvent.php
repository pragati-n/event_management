<?php


class apiEvent
{
    protected $db;
    public function __construct($db)
    {

        $this->db = $db;
      
    }
    public function events()
    {
       try{
          
            $data = $this->db->get_data(['columns'=>'all','table_name'=>'tbl_events']);            
            return ['success' => true, 'data'=>["a"=>1,"b"=>11,"data"=>$data],'status_code'=>200,'message'=>"executed sucessfully"];
       }
       catch(Exception $e)
       {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
            exit;
       }
    }
}