<?php

require_once 'vendor/autoload.php';

use Tonic\Application;
use Tonic\Request;
use Tonic\Response;
use Tonic\NotFoundException;
use Tonic\UnauthorizedException;


// CORS hack (UI can be on different domain than API)
// e.g. 	API: 	http://localhost/
// 	 		UI:		http://localhost:9000
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Max-Age: 86400");
header('Access-Control-Request-Method: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-Requested-With");

try {
    $app = new Application(array(
        'load' => array('resource/*.php',
            'load' => 'resource/*/*.php')
    ));

    $request = new Request();

    $resource = $app->getResource($request);
    $response = $resource->exec();
} catch (NotFoundException $e) {
    $response = new Response(Response::NOTFOUND, 'Not found');
} catch (UnauthorizedException $e) {
    $response = new Response(Response::UNAUTHORIZED, 'Unauthorized');
    $response->wwwAuthenticate = 'Basic realm="My Realm"';
} catch (\Exception $e) {
    $response = new Response(Response::INTERNALSERVERERROR, 'Server error');
}

$response->output();

?>
