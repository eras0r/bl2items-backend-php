<?php

require_once 'vendor/autoload.php';

require_once 'include/config.php';
require_once 'exception/UnauthorizedException.php';

use Tonic\Application;
use Tonic\NotFoundException;
use Tonic\Request;
use Tonic\Response;

//use Tonic\UnauthorizedException;


// TODO introduce setupHeaders(boolean useCors) method
// CORS hack (UI can be on different domain than API)
// e.g. 	API: 	http://localhost/
// 	 		UI:		http://localhost:9000
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Max-Age: 86400");
header('Access-Control-Request-Method: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-Requested-With, X-MICRO-TIME, X-SESSION-TOKEN, X-HMAC-HASH, X-URL");

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
//    $response->wwwAuthenticate = 'Basic realm="My Realm"';
} catch (\Exception $e) {
    // show exception in debug mode
    if (DEBUG_MODE == true) {
        echo $e;
    }
    $response = new Response(Response::INTERNALSERVERERROR, 'Server error');
}

$response->output();

?>
