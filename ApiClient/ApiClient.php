<?php
	class ApiClient
	{
		private $ch;
		public $token;
		private $url="http://localhost/api/index.php";

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
			curl_setopt($this->ch, CURLOPT_URL, $this->url."/".$this->token."/programs"); 
			curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1); 
			$output = curl_exec($this->ch);
			return $output;
		}
		
		private function _get_program_by_id($id=0) {
			if ( empty($id) ) {
                trigger_error("Missing parameter id in get_program_by_id", E_USER_ERROR);
                return;
            }
                
			curl_setopt($this->ch, CURLOPT_URL, $this->url."/".$this->token."/program/".$id); 
			curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1); 
			$output = curl_exec($this->ch);
            return $output;
		}
        
        private function _gel_all_teachers() {
            curl_setopt($this->ch, CURLOPT_URL, $this->url."/".$this->token."/teachers"); 
			curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1); 
			$output = curl_exec($this->ch);
			return $output;
        }
        
        private function _get_teachers_by_department($department="") {
			if ( empty($department) ) {
				trigger_error("Missing parameter department in get_teachers_by_department", E_USER_ERROR);
				return;
			}

            curl_setopt($this->ch, CURLOPT_URL, $this->url."/".$this->token."/teachers/department/".$department); 
			curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($this->ch);
            return $output;
        }
		
        private function _get_teachers_by_position($position="") {
			if ( empty($position) ) {
				trigger_error("Missing parameter position in get_teachers_by_position", E_USER_ERROR);
				return;
			}

            curl_setopt($this->ch, CURLOPT_URL, $this->url."/".$this->token."/teachers/position/".urlencode($position)); 
			curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($this->ch);
            return $output;
        }
        
        private function _get_teacher_by_id($id=0) {
			if ( empty($id) ) {
                trigger_error("Missing parameter id in get_teacher_by_id", E_USER_ERROR);
                return;
            }

			curl_setopt($this->ch, CURLOPT_URL, $this->url."/".$this->token."/teacher/".$id); 
			curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1); 
			$output = curl_exec($this->ch);
            return $output;
		}
        
        private function _get_all_semesters() {
            curl_setopt($this->ch, CURLOPT_URL, $this->url."/".$this->token."/semesters"); 
			curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1); 
			$output = curl_exec($this->ch);
			return $output;
        }
        
        private function _get_semesters_by_filter($params) {
			$urlextend="";
			if ( isset($params['season']) )
			  $urlextend.="/".$params['season'];
			if ( isset($params['start_year'] ) )
			  $urlextend.="/".$params['start_year'];
			if ( isset($params['end_year']) )
			  $urlextend.="/".$params['end_year'];
            
            curl_setopt($this->ch, CURLOPT_URL, $this->url."/".$this->token."/semester_filter".$urlextend); 
			curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($this->ch);
            return $output;
        }

		private function _get_semesters_by_season($season) {
			if ( empty($season) ) {
                trigger_error("Missing parameter season in get_semesters_by_season", E_USER_ERROR);
                return;
            }
			curl_setopt($this->ch, CURLOPT_URL, $this->url."/".$this->token."/semesters/season/".$season); 
			curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($this->ch);
            return $output;
		}
		
		private function _get_semesters_by_start_year($start_year=0) {
			if ( empty($start_year) ) {
				trigger_error("Missing parameter start_year in get_semesters_by_start_year", E_USER_ERROR);
                return;
			}
			curl_setopt($this->ch, CURLOPT_URL, $this->url."/".$this->token."/semesters/start/".$start_year); 
			curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($this->ch);
            return $output;
		}
		
		private function _get_semesters_by_end_year($end_year=0) {
			if ( empty($end_year) ) {
				trigger_error("Missing parameter end_year in get_semesters_by_end_year", E_USER_ERROR);
                return;
			}
			curl_setopt($this->ch, CURLOPT_URL, $this->url."/".$this->token."/semesters/end/".$end_year); 
			curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($this->ch);
            return $output;
		}
		
		private function _get_all_courses() {
			curl_setopt($this->ch, CURLOPT_URL, $this->url."/".$this->token."/courses"); 
			curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($this->ch);
            return $output;
		}
		
		private function _get_courses_by_id($id=0) {
			if ( empty($id) ) {
                trigger_error("Missing parameter id in get_teacher_by_id", E_USER_ERROR);
                return;
            }

			curl_setopt($this->ch, CURLOPT_URL, $this->url."/".$this->token."/course/".$id); 
			curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1); 
			$output = curl_exec($this->ch);
            return $output;
		}

        private function _get_courses_by_semester_year($year=0) {
            curl_setopt($this->ch, CURLOPT_URL, $this->url."/".$this->token."/courses/year/".$year); 
            curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1); 
            $output = curl_exec($this->ch);
            return $output;
        }

        private function _get_courses_by_semester($semester=0) {
            if ( empty($semester) ) {
                trigger_error("Missing parameter semester in get_courses_by_semester", E_USER_ERROR);
                return;
            }
            curl_setopt($this->ch, CURLOPT_URL, $this->url."/".$this->token."/courses/semester/".$semester); 
            curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1); 
            $output = curl_exec($this->ch);
            return $output;
        }

        private function _get_courses_by_credits($credits="") {
            if ( empty($credits) ) {
                trigger_error("Missing parameter credits in get_courses_by_credits", E_USER_ERROR);
                return;
            }
            curl_setopt($this->ch, CURLOPT_URL, $this->url."/".$this->token."/courses/credits/".$credits); 
            curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1); 
            $output = curl_exec($this->ch);
            return $output;
        }

        private function _get_courses_by_group($group="") {
            if ( empty($group) ) {
                trigger_error("Missing parameter group in get_courses_by_group", E_USER_ERROR);
                return;
            }
            curl_setopt($this->ch, CURLOPT_URL, $this->url."/".$this->token."/courses/group/".$group); 
            curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1); 
            $output = curl_exec($this->ch);
            return $output;
        }

        private function _get_program_by_filter($filter) {
            $urlextend="";
            if ( isset($filter['year']) )
              $urlextend.="/".$filter['year'];
            if ( isset($filter['program_id'] ) )
              $urlextend.="/".$filter['program_id'];
            if ( isset($filter['semester']) )
              $urlextend.="/".$filter['semester'];
            
            curl_setopt($this->ch, CURLOPT_URL, $this->url."/".$this->token."/courses/program".$urlextend); 
            curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($this->ch);
            return $output;
        }

        // courses/program(/:year(/:program_id(/:semester)))

		public function __call($func, $params=array()) {
			$this->ch = curl_init();
			$output = call_user_func_array(array($this,'_'.$func),$params);
			curl_close($this->ch);
			return $output;
		}
	}

	$cl= new ApiClient("Bshkpc5KWESLAZQGx");
	$cool=$cl->get_all_programs();
	$cool1=$cl->get_program_by_id(1);	
    $cool2=$cl->gel_all_teachers();
    $cool3=$cl->get_teachers_by_department("СТ");
    $cool4=$cl->get_teachers_by_position("главен асистент");
    $cool5=$cl->get_teacher_by_id(1);
    $cool6=$cl->get_all_semesters();
    $cool7=$cl->get_semesters_by_filter(array("season"=>"summer","start_year"=>2012,"end_year"=>2013));
	$cool8=$cl->get_semesters_by_season("summer");
	$cool9=$cl->get_semesters_by_start_year(2012);
	$cool10=$cl->get_semesters_by_end_year(2013);
	$cool11=$cl->get_all_courses();
	$cool12=$cl->get_courses_by_id(4);
    $cool13=$cl->get_courses_by_semester_year(0);
    $cool14=$cl->get_courses_by_semester(1);
    $cool15=$cl->get_courses_by_credits(">7");
    $cool16=$cl->get_courses_by_group("Д");
    $cool17=$cl->get_program_by_filter(array("year"=>"0","program_id"=>9,"semester"=>1));
    // "program_id"=>"1","semester"=>1
	echo $cool17;
?>