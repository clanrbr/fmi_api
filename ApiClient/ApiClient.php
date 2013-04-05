<?php
	class ApiClient
	{
		public $token;
		private $url="http://localhost/api/index.php/";

		public function __construct($token="") {
			$this->token = $token;
		}
        
        function myErrorHandler($errno, $errstr, $errfile, $errline) {
            // if (!(error_reporting() & $errno)) {
                // return;
            // }
            switch ($errno) {
                case E_USER_ERROR:
                    echo "ERROR : [$errno] $errstr on line $errline in file $errfile\n";
                    exit(1);
                    break;

                case E_USER_WARNING:
                    echo "WARNING [$errno] $errstr\n";
                    break;

                case E_USER_NOTICE:
                    echo "NOTICE [$errno] $errstr\n";
                    break;

                default:
                    echo "Unknown error type: [$errno] $errstr\n";
                    break;
            }
            return true;
        }
		
		private function _get_all_programs() {
			$params=func_get_args();
			$ch = array_shift($params);
            if ( !(empty($params)) ) {
                trigger_error("This function don't take parameters", E_USER_ERROR);
                return;
            }
            
			curl_setopt($ch, CURLOPT_URL, $this->url."/".$this->token."/programs"); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			$output = curl_exec($ch);
			return $output;
		}
		
		private function _get_program_by_id() {
			$params=func_get_args();
			$ch = array_shift($params);
			$id="";
            
			if ( empty($params) ) {
                trigger_error("Missing parameter id", E_USER_ERROR);
                return;
            }
                
			$id=array_shift($params);	
			curl_setopt($ch, CURLOPT_URL, $this->url."/".$this->token."/program/".$id); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			$output = curl_exec($ch);
			$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            return $output;
		}
        
        private function _gel_all_teachers() {
            $params=func_get_args();
            $ch = array_shift($params);
            
            if ( !(empty($params)) ) {
                trigger_error("This function don't take parameters", E_USER_ERROR);
                return;
            }
            curl_setopt($ch, CURLOPT_URL, $this->url."/".$this->token."/teachers"); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			$output = curl_exec($ch);
			return $output;
        }
        
        private function _get_teachers_by_department() {
            $params=func_get_args();
			$ch = array_shift($params);
			$department="";
            
			if ( empty($params) ) {
                trigger_error("Missing parameter department", E_USER_ERROR);
                return;
            }
			$department=array_shift($params);
            curl_setopt($ch, CURLOPT_URL, $this->url."/".$this->token."/teachers/department/".$department); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);
			$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            return $output;
        }
        private function _get_teachers_by_position() {
            $params=func_get_args();
			$ch = array_shift($params);
			$position="";
            
			if ( empty($params) ) {
                trigger_error("Missing parameter position", E_USER_ERROR);
                return;
            }
			$position=array_shift($params);
            curl_setopt($ch, CURLOPT_URL, $this->url."/".$this->token."/teachers/position/".urlencode($position)); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);
			$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            return $output;
        }
        
        private function _get_teacher_by_id() {
			$params=func_get_args();
			$ch = array_shift($params);
			$id="";
            
			if ( empty($params) ) {
                trigger_error("Missing parameter id", E_USER_ERROR);
                return;
            }
                
			$id=array_shift($params);	
			curl_setopt($ch, CURLOPT_URL, $this->url."/".$this->token."/teacher/".$id); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			$output = curl_exec($ch);
			$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            return $output;
		}
        private function _get_all_semesters() {
            $params=func_get_args();
            $ch = array_shift($params);
            
            if ( !(empty($params)) ) {
                trigger_error("This function don't take parameters", E_USER_ERROR);
                return;
            }
            curl_setopt($ch, CURLOPT_URL, $this->url."/".$this->token."/semesters"); 
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
	$cool=$cl->get_all_programs();	
	$cool1=$cl->get_program_by_id('1');	
    $cool2=$cl->gel_all_teachers();
    $cool3=$cl->get_teachers_by_department("СТ");
    $cool4=$cl->get_teachers_by_position("главен асистент");
    $cool5=$cl->get_teacher_by_id(1);
    $cool6=$cl->get_all_semesters();
	echo $cool6;
	// var_dump($cool1);
?>