<?php
	class ApiClient
	{
		private $ch;
		public $token;
		private $url="http://localhost/api/index.php";

		public function __construct($token="") {
			$this->token = $token;
		}
		
		private function _get_all_programs() {
			$data=[];
			$data['data']=$this->url."/".$this->token."/programs"; 
			return $data;
		}
		
		private function _get_program_by_id($id=0) {
			$data=[];
			if ( empty($id) ) {
                $data['error']="Missing parameter id in get_program_by_id";
                return $data;
            }
                
			$data['data']=$this->url."/".$this->token."/program/".$id;
            return $data;
		}
        
        private function _gel_all_teachers() {
			$data=[];
            $data['data']=$this->url."/".$this->token."/teachers";
			return $data;
        }
        
        private function _get_teachers_by_department($department="") {
			$data=[];
			if ( empty($department) ) {
				$data['data']="Missing parameter department in get_teachers_by_department";
				return $data;
			}

            $data['data']=$this->url."/".$this->token."/teachers/department/".$department;
            return $data;
        }
		
        private function _get_teachers_by_position($position="") {
			$data=[];
			if ( empty($position) ) {
				$data['error']="Missing parameter position in get_teachers_by_position";
				return $data;
			}

            $data['data']=$this->url."/".$this->token."/teachers/position/".urlencode($position);
            return $data;
        }
        
		private function _get_teachers_by_course($course_id="") {
			$data=[];
			if ( empty($course_id) ) {
				$data['error']="Missing parameter course_id in get_teachers_by_course";
				return $data;
			}

            $data['data']=$this->url."/".$this->token."/teachers/course/".$course_id;
            return $data;
		}
		
        private function _get_teacher_by_id($id=0) {
			$data=[];
			if ( empty($id) ) {
                $data['error']="Missing parameter id in get_teacher_by_id";
                return $data;
            }

			$data['data']=$this->url."/".$this->token."/teacher/".$id; 
            return $data;
		}
        
        private function _get_all_semesters() {
			$data=[];
            $data['data']=$this->url."/".$this->token."/semesters";
			return $data;
        }
        
        private function _get_semesters_by_filter($params=array()) {
			$data=[];
			$urlextend="";
			if ( isset($params['season']) ) {
			  $urlextend.="/".$params['season'];
			}
			else {
			   $data['error']="Missing parameter array with key season in get_semesters_by_filter";
                           return $data;	
			}
			
			if ( isset($params['start_year'] ) )
			  $urlextend.="/".$params['start_year'];
			if ( isset($params['end_year']) )
			  $urlextend.="/".$params['end_year'];
            
			if (empty($urlextend)) {
				$data['error']="Missing parameters in get_semesters_by_filter";
				return $data;
			}
			
            $data['data']=$this->url."/".$this->token."/semester_filter".$urlextend;
            return $data;
        }

		private function _get_semesters_by_season($season) {
			$data=[];
			if ( empty($season) ) {
                $data['error']="Missing parameter season in get_semesters_by_season";
                return $data;
            }
			$data['data']=$this->url."/".$this->token."/semesters/season/".$season; 
            return $data;
		}
		
		private function _get_semesters_by_start_year($start_year=0) {
			$data=[];
			if ( empty($start_year) ) {
				$data['error']="Missing parameter start_year in get_semesters_by_start_year";
                return $data;
			}
			$data['data']=$this->url."/".$this->token."/semesters/start/".$start_year; 
            return $data;
		}
		
		private function _get_semesters_by_end_year($end_year=0) {
			$data=[];
			if ( empty($end_year) ) {
				$data['error']="Missing parameter end_year in get_semesters_by_end_year";
                return $data;
			}
			$data['data']=$this->url."/".$this->token."/semesters/end/".$end_year;
            return $data;
		}
		
		private function _get_all_courses() {
			$data=[];
			$data['data']=$this->url."/".$this->token."/courses";
            return $data;
		}
		
		private function _get_courses_by_id($id=0) {
			$data=[];
			if ( empty($id) ) {
				$data['error']="Missing parameter id in get_teacher_by_id";
                return $data;
            }
			$data['data']=$this->url."/".$this->token."/course/".$id;
            return $data;
		}
		
		private function _get_courses_by_semester_year($year=0) {
			$data=[];
            $data['data']=$this->url."/".$this->token."/courses/year/".$year; 
            return $data;
        }

        private function _get_courses_by_semester($semester=0) {
			$data=[];
            if ( empty($semester) ) {
                $data['data']="Missing parameter semester in get_courses_by_semester";
                return $data;
            }
            $data['data']=$this->url."/".$this->token."/courses/semester/".$semester; 
            return $data;
        }

        private function _get_courses_by_credits($credits="") {
			$data=[];
            if ( empty($credits) ) {
                 $data['error']="Missing parameter credits in get_courses_by_credits";
                return $data;
            }
            $data['data']=$this->url."/".$this->token."/courses/credits/".$credits; 
            return $data;
        }

        private function _get_courses_by_group($group="") {
			$data=[];
            if ( empty($group) ) {
                $data['error']="Missing parameter group in get_courses_by_group";
                return $data;
            }
            $data['data']=$this->url."/".$this->token."/courses/group/".$group; 
            return $data;
        }

        private function _get_program_by_filter($filter=array()) {
			$data=[];
            $urlextend="";
            if ( isset($filter['year']) )
              $urlextend.="/".$filter['year'];
            if ( isset($filter['program_id'] ) )
              $urlextend.="/".$filter['program_id'];
            if ( isset($filter['semester']) )
              $urlextend.="/".$filter['semester'];
            
			if (empty($urlextend)) {
				$data['error']="Missing parameters in get_program_by_filter";
				return $data;
			}
			
            $data['data']=$this->url."/".$this->token."/courses/program".$urlextend; 
            return $data;
        }
		
		private function _get_all_students() {
			$data=[];
			$data['data']=$this->url."/".$this->token."/students";
            return $data;
		}
		
		private function _get_student_by_id($id=0) {
			$data=[];
			if ( empty($id) ) {
                $data['error']="Missing parameter id in get_student_by_id";
                return $data;
            }

			$data['data']=$this->url."/".$this->token."/student/".$id; 
            return $data;
		}
		
		private function _get_student_by_fn($fn=0) {
			$data=[];
			if ( empty($fn) ) {
                $data['error']="Missing parameter fn in get_student_by_fn";
                return $data;
            }

			$data['data']=$this->url."/".$this->token."/students/fn/".$fn; 
            return $data;
		}
		
		private function _get_students_by_filter($params=array()) {
			$data=[];
			$urlextend="";
			if ( isset($params['course']) )
			  $urlextend.="/".$params['course'];
			if ( isset($params['year'] ) )
			  $urlextend.="/".$params['year'];
            
			if ( empty($urlextend) ) {
				$data['error']="Missing parameters in get_students_by_filter";
				return $data;
			}
			
            $data['data']=$this->url."/".$this->token."/students_filter".$urlextend;
            return $data;
		}

		public function __call($func, $params=array()) {
			$this->ch = curl_init();
			$result = call_user_func_array(array($this,'_'.$func),$params);
			if (isset($result['error']) ) {
				return json_encode($result , JSON_UNESCAPED_UNICODE );
			}
			
			curl_setopt($this->ch, CURLOPT_URL, $result['data']);
			curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($this->ch);
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
	$cool4a=$cl->get_teachers_by_course(4);
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
    $cool16=$cl->get_courses_by_group("Ст");
    $cool17=$cl->get_program_by_filter(array("year"=>"0","program_id"=>9,"semester"=>1));
	$cool18=$cl->get_all_students();
	$cool19=$cl->get_student_by_id(1);
	$cool20=$cl->get_student_by_fn(71112);
	$cool21=$cl->get_students_by_filter(array("course"=>1,"year"=>3));
	echo $cool21;
?>
