 <?php

require  'Slim/Slim.php';
require  'Redbeanphp/rb.php';
\Slim\Slim::registerAutoloader();

R::setup('mysql:host=localhost;dbname=testdb','root','');
R::freeze(true);


$groupMap = array(
	"Д" => "DID",
	"Др." => "OTHR",
	"КП" => "CSP" /*ComputerScience - Practicum*/,
	"М" => "MAT",
	"ОКН" => "CSF" /*CS Fundamentals*/,
	"ПМ" => "APM" /*APPLIED MATH*/,
	"С" => "SEM" /*Seminars*/,
	"Ст" => "STAT" /*Statistics*/,
	"Х" => "HUM" /*Humanitarian*/,
	"ЯКН" => "CSC" /*CS Core*/,
	"И" => "INF" /*informatics*/,
	"ПМ / Ст" => array("APM", "STAT"), /*wtf fmi*/
	"ПМ/Ст" => array("APM", "STAT"), /*wtf fmi x2*/
	"ОКН/Ст" => array("CSF", "STAT") /*wtf fmi x3*/
);

$app = new \Slim\Slim();

function generateExceptionError($app,$exception) {
	$error['error']=$exception->getMessage();
	$app->response()->header('Content-Type', 'application/json');
	$app->response()->status($exception->getCode());
	echo json_encode($error  , JSON_UNESCAPED_UNICODE );
};

function generateCustomError($app,$code,$message) {
	$error['error']=$message;
	$app->response()->header('Content-Type', 'application/json');
	$app->response()->status($code);
	echo json_encode($error  , JSON_UNESCAPED_UNICODE );
};

function token() {
	$length=17;
    $characters = array(
        "A","B","C","D","E","F","G","H","J","K","L","M",
        "N","P","Q","R","S","T","U","V","W","X","Y","Z",
        "a","b","c","d","e","f","g","h","i","j","k","m",
        "n","o","p","q","r","s","t","u","v","w","x","y","z",
        "1","2","3","4","5","6","7","8","9");
    if ($length < 0 || $length > count($characters)) return null;
    shuffle($characters);
    return implode("", array_slice($characters, 0, $length));
}

function generateToken($token_,$ip) {
	do {
		$token_ = token();
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

function checkToken ($token) {
	$escaped_token=mysql_real_escape_string($token);
	$thing = R::findOne("tokens", 'token = ?', array($escaped_token));
	if (isset($thing)){
		return true;
	}
	else {
		return false;
	}
}

$app->get('/aba', function () use ($app) {
		$token='';
		$ip_address = "";
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARTDED_FOR'] != '') {
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} 
		else {
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}
		$token=generateToken($token,$ip_address);
		if (isset($token)) {
			$generatedToken['token']=$token;
			$app->response()->header('Content-Type', 'application/json');
			echo json_encode($generatedToken,JSON_UNESCAPED_UNICODE);
		}
		else {
			$error['error'] = 'No token was generated';
			$app->response()->header('Content-Type', 'application/json');
			echo json_encode($error,JSON_UNESCAPED_UNICODE);
		}
});

$app->get('/:token/programs', function ($token) use ($app) {
	if (checkToken($token))
	  {
		try {
			$programs=R::getAll('SELECT * FROM bachelor_programmes');
			if ($programs) {
				$app->response()->header('Content-Type', 'application/json');
				echo json_encode($programs,JSON_UNESCAPED_UNICODE);
			}
			else {
				throw new Exception('Nothing was found',400);
			}
		}
		catch (Exception $e) {
				 generateExceptionError($app,$e);
		}
	  }
	else{
	    generateCustomError($app,400,"Invalid Token");
	  }
});

$app->get('/:token/programs/:id', function ($token,$id) use ($app) {
	if (checkToken($token)) {
		try {
			$escaped_id = mysql_real_escape_string($id);
			$program = R::getRow("SELECT * FROM bachelor_programmes WHERE programme_id = $escaped_id");
			if ($program) {
				$app->response()->header('Content-Type', 'application/json');
				echo json_encode($program  , JSON_UNESCAPED_UNICODE );
			}
			else {
				throw new Exception('Nothing was found',400);
			}
		}
		catch (Exception $e) {
			generateExceptionError($app,$e);
		}
	}
	else {
		generateCustomError($app,400,"Invalid Token");
	}
});

$app->get('/:token/courses', function ($token) use ($app) {
	if (checkToken($token)) {
		try {
			$courses = R::getAll("SELECT courses.course_id, courses.course_name, courses.group, courses.credits, courses.semester, bachelor_programmes.programme_name, courses.year FROM courses LEFT JOIN bachelor_programmes on courses.programme_id=bachelor_programmes.programme_id");
			if ($courses) {
				$app->response()->header('Content-Type', 'application/json');
				echo json_encode($courses  , JSON_UNESCAPED_UNICODE );
			} 
			else {
				throw new Exception('Nothing was found',400);
			}
		}
		catch (Exception $e) {
				generateExceptionError($app,$e);
		}
	}
	else {
		generateCustomError($app,400,"Invalid Token");
	}
});

$app->get('/:token/courses/:id', function ($token,$id) use ($app) {
	if (checkToken($token)) {
		try {
			$escaped_id = mysql_real_escape_string($id);
			$program = R::getRow("SELECT courses.course_id, courses.course_name, courses.group, courses.credits, courses.semester, bachelor_programmes.programme_name, courses.year FROM courses LEFT JOIN bachelor_programmes on courses.programme_id=bachelor_programmes.programme_id WHERE courses.course_id = $escaped_id");
			if ($program) {
				$app->response()->header('Content-Type', 'application/json');
				echo json_encode($program  , JSON_UNESCAPED_UNICODE );
			}
			else {
				throw new Exception('Nothing was found',400);
			}
		}
		catch (Exception $e) {
			generateExceptionError($app,$e);
		}
	}
	else {
		generateCustomError($app,400,"Invalid Token");
	}
});

$app->get('/:token/courses/year/:year', function ($token,$year) use ($app) {
	if (checkToken($token)) {
		if ( preg_match('/^[0-4]$/', $year) ) {
			try {
				$escaped_year=mysql_real_escape_string($year);
				$courses = R::getAll("SELECT courses.course_id, courses.course_name, courses.group, courses.credits, courses.semester, bachelor_programmes.programme_name, courses.year FROM courses LEFT JOIN bachelor_programmes on courses.programme_id=bachelor_programmes.programme_id WHERE year=$escaped_year");
				if ($courses) {
					$app->response()->header('Content-Type', 'application/json');
					echo json_encode($courses  , JSON_UNESCAPED_UNICODE );
				}
				else {
					throw new Exception('Nothing was found',400);
				}
			}
			catch (Exception $e) {
					  generateExceptionError($app,$e);
			}
		}
		else {
			generateCustomError($app,400,"Should be a number from 0 to 4");
		}
	}
	else {
		generateCustomError($app,400,"Invalid Token");
	}
});




// http://alexbilbie.com/2013/02/securing-your-api-with-oauth-2/
// http://help.slimframework.com/discussions/questions/230-can-i-have-a-get-request-with-variable-number-of-parameters-in-the-url
// http://nesbot.com/2012/6/18/slim-wildcard-routes-via-route-middleware
// http://linkey.blogs.lincoln.ac.uk/tag/access-token/

R::close();
$app->run();
