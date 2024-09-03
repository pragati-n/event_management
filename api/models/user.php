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
       //print_r($params);exit;
        $params['table_name'] = $this->table;
        $sql = "
                SELECT user.id,name,email,status,if(role_id =1,'Admin','Author') as role FROM tbl_user   user  inner join tbl_user_role role on(user.id = role.user_id)";
        $sql .=" where ".$params['where']." ";
        $params["sql"] = $sql;
       // $rdata['data'] = $this->db->get_data($params); 
        $rdata['data'] = $this->db->run_sql($params); 
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