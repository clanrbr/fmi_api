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

// class ResourceNotFoundException extends Exception {  };

$parseWildcardToArray = function ($param_name) use ($app) {
   return function ($req, $res, $route) use ($param_name, $app) {

      $env = $app->environment();
      $params = $route->getParams();

      $env[$param_name.'_array'] = array();

      //Is there a useful url parameter?
      if (!isset($params[$param_name])) return;
      // {
         // return;
      // }

      $val = $params[$param_name];

      //Handle  /api/getitems/seafood//fruit////meat
      if (strpos($val, '//') !== false) $val = preg_replace("#//+#", "/", $val);
      // {
         // $val = preg_replace("#//+#", "/", $val);
      // }

      //Remove the last slash
      if (substr($val, -1) === '/') $val = substr($val, 0, strlen($val) - 1);
      // {
         // $val = substr($val, 0, strlen($val) - 1);
      // }

      //explode or create array depending if there are 1 or many parameters
      strpos($val, '/') !== false ? $values = explode('/', $val) : $values = array($val);
      // {
         // $values = explode('/', $val);
      // }
      // else
      // {
         // $values = array($val);
      // }

      $env[$param_name.'_array'] = $values;
   };
};

$app->get('/programs', function () use ($app) {
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
			  $app->response()->status($e->getCode());
			  $app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get('/programs/:id', function ($id) use ($app) {
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
			  $app->response()->status($e->getCode());
			  $app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get('/courses', function () use ($app) {
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
			  $app->response()->status($e->getCode());
			  $app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get('/courses/year/:year', function ($year) use ($app) {
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
				  $app->response()->status($e->getCode());
				  $app->response()->header('X-Status-Reason', $e->getMessage());
		}
	}
	else {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', "Should be a number from 0 to 4");
	}
});




// http://alexbilbie.com/2013/02/securing-your-api-with-oauth-2/
// http://help.slimframework.com/discussions/questions/230-can-i-have-a-get-request-with-variable-number-of-parameters-in-the-url
// http://nesbot.com/2012/6/18/slim-wildcard-routes-via-route-middleware
// http://linkey.blogs.lincoln.ac.uk/tag/access-token/

R::close();
$app->run();