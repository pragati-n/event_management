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
        $user_id = $this->db->insert_data($params);
        if($user_id)
        {
            
            $role_arr = array(
                'columns' => array(
                    array(
                        "user_id" => $user_id,
                        "role_id" => 2, //hardcoded for timebeing                       
                    )
                )
            );
            $role_arr['table_name'] = 'tbl_user_role';
            $this->db->insert_data($role_arr);
        }
        return $user_id;
       
    }
}