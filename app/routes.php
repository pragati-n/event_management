<?php


class server
{
	
	
	private $db;
	private $app_type = "app"; 
	private $path_arr = [
							
                            '/' =>['GET'=>'authentication_controller@dahsboard'],	
                            '/login' =>['GET'=>'authentication_controller@login'],	
                            '/event_list' =>['GET'=>'event_controller@list'],	
                            '/fetch_events' =>['GET'=>'event_controller@fetch_events'],	
                            


							//API paths
							'/api/events' => ['GET'=>'apiEvent_controller@events'],
							'/api/events/create' =>['POST'=>'apiEvent_controller@add_event'],		

                           
						];
	
	public function __construct()
	{
		$this->db = new database();
		$this->db->connect();
		
		
		
	}
	
	public function handle($path = '')
	{
		try
		{
			
			if (strpos($path, '/api') === 0) 
			{
				$this->app_type = 'api';
			}
			
			$req_method = $_SERVER['REQUEST_METHOD'];
			
			
			$params = array();
			//$params = json_decode(file_get_contents("php://input") ,true);
			if ($_SERVER['REQUEST_METHOD'] === 'GET')
			{
				$params = $_GET; 
			}
			elseif (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) 
			{
				
				$params = json_decode(file_get_contents("php://input"), true);
				
			}
			else {
				
				// Fallback to $_POST for form submissions
				$params = $_POST;
			}

			/* if($req_method == "GET")
			{
				print_r($_GET);
				// $params = json_decode($_GET,1);
			} */
            
			$path_info = $this->path_arr[$path][$req_method];
			
			if($path_info)
			{
				$path_info_arr = explode("@",$path_info);
				

				include_once ROOT.$this->app_type.'/controllers/'.$path_info_arr[0].'.php';
				//echo "in2 ";
				$c_obj = new $path_info_arr[0]($this->db);
				$response = $c_obj->{$path_info_arr[1]}($params);
				
				
				if($this->app_type =='api')
				{
					$response["status_code"] = 200;
				http_response_code($response["status_code"]);
				header("Access-Control-Allow-Origin: *");
				header('Content-Type: text/html; charset=utf-8');
					header('Content-Type: application/json; charset=utf-8');

					echo  json_encode([
						'success' => $response["success"] ?? false, 
						'data' =>  $response["data"] ?? '',
						'message' =>  $response["message"] ??  '',
						'error' =>  $response["error"] ?? false,
			]);
				}
				
				
					
			
			}
			else
			{
				throw new Exception ("Page not found",404);
			}
			
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}

		
	}
}

