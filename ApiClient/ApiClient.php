<?php
	class ApiClient
	{
		public $token;
		private $url="http://localhost/api/index.php/";

-		public function __construct($token="") {
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
?>