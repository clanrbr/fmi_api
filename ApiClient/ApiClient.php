<?php
	class ApiClient
	{
		public $token;
		private $url="http://localhost/api/index.php/";

		public function __construct($token="") {
			$this->token = $token;
		}
		
		private function _get_all_programs() {
			$params=func_get_args();
			$ch = array_shift($params);
			curl_setopt($ch, CURLOPT_URL, $this->url."/".$this->token."/programs"); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			$output = curl_exec($ch);
			return $output;
		}
		
		private function _get_all_program() {
			$params=func_get_args();
			$ch = array_shift($params);
			$id="";
			if ( isset($params) )
			  $id=array_shift($params);
				
			curl_setopt($ch, CURLOPT_URL, $this->url."/".$this->token."/program/".$id); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			$output = curl_exec($ch);
			$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if ($status_code==404) {
				return json_encode(array('error'=>'Missing parameter ID'),JSON_UNESCAPED_UNICODE);
			}
			else {
				return $output;
			}
		}
		
		
		public function __call($func, $params=array()) {
			$ch = curl_init();
			array_unshift($params, $ch);
			$output = call_user_func_array(array($this,'_'.$func),$params);
			curl_close($ch);
			return $output;
		}
	}

	$cl= new ApiClient("Bshkpc5KWESLAZQGx");
	$cool=$cl->get_all_programs('1','2');	
	$cool1=$cl->get_all_program();	
	echo $cool1;
	// var_dump($cool1);
?>