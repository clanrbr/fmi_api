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

$app->get('/programs', function () use ($app) {
	try {
		$programs=R::getAll('SELECT * FROM bachelor_programmes');
		if ($programs) {
			$app->response()->header('Content-Type', 'application/json');
			echo json_encode($programs,JSON_UNESCAPED_UNICODE);
		}
		else {
			throw new ResourceNotFoundException();
		}
	}
	catch (ResourceNotFoundException $e) {
		$app->response()->status(404);
	}
	catch (Exception $e) {
			  $app->response()->status(400);
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
			throw new ResourceNotFoundException();
		}
	}
	catch (ResourceNotFoundException $e) {
		$app->response()->status(404);
	}
	catch (Exception $e) {
			  $app->response()->status(400);
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
			throw new ResourceNotFoundException();
		}
	}
	catch (ResourceNotFoundException $e) {
		$app->response()->status(404);
	}
	catch (Exception $e) {
			  $app->response()->status(400);
			  $app->response()->header('X-Status-Reason', $e->getMessage());
	}
});


// http://alexbilbie.com/2013/02/securing-your-api-with-oauth-2/
// http://help.slimframework.com/discussions/questions/230-can-i-have-a-get-request-with-variable-number-of-parameters-in-the-url
// http://nesbot.com/2012/6/18/slim-wildcard-routes-via-route-middleware
// http://linkey.blogs.lincoln.ac.uk/tag/access-token/

R::close();
$app->run();
