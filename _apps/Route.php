<?php
/*
credits:
https://stackoverflow.com/questions/19198804/deducing-php-closure-parameters
https://hotexamples.com/examples/-/ReflectionMethod/getParameters/php-reflectionmethod-getparameters-method-examples.html

*/
namespace Apps;

class Route{

	protected $route_id = NULL;
	protected $route = NULL;
	protected $path = "";
	protected $route_path = NULL;
	
	private static $routes = Array();
	private static $pathNotFound = null;
	private static $methodNotAllowed = null;

	public $UsedVariable = Array();

	public function __construct(){}
	
	public function debug($data="Debug::Stoped"){
		print_r($data);
		exit();
	}

  	public static function add($expression, $function, $method = 'get'){
    	array_push(self::$routes,Array(
      		'expression' => $expression,
      		'function' => $function,
      		'method' => $method
	  ));
  	}
	
	public function getBetween($string,$start='',$end=''){
		if (strpos($string, $start)) { // required if $start not exist in $string
			$startCharCount = strpos($string, $start) + strlen($start);
			$firstSubStr = substr($string, $startCharCount, strlen($string));
			$endCharCount = strpos($firstSubStr, $end);
			if ($endCharCount == 0) {
				$endCharCount = strlen($firstSubStr);
			}
			return substr($firstSubStr, 0, $endCharCount);
		} else {
			return '';
		}
	}	

	public static function pathNotFound($function){
    	self::$pathNotFound = $function;
	}

  	public static function methodNotAllowed($function){
   		self::$methodNotAllowed = $function;
  	}

  	public function run($basepath = '/'){
    	// Parse current url
    	$parsed_url = parse_url($_SERVER['REQUEST_URI']);//Parse Uri
    	if(isset($parsed_url['path'])){
      		$path = $parsed_url['path'];
   	 	}else{
      		$path = '/';
    	}
    	// Get current request method
    	$method = $_SERVER['REQUEST_METHOD'];
    	
		$path_match_found = false;
    	$route_match_found = false;

    	foreach(self::$routes as $route){
			// If the method matches check the path
			// Add basepath to matching string
			if($basepath!=''&&$basepath!='/'){
				$route['expression'] = '('.$basepath.')'.$route['expression'];
			}
			// Keep original expression
			$saved_expression = trim($route['expression']);
			$saved_path = trim($path) . '/';
			$saved_funct_params = array();
			
			$saved_expression_arr = explode('/',$saved_path);
			$saved_path_arr = explode('/',$saved_expression);
			
			// Add 'find string start' automatically
			$route['expression'] = '^'.$route['expression'];
			// Add 'find string end' automatically
			$route['expression'] = $route['expression'].'$';
			
			// Let match braces supplied args on the url to the function parameters//	
			preg_match_all('#\{(.*?)\}#', $saved_expression, $match_path_args);
			$matched_path_args = $match_path_args[1];
			
			//Path matching and variable//
			////////////////////////////////////////////////////////////////
			$strKeys = array();
			$strVals = array();
			$strKeyVal_arr = array();
			if (is_callable($route['function'])) {
				$reflection = new \ReflectionFunction($route['function']);
				foreach ($reflection->getParameters() as $funct_param) {
					$saved_funct_params[] = $funct_param->name;
				}
			}

			$new_expression = $saved_expression;
			foreach($saved_funct_params as $funct_param){
				$func_param_str = "{" . $funct_param . "}";
				$ar_key = array_search($func_param_str,$saved_path_arr,true);
					
				@ $ar_val = $saved_expression_arr[$ar_key];
				@ $ar_str_key_name = $saved_expression_arr[($ar_key-1)];
	
				$strKeyVal_arr[$ar_str_key_name] = $ar_val; 
				$strKeys[] = $ar_key; 
				$strVals[] = $ar_val; 
				$route['expression'] = str_replace($func_param_str,$ar_val,$route['expression']);
			}
	
		
			// Check path match	
			if(preg_match('#' . $route['expression'] . '#', $path, $matches)){
				$this->path = $path;
				$path_match_found = true;
				// Check method match
				if(strtolower($method) == strtolower($route['method'])){
					array_shift($matches);// Always remove first element. This contains the whole string
					if($basepath!=''&&$basepath!='/'){
						array_shift($matches);// Remove basepath
					}
					if (is_callable($route['function'])) {
						call_user_func_array($route['function'], $strVals);
					}
					$route_match_found = true;
					// Do not check other routes
					break;
				}
			}
		}
		// No matching route was found
		if(!$route_match_found){
			// But a matching path exists
			if($path_match_found){
				header("HTTP/1.0 405 Method Not Allowed");
				if(self::$methodNotAllowed){
					call_user_func_array(self::$methodNotAllowed, Array($path,$method));
				}
			}else{
				header("HTTP/1.0 404 Not Found");
				if(self::$pathNotFound){
					call_user_func_array(self::$pathNotFound, Array($path));
				}
			}
		}
	}
}
	
?>