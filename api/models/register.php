<?php


class register
{
    protected $db;
    protected $table = 'tbl_user';
    public function __construct($db)
    {

        $this->db = $db;
      
    }
    
    public function register($params=array())
    {
        $params['table_name'] = $this->table;
        return $this->db->insert_data($params);
       
    }
}