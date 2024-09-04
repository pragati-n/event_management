<?php


class login
{
    protected $db;
    protected $table = 'tbl_user';
    public function __construct($db)
    {

        $this->db = $db;
      
    }
    
    public function user_login($params=array())
    {
        $data['table_name'] = $this->table;
        $data['columns'] = "all";
        $data['where'] =  "email=:EMAIL and status=1";
        $data['bind_params'] =  [':EMAIL'=>$params["email"]]; 
        
        
        $u_id = $this->db->get_data($data);
        if($u_id[0]["id"])
        {
            $role = $this->user_role($u_id[0]["id"]);
            $u_id[0]['role'] = $role;

            return $u_id;
        }
        return false;
    }

    public function user_role($u_id)
    {
        if($u_id)
        {
            $params["sql"] = "
                            SELECT user_id,role_type FROM tbl_user_role as user_role
                            inner join tbl_role role on(role.id = role_id ) 
                            where user_id = :U_ID";
                            
            $params["bind_params"] = [":U_ID" => $u_id];
           $result = $this->db->run_sql($params);

            return $result[0]['role_type'];

        }
    }

   
}