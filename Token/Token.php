<?php
	class ApiToken 
	{
		private $token;
		
		private function token() {
			$length=17;
			$characters = array(
				"A","B","C","D","E","F","G","H","J","K","L","M",
				"N","P","Q","R","S","T","U","V","W","X","Y","Z",
				"a","b","c","d","e","f","g","h","i","j","k","m",
				"n","o","p","q","r","s","t","u","v","w","x","y","z",
				"1","2","3","4","5","6","7","8","9");
			if ($length < 0 || $length > count($characters)) 
				return null;
				
			shuffle($characters);
			return implode("", array_slice($characters, 0, $length));
		}

		private function _generateToken($token_,$ip) {
			do {
				$token_ = $this->token();
				$check = R::findOne('tokens',' token = ? ',array($token_));
			} while ( isset($check) and $check.length > 0  );
			
			if (isset($token_)) {
				$escaped_ip=mysql_real_escape_string($ip);
				$thing = R::dispense("tokens");
				$thing->token = "$token_";
				$thing->ip = "$escaped_ip";
				$id = R::store($thing);
			}
			return $token_;
		}

		private function _checkToken ($token) {
			$escaped_token=mysql_real_escape_string($token);
			$thing = R::findOne("tokens", 'token = ?', array($escaped_token));
			if (isset($thing)){
				return true;
			}
			else {
				return false;
			}
		}
		
		public function __call($func, $params=array()) {
			$result = call_user_func_array(array($this,'_'.$func),$params);
			return $result;
		}
	
	}