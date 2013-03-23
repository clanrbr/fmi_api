 <?php

require  'Slim/Slim.php';
require  'Redbeanphp/rb.php';
\Slim\Slim::registerAutoloader();

R::setup('mysql:host=localhost;dbname=testdb','root','');
R::freeze(true);

$app = new \Slim\Slim();
$app->get('/programs', function () use ($app) {
	try {
		$programs=R::getAll('select * from bachelor_programmes');
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
R::close();
$app->run();