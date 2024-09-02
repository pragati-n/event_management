<?php


class user
{
    protected $db;
    protected $table = 'tbl_user';
    public function __construct($db)
    {

        $this->db = $db;
      
    }
    
    public function get_user($params = array())
    {
        $params['table_name'] = $this->table;
        $rdata['data'] = $this->db->get_data($params); 
        return $rdata;
    }

    public function update_user($params = array())
    {
        $params['table_name'] = $this->table;
        return $this->db->update_data($params);
    }

    public function delete_user($params=array())
    {
        
        $params['table_name'] = $this->table;
        $d_result =  $this->db->delete_data($params);

        //DELETE user role
        $role_arr = [];
        $role_arr['table_name'] = "tbl_user_role";
        $d_data['where'] = ["id"=>$params['id'] ];
        $role_arr['where'] = ["user_id" =>$params["where"]["id"] ];
        $this->db->delete_data($role_arr);
        return $d_result;
       
    }
}