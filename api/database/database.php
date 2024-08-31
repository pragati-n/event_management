<?php 

class database
{

    private $host;
    private $dbname;
    private $user; 
    private $pass; 
    private $db_pdo; 

    public function connect()
    {
       
      
       $this->host = getenv('DB_HOST');
       $this->dbname = getenv('DB_NAME');
       $this->user = getenv('DB_USER');
       $this->pass = getenv('DB_PASSWORD');
      
       try
       {

       

            $this->db_pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);

            $this->db_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //$data =       $this->db_pdo->get_data(['columns'=>'all','table_name'=>'tbl_events']);
            //return $this->db_pdo;
       }
       catch(PDOException $e)
       {
            echo "Error in connecting db ". $e->getMessage();
            exit;
       }
       
    }

    public function get_data($params = array() )
    {
       
        $bindParam = array();
        if($params["columns"] == "all")
        {
            $columns = " * ";              
        }
        elseif(is_array($params["columns"]))
        {
            $columns = rtrim( implode(",",$params["columns"] ), ",");
        }
        
        if(!isset($params["where"]))
        {
            $where = " 1 "; 
        }
        else
        {
            $where = $params["where"];
            $count = 0;
        }

        $query = "Select ".$columns." from ".$params['table_name']." where ".$where;
        $stmt = $this->db_pdo->prepare($query );
        if(isset($params['bind_params']) && count($params['bind_params']))
        {
            foreach($params['bind_params'] as $key => $val)
            {
                $stmt->bindParam($key, $val);
            }
        }
       /*  echo $query;
        echo "<br>";
        echo "==<br>"; */
        try
        {
            if($stmt->execute())
            {
                $result = $stmt->fetchAll();
            }
            else
            {
                throw new Exception("Query execution failed");
            }
        }
        catch(Exception $e)
        {
            echo "Error: " . $e->getMessage();
        }
        
        return  $result;
    }

    public function insert_data($params)
    {
        $bindParam = array();
        
        $columns = array_keys($params['columns'][0]);
        $place_var = '';
        $values_str = '';
        for($i=0; $i<count($params['columns']); $i++)
        {
            $placeholders = array_map(function($col) use ($i) {
                return ":".$col."_".$i;
            },$columns);
           
            $values_str .= " ( ".implode("," ,$placeholders)." ) ,";
            
        }
        $values_str = rtrim($values_str,",");
        
                
        $query = "INSERT INTO ".$params['table_name']." (". implode(",",$columns).") VALUES ".$values_str." " ;

        $stmt = $this->db_pdo->prepare($query);
        
        $count = 0;
        foreach($params['columns'] as $key => $val)
        {
            foreach($val as $key1 => $val1)
            {
                $stmt->bindValue(":".$key1."_".$count,$val1);
                echo ":".$key1."_".$count."==".$val1."<br>";
            }
            $count++;
        }
       
       
        try{
            if($stmt->execute())
            {
                return $this->db_pdo->lastInsertId();
            }
            else
            {
                throw new Exception("Query execution failed");
            }
        }
        catch(Exception $e)
        {
            echo "Error: " . $e->getMessage();
        }
        
    }

    public function update_data($params)
    {
        echo "<pre>";
        print_r($params);
        $columns = array_keys($params["columns"]);
        print_r($columns);
        if(is_array($columns))
        {
            $columns = array_map(function($col){
               
                return $col." = :".$col;
            }, $columns);
        }
       
        $columns = implode(",",$columns);
        $where = "";
        $whereColumns = array_keys($params['where']);
        
        if(is_array($whereColumns))
        {
            $whereColumns = array_map(function($col){
                echo $col." = :c_".$col;
                return $col." = :c_".$col;
            },$whereColumns);
        }
        $where = implode(" and ",$whereColumns);

        $query = "UPDATE ".$params['table_name']." SET ".$columns." where ".$where;
        $stmt = $this->db_pdo->prepare($query);
        foreach($params["columns"] as $key => $val)
        {
            $stmt->bindValue(':'.$key,$val);
            echo "<br>";
            echo ':'.$key."==".$val;
            echo "<br>";
        }
        foreach($params['where'] as $key => $val)
        {
            $stmt->bindValue(':c_'.$key,$val);
            echo "<br>";
            echo ':'.$key."==".$val;
            echo "<br>";
        }
       echo $query ;
        try{
            if($stmt->execute())
            {
                return $this->db_pdo->lastInsertId();
            }
            else
            {
                throw new Exception("Query execution failed");
            }
        }
        catch(Exception $e)
        {
            echo "Error: " . $e->getMessage();
        }
        
    }

    public function delete_data($params)
    {
        
        $columns = array_keys($params["where"]);
        
        if(is_array($columns))
        {
            $columns = array_map(function($col){
               
                return $col." = :".$col;
            }, $columns);
        }
        $where = implode(" and ", $columns);
       echo "columns = ".$where;
        $query = " DELETE from ".$params['table_name']." where ".$where;
        echo "<br>".$query;
        $stmt = $this->db_pdo->prepare($query);

        foreach($params['where'] as $key => $val)
        {
            $stmt->bindValue(':'.$key,$val);
            echo "<br>";
            echo ':'.$key."===".$val."<br>";
        }

        try{
            if($stmt->execute())
            {
                echo "Row deleted successfully.";
            }
            else
            {
                throw new Exception("Query execution failed");
            }
        }
        catch(Exception $e)
        {
            echo "Error: " . $e->getMessage();
        }
    }
}