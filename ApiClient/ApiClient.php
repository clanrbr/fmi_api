<?php
	class ApiClient
	{
		// private $ch;
		private $token;
		private $url="http://localhost/api/index.php/";

		public function __construct($token="") {
			// $this->ch = curl_init();
			$this->token = $token;
		}
		public function get_all_programs() {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url."/programs"); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			$output = curl_exec($ch); 
			curl_close($ch);
			return $output;
		}
