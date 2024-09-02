<?php

session_start();
class server
{
	
	
	private $db;
	private $app_type = "app"; 
	private $path_arr = [
							
                            '/' =>['GET'=>'authentication_controller@dahsboard'],	
                            '/login' =>['GET'=>'authentication_controller@draw_login'],	
                            //'/login_user' =>['POST'=>'authentication_controller@login_user'],	
                            '/event_list' =>['GET'=>'event_controller@list'],	
                            '/fetch_events' =>['GET'=>'event_controller@fetch_events'],	
                            


							//API paths
							'/api/register' =>['POST'=>'register_controller@register'],
							'/api/login' =>['POST'=>'login_controller@login'],

							'/api/events' => ['GET'=>'apiEvent_controller@events'],
							'/api/events/create' =>['POST'=>'apiEvent_controller@add_event'],		
							'/api/events/update' =>['PUT'=>'apiEvent_controller@update_event'],		
							'/api/events/delete' =>['DELETE'=>'apiEvent_controller@delete_event'],	
							
							'/api/user' => ['GET'=>'user_controller@get_user'],
							'/api/user/update' => ['PUT'=>'user_controller@update_user'],
							'/api/user/delete' => ['DELETE'=>'user_controller@delete_user'],
									

                           
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
			
			$path = ($path != '/') ? rtrim($path,'/') : '/';
			if (strpos($path, '/api') === 0) 
			{
				$this->app_type = 'api';
				include API_ROOT.'helpers/auth.php'; 
				include API_ROOT.'/middleware/jwt_auth.php';
				$j_data = array();
				if(!in_array($path, ['/api/login', '/api/register'])) 
				{
					$jwt_auth = new	jwt_auth();
					$j_data = $jwt_auth->jwt_authenticate();		
					
				}

			}
			/* echo "<pre> session ";
			print_r($_SESSION); */
			
			$req_method = $_SERVER['REQUEST_METHOD'];
			
			
			$params = array();
			
			//$params = json_decode(file_get_contents("php://input") ,true);
			/* if ($_SERVER['REQUEST_METHOD'] === 'GET')
			{
				echo "inside";
				$params = $_GET; 
			}
			else */
			if (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) 
			{
				$params = json_decode(file_get_contents("php://input"), true);
				
			}
			else 
			{
				
				// Fallback to $_POST for form submissions
				$params = $_POST;
			}
//echo $path."====".$req_method;
//print_r($params);
			$params['is_admin'] =  $j_data['is_admin'] ?? '';
			$params['user_id'] =  $j_data['user_id'] ?? '';

			$path_info = $this->path_arr[$path][$req_method];
//echo "info===".$path_info;

			if($path_info)
			{
				
				if($this->app_type =="app" && !$_SESSION['user_id'] && !in_array($path, ['/login', '/register','/login_user']) )
       			{
					header("location: http://".$_SERVER['SERVER_NAME']."/events-management/index.php/login");
					exit;
				}
				if($_SESSION['user_id'] && in_array($path, ['/login', '/register','/login_user']))
				{
					header("location: http://".$_SERVER['SERVER_NAME']."/events-management/index.php/");
					exit;
				}
				$path_info_arr = explode("@",$path_info);
				
		//	print_r($path_info_arr);
	
				include_once ROOT.$this->app_type.'/controllers/'.$path_info_arr[0].'.php';
				//echo "in2 ";
				
				//exit;
				$c_obj = new $path_info_arr[0]($this->db);
				$response = $c_obj->{$path_info_arr[1]}($params);
				
				
				if($this->app_type =='api')
				{
					$response["status_code"] = $response["status_code"] ?? 200;
					http_response_code($response["status_code"]);
					header("Access-Control-Allow-Origin: *");
					header('Content-Type: text/html; charset=utf-8');
					header('Content-Type: application/json; charset=utf-8');

					echo  json_encode([
						'success' => $response["success"] ?? false, 
						'data' =>  $response["data"] ?? '',
						'message' =>  $response["message"] ??  '',
						//'error' =>  $response["error"] ?? false,
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

